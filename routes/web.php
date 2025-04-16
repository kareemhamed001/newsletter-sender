<?php

use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;

Route::get('/',[NewsletterController::class,'index'] );
Route::get('/newsletter', [NewsletterController::class,'index'] )->name('newsletters.index');
Route::post('/newsletter/send', [NewsletterController::class,'send'])->name('newsletters.send');
Route::post('/newsletter/test/smtp', [NewsletterController::class,'testEmail'])->name('test.smtp');
