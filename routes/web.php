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
    Route::get('/', [MainController::class,'index']);
    Route::get('/newNote', [MainController::class,'newNote']);
    Route::get('/logout', [AuthController::class,'logout']);

});
