<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;

// Show the welcome page (optional, could redirect to login if needed)
Route::get('/', function () {
    return view('welcome');
});

// Registration routes without CSRF protection for testing
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Login routes without CSRF protection for testing
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Home route (protected by auth middleware)
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');  // Protect home route with 'auth' middleware

// Dashboard actions (Start Writing and View All Thoughts)
Route::get('/start-writing', [EntryController::class, 'showStartWriting'])->name('start-writing')->middleware('auth');
Route::post('/start-writing', [EntryController::class, 'saveEntry']);  // POST request to save the new entry

Route::get('/view-all-thoughts', [EntryController::class, 'viewAllEntries'])->name('view-all-thoughts')->middleware('auth');
