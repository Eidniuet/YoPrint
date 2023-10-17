<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::post('/upload', [App\Http\Controllers\UploadController::class, 'upload'])->name('upload');