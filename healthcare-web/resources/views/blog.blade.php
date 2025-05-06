

<x-layout>
    <x-slot name="heading">
        Blog    
    </x-slot>
    
    <div class="w-full h-screen bg-cover bg-center text-white relative" style="background-image: url('/assets/bg-blog.jpg');">
        <div class="absolute" style="left: 10%; top: 30%;">
            <h1 class="text-4xl font-bold">BLOG KESEHATAN</h1>
            <h1 class="text-4xl font-bold">
                <span class="border-b-2 border-white pb-1">ARTIKEL</span> GAYA HIDUP SEHAT
            </h1>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-white text-blue-600 font-semibold px-10 py-2 rounded-3xl">Beranda</a>
        </div>
    </div>

    <div class="w-full h-screen flex flex-col items-center ">
        <div>
            <h1 class="relative top-8 text-3xl font-bold">List Blog Kesehatan</h1>
        </div>
        
        <div class="relative top-14">
            <form action="{{ route('blog.search') }}" method="GET" class="flex items-center w-full max-w-md space-x-0.5">
                <input type="text" name="query" placeholder="Cari artikel..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Cari</button>
            </form>
        </div>

        <div class="relative w-full h-auto flex justify-between space-x-4 mt-8 top-14">
            <!-- Artikel 1 -->
            <div class="w-1/3 bg-white shadow-lg rounded-lg p-4">
                <img src="/assets/gambar-artikel.jpg" alt="Gambar Artikel 1" class="w-full h-48 object-cover rounded-md mb-4">
                <h3 class="text-xl font-semibold mb-2">Judul Artikel 1</h3>
                <p class="text-gray-600 mb-4">Deskripsi singkat artikel 1. Dapatkan informasi menarik tentang topik ini.</p>
                <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-2xl hover:bg-blue-700">Baca Artikel</a>
            </div>
            
            <!-- Artikel 2 -->
            <div class="w-1/3 bg-white shadow-lg rounded-lg p-4">
                <img src="/assets/gambar-artikel.jpg" alt="Gambar Artikel 2" class="w-full h-48 object-cover rounded-md mb-4">
                <h3 class="text-xl font-semibold mb-2">Judul Artikel 2</h3>
                <p class="text-gray-600 mb-4">Deskripsi singkat artikel 2. Pelajari lebih lanjut tentang gaya hidup sehat.</p>
                <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-2xl hover:bg-blue-700">Baca Artikel</a>
            </div>
            
            <!-- Artikel 3 -->
            <div class="w-1/3 bg-white shadow-lg rounded-lg p-4">
                <img src="/assets/gambar-artikel.jpg" alt="Gambar Artikel 3" class="w-full h-48 object-cover rounded-md mb-4">
                <h3 class="text-xl font-semibold mb-2">Judul Artikel 3</h3>
                <p class="text-gray-600 mb-4">Deskripsi singkat artikel 3. Temukan tips hidup sehat di artikel ini.</p>
                <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-2xl hover:bg-blue-700">Baca Artikel</a>
            </div>
        </div>
        
        </div>
        
    </div>
    
</x-layout>

