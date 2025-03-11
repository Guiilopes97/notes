<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return "Hello World";
});

Route::get('/about', function () {
    return "This is about page";
});

Route::get('/main ', [MainController::class,'index']);
