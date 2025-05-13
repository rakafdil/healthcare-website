<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Login</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 10px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .links {
            margin-top: 15px;
            text-align: center;
        }
        .google-login {
            margin-top: 10px;
            text-align: center;
        }
        .google-login a {
            background-color: #db4437;
            color: white;
            padding: 10px;
            display: inline-block;
            border-radius: 5px;
            text-decoration: none;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Masuk</h2>

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="/masuk">
        @csrf

        <div class="form-group">
            <label>Username atau Email</label>
            <input type="text" name="login" value="{{ old('login') }}" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label><input type="checkbox" name="remember"> Remember Me</label>
        </div>

        <button type="submit">Masuk</button>
    </form>

    <div class="links">
        <a href="#">Lupa Password?</a> | 
        <a href="#">Daftar Sekarang</a>
    </div>

    <div class="google-login">
        <a href="{{ url('/auth/google') }}">Masuk dengan Google</a>
    </div>
</div>
</body>
</html>