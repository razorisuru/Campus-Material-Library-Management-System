<?php

namespace App\Http\Controllers;

use App\Services\GeminiAPI;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

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

    public function summarize(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'pdf' => 'required|file|mimes:pdf',
            'task' => 'required|string',
        ]);

        // Get the task and prompt from the request
        $task = $request->input('task');

        // Read the PDF file
        $pdfPath = $request->file('pdf')->getRealPath();
        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = $pdf->getText();
        $pages = explode("\f", $text);

        $summaries = [];

        // Iterate through each page and perform the selected task
        foreach ($pages as $pageText) {
            // Default prompt message based on the selected task
            $content = "Perform the task '$task' on this: $pageText";

            if ($task === 'summarize') {
                $content = "Summarize this: $pageText";
            } elseif ($task === 'paraphrase') {
                $content = "Paraphrase this: $pageText";
            } elseif ($task === 'check_ai_written') {
                $content = "Check if this content is AI-written: $pageText";
            } elseif ($task === 'extract_text') {
                $formattedpageText = nl2br($pageText);
                return response()->json(['summary' => $formattedpageText]);
            } elseif ($task === 'translate') {
                $content = "Translate this to Sinhala : $pageText";
            }
            // elseif ($task === 'check_plagiarism') {




            $responseData = GeminiAPI::calAPI($content);

            // Map the new structure to extract the content parts
            $pageSummary = '';
            if (!empty($responseData['candidates'][0]['content']['parts'])) {
                $parts = $responseData['candidates'][0]['content']['parts'];
                foreach ($parts as $part) {
                    $pageSummary .= $part['text'] ?? '';
                }
            } else {
                $pageSummary = $responseData ;
            }

            // Store the summary
            $summaries[] = $pageSummary;

        }

        // Combine all summaries into one text
        $finalSummary = implode("\n\n", $summaries);

        if ($request->ajax()) {
            // Format the summary with line breaks for better display in HTML
            $formattedSummary = nl2br($finalSummary);
            return response()->json(['summary' => $formattedSummary]);
        }

        // Return the summary to the view for non-AJAX requests
        return view('PDF.summarize-pdf', ['summary' => $finalSummary]);
    }

    // public  function chatBot(Request $request){
    //     $prompt = $request->input('text');

    //     $response = GeminiAPI::calAPI($prompt);

    //     $responseData = $response['candidates'][0]['content']['parts'];

    //     return response()->json(['message' => $responseData]);
    // }


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
