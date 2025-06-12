<?php

use App\Models\History;
use App\Models\SistemPakar;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\KategoriPenyakitController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SistemPakarController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home'); // Pastikan nama view-nya benar
})->name('home');

//artikel controller
Route::resource('kategori', KategoriPenyakitController::class);
//route artikel
Route::get('/artikel', [ArtikelController::class, 'index']);
Route::get('/artikel/search', [ArtikelController::class, 'search'])->name('artikel.search');
Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
Route::get('/artikel/syncFromAPI', [ArtikelController::class, 'syncFromAPI']);

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



Route::get('/tentang-kita', function () {
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
    return view('lupa-password');
})->name('password.request');

Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');


// Route register menggunakan RegisterController
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Route peta
Route::get('/peta', function () {
    return view('peta');
});

Route::get('/peta', [HospitalController::class, 'showMap'])->name('peta');

// API routes
Route::prefix('api/hospital')->group(function () {
    Route::get('capacity/{id}', [HospitalController::class, 'getHospitalCapacity']);
    Route::get('doctors/{id}', [HospitalController::class, 'getHospitalDoctors']);
    Route::get('specialties/{id}', [HospitalController::class, 'getHospitalSpecialties']);
    Route::get('doctors/{hospitalId}/specialty/{specialty}', [HospitalController::class, 'getDoctorsBySpecialty']);
    Route::get('data/{id}', [HospitalController::class, 'getHospitalData']);
    Route::get('debug/{hospitalId?}', [HospitalController::class, 'debugDoctors']);
});

Route::get('/hospital/{id}', [HospitalController::class, 'showHospitalDetail'])->name('detail');

// Route detail alternatif
Route::get('/detail/{id?}', [HospitalController::class, 'showHospitalDetail'])->name('detail.alt');

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

// Dasboard routes
Route::get('/dashboard', ['\App\Http\Controllers\DashboardController', 'index'])
    ->middleware('auth')
    ->name('dashboard');
