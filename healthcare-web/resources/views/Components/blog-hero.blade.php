<div class="relative left-1/2 right-1/2 -translate-x-1/2 text-white">
    <img src="{{ asset('assets/bg-blog.jpg') }}" alt="foto fitur sistem pakar"
        class="w-full h-screen object-cover object-center">
    <div class="absolute" style="left: 10%; top: 30%;">
        <h1 class="text-4xl font-bold">BLOG KESEHATAN</h1>
        <h1 class="text-4xl font-bold py-1">ARTIKEL GAYA HIDUP SEHAT</h1>

        <!-- Garis di atas tombol -->
        <div class="w-30 h-0.5 bg-white my-4 rounded-full"></div>

        <form action="{{ route('home') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user_id ?? '' }}">
            <button type="submit" class="bg-white text-blue-600 font-semibold px-10 py-2 rounded-3xl">
                Beranda
            </button>
        </form>

    </div>
</div>
