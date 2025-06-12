<x-layout title="Healthcare Alomany - Blog Kesehatan">
    <x-slot name="heading">
        Blog
    </x-slot>

    <x-hero.blog />

    <!-- Main Container - Removed fixed height, added responsive padding -->
    <div class="w-full min-h-screen flex flex-col items-center px-4 sm:px-6 lg:px-8">
        
        <!-- Title Section -->
        <div class="text-center mt-8 mb-6">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold">List Blog Kesehatan</h1>
        </div>

        <!-- Search Form - Responsive width and spacing -->
        <div class="w-full max-w-md mb-8">
            <form action="{{ route('artikel.search') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                <input type="text" name="query" placeholder="Cari artikel..." 
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    value="{{ request('query') }}">
                <button type="submit" class="px-4 py-2 bg-[#499BE8] text-white rounded-md hover:bg-[#418ACE] whitespace-nowrap">
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
                                @if($artikel->gambar)
                                    <img src="{{ $artikel->gambar }}" alt="Gambar Artikel" 
                                         class="w-full h-48 sm:h-52 lg:h-48 object-cover rounded-t-md">
                                @endif
                                <div class="flex flex-col flex-1 justify-between p-4 sm:p-6">
                                    <div>
                                        <h3 class="text-lg sm:text-xl font-semibold mb-2 line-clamp-2">{{ $artikel->judul }}</h3>
                                        <p class="text-gray-600 text-sm sm:text-base line-clamp-3">{{ $artikel->isi }}</p>
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
                @if($artikels->count() > 0)
                    <div class="w-full">
                        <!-- Responsive grid for search results -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                            @foreach ($artikels as $artikel)
                                <div class="bg-white shadow-lg rounded-lg flex flex-col h-full">
                                    @if($artikel->gambar)
                                        <img src="{{ $artikel->gambar }}" alt="Gambar Artikel" 
                                             class="w-full h-48 sm:h-52 lg:h-48 object-cover rounded-t-md">
                                    @endif
                                    <div class="flex flex-col flex-1 justify-between p-4 sm:p-6">
                                        <div>
                                            <h3 class="text-lg sm:text-xl font-semibold mb-2 line-clamp-2">{{ $artikel->judul }}</h3>
                                            <p class="text-gray-600 text-sm sm:text-base line-clamp-3">{{ $artikel->bahasan_penyakit }}</p>
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
                            <p class="text-gray-600 mb-4 text-sm sm:text-base">Tidak ada artikel yang sesuai dengan pencarian "{{ request('query') }}"</p>
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polyline points="15 18 9 12 15 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @else
                <a href="{{ $artikels->previousPageUrl() }}" class="p-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polyline points="15 18 9 12 15 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @endif

            {{-- Nomor Halaman - Responsive sizing --}}
            @foreach ($artikels->getUrlRange(1, $artikels->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                   class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center rounded-full 
                          text-xs sm:text-sm font-semibold transition
                          {{ $page == $artikels->currentPage() 
                              ? 'bg-blue-500 text-white' 
                              : 'bg-gray-300 text-black hover:bg-gray-400' }}">
                    {{ $page }}
                </a>
            @endforeach

            {{-- Tombol Next --}}
            @if ($artikels->hasMorePages())
                <a href="{{ $artikels->nextPageUrl() }}" class="p-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polyline points="9 18 15 12 9 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @else
                <span class="p-2 rounded-full bg-gray-200 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polyline points="9 18 15 12 9 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @endif
        </div>
    </div>

</x-layout>