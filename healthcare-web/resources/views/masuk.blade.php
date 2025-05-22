<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-sky-400 to-sky-600 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold">Masuk</h2>
            <p class="text-sm text-gray-600">Belum memiliki akun? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar Sekarang</a></p>
        </div>

        <a href="{{ route('google.login') }}" class="flex items-center justify-center gap-2 bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 text-sm font-medium w-full mb-4">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google"> Lanjutkan dengan Google
        </a>

        <div class="flex items-center gap-2 mb-4">
            <hr class="flex-grow border-gray-300">
            <span class="text-sm text-gray-400">atau</span>
            <hr class="flex-grow border-gray-300">
        </div>

        <form method="POST" action="{{ route('masuk') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Username atau Email</label>
                <input type="text" name="masuk" class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div class="flex justify-between items-center mb-4 text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">Forgot Password</a>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 font-semibold">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
