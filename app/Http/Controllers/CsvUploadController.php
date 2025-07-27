<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCsvJob;
use App\Models\FileJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CsvUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv'
        ]);

        $file = $request->file('file');
        $filePath = $file->store('csv_uploads');
        $fileName = $file->getClientOriginalName();

        $fileJobLog = FileJob::create([
            'file_name' => $fileName,
            'status' => 'pending',
        ]);

        // Dispatch the job to process the CSV
        ProcessCsvJob::dispatch($filePath, $fileJobLog);

        return response()->json([
            'message' => 'CSV uploaded and processing started.',
            'file_job' => $fileJobLog,
        ]);
    }

    public function index()
    {
        $fileJobLogs = FileJob::all();
        return response()->json($fileJobLogs);
    }
}

