<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RespondentController;

Route::get('/', [FeedbackController::class, 'index'])->name('home');
Route::post('/feedback-store', [FeedbackController::class, 'store'])->name('feedback.store');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
        // Route to display respondents list
        Route::get('/admin/respondents', [RespondentController::class, 'index'])->name('admin.respondents');


        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});

// Route to fetch a specific respondent's feedback for preview
Route::get('/admin/respondents/{id}/preview', [RespondentController::class, 'preview'])->name('admin.respondent.preview');
