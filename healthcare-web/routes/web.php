<?php

use App\Models\SistemPakar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SistemPakarController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('home'); // Pastikan nama view-nya benar
})->name('home');

Route::get('/blog/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/blog/search', [BlogController::class, 'search'])->name('blog.search');

Route::get('/baca-blog', function () {
    return view('baca-blog');
})->name('baca-blog');

Route::get('/sistem-pakar', function () {
    return view('sistem-pakar.index');
});

Route::get('/sistem-pakar/{user_id}', function ($user_id) {
    $user_history = SistemPakar::getHistory($user_id);
    return view('sistem-pakar.index', [
        'user_id' => $user_id,
        'history' => $user_history,
    ]);
});

Route::post('/sistem-pakar/{user_id}/symptoms/predict', [SistemPakarController::class, 'predict'])->name('sistem-pakar.predict');

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

Route::get('/sistem-pakar/{user_id}/history', function ($user_id) {
    $history_id = request('id'); // ambil dari query string
    $user_history = SistemPakar::getHistory($user_id);
    return view('sistem-pakar.history', [
        'user_id' => $user_id,
        'history' => $user_history,
        'selected_id' => $history_id,
    ]);
})->name('sistem-pakar.history');

Route::get('/rumah-sakit', function () {
    return view('rumah-sakit');
})->name('rumah-sakit');

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});

// Route login menggunakan LoginController
Route::get('/masuk', [LoginController::class, 'showLoginForm']);
Route::post('/masuk', [LoginController::class, 'login']);

// Route peta
Route::get('/peta', function () {
    return view('peta');
});

Route::get('/hospital/{id}', [HospitalController::class, 'showHospitalDetail'])->name('hospital.detail');

// Route detail alternatif
Route::get('/detail/{id?}', [HospitalController::class, 'showHospitalDetail'])->name('hospital.detail.alt');

// Fallback jika ID tidak disediakan
Route::get('/detail', function () {
    return redirect('/peta');
});

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/hospital/{id}', [HospitalController::class, 'getHospitalData']);
    Route::get('/hospital/capacity/{placeId}', [HospitalController::class, 'getHospitalCapacity']);
    Route::get('/nearby-hospitals', [HospitalController::class, 'getNearbyHospitals']);
    Route::get('/hospitals/nearby', [HospitalController::class, 'getNearbyHospitals']); // Alias lama
});
