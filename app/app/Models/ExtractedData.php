<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtractedData extends Model
{
    public function uploadFile()
    {
        return $this->belongsTo(UploadFile::class);
    }
}
