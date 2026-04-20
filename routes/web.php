<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\MailController;

Route::get('/', function () {
    return view('index');
});

// Excel routes
Route::get('/excel-data',                   [ExcelController::class, 'index'])->name('excel.index');
Route::post('/excel-data',                  [ExcelController::class, 'upload'])->name('excel.upload');
Route::post('/excel-data/save',             [ExcelController::class, 'saveColumn'])->name('excel.save');
Route::get('/excel-data/saved',             [ExcelController::class, 'savedData'])->name('excel.saved');
Route::get('/excel-data/{id}/edit',         [ExcelController::class, 'edit'])->name('excel.edit');
Route::put('/excel-data/{id}',              [ExcelController::class, 'update'])->name('excel.update');
Route::delete('/excel-data/{id}',           [ExcelController::class, 'destroy'])->name('excel.destroy');

// Mail routes
Route::get('/send-mail',                    [MailController::class, 'compose'])->name('mail.compose');
Route::post('/send-mail',                   [MailController::class, 'send'])->name('mail.send');
Route::get('/send-mail/report/{logId}',     [MailController::class, 'report'])->name('mail.report');
