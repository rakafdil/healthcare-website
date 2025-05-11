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
                <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight">
                     SELAMAT DATANG<br />
                <span>DI </span><span class="text-blue-500">HEALTHCARE</span>
                </h1>
                <a href="#tentang-kita"
                   class="mt-6 bg-white text-blue-500 font-semibold px-6 py-2 rounded-full shadow-md max-w-screen-xl ml-auto hover:bg-blue-100 transition">
                    Tentang Kita
                </a>
            </div>
            
            
            <div class="w-full flex justify-between space-x-4 mt-24 mb-10">
                <!-- sistem pakar -->
                <div class="w-1/4 h-full bg-white shadow-lg rounded-3xl p-4">
                   <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="w-12 h-12 object-cover rounded-md mb-4">
                        <g fill="#3b82f6">
                            <path fill-rule="evenodd" d="M3.207 11.571a2 2 0 0 0 0 2.829l1.414 1.414a2 2 0 0 0 2.829 0l6.97-6.971a2 2 0 0 0 .586-1.46l-.032-1.407a2 2 0 0 0-1.978-1.955l-1.375-.014a2 2 0 0 0-1.435.585zm10.507-3.436l-6.971 6.972a1 1 0 0 1-1.415 0l-1.414-1.415a1 1 0 0 1 0-1.414L10.893 5.3a1 1 0 0 1 .718-.293l1.374.014a1 1 0 0 1 .99.978l.031 1.407a1 1 0 0 1-.292.73" clip-rule="evenodd"/>
                            <path d="M9.52 12.107a.5.5 0 1 1-.706.707l-1.415-1.415a.5.5 0 1 1 .708-.707zm-5.956 5.657a.5.5 0 0 1-.707.707L.328 15.942a.5.5 0 1 1 .708-.707zm3.79-.118a.5.5 0 1 1-.708.707l-6-6a.5.5 0 1 1 .708-.707zm4.288-7.661a.5.5 0 0 1-.707.707L9.521 9.278a.5.5 0 0 1 .707-.707z"/>
                            <path d="m2 17.457l-.707-.707l2.457-2.457l.707.707zM16.854 1.354a.5.5 0 1 1 .707.707l-3 3a.5.5 0 1 1-.707-.707z"/>
                        </g>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2 border-t-2 border-black pt-1">Sistem Pakar</h3>
                    <p class="text-gray-600 mb-4">Diagnosa Penyakit</p>
                    <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-3xl hover:bg-blue-700">Masuk Halaman</a>
                </div>
                
                <!-- Artikel 2 -->
                <div class="w-1/4 h-full bg-white shadow-lg rounded-3xl p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="w-12 h-12 object-cover rounded-md mb-4">
                        <g fill="#3b82f6">
                            <path fill-rule="evenodd"  d="M10.497 16.803L15.253 12H14.25q-.184 0-.36-.044l-3.865 3.902l-3.863-3.902Q5.986 12 5.8 12H4.799l4.755 4.803c.26.263.682.263.942 0m6.227-12.49a4.42 4.42 0 0 1 .978 4.7A2 2 0 0 0 17.5 9h-.889a3.415 3.415 0 0 0-.598-3.984A3.306 3.306 0 0 0 11.3 5l-.951.963a.5.5 0 0 1-.711 0l-.96-.97a3.3 3.3 0 0 0-4.706-.016C2.899 6.061 2.713 7.711 3.42 9H2.5q-.09 0-.18.01a4.4 4.4 0 0 1 .941-4.736a4.3 4.3 0 0 1 6.127.016l.605.61l.596-.603l.109-.106a4.306 4.306 0 0 1 6.026.121M7.962 6.307a.5.5 0 0 0-.922-.004L5.47 10H2.5a.5.5 0 0 0 0 1h3.3a.5.5 0 0 0 .46-.304l1.235-2.907l2.043 4.903a.5.5 0 0 0 .886.073l2.143-3.429l1.307 1.493a.5.5 0 0 0 .376.171h3.25a.5.5 0 0 0 0-1h-3.023l-1.6-1.83a.5.5 0 0 0-.801.065l-1.987 3.179z"/></svg>
                    <h3 class="text-xl font-semibold mb-2 border-t-2 border-black pt-1">Rumah Sakit</h3>
                    <p class="text-gray-600 mb-4">Cek Ketersedian kamar</p>
                    <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-3xl hover:bg-blue-700">Masuk Halaman</a>
                </div>
                
                <!-- Artikel 3 -->
                <div class="w-1/4 h-full bg-white shadow-lg rounded-3xl p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="w-12 h-14 object-cover rounded-md mb-4">
                        <g fill="#3b82f6">
                            <path fill-rule="evenodd" d="M20 2a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-2H3v-2h2v-2H3v-2h2v-2H3V9h2V7H3V5h2V3a1 1 0 0 1 1-1zm-1 2H7v16h12zm-5 4v3h3v2h-3.001L14 16h-2l-.001-3H9v-2h3V8z"/></svg>
                    <h3 class="text-xl font-semibold mb-2 border-t-2 border-black pt-1">Blog Kesehatan</h3>
                    <p class="text-gray-600 mb-4">Berisi Artikel Peduli Kesehatan</p>
                    <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-3xl hover:bg-blue-700">Masuk Halaman</a>
                </div>

                <!-- Artikel 4 -->
                <div class="w-1/4 h-full bg-white shadow-lg rounded-3xl p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="w-12 h-12 object-cover rounded-md mb-4">
                        <g fill="#3b82f6" >
                            <path fill-rule="evenodd" d="M6.25 1.5a4.75 4.75 0 1 0 0 9.5a4.75 4.75 0 0 0 0-9.5M0 6.25a6.25 6.25 0 1 1 11.32 3.656l2.387 2.387a1 1 0 1 1-1.414 1.414L9.906 11.32A6.25 6.25 0 0 1 0 6.25m5.962-1.723a.625.625 0 0 0-1.095-.044L4.101 5.75H3.046a.625.625 0 1 0 0 1.25h1.408a.63.63 0 0 0 .535-.302l.36-.596l.93 1.87a.625.625 0 0 0 1.016.15L8.345 7h1.11a.625.625 0 1 0 0-1.25h-1.38a.63.63 0 0 0-.456.197l-.621.663z" clip-rule="evenodd"/></svg>
                    <h3 class="text-xl font-semibold mb-2 border-t-2 border-black pt-1">Hasil Analisa</h3>
                    <p class="text-gray-600 mb-4">Berisi Jurnal Sistem Pakar</p>
                    <a href="{{ route('baca-blog') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-3xl hover:bg-blue-700">Masuk Halaman</a>
                </div>
            </div>
        </div>
    </div>

    
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/4.0.20/fullpage.min.css">
    @endpush

@section('content')
<div id="fullpage">
    <!-- Section 1 -->
    <div class="section" id="section1">
        <div class="h-full w-full flex items-center justify-center">
            <h2 class="text-4xl font-bold">Section 1</h2>
        </div>
    </div>
    <!-- Section 2 -->
    <div class="section" id="section2">
        <div class="h-full w-full flex items-center justify-center">
            <h2 class="text-4xl font-bold">Section 2</h2>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/4.0.20/fullpage.min.js"></script>
    <script>
        new fullpage('#fullpage', {
            autoScrolling: true,
            scrollHorizontally: false,
            navigation: true,
            anchors: ['section1', 'section2'],
            afterLoad: function(origin, destination) {
                console.log("Berpindah ke section: ", destination.index);
            }
        });
    </script>
@endpush
    
</x-layout>
