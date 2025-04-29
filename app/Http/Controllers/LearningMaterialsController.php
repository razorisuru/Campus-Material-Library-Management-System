<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\DegreeProgramme;
use App\Models\LearningMaterial;
use App\Mail\pdfStatusNotifyMail;
use App\Mail\pdfApprovedNotifyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LearningMaterialsController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $degrees = DegreeProgramme::all();
        $categories = Category::all();
        return view('PDF.upload', compact(['subjects', 'degrees', 'categories']));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'degree_programme_id' => 'required|exists:degree_programmes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files.*' => 'required|mimes:pdf,doc,docx,txt,pptx|max:51200',
            'category' => 'required',
        ]);

        $status = 'approved';
        if (auth()->user()->role == 'student') {
            $status = 'pending';
        }

        if ($files = $request->file('files')) {
            foreach ($files as $key => $file) {
                // $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $path = "uploads/files/";
                $file->storeAs('public', $path . $filename);
                $imageData[] = [
                    'subject_id' => $request->subject_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'category_id' => $request->category,
                    'file_path' => $path . $filename,
                    'uploaded_by' => Auth()->user()->id,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

            }
        }
        LearningMaterial::insert($imageData);

        return redirect()->back()->with('status', 'Uploaded Successfully');
        // return $filename;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'degree_programme_id' => 'required|exists:degree_programmes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files.*' => 'nullable|mimes:pdf,doc,docx,txt,pptx|max:51200',
            'category' => 'required',
        ]);

        $learningMaterial = LearningMaterial::findOrFail($id);

        if ($files = $request->file('files')) {
            foreach ($files as $key => $file) {
                $filename = $file->getClientOriginalName();
                $path = "uploads/files/";
                $file->storeAs('public', $path . $filename);
                $file_path = $path . $filename;
            }
        } else {
            $file_path = $learningMaterial->file_path;
        }

        $learningMaterial->update([
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $file_path,
            'uploaded_by' => Auth()->user()->id,
            'category_id' => $request->category,
            'status' => 'approved',
        ]);

        return redirect()->back()->with('status', 'Updated Successfully');
    }


    public function destroy($id)
    {
        $learningMaterial = LearningMaterial::findOrFail($id);

        Storage::delete('public/' . $learningMaterial->file_path);
        $learningMaterial->delete();
        return redirect()->back()->with('status', 'File Deleted Successfully');
    }


    public function view()
    {
        // $subjects = Subjects::all();
        $materials = LearningMaterial::with(['subjects', 'user', 'category', 'degree'])->get();
        return view('PDF.view', compact('materials'));
    }

    public function EditView($id)
    {
        // $subjects = Subject::all();
        $degrees = DegreeProgramme::all();
        $categories = Category::all();
        $materials = LearningMaterial::with(['subjects', 'user', 'category', 'degree'])->findOrFail($id);
        return view('PDF.EditView', compact('materials', 'categories', 'degrees'));
    }

    public function approve(Request $request, $id)
    {
        $material = LearningMaterial::findOrFail($id);
        $material->status = 'approved';
        $material->save();

        $pdfName = $request->pdfName;
        $uploaderMail = $request->uploaderMail;
        $UserName = $request->UserName;

        Mail::to($uploaderMail)->queue(new pdfApprovedNotifyMail($pdfName, $UserName));


        return redirect()->back()->with('status', 'Learning material approved successfully.');
    }

    public function pending(Request $request, $id)
    {
        $material = LearningMaterial::findOrFail($id);
        $material->status = 'pending';
        $material->save();

        return redirect()->back()->with('status', 'Change Success.');
    }

    public function reject(Request $request, $id)
    {
        $material = LearningMaterial::findOrFail($id);
        $material->status = 'rejected';
        $material->save();

        $pdfName = $request->pdfName;
        $uploaderMail = $request->uploaderMail;
        $UserName = $request->UserName;
        $reason = $request->rejectReason;

        Mail::to($uploaderMail)->queue(new pdfStatusNotifyMail($reason, $pdfName, $UserName));

        // return $reason.$uploaderMail;
        return redirect()->back()->with('status', 'Learning material rejected successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids)) {
            // Fetch the LearningMaterial records to get the file paths
            $learningMaterials = LearningMaterial::whereIn('id', $ids)->get();

            // Loop through the records and delete the associated files
            foreach ($learningMaterials as $material) {
                if ($material->file_path) {
                    Storage::delete('public/' . $material->file_path);
                }
            }

            // Now delete the records from the database
            LearningMaterial::whereIn('id', $ids)->delete();

            return response()->json(['message' => 'PDFs and files deleted successfully!']);
        }

        return response()->json(['message' => 'No items selected!'], 400);
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids)) {
            // Fetch the LearningMaterial records to get the file paths
            $learningMaterials = LearningMaterial::whereIn('id', $ids)->get();

            // Loop through the records and delete the associated files
            foreach ($learningMaterials as $material) {

                $material->status = 'approved';
                $material->save();
            }


            return response()->json(['message' => 'PDFs and files approved successfully!']);
        }

        return response()->json(['message' => 'No items selected!'], 400);
    }

    public function bulkPending(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids)) {
            // Fetch the LearningMaterial records to get the file paths
            $learningMaterials = LearningMaterial::whereIn('id', $ids)->get();

            // Loop through the records and delete the associated files
            foreach ($learningMaterials as $material) {

                $material->status = 'pending';
                $material->save();
            }


            return response()->json(['message' => 'PDFs and files pending successfully!']);
        }

        return response()->json(['message' => 'No items selected!'], 400);
    }

    public function bulkReject(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids)) {
            // Fetch the LearningMaterial records to get the file paths
            $learningMaterials = LearningMaterial::whereIn('id', $ids)->get();

            // Loop through the records and delete the associated files
            foreach ($learningMaterials as $material) {

                $material->status = 'rejected';
                $material->save();
            }


            return response()->json(['message' => 'PDFs and files rejected successfully!']);
        }

        return response()->json(['message' => 'No items selected!'], 400);
    }

}
