<?php

namespace App\Http\Controllers;

use App\Models\EBook;
use Illuminate\Http\Request;

class EBookController extends Controller
{
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
        EBook::insert($imageData);

        return redirect()->back()->with('status', 'Uploaded Successfully');
        // return $filename;
    }
}
