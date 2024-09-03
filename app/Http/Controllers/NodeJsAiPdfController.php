<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

class NodeJsAiPdfController extends Controller
{
    public function index()
    {
        return view('PDF.summarize-pdf');
    }

    public function summarize(Request $request)
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

    public function chat($arg)
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

    // public function chat($arg)
    // {
    //     $nodeScriptPath = base_path('node_scripts/chat.cjs');
    //     $process = shell_exec('C:\Program Files\nodejs\node.exe'.' '. $nodeScriptPath.' '. $arg);

    //     while($process != null){

    //     }

    //     return view('PDF.summarize-pdf', ['summary' => $process]);
    // }
}
