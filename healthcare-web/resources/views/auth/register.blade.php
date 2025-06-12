<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-sky-400 to-sky-600 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold">Daftar Akun</h2>
            <p class="text-sm text-gray-600">Sudah memiliki akun? <a href="{{ route('masuk') }}"
                    class="text-blue-500 hover:underline">Masuk Sekarang</a></p>
        </div>

        <a href="{{ route('google') }}"
            class="flex items-center justify-center gap-2 bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 text-sm font-medium w-full mb-4">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google"> Daftar dengan Google
        </a>

        <div class="flex items-center gap-2 mb-4">
            <hr class="flex-grow border-gray-300">
            <span class="text-sm text-gray-400">atau</span>
            <hr class="flex-grow border-gray-300">
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Username --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                @error('username')
                    <p class="text-sm text-red-600 mt-1">{{ $message == 'The username has already been taken.' ? 'Username sudah digunakan.' : $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message == 'The email has already been taken.' ? 'Email sudah digunakan.' : $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password"
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 font-semibold">
                Daftar
            </button>
        </form>
    </div>
</body>

</html>