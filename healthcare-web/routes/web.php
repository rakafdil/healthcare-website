<?php

use App\Models\History;
use App\Models\SistemPakar;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SistemPakarController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('home'); // Pastikan nama view-nya benar
})->name('home');

Route::get('/blog/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/blog/search', [BlogController::class, 'search'])->name('blog.search');

Route::get('/baca-blog', function () {
    return view('baca-blog');
})->name('baca-blog');

// Tampilan awal sistem pakar
Route::get('/sistem-pakar', [SistemPakarController::class, 'index'])->name('sistem-pakar.index');

// Sistem Pakar routes dengan middleware auth
Route::middleware(['auth'])->group(function () {

    Route::get('/sistem-pakar/symptoms', [SistemPakarController::class, 'submitStep'])
        ->name('sistem-pakar.process');

    Route::post('/sistem-pakar/symptoms', [SistemPakarController::class, 'submitStep'])
        ->name('sistem-pakar.process');

    Route::post('/sistem-pakar/symptoms/predict', [SistemPakarController::class, 'predict'])
        ->name('sistem-pakar.predict');

    Route::post('/sistem-pakar/symptoms/finish', [SistemPakarController::class, 'finishDiagnosis'])
        ->name('sistem-pakar.finish');

    Route::get('/sistem-pakar/history', [SistemPakarController::class, 'history'])
        ->name('sistem-pakar.history');
});

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
Route::get('/masuk', [LoginController::class, 'showLoginForm'])->name('masuk');
Route::post('/masuk', [LoginController::class, 'login']);


// Route login menggunakan GoogleController
// web.php
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::get('/lupa-password', function () {
    return view('auth.lupa-password');
})->name('password.request');

// Route register menggunakan RegisterController
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

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
    Route::get('/hospitals', [HospitalController::class, 'getAllHospitals']);
});

// ------------------------------
// Home & Logout Session
// ------------------------------
Route::get('/home', function () {
    if (!session('user_name')) {
        return redirect('/masuk'); // kalau belum login
    }

    return view('home');
});

Route::post('/logout', function () {
    Auth::logout(); // Logout auth Laravel
    session()->invalidate(); // Invalidate semua session
    session()->regenerateToken(); // Regenerate CSRF token

    return redirect('/')->with('success', 'Berhasil logout');
})->name('logout');

Route::get('/lupa-password', function () {
    return view('auth.lupa-password'); // pastikan penamaannya sesuai dengan folder dan file
});