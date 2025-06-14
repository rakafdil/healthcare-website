<?php

use App\Models\User;
use App\Models\History;
use App\Models\SistemPakar;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    Route::delete('/sistem-pakar/history/{id}', [SistemPakarController::class, 'destroyHistory'])
        ->name('sistem-pakar.history.destroy');

    Route::post('/sistem-pakar/history/{id}/retake', [SistemPakarController::class, 'retake'])
        ->name('sistem-pakar.history.retake');
});


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


// Route lupa password
Route::get('/lupa-password', function () {
    return view('auth.lupa-password');
})->name('password.request');

Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');


// Route untuk form reset password
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

// Route untuk handle reset password
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    return $status == Password::PASSWORD_RESET
        ? redirect()->route('masuk')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');

// Route register menggunakan RegisterController
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// ------------------------------
// Route Rumah Sakit
// ------------------------------
Route::get('/rumah-sakit', [HospitalController::class, 'showHospitalForm'])->name('rumah-sakit');

// Group routes untuk rumah sakit
Route::prefix('rumah-sakit')->name('rumah-sakit.')->group(function () {
    
    // Route untuk menampilkan peta
    Route::get('/peta', [HospitalController::class, 'showMap'])->name('peta');
    
    // Route untuk detail rumah sakit
    Route::get('/{id}', [HospitalController::class, 'showHospitalDetail'])
        ->where('id', '[0-9]+')
        ->name('detail');
    
    // Route alternatif untuk detail (jika masih dibutuhkan)
    Route::get('/detail/{id?}', [HospitalController::class, 'showHospitalDetail'])
        ->where('id', '[0-9]+')
        ->name('detail.alt');
});

// API Routes - tetap menggunakan prefix api
Route::prefix('api')->name('api.')->group(function () {
    
    // API untuk rumah sakit
    Route::prefix('rumah-sakit')->name('rumah-sakit.')->group(function () {
        Route::get('/nearby', [HospitalController::class, 'getNearbyHospitals'])->name('nearby');
        Route::get('/stats', [HospitalController::class, 'getHospitalStats'])->name('stats');
        Route::get('/{id}/data', [HospitalController::class, 'getHospitalData'])
            ->where('id', '[0-9]+')
            ->name('data');
        Route::get('/{id}/capacity', [HospitalController::class, 'getHospitalCapacity'])
            ->where('id', '[0-9]+')
            ->name('capacity');
        Route::get('/{id}/doctors', [HospitalController::class, 'getHospitalDoctors'])
            ->where('id', '[0-9]+')
            ->name('doctors');
        Route::get('/{id}/specialties', [HospitalController::class, 'getHospitalSpecialties'])
            ->where('id', '[0-9]+')
            ->name('specialties');
        Route::get('/{hospitalId}/doctors/specialty/{specialty}', [HospitalController::class, 'getDoctorsBySpecialty'])
            ->where('hospitalId', '[0-9]+')
            ->name('doctors.specialty');
        Route::get('/debug/{hospitalId?}', [HospitalController::class, 'debugDoctors'])
            ->where('hospitalId', '[0-9]+')
            ->name('debug');
    });
    
    // Backward compatibility - alias untuk route lama
    Route::prefix('hospital')->group(function () {
        Route::get('/capacity/{id}', [HospitalController::class, 'getHospitalCapacity'])
            ->where('id', '[0-9]+');
        Route::get('/doctors/{id}', [HospitalController::class, 'getHospitalDoctors'])
            ->where('id', '[0-9]+');
        Route::get('/specialties/{id}', [HospitalController::class, 'getHospitalSpecialties'])
            ->where('id', '[0-9]+');
        Route::get('/doctors/{hospitalId}/specialty/{specialty}', [HospitalController::class, 'getDoctorsBySpecialty'])
            ->where('hospitalId', '[0-9]+');
        Route::get('/data/{id}', [HospitalController::class, 'getHospitalData'])
            ->where('id', '[0-9]+');
        Route::get('/debug/{hospitalId?}', [HospitalController::class, 'debugDoctors'])
            ->where('hospitalId', '[0-9]+');
    });
    
    // Route lama untuk kompatibilitas
    Route::get('/nearby-hospitals', [HospitalController::class, 'getNearbyHospitals']);
    Route::get('/hospitals/nearby', [HospitalController::class, 'getNearbyHospitals']);
    Route::get('/hospital/{id}', [HospitalController::class, 'getHospitalData'])
        ->where('id', '[0-9]+');
    Route::get('/hospital/capacity/{placeId}', [HospitalController::class, 'getHospitalCapacity'])
        ->where('placeId', '[0-9]+');
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
