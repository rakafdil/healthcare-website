<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-sky-400 to-sky-600 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold">Lupa Password</h2>
            <p class="text-sm text-gray-600">Masukkan email untuk mendapatkan link reset password.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 text-sm text-green-800 bg-green-100 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 text-sm text-red-800 bg-red-100 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" id="email" name="email"
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                    placeholder="you@example.com" required autofocus>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 font-semibold">
                Kirim Link Reset Password
            </button>
        </form>

        <div class="mt-4 text-center text-sm">
            <a href="{{ route('masuk') }}" class="text-blue-500 hover:underline">← Kembali ke halaman login</a>
        </div>
    </div>
</body>

</html>