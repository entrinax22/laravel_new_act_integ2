<?php

use App\Http\Controllers\ResendController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/send-email', [ResendController::class, 'index'])->name('resend.index');
Route::post('/send-email', [ResendController::class, 'sendEmail'])->name('resend.send');