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
        $process->run();

        // Get the current time
        $current_time = time();

        // Add 5 minutes (300 seconds) to the current time
        $future_time = $current_time + 300;

        // Wait until the future time is reached
        while (time() < $future_time) {
            // Do nothing, just wait
        }

        // Check if the process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Get the output from the Node.js script
        $output = $process->getOutput();

        // Return the output to the view
        return view('PDF.summarize-pdf', ['summary' => $output]);
    }
}
