<?php

use App\Http\Controllers\CsvUploadController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Main');
})->name('main');

Route::post('/upload-csv', [CsvUploadController::class, 'upload']);
Route::get('/file-logs', [CsvUploadController::class, 'index']);


