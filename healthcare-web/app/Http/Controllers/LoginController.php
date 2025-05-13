<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.masuk');
    }

    public function login(Request $request)
    {
        $login = $request->input('login');

        $fieldType = 'username';
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        }

        $credentials = [
            $fieldType => $login,
            'password' => $request->input('password')
        ];

        $remember = false;
        if ($request->has('remember')) {
            $remember = true;
        }

        if (Auth::attempt($credentials, $remember)) {
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'login' => 'Login gagal. Cek email/username dan password.',
        ])->withInput();
    }
}