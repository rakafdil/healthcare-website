<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/sistem-pakar', function () {
    return view('sistem-pakar');
});

Route::get('/rumah-sakit', function () {
    return view('rumah-sakit');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/masuk', function () {
    return view('masuk');
});
