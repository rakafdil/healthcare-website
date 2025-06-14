<x-layout title="Healthcare Alomany - Blog Kesehatan">
    <x-slot name="heading">
        Blog
    </x-slot>

    <x-hero hero_img="{{ asset('assets/bg-blog.jpg') }}" img_alt="foto fitur blog kesehatan" text1="BLOG KESEHATAN"
        text2="ARTIKEL GAYA HIDUP SEHAT" route="{{ route('home') }}" />

    <!-- Main Container - Removed fixed height, added responsive padding -->
    <div class="w-full min-h-screen flex flex-col items-center px-4 sm:px-6 lg:px-8">

        <!-- Title Section -->
        <div class="text-center mt-8 mb-6">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold">List Artikel Kesehatan</h1>
        </div>

        <!-- Search Form - Responsive width and spacing -->
        <div class="w-full max-w-md mb-8">
            <form action="{{ route('artikel.search') }}" method="GET"
                class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                <input type="text" name="query" placeholder="Cari artikel..."
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('query') }}">
                <button type="submit"
                    class="px-4 py-2 bg-[#499BE8] text-white rounded-md hover:bg-[#418ACE] whitespace-nowrap">
                    Cari
                </button>
            </form>
        </div>

        <!-- Articles Container - Removed fixed height -->
        <div class="w-full max-w-7xl mb-8">

            <!-- Carousel Default Artikel (bukan hasil search) -->
            @if (!request()->has('query'))
                <div class="w-full">
                    <!-- Responsive grid with better spacing -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @foreach ($artikels as $artikel)
                            <div class="bg-white shadow-lg rounded-lg flex flex-col h-full">
                                                        {{-- Opsi 2: Menggunakan onerror JavaScript (Lebih sederhana) --}}
                            <img src="{{ $artikel->gambar ?? '/images/placeholder.jpg' }}" 
                                alt="Gambar Artikel" 
                                class="w-full h-48 sm:h-52 lg:h-48 object-cover rounded-t-md"
                                onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">

                            <div class="w-full h-48 sm:h-52 lg:h-48 bg-gray-200 rounded-t-md flex items-center justify-center" style="display: none;">
                                <div class="text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-sm">Tidak ada gambar</p>
                                </div>
                            </div>
                                <div class="flex flex-col flex-1 justify-between p-4 sm:p-6">
                                    <div>
                                        <h3 class="text-lg sm:text-xl font-semibold mb-2 line-clamp-2">
                                            {{ $artikel->judul }}</h3>
                                        <p class="text-gray-600 text-sm sm:text-base line-clamp-3">{{ $artikel->isi }}
                                        </p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ $artikel->link }}" target="_blank"
                                            class="inline-block bg-[#499BE8] text-white px-4 py-2 rounded-2xl hover:bg-[#418ACE] text-sm sm:text-base">
                                            Baca Artikel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Hasil Pencarian -->
            @if (request()->has('query'))
                @if ($artikels->count() > 0)
                    <div class="w-full">
                        <!-- Responsive grid for search results -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                            @foreach ($artikels as $artikel)
                                <div class="bg-white shadow-lg rounded-lg flex flex-col h-full">
                                    {{-- Opsi 2: Menggunakan onerror JavaScript (Lebih sederhana) --}}
                                    <img src="{{ $artikel->gambar ?? '/images/placeholder.jpg' }}" 
                                        alt="Gambar Artikel" 
                                        class="w-full h-48 sm:h-52 lg:h-48 object-cover rounded-t-md"
                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                    <div class="w-full h-48 sm:h-52 lg:h-48 bg-gray-200 rounded-t-md flex items-center justify-center" style="display: none;">
                                        <div class="text-center text-gray-500">
                                            <svg class= "w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-sm">Tidak ada gambar</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col flex-1 justify-between p-4 sm:p-6">
                                        <div>
                                            <h3 class="text-lg sm:text-xl font-semibold mb-2 line-clamp-2">
                                                {{ $artikel->judul }}</h3>
                                            <p class="text-gray-600 text-sm sm:text-base line-clamp-3">
                                                {{ $artikel->isi }}</p>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ $artikel->link }}" target="_blank"
                                                class="inline-block bg-[#499BE8] text-white px-4 py-2 rounded-2xl hover:bg-[#418ACE] text-sm sm:text-base">
                                                Baca Artikel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- No Search Results - Responsive text -->
                    <div class="w-full min-h-64 flex items-center justify-center">
                        <div class="text-center px-4">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Artikel Tidak Ditemukan</h2>
                            <p class="text-gray-600 mb-4 text-sm sm:text-base">Tidak ada artikel yang sesuai dengan
                                pencarian "{{ request('query') }}"</p>
                            <p class="text-gray-500 text-sm sm:text-base">Coba gunakan kata kunci yang berbeda</p>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <!-- Pagination - Responsive design -->
<div class="flex items-center justify-center space-x-1 sm:space-x-2 mt-4 mb-8 px-4">
    {{-- Tombol Previous --}}
    @if ($artikels->onFirstPage())
        <span class="p-2 rounded-full bg-gray-200 cursor-not-allowed">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <polyline points="15 18 9 12 15 6" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    @else
        <a href="{{ $artikels->previousPageUrl() }}"
            class="p-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <polyline points="15 18 9 12 15 6" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </a>
    @endif

    {{-- Logika untuk menentukan range halaman --}}
    @php
        $currentPage = $artikels->currentPage();
        $lastPage = $artikels->lastPage();
        $maxPages = 10; // Maksimal 10 nomor halaman yang ditampilkan
        
        // Hitung start dan end page
        if ($lastPage <= $maxPages) {
            // Jika total halaman <= 10, tampilkan semua
            $startPage = 1;
            $endPage = $lastPage;
        } else {
            // Jika total halaman > 10, hitung range dinamis
            $halfRange = floor($maxPages / 2);
            
            if ($currentPage <= $halfRange) {
                // Jika di awal, tampilkan 1-10
                $startPage = 1;
                $endPage = $maxPages;
            } elseif ($currentPage >= ($lastPage - $halfRange)) {
                // Jika di akhir, tampilkan 10 halaman terakhir
                $startPage = $lastPage - $maxPages + 1;
                $endPage = $lastPage;
            } else {
                // Jika di tengah, tampilkan dengan current page di tengah
                $startPage = $currentPage - $halfRange;
                $endPage = $currentPage + $halfRange;
            }
        }
    @endphp

    {{-- Tombol "First" jika tidak dimulai dari halaman 1 --}}
    @if ($startPage > 1)
        <a href="{{ $artikels->url(1) }}"
            class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center rounded-full
                  text-xs sm:text-sm font-semibold transition bg-gray-300 text-black hover:bg-gray-400">
            1
        </a>
        @if ($startPage > 2)
            <span class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm">
                ...
            </span>
        @endif
    @endif

    {{-- Nomor Halaman - Range terbatas --}}
    @for ($page = $startPage; $page <= $endPage; $page++)
        <a href="{{ $artikels->url($page) }}"
            class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center rounded-full
                  text-xs sm:text-sm font-semibold transition
                  {{ $page == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black hover:bg-gray-400' }}">
            {{ $page }}
        </a>
    @endfor

    {{-- Tombol "Last" jika tidak berakhir di halaman terakhir --}}
    @if ($endPage < $lastPage)
        @if ($endPage < $lastPage - 1)
            <span class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-xs sm:text-sm">
                ...
            </span>
        @endif
        <a href="{{ $artikels->url($lastPage) }}"
            class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center rounded-full
                  text-xs sm:text-sm font-semibold transition bg-gray-300 text-black hover:bg-gray-400">
            {{ $lastPage }}
        </a>
    @endif

    {{-- Tombol Next --}}
    @if ($artikels->hasMorePages())
        <a href="{{ $artikels->nextPageUrl() }}"
            class="p-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <polyline points="9 18 15 12 9 6" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </a>
    @else
        <span class="p-2 rounded-full bg-gray-200 cursor-not-allowed">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <polyline points="9 18 15 12 9 6" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    @endif
</div>
</div>

</x-layout>
