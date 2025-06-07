@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Lupa Password</h2>

    {{-- Pesan Sukses --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Pesan Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control"
                placeholder="Masukkan email kamu" required autofocus>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                Kirim Link Reset Password
            </button>
        </div>
    </form>

    <div class="mt-3 text-center">
        <a href="{{ route('masuk') }}">← Kembali ke halaman login</a>
    </div>
</div>
@endsection
