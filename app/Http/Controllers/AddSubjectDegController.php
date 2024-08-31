<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DegreeProgramme;
use App\Models\Subject;

class AddSubjectDegController extends Controller
{
    public function show()
    {
        $degrees = DegreeProgramme::with('subjects')->get();
        return view('degree.show', compact('degrees'));
    }

    public function add()
    {
        $degrees = DegreeProgramme::get();
        return view('degree.add', compact('degrees'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',

        ]);
        DegreeProgramme::insert([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->back()->with('status', 'Subject Added Successfully');
    }

    public function SubjectStore(Request $request)
    {
        $request->validate([

            'degree_id' => 'required',
            'subject_code' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
            'subject_description' => 'required|string|max:255',

        ]);
        Subject::insert([
            'degree_programme_id' => $request->degree_id,
            'subject_code' => $request->subject_code,
            'name' => $request->subject_name,
            'description' => $request->subject_description,
        ]);

        return redirect()->back()->with('status', 'Subject Added Successfully');
    }


}
