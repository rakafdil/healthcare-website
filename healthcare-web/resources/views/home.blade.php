<x-layout>
    <x-slot name="heading">
        Home    
    </x-slot>
 
        
        <div class="w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]">
            <img src="{{ asset('assets/Desktop - 2.png') }}" class="w-full h-screen" alt="Full Width Image">
            <!-- Overlay (optional, biar teksnya makin kelihatan) -->
            <div class="absolute inset-0 bg-white/10 "></div>

            <!-- Hero Content -->
            <div class="relative z-10 flex flex-col justify-center items-start h-full px-8 max-w-screen-xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight">
                    SELAMAT DATANG<br />
                    <span class="text-blue-500">DI HEALTHCARE</span>
                </h1>
                <a href="#tentang-kita"
                    class="mt-6 bg-white text-blue-500 font-semibold px-6 py-2 rounded-full shadow-md hover:bg-blue-100 transition">
                    Tentang Kita
                </a>
            </div>
        </div>
    
</x-layout>
