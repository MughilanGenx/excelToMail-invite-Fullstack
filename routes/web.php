<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\MailController;

Route::get('/', function () {
    return view('index');
});

// Excel routes
Route::get('/excel-data',           [ExcelController::class, 'index'])->name('excel.index');
Route::post('/excel-data',          [ExcelController::class, 'upload'])->name('excel.upload');
Route::post('/excel-data/save',     [ExcelController::class, 'saveColumn'])->name('excel.save');
Route::get('/excel-data/saved',     [ExcelController::class, 'savedData'])->name('excel.saved');

// Mail routes
Route::get('/send-mail',            [MailController::class, 'compose'])->name('mail.compose');
Route::post('/send-mail',           [MailController::class, 'send'])->name('mail.send');
