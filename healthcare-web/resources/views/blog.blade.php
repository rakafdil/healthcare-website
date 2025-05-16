<x-layout title="Healthcare Alomany - Blog Kesehatan">
    <x-slot name="heading">
        Blog
    </x-slot>

    <x-blog-hero />

    <div class="w-full h-screen flex flex-col items-center ">
        <div>
            <h1 class="relative top-8 text-3xl font-bold">List Blog Kesehatan</h1>
        </div>

        <div class=" top-14 my-14 mb-4">
            <form action="{{ route('blog.search') }}" method="GET"
                class="flex items-center w-full max-w-md space-x-0.5 z-10">
                <input type="text" name="query" placeholder="Cari artikel..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                <button type="submit" class="px-4 py-2 bg-[#499BE8] text-white rounded-md hover:bg-[#418ACE]">Cari
                </button>
            </form>
        </div>


        <div id="fullPage" class="w-full">
            <!-- Carousel Container -->
            <div class="carousel-container relative">
                <div class="carousel-slides">
                    <div class="relative w-full h-auto flex justify-between space-x-4 top-4 mb-8 px-16">
                        <!-- Artikel 1 -->
                        <div class="w-1/4 h-auto bg-white shadow-lg rounded-lg ">
                            <img src="/assets/gambar-artikel.jpg" alt="Gambar Artikel 1"
                                class="w-full h-48 object-cover rounded-md mb-4">
                            <h3 class="text-xl font-semibold mb-2 ml-2">Judul Artikel 1</h3>
                            <p class="text-gray-600 mb-4 ml-2">Deskripsi singkat artikel 1. Dapatkan informasi menarik
                                tentang topik ini.
                            </p>
                            <a href="{{ route('baca-blog') }}"
                                class="inline-block bg-[#499BE8] text-white px-4 py-2 rounded-2xl hover:bg-[#418ACE] ml-2">Baca
                                Artikel</a>
                        </div>

                        <!-- Artikel 2 -->
                        <div class="w-1/4 h-auto bg-white shadow-lg rounded-lg ">
                            <img src="/assets/gambar-artikel.jpg" alt="Gambar Artikel 2"
                                class="w-full h-48 object-cover rounded-md mb-4">
                            <h3 class="text-xl font-semibold mb-2 ml-2">Judul Artikel 2</h3>
                            <p class="text-gray-600 mb-4 ml-2">Deskripsi singkat artikel 2. Pelajari lebih lanjut
                                tentang gaya hidup
                                sehat.</p>
                            <a href="{{ route('baca-blog') }}"
                                class="inline-block bg-[#499BE8] text-white px-4 py-2 rounded-2xl hover:bg-[#418ACE] mb-2 ml-2">Baca
                                Artikel</a>
                        </div>

                        <!-- Artikel 3 -->
                        <div class=" w-1/4 h-auto bg-white shadow-lg rounded-lg ">
                            <img src="/assets/gambar-artikel.jpg" alt="Gambar Artikel 3"
                                class="w-full h-48 object-cover rounded-md mb-4">
                            <h3 class="text-xl font-semibold mb-2 ml-2">Judul Artikel 3</h3>
                            <p class="text-gray-600 mb-4 ml-2">Deskripsi singkat artikel 3. Temukan tips hidup sehat di
                                artikel ini.</p>
                            <a href="{{ route('baca-blog') }}"
                                class="inline-block bg-[#499BE8] text-white px-4 py-2 rounded-2xl hover:bg-[#418ACE] ml-2">Baca
                                Artikel</a>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <!-- Indikator Nomor -->
                <div class="flex justify-center space-x-2 ">
                    <div class="carousel-button carousel-button-left ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-left">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </div>
                    <button class="w-8 h-8 rounded-full bg-gray-300 text-black font-semibold"
                        onclick="goToSlide(0)">1</button>
                    <button class="w-8 h-8 rounded-full bg-gray-300 text-black font-semibold"
                        onclick="goToSlide(1)">2</button>
                    <button class="w-8 h-8 rounded-full bg-gray-300 text-black font-semibold"
                        onclick="goToSlide(2)">3</button>
                    <button class="w-8 h-8 rounded-full bg-gray-300 text-black font-semibold"
                        onclick="goToSlide(3)">4</button>
                    <button class="w-8 h-8 rounded-full bg-gray-300 text-black font-semibold"
                        onclick="goToSlide(4)">5</button>
                    <div class="carousel-button carousel-button-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout>
