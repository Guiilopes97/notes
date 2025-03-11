<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

// Public Routes - user not logged
Route::middleware([CheckIsNotLogged::class])->group(function () {
    
    // Auth Routes
    Route::get('/login', [AuthController::class,'login']);
    Route::post('/loginSubmit', [AuthController::class,'loginSubmit']);

});

// Protected Routes - user logged
Route::middleware([CheckIsLogged::class])->group(function () {
    
    // Main Routes
    Route::get('/', [MainController::class,'index'])->name('home');
    Route::get('/newNote', [MainController::class,'newNote'])->name('new');

    
    // edit note
    Route::get('/editNote/{id}', [MainController::class,'editNote'])->name('edit');
    Route::get('/deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');


    // Auth Routes
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');

});
