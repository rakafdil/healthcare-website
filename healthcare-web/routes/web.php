<?php

use App\Models\SistemPakar;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/sistem-pakar', function () {
    return view('sistem-pakar', SistemPakar::steps());
});

Route::get('/sistem-pakar/{user_id}', function ($user_id) {
    $user_history = SistemPakar::getHistory($user_id);
    return view('sistem-pakar', array_merge(
        SistemPakar::steps(),
        ['history' => $user_history]
    ));
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

Route::get('/peta', function () {
    return view('peta');
});

Route::get('/detail', function () {
    return view('detail');
});
