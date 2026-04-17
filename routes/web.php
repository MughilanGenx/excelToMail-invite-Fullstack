<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

Route::get('/', function () {
    return view('index');
});

Route::get('/excel-data', [ExcelController::class, 'index'])->name('excel.index');
Route::post('/excel-data', [ExcelController::class, 'upload'])->name('excel.upload');
