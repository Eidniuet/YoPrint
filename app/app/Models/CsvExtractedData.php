<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvExtractedData extends Model
{
    protected $table = 'csv_extracted_data'; // Specify the table name

    protected $fillable = [
        'UNIQUE_KEY',
        'PRODUCT_TITLE',
        'PRODUCT_DESCRIPTION',
        'STYLE#',
        'SANMAR_MAINFRAME_COLOR',
        'SIZE',
        'COLOR_NAME',
        'PIECE_PRICE',
    ];
    
    public function uploadFile()
    {
        return $this->belongsTo(UploadFile::class);
    }
    
}
