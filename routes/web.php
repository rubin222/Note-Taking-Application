<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

//Authentication Routes
Route::get('auth/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('auth/login', [AuthController::class, 'webLogin'])->name('login.submit');
Route::get('auth/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('auth/register', [AuthController::class, 'webRegister'])->name('register.submit');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

//Protected Routes
Route::middleware('auth')->group(function(){
    // Dashboard:Categories focused
    Route::get('/dashboard', [CategoryController::class, 'index'])->name('dashboard');
    
    //Category notes view
    Route::get('/categories/{category}/notes', [CategoryController::class, 'showNotes'])->name('categories.notes');
    
    //Notes Route within categories
    Route::post('/categories/{category}/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    
    //Categories Routes
    Route::resource('categories', CategoryController::class)->except(['show']);
});

//Home redirect
Route::get('/', function(){
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});