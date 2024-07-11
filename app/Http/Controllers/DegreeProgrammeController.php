<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\DegreeProgramme;

class DegreeProgrammeController extends Controller
{
    public function getSubjects($degreeId)
{
    $subjects = Subject::where('degree_programme_id', $degreeId)->get();
    return response()->json($subjects);
}
}
