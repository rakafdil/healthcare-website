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
            // Simpan session
            session(['login_time' => now()]);
            session(['user_id' => Auth::id()]);
            session(['user_name' => Auth::user()->username]); // Tambahan

            // Simpan cookie
            cookie()->queue(cookie('user_name', Auth::user()->username, 60 * 24)); // Tambahan

            if ($remember) {
                Cookie::queue('remember_username', $request->masuk, 60 * 24 * 30);
                logger('Cookie set: ' . $request->masuk);
            }

            if (session()->get('redirect_to') === 'sistem-pakar') {
                return redirect()->route('sistem-pakar.index');
            }

            return redirect('/home');
        }

        return back()->withErrors([
            'login' => 'Login gagal. Cek email/username dan password.',
        ])->withInput();
    }
}
