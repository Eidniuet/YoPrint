<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadFile;

class DashboardController extends Controller
{
    public function index()
    {
        $uploads = UploadFile::orderBy('upload_time', 'desc')->get();
        return view('dashboard', compact('uploads'));
    }

    public function uploads()
    {
        $uploads = UploadFile::orderBy('upload_time', 'desc')->get();
        return response()->json($uploads);
    }
}
