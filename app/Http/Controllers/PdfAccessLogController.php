<?php

namespace App\Http\Controllers;

use App\Services\GeminiAPI;
use Illuminate\Http\Request;
use App\Models\pdf_access_log;
use App\Models\LearningMaterial;

class PdfAccessLogController extends Controller
{
    protected $gpi;
    public function __construct()
    {
        $this->gpi = new GeminiAPI();
    }
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
        $lastAccessed = pdf_access_log::where('student_id', 1)
            ->orderByDesc('accessed_at')
            ->take(5)
            ->pluck('pdf_id');

        $pdfs = LearningMaterial::whereIn('id', $lastAccessed)->get();

        $prompt = "Suggest similar study materials for these PDFs:\n";
        foreach ($pdfs as $pdf) {
            $prompt .= "Title: {$pdf->title}, Description: {$pdf->description}, Category: {$pdf->category->name}\n";
        }

        $response = $this->gpi->callAPI($prompt);

        // $responseData = $response['candidates'][0]['content']['parts'][0]['text'];

        // Parse response and query for recommended PDFs
        // ...your logic here...

        return response()->json(
            $response,
            200
        );
    }
}
