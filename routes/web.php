<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminLoginController;

Route::get('/', [FeedbackController::class, 'index'])->name('home'); // Home page is the feedback form
Route::post('/feedback-store', [FeedbackController::class, 'store'])->name('feedback.store');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminLoginController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});
