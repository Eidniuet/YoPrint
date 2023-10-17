<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadFile;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessUploadedFile;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName);
    
            $uploadFile = UploadFile::create([
                'upload_time' => now(),
                'file_name' => $fileName,
                'status' => 'pending',
            ]);
    
            // $csvData = file_get_contents($file->getPathname());
            // $lines = explode("\n", $csvData);
    
            // $fieldMappings = [
            //     'UNIQUE_KEY'=>null,
            //     'PRODUCT_TITLE' => null,
            //     'PRODUCT_DESCRIPTION' => null,
            //     'STYLE#' => null,
            //     'SANMAR_MAINFRAME_COLOR' => null,
            //     'SIZE' => null,
            //     'COLOR_NAME' => null,
            //     'PIECE_PRICE' => null,
            // ];
    
            // $skipFirstRow = true;
    
            // foreach ($lines as $line) {
            //     $data = str_getcsv($line);
    
            //     if ($skipFirstRow) {
            //         $skipFirstRow = false;
    
            //         foreach ($fieldMappings as $field => $index) {
            //             $fieldIndex = array_search($field, $data);
    
                        
            //             $fieldMappings[$field] = $fieldIndex;
                        
            //         }
    
            //         continue;
            //     }
    
            //     $insertData = [];
            //     foreach ($fieldMappings as $field => $index) {
            //         if ($index !== null && isset($data[$index])) {
            //             $insertData[$field] = $data[$index];
            //         } else {
            //             $insertData[$field] = null;
            //         }
            //     }
    
            //     $insertData['upload_file_id'] = $uploadFile->id;
    
            //     DB::table('csv_extracted_data')->insert($insertData);
            // }
            ProcessUploadedFile::dispatch($uploadFile);
    
            return redirect()->route('dashboard')->with('success', 'File uploaded, and relevant data extracted successfully.');
        }
    
        return redirect()->route('dashboard')->with('error', 'File upload failed.');
    }
}    
