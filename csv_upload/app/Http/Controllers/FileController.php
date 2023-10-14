<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    function index(){
        return view('csv_upload');
    }
    
}
