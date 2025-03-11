<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return "Hello World";
});

Route::get('/about', function () {
    return "This is about page";
});
