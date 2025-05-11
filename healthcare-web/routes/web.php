<?php

use App\Models\SistemPakar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MLController;

Route::get('/', function () {
    return view('home'); // Pastikan nama view-nya benar
})->name('home');

Route::get('/blog/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/blog/search', [BlogController::class, 'search'])->name('blog.search');
Route::get('/baca-blog', function () {
    return view('baca-blog');
})->name('baca-blog');



Route::get('/sistem-pakar', function () {
    return view('sistem-pakar.index', ['steps' => SistemPakar::steps()]);
});
Route::get('/sistem-pakar/{user_id}', function ($user_id) {
    $user_history = SistemPakar::getHistory($user_id);
    return view('sistem-pakar.index', [
        'user_id' => $user_id,
        'steps' => SistemPakar::steps(),
        'history' => $user_history,
    ]);
});

Route::post('/sistem-pakar/{user_id}/symptoms/predict', [MLController::class, 'predict'])->name('sistem-pakar.predict');

Route::post('/sistem-pakar/{user_id}/symptoms', function ($user_id) {
    return view('sistem-pakar.process', [
        'user_id' => $user_id,
        'step' => request('step', 1)
    ]);
});

Route::get('/sistem-pakar/{user_id}/symptoms', function ($user_id) {
    return view('sistem-pakar.process', [
        'user_id' => $user_id,
        'step' => request('step', 1)
    ]);
});


Route::get('/sistem-pakar/history/{user_id}', function ($user_id) {
    $user_history = SistemPakar::getHistory($user_id);
    return view('sistem-pakar.history', [
        'user_id' => $user_id,
        'history' => $user_history,
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
