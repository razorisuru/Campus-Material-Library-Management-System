<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use App\Models\pdf_access_log;

class PdfAccessLogController extends Controller
{
    public function store(Request $request)
    {
        // $request->validate([
        //     'pdf_id' => 'required|exists:learning_materials,id',
        // ]);
        pdf_access_log::create([
            'student_id' => $request->student_id,
            'pdf_id' => $request->pdf_id,
            'accessed_at' => now(),
        ]);
        return response()->json(['message' => 'PDF access logged successfully'], 201);
    }

    public function getRecommendations()
    {
        $lastAccessed = pdf_access_log::where('student_id', auth()->id())
            ->orderByDesc('accessed_at')
            ->take(5)
            ->pluck('pdf_id');

        $pdfs = LearningMaterial::whereIn('id', $lastAccessed)->get();

        $prompt = "Suggest similar study materials for these PDFs:\n";
        foreach ($pdfs as $pdf) {
            $prompt .= "Title: {$pdf->title}, Description: {$pdf->description}, Category: {$pdf->category->name}\n";
        }

        $response = app(\App\Services\GeminiAPI::class)->callAPI($prompt);

        // Parse response and query for recommended PDFs
        // ...your logic here...

        return response()->json(
            $response,
            200
        );
    }
}
