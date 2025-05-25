<!-- resources/views/auth/lupa-password.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lupa Password</h1>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <button type="submit">Kirim Link Reset</button>
        </form>
    </div>
@endsection