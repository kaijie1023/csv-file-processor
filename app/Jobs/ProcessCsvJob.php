<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\FileJob;
use App\Models\Product;

class ProcessCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $fileJobLog;

    public function __construct(string $filePath, FileJob $fileJobLog)
    {
        $this->filePath = $filePath;
        $this->fileJobLog = $fileJobLog;
    }

    public function handle()
    {
        $this->fileJobLog->status = 'processing';
        $this->fileJobLog->save();

        Log::info('Processing CSV file', [
            'file_path' => $this->filePath,
            'file_name' => $this->fileJobLog->file_name,
        ]);

        $stream = Storage::readStream($this->filePath);
        if (!$stream) {
            $this->fileJobLog->status = 'failed';
            $this->fileJobLog->save();

            Log::error('Failed to read CSV file', [
                'file_path' => $this->filePath,
                'file_name' => $this->fileJobLog->file_name,
            ]);
            return;
        }

        $header = null;
        while (($row = fgetcsv($stream)) !== false) {
            $cleaned_row = array_map(function ($value) {
                // Convert to UTF-8 and ignore invalid characters
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                // Optional: strip non-printable characters
                return preg_replace('/[^\P{C}\n]+/u', '', $value);
            }, $row);
            if (!$header) {
                $header = array_map(function($column) {
                    return strtolower(trim(str_replace('#', '_number', $column)));
                }, $cleaned_row);
                continue;
            }

            $data = array_combine($header, $cleaned_row);
            Product::upsert($data, ['unique_key']);
        }

        fclose($stream);

        $this->fileJobLog->status = 'completed';
        $this->fileJobLog->save();

        Log::info('CSV processing completed', [
            'file_path' => $this->filePath,
            'file_name' => $this->fileJobLog->file_name,
        ]);
    }

    public function failed(\Exception $exception)
    {
        $this->fileJobLog->status = 'failed';
        $this->fileJobLog->save();

        Log::error('CSV processing failed for file: ' . $this->fileJobLog->file_name, [
            'file_path' => $this->filePath,
            'error' => $exception->getMessage(),
        ]);
    }
}
