<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-sky-400 to-sky-600 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold">Reset Password</h2>
            <p class="text-sm text-gray-600">Masukkan password baru Anda</p>
        </div>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Password Baru</label>
                <input type="password" name="password"
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 font-semibold">
                Reset Password
            </button>
        </form>
    </div>
</body>

</html>
