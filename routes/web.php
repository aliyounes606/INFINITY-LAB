<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/print-invoice/{doctor}', [InvoiceController::class, 'print'])
    ->name('print.doctor.invoice')
    ->middleware(['auth']);