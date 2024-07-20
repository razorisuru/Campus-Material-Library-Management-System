<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\DegreeProgramme;
use App\Models\LearningMaterial;
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
                    'status' => 'approved',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

            }
        }
        LearningMaterial::insert($imageData);

        return redirect()->back()->with('status', 'Uploaded Successfully');
        // return $filename;
    }

    public function destroy($id)
    {
        // Find the file record in the database
        $learningMaterial = LearningMaterial::findOrFail($id);

        // Delete the file from the storage
        // if (Storage::exists('public/' . $learningMaterial->file_path)) {
        Storage::delete('public/' . $learningMaterial->file_path);
        $learningMaterial->delete();
        return redirect()->back()->with('status', 'File Deleted Successfully');
        // } else {
        //     return ('public/' . $learningMaterial->file_path);
        // }

        // Delete the database record
        // $learningMaterial->delete();


        // return $learningMaterial->file_path;
    }

    public function view()
    {
        // $subjects = Subjects::all();
        $materials = LearningMaterial::with(['subjects', 'user', 'category'])->get();
        return view('PDF.view', compact('materials'));
    }

    public function approve(Request $request, $id)
    {
        $material = LearningMaterial::findOrFail($id);
        $material->status = 'approved';
        $material->save();

        return redirect()->back()->with('success', 'Learning material approved successfully.');
    }

    public function pending(Request $request, $id)
    {
        $material = LearningMaterial::findOrFail($id);
        $material->status = 'pending';
        $material->save();

        return redirect()->back()->with('success', 'Learning material approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $material = LearningMaterial::findOrFail($id);
        $material->status = 'rejected';
        $material->save();

        return redirect()->back()->with('success', 'Learning material rejected successfully.');
    }
}
