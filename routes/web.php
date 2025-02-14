<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;

Route::get('/', [FeedbackController::class, 'index'])->name('home'); // Home page is the feedback form
Route::post('/feedback-store', [FeedbackController::class, 'store'])->name('feedback.store');
