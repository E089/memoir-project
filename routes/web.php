<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\CategoryController;

Route::get('/welcome-page', function () {
    return view('welcome-page');
});

// Registration routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])
    ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);  

Route::view('/terms', 'terms')->name('terms');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');  // Logout via GET
Route::get('/welcome-page', function () {
    return view('welcome-page');  
})->name('welcome-page');  

// Home route (protected by auth middleware)
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');  // Protect home route with 'auth' middleware

Route::get('/home', [EntryController::class, 'home'])->name('home');



// Dashboard actions (Start Writing and View All Thoughts)
Route::get('/start-writing', [EntryController::class, 'showStartWriting'])->name('start-writing')->middleware('auth');
Route::post('/start-writing', [EntryController::class, 'saveEntry']);  // POST request to save the new entry

Route::get('/view-all-thoughts', [EntryController::class, 'viewAllEntries'])->name('view-all-thoughts')->middleware('auth');

// View a single entry
Route::get('/entries/{id}', [EntryController::class, 'showEntry'])->name('entries.show')->middleware('auth');

// Edit an entry
Route::get('/entries/{id}/edit', [EntryController::class, 'editEntry'])->name('entries.edit')->middleware('auth');
Route::put('/entries/{id}/update', [EntryController::class, 'updateEntry'])->name('entries.update')->middleware('auth');
Route::delete('/entry/{id}/delete', [EntryController::class, 'deleteEntry'])->name('delete-entry');

// Categories routes
Route::resource('categories', CategoryController::class);

// Route for storing categories
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

// Route to get all categories for the entry form
Route::get('/categories', [CategoryController::class, 'getAllCategories'])->name('categories.getAll');

//Delete Categories
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('delete-category');
