<x-layout title="Healthcare Alomany - Blog Kesehatan">
    <x-slot name="heading">
        Blog
    </x-slot>

    <x-hero.blog />

    <div class="w-full h-screen flex flex-col items-center ">
        <div>
            <h1 class="relative top-8 text-3xl font-bold">List Blog Kesehatan</h1>
        </div>

                <!-- Form Pencarian -->
        <div class="top-14 my-14 mb-4">
            <form action="{{ route('artikel.search') }}" method="GET" class="flex items-center w-full max-w-md space-x-0.5 z-10">
                <input type="text" name="query" placeholder="Cari artikel..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    value="{{ request('query') }}">
                <button type="submit" class="px-4 py-2 bg-[#499BE8] text-white rounded-md hover:bg-[#418ACE]">Cari</button>
            </form>
        </div>

        <!-- Carousel Default Artikel (bukan hasil search) -->
        @if (!request()->has('query'))
            <div id="fullPage" class="w-full flex h-screen">
                <div class="carousel-container relative">
                    <div class="carousel-slides">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 px-16">
                                @foreach ($artikels as $artikel)
                                    <div class="bg-white shadow-lg rounded-lg flex flex-col h-full">
                                        @if($artikel->gambar)
                                            <img src="{{ $artikel->gambar }}" alt="Gambar Artikel" class="w-full h-48 object-cover rounded-t-md">
                                        @endif
                                        <div class="flex flex-col flex-1 justify-between p-4">
                                            <div>
                                                <h3 class="text-xl font-semibold mb-2">{{ $artikel->judul }}</h3>
                                                <p class="text-gray-600">{{ $artikel->bahasan_penyakit }}</p>
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('artikel.show', $artikel->id) }}" 
                                                class="inline-block bg-[#499BE8] text-white px-4 py-2 rounded-2xl hover:bg-[#418ACE]">
                                                    Baca Artikel
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                    </div>
                </div>
                
            </div>
        @endif

        <!-- Hasil Pencarian --> 
        @if (request()->has('query')) 
            @if($artikels->count() > 0)
                <div id="fullPage" class="w-full flex h-screen"> 
                
                    <div class="carousel-container relative"> 
                    
                    <div class="carousel-slides"> 
                        
                            <!-- Ada Hasil Pencarian -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 px-16">
                                @foreach ($artikels as $artikel)
                                    <div class="bg-white shadow-lg rounded-lg flex flex-col h-full">
                                        @if($artikel->gambar)
                                            <img src="{{ $artikel->gambar }}" alt="Gambar Artikel" class="w-full h-48 object-cover rounded-t-md">
                                        @endif
                                        <div class="flex flex-col flex-1 justify-between p-4">
                                            <div>
                                                <h3 class="text-xl font-semibold mb-2">{{ $artikel->judul }}</h3>
                                                <p class="text-gray-600">{{ $artikel->bahasan_penyakit }}</p>
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('artikel.show', $artikel->id) }}" 
                                                class="inline-block bg-[#499BE8] text-white px-4 py-2 rounded-2xl hover:bg-[#418ACE]">
                                                    Baca Artikel
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                        
                    </div> 
                   
                </div> 
                 @else
                            <!-- Tidak Ada Hasil Pencarian -->
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="text-center">
                                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Artikel Tidak Ditemukan</h2>
                                    <p class="text-gray-600 mb-4">Tidak ada artikel yang sesuai dengan pencarian "{{ request('query') }}"</p>
                                    <p class="text-gray-500">Coba gunakan kata kunci yang berbeda</p>
                                </div>
                            </div>
                        @endif
            </div> 
        @endif




    </div>
    
        <div class="flex items-center justify-center space-x-2 mt-4 mb-4">
            {{-- Tombol Previous --}}
            @if ($artikels->onFirstPage())
                <span class="p-2 rounded-full bg-gray-200 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polyline points="15 18 9 12 15 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @else
                <a href="{{ $artikels->previousPageUrl() }}" class="p-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polyline points="15 18 9 12 15 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($artikels->getUrlRange(1, $artikels->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                class="w-8 h-8 flex items-center justify-center rounded-full 
                        text-sm font-semibold transition
                        {{ $page == $artikels->currentPage() 
                            ? 'bg-blue-500 text-white' 
                            : 'bg-gray-300 text-black hover:bg-gray-400' }}">
                    {{ $page }}
                </a>
            @endforeach

            {{-- Tombol Next --}}
            @if ($artikels->hasMorePages())
                <a href="{{ $artikels->nextPageUrl() }}" class="p-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polyline points="9 18 15 12 9 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @else
                <span class="p-2 rounded-full bg-gray-200 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polyline points="9 18 15 12 9 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @endif
        </div>

</x-layout>