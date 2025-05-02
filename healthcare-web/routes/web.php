<?php

use App\Models\SistemPakar;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/sistem-pakar', function () {
    return view('sistem-pakar', ['steps' => SistemPakar::steps()]);
});

Route::get('/sistem-pakar/{user_id}', function ($user_id) {
    $user_history = SistemPakar::getHistory($user_id);
    return view('sistem-pakar', [
        'user_id' => $user_id,
        'steps' => SistemPakar::steps(),
        'history' => $user_history,
    ]);
});

Route::get('/sistem-pakar/history/{user_id}', function ($user_id) {
    $user_history = SistemPakar::getHistory($user_id);
    return view('history', [
        'user_id' => $user_id,
        'history' => $user_history,
    ]);
});

Route::post('/sistem-pakar/{user_id}/symptoms', function ($user_id) {
    return view('symptoms', [
        'user_id' => $user_id,
        'step' => request('step', 1) // kalau mau bawa step juga
    ]);
});

Route::get('/sistem-pakar/{user_id}/symptoms', function ($user_id) {
    return view('symptoms', [
        'user_id' => $user_id,
        'step' => request('step', 1) // kalau mau bawa step juga
    ]);
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
