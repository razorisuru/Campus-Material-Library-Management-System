<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Str;

class aiPDFController extends Controller
{
    public function index()
    {
        return view('PDF.ai');
    }
    public function upload(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10000',
        ]);

        $pdf = $request->file('pdf_file');
        // $filename = $pdf->getClientOriginalName();
        $filename = Str::random(20) . '.pdf';
        $path = "uploads/Summarize/";
        $pdfPath = $pdf->storeAs('public', $path . $filename);
        // dd($path . $filename);
        $dd = $path . $filename;

        // $pdfPath = $request->file('pdf_file')->store('pdfs');
        // $fullPath = storage_path('app/' . $pdfPath);

        $pythonPath = 'C:\Users\iduni\AppData\Local\Programs\Python\Python312\python.exe';
        $scriptPath = base_path('python-scripts/summarize_pdf.py');
        // dd($scriptPath);// This should be the local path
        $filename = storage_path('uploads/Summarize/VZJ8HMhjRTuFqp5YH5F2.pdf');
        $process = new Process([$pythonPath, $scriptPath, $filename]);

        // dd($process);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $summary = $process->getOutput();

        return response()->json(['summary' => $summary]);
        // return $filename;
    }

    public function runPythonScript($argument)
    {
        // Define the Python script path
        $scriptPath = base_path('python-scripts/run.py');

        // Run the Python script with the argument
        $process = new Process(['C:\Users\iduni\AppData\Local\Programs\Python\Python312\python.exe', $scriptPath, $argument]);
        $process->run();

        // Check for errors
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Return the output
        return $process->getOutput();
    }
}
