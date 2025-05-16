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

Route::get('/', function () {
    return view('home'); // Pastikan nama view-nya benar
})->name('home');

Route::get('/blog/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/blog/search', [BlogController::class, 'search'])->name('blog.search');

Route::get('/baca-blog', function () {
    return view('baca-blog');
})->name('baca-blog');

// Tampilan awal sistem pakar
Route::get('/sistem-pakar', [SistemPakarController::class, 'index']);

// Tampilan form dengan user_id
Route::get('/sistem-pakar/{user_id}', [SistemPakarController::class, 'start']);

Route::get('/sistem-pakar/{user_id}/symptoms', [SistemPakarController::class, 'submitStep'])->name('sistem-pakar.step');

// Submit step-by-step
Route::post('/sistem-pakar/{user_id}/symptoms', [SistemPakarController::class, 'submitStep'])->name('sistem-pakar.step');

// Prediksi penyakit dari gejala
Route::post('/sistem-pakar/{user_id}/symptoms/predict', [SistemPakarController::class, 'predict'])->name('sistem-pakar.predict');

// Riwayat diagnosa
Route::get('/sistem-pakar/{user_id}/history', [SistemPakarController::class, 'history'])->name('sistem-pakar.history');

Route::post('/finish-diagnosis', [SistemPakarController::class, 'finishDiagnosis'])->name('finishDiagnosis');

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

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');

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
});
