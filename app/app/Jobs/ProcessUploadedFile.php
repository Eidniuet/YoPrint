<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UploadFile;
use App\Models\CsvExtractedData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessUploadedFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uploadFile;

    public function __construct($uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    public function handle()
    {
        $this->uploadFile->update(['status' => 'processing']);

        $filePath = storage_path('app/uploads/' . $this->uploadFile->file_name);

        if (file_exists($filePath)) {
            $csvData = file_get_contents($filePath);
            $lines = explode("\n", $csvData);

            $fieldMappings = [
                'UNIQUE_KEY' => 0,
                'PRODUCT_TITLE' => 1,
                'PRODUCT_DESCRIPTION' => 2,
                'STYLE#' => 3,
                'SANMAR_MAINFRAME_COLOR' => 4,
                'SIZE' => 5,
                'COLOR_NAME' => 6,
                'PIECE_PRICE' => 7,
            ];

            $skipFirstRow = true;

            foreach ($lines as $line) {
                $data = str_getcsv($line);

                if ($skipFirstRow) {
                    $skipFirstRow = false;

                    foreach ($fieldMappings as $field => $index) {
                        $fieldIndex = array_search($field, $data);

                        if ($fieldIndex !== false) {
                            $fieldMappings[$field] = $fieldIndex;
                        }
                    }

                    continue;
                }

                $insertData = [];
                foreach ($fieldMappings as $field => $index) {
                    if ($index !== false && isset($data[$index])) {
                        $insertData[$field] = $data[$index];
                    } else {
                        $insertData[$field] = null;
                    }
                }

                $insertData['upload_file_id'] = $this->uploadFile->id;

                DB::table('csv_extracted_data')->insert($insertData);
            }

            $this->uploadFile->update(['status' => 'completed']);
            Log::info('Processing completed');
        } else {
            $this->uploadFile->update(['status' => 'failed']);
            Log::error('File does not exist: ' . $filePath);
        }
    }
}



