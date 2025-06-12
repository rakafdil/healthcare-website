<x-layout>
    <x-slot name="heading">
        Baca Blog
    </x-slot>

    <x-hero.blog />

    <div class="text-center items-center max-w-3xl mx-auto px-4 py-8">
        <div class="relative space-y-5 top-8 flex flex-col items-center">
            <h1 class="text-3xl font-bold">{{ $artikel->judul }}</h1>
            
            <p class="relative">{{ $artikel->penulis }}</p>
            <p class="relative">{{ $artikel->created_at }}</p>
            @if($artikel->gambar)
                <img src="{{ $artikel->gambar }}" alt="Gambar Artikel" class="w-64 h-48 object-cover rounded-md mb-4 ">
            @endif
            <p class="text-gray-700 leading-relaxed mb-4 text-justify">{{ $artikel->isi }}
            </p>

            
        </div>
    </div>

</x-layout>
