<?php

namespace App\Http\Controllers;

use App\Models\LearningMaterial;
use App\Models\pdf_access_log;
use App\Services\GeminiAPI;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class NodeJsAiPdfController extends Controller
{
    public function index()
    {
        return view('PDF.summarize-pdf');
    }

    public function chat()
    {
        return view('PDF.chat');
    }

    protected $gpi;

    public function __construct()
    {
        $this->gpi = new GeminiAPI();
    }

    public function summarize(Request $request)
    {
        // Validate inputs
        $request->validate([
            'pdf' => 'nullable|file|mimes:pdf',
            'task' => 'required|string',
        ]);

        $task = $request->input('task');
        $summaries = [];

        $st_id = auth()->id() ?: 1;

        // --- Special case: getRecommendations does NOT need PDF ---
        if ($task === 'getRecommendations') {
            $lastAccessed = pdf_access_log::where('student_id', $st_id)
                ->orderByDesc('accessed_at')
                ->take(5)
                ->pluck('pdf_id');

            $pdfs = LearningMaterial::whereIn('id', $lastAccessed)->get();

            $content = "You are an expert academic assistant. Based on the following study materials (PDFs), suggest a list of similar books or study resources that would help students learn more deeply.
For each suggested resource, include:
- Title of the book or material
- Author(s)
- Difficulty level (Beginner / Intermediate / Advanced)
- Key topics covered
- Why this resource is relevant

Here are the study materials:\n";

            foreach ($pdfs as $pdf) {
                $content .= "Title: {$pdf->title}, Description: {$pdf->description}, Category: {$pdf->category->name}\n";
            }

            $responseData = $this->gpi->callAPI($content);

            $finalSummary = '';
            if (!empty($responseData['candidates'][0]['content']['parts'])) {
                foreach ($responseData['candidates'][0]['content']['parts'] as $part) {
                    $finalSummary .= $part['text'] ?? '';
                }
            } else {
                $finalSummary = $responseData;
            }

            if ($request->ajax()) {
                return response()->json(['summary' => nl2br($finalSummary)]);
            }

            return view('PDF.summarize-pdf', ['summary' => $finalSummary]);
        }

        // --- Other tasks DO need a PDF ---
        if (!$request->hasFile('pdf')) {
            return response()->json(['error' => 'PDF is required for this task.'], 422);
        }

        $pdfPath = $request->file('pdf')->getRealPath();
        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = $pdf->getText();
        $pages = explode("\f", $text);

        foreach ($pages as $pageText) {
            // Default prompt
            $content = "Perform the task '$task' on this: $pageText";

            if ($task === 'summarize') {
                $content = "Summarize this: $pageText";
            } elseif ($task === 'paraphrase') {
                $content = "Paraphrase this: $pageText";
            } elseif ($task === 'check_ai_written') {
                $content = "Check if this content is AI-written: $pageText";
            } elseif ($task === 'extract_text') {
                return response()->json(['summary' => nl2br($pageText)]);
            } elseif ($task === 'translate') {
                $content = "Translate this to Sinhala: $pageText";
            }

            // if this class does not work, run this and dont ask why
            // run this command when the AI IS NOT WORKING
            // if anyhing is not working, run this command
            // php artisan optimize
            // php artisan config:clear
            // php artisan cache:clear

            $responseData = $this->gpi->callAPI($content);

            $pageSummary = '';
            if (!empty($responseData['candidates'][0]['content']['parts'])) {
                foreach ($responseData['candidates'][0]['content']['parts'] as $part) {
                    $pageSummary .= $part['text'] ?? '';
                }
            } else {
                $pageSummary = $responseData;
            }

            $summaries[] = $pageSummary;
        }

        $finalSummary = implode("\n\n", $summaries);

        if ($request->ajax()) {
            return response()->json(['summary' => nl2br($finalSummary)]);
        }

        return view('PDF.summarize-pdf', ['summary' => $finalSummary]);
    }


    public function chatBot(Request $request)
    {
        $text = $request->input(key: 'text');

        // $gpi = new GeminiAPI();

        $response = $this->gpi->callAPI($text);

        $responseData = $response['candidates'][0]['content']['parts'][0]['text'];

        return response()->json([
            'message' => $responseData
        ]);
    }

    public function chatBotMobile(Request $request)
    {
        $text = $request->text;

        $response = $this->gpi->callAPI($text);

        $responseData = $response['candidates'][0]['content']['parts'][0]['text'];

        return response()->json([
            'message' => $responseData
        ]);
    }

    public function prompt(Request $request)
    {
        $prompt = $request->input('prompt');

        // Initialize HTTP client
        $client = new Client([
            'base_uri' => 'https://api.pawan.krd/cosmosrp/v1/',
        ]);

        try {
            // Send request to OpenAI API
            $response = $client->post('chat/completions', [
                'headers' => [
                    'Authorization' => 'pk-FlcimbdWcfAEfryzTjywVXQQjpbRpjcjITIrmuBPKuTfdXQY',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'pai-001-light',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Powered by RaZoR.',
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt, // Ensure $content is a defined string
                        ],
                    ],
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);
            $pageSummary = $responseData['choices'][0]['message']['content'];

            return view('PDF.summarize-pdf', ['chat' => $pageSummary]);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to get summary: ' . $e->getMessage());
        }
    }


    public function summarizeNode(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);

        // Store the uploaded PDF
        $pdfPath = $request->file('pdf')->store('pdfss');

        // Define the Node.js script path and PDF path
        $nodeScriptPath = base_path('node_scripts/summarizePdf.cjs');
        $pdfFullPath = storage_path("app/{$pdfPath}");

        // Run the Node.js script using Symfony Process
        $process = new Process(['C:\Program Files\nodejs\node.exe', $nodeScriptPath, $pdfFullPath]);

        // Start the process and handle real-time output
        $process->start();

        $output = '';
        $errorOutput = '';

        // Stream the output
        $process->wait(function ($type, $buffer) use (&$output, &$errorOutput) {
            if (Process::ERR === $type) {
                $errorOutput .= $buffer;
            } else {
                $output .= $buffer;
            }
        });

        // Check if the process was successful
        if (!$process->isSuccessful()) {
            // Optionally log or handle errors
            throw new ProcessFailedException($process);
            // return response()->json(['error' => 'Failed to process the PDF'], 500);
        }

        // Check if the request expects a JSON response
        if ($request->ajax()) {
            return response()->json(['summary' => $output]);
        }

        // For non-AJAX requests, return the full view
        return view('PDF.summarize-pdf', ['summary' => $output]);
    }

    public function arg($arg)
    {
        $nodeScriptPath = base_path('node_scripts/test.cjs');
        $process = new Process(['C:\Program Files\nodejs\node.exe', $nodeScriptPath, $arg]);
        $process->run();

        // Check if the process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Get the output from the Node.js script
        $output = $process->getOutput();

        // Return the output to the view
        return $output;
    }


}
