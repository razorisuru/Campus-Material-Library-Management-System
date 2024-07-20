<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\DegreeProgramme;
use App\Models\LearningMaterial;

class STLearningMaterialsController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $degrees = DegreeProgramme::all();
        $categories = Category::all();
        return view('studentView.stdUpload', compact(['subjects', 'degrees', 'categories']));
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
                $file->move($path, $filename);
                $imageData[] = [
                    'subject_id' => $request->subject_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'category_id' => $request->category,
                    'file_path' => $path . $filename,
                    'uploaded_by' => Auth()->user()->id,
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

            }
        }
        LearningMaterial::insert($imageData);

        return redirect()->back()->with('status', 'Uploaded Successfully');
        // return $filename;
    }

    public function view()
    {
        // $subjects = Subjects::all();
        $materials = LearningMaterial::with(['subjects', 'user'])->where('status', '=', 'approved')->get();
        return view('studentView.index', compact('materials'));
    }
}
