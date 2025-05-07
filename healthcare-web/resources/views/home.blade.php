<x-layout>
    <x-slot name="heading">
        Home    
    </x-slot>

    <div class="w-screen h-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] overflow-hidden">
        <!-- Background Image -->
        <img src="{{ asset('assets/Desktop - 2.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="Full Width Image">
        <!-- Optional Overlay -->
        <div class="absolute inset-0 bg-white/10 z-10"></div>
        
        <!-- Container untuk semua konten -->
        <div class="relative z-20 flex flex-col h-full px-8 max-w-screen-xl mx-auto">
            <!-- Hero Content - Menggunakan ukuran tinggi yang lebih kecil -->
            <div class="flex flex-col justify-center text-right h-3/5 pt-20">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight">
                    SELAMAT DATANG<br />
                    <span class="text-blue-500">DI HEALTHCARE</span>
                </h1>
                <a href="#tentang-kita"
                   class="mt-6 bg-white text-blue-500 font-semibold px-6 py-2 rounded-full shadow-md max-w-screen-xl ml-auto hover:bg-blue-100 transition">
                    Tentang Kita
                </a>
            </div>
            
            <!-- Section Artikel - Pastikan ini terlihat -->
            <div class="w-full flex justify-between space-x-4 mt-8 mb-10">
                <!-- Artikel 1 -->
                <div class="w-1/3 bg-white shadow-lg rounded-lg p-4">
                    <img src="\assets\home\pepicons-pencil--syringe.svg" alt="Gambar Artikel 1" class="w-full h-48 object-cover rounded-md mb-4">
                    <h3 class="text-xl font-semibold mb-2">Judul Artikel 1</h3>
                    <p class="text-gray-600 mb-4">Deskripsi singkat artikel 1. Dapatkan informasi menarik tentang topik ini.</p>
                    <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-2xl hover:bg-blue-700">Baca Artikel</a>
                </div>
                
                <!-- Artikel 2 -->
                <div class="w-1/3 bg-white shadow-lg rounded-lg p-4">
                    <img src="\assets\home\fluent--heart-pulse-32-regular.svg" alt="Gambar Artikel 2" class="w-full h-48 object-cover rounded-md mb-4">
                    <h3 class="text-xl font-semibold mb-2">Judul Artikel 2</h3>
                    <p class="text-gray-600 mb-4">Deskripsi singkat artikel 2. Pelajari lebih lanjut tentang gaya hidup sehat.</p>
                    <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-2xl hover:bg-blue-700">Baca Artikel</a>
                </div>
                
                <!-- Artikel 3 -->
                <div class="w-1/3 bg-white shadow-lg rounded-lg p-4">
                    <img src="\assets\home\healthicons--health-literacy-outline.svg" alt="Gambar Artikel 3" class="w-full h-48 object-cover rounded-md mb-4">
                    <h3 class="text-xl font-semibold mb-2">Judul Artikel 3</h3>
                    <p class="text-gray-600 mb-4">Deskripsi singkat artikel 3. Temukan tips hidup sehat di artikel ini.</p>
                    <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-2xl hover:bg-blue-700">Baca Artikel</a>
                </div>

                <!-- Artikel 4 -->
                <div class="w-1/3 bg-white shadow-lg rounded-lg p-4">
                    <img src="\assets\home\streamline--heart-rate-search-solid.svg" alt="Gambar Artikel 3" class="w-full h-48 object-cover rounded-md mb-4">
                    <h3 class="text-xl font-semibold mb-2">Judul Artikel 3</h3>
                    <p class="text-gray-600 mb-4">Deskripsi singkat artikel 3. Temukan tips hidup sehat di artikel ini.</p>
                    <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-2xl hover:bg-blue-700">Baca Artikel</a>
                </div>
            </div>
        </div>
    </div>

    
</x-layout>
