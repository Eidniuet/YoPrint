<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadFile extends Model
{
    protected $fillable = [
        'upload_time', 
        'file_name',
        'status',
    ];
    public function extractedData()
    {
        return $this->hasMany(CsvExtractedData::class);
    }
}
