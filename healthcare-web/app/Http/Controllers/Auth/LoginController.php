<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('masuk');
    }

    public function login(Request $request)
    {
        $login = $request->input('masuk');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $login,
            'password' => $request->input('password')
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Simpan session custom
            session(['login_time' => now()]);
            session(['user_id' => Auth::id()]);

            // Simpan cookie jika centang "Remember Me"
            if ($request->has('remember')) {
    Cookie::queue('remember_username', $request->masuk, 60 * 24 * 30);
    logger('Cookie set: ' . $request->masuk);
}


            return redirect('/dashboard');
        }

        return back()->withErrors([
            'login' => 'Login gagal. Cek email/username dan password.',
        ])->withInput();
    }
}