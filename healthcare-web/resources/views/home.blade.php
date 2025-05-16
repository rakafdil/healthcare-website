<x-layout title="Healthcare Alomany - Beranda">

    <div class="w-full h-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] overflow-hidden">
        <!-- Background Image -->
        <img src="{{ asset('assets/Desktop - 2.png') }}" class="absolute inset-0 w-full h-full object-cover z-0"
            alt="Full Width Image">
        <!-- Optional Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-white via-white/30 to-white/5 backdrop-blur-sm z-10"></div>

        <!-- Container untuk semua konten -->
        <div class="relative z-20 flex flex-col h-full px-8 max-w-screen-xl mx-auto">
            <!-- Hero Content - Menggunakan ukuran tinggi yang lebih kecil -->
            <div class="flex flex-col justify-center text-right h-3/5 pt-20">
                <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight">
                    SELAMAT DATANG<br />
                    <span>DI </span><span class="text-blue-500 mr-[5%]">HEALTHCARE</span>
                </h1>
                <div class="w-[12%] h-[3px] bg-white mt-6 ml-auto mr-[23%]"></div>
                <a href="#tentang-kita"
                    class="mt-6 mr-[23%] bg-white text-blue-500 font-semibold px-6 py-2 rounded-full shadow-md max-w-screen-xl ml-auto hover:bg-blue-100 transition">
                    Tentang Kita
                </a>
            </div>


            <!-- Feature Cards with Uniform Icon Sizes -->
            <div class="w-full flex justify-between space-x-4 mt-16 mb-10">
                <!-- Sistem Pakar -->
                <div class="w-1/4 h-full bg-white shadow-lg rounded-3xl p-4 opacity-0 animate-fade-in-up">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="w-12 h-12 text-blue-500 mb-4">
                        <g fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3.207 11.571a2 2 0 0 0 0 2.829l1.414 1.414a2 2 0 0 0 2.829 0l6.97-6.971a2 2 0 0 0 .586-1.46l-.032-1.407a2 2 0 0 0-1.978-1.955l-1.375-.014a2 2 0 0 0-1.435.585zm10.507-3.436l-6.971 6.972a1 1 0 0 1-1.415 0l-1.414-1.415a1 1 0 0 1 0-1.414L10.893 5.3a1 1 0 0 1 .718-.293l1.374.014a1 1 0 0 1 .99.978l.031 1.407a1 1 0 0 1-.292.73"
                                clip-rule="evenodd" />
                            <path
                                d="M9.52 12.107a.5.5 0 1 1-.706.707l-1.415-1.415a.5.5 0 1 1 .708-.707zm-5.956 5.657a.5.5 0 0 1-.707.707L.328 15.942a.5.5 0 1 1 .708-.707zm3.79-.118a.5.5 0 1 1-.708.707l-6-6a.5.5 0 1 1 .708-.707zm4.288-7.661a.5.5 0 0 1-.707.707L9.521 9.278a.5.5 0 0 1 .707-.707z" />
                            <path
                                d="m2 17.457l-.707-.707l2.457-2.457l.707.707zM16.854 1.354a.5.5 0 1 1 .707.707l-3 3a.5.5 0 1 1-.707-.707z" />
                        </g>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2 border-t-2 border-black pt-1">Sistem Pakar</h3>
                    <p class="text-gray-600 mb-4">Diagnosa Penyakit</p>
                    <a href="{{ route('sistem-pakar.index') }}"
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-3xl hover:bg-blue-700">Masuk Ke
                        Halaman</a>
                </div>

                <!-- Rumah Sakit -->
                <div
                    class="w-1/4 h-full bg-white shadow-lg rounded-3xl p-4 opacity-0 animate-fade-in-up animation-delay-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="w-12 h-12 text-blue-500 mb-4">
                        <g fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.497 16.803L15.253 12H14.25q-.184 0-.36-.044l-3.865 3.902l-3.863-3.902Q5.986 12 5.8 12H4.799l4.755 4.803c.26.263.682.263.942 0m6.227-12.49a4.42 4.42 0 0 1 .978 4.7A2 2 0 0 0 17.5 9h-.889a3.415 3.415 0 0 0-.598-3.984A3.306 3.306 0 0 0 11.3 5l-.951.963a.5.5 0 0 1-.711 0l-.96-.97a3.3 3.3 0 0 0-4.706-.016C2.899 6.061 2.713 7.711 3.42 9H2.5q-.09 0-.18.01a4.4 4.4 0 0 1 .941-4.736a4.3 4.3 0 0 1 6.127.016l.605.61l.596-.603l.109-.106a4.306 4.306 0 0 1 6.026.121M7.962 6.307a.5.5 0 0 0-.922-.004L5.47 10H2.5a.5.5 0 0 0 0 1h3.3a.5.5 0 0 0 .46-.304l1.235-2.907l2.043 4.903a.5.5 0 0 0 .886.073l2.143-3.429l1.307 1.493a.5.5 0 0 0 .376.171h3.25a.5.5 0 0 0 0-1h-3.023l-1.6-1.83a.5.5 0 0 0-.801.065l-1.987 3.179z" />
                        </g>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2 border-t-2 border-black pt-1">Rumah Sakit</h3>
                    <p class="text-gray-600 mb-4">Cek Ketersedian kamar</p>
                    <a href="{{ route('rumah-sakit') }}"
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-3xl hover:bg-blue-700">Masuk Ke
                        Halaman</a>
                </div>

                <!-- Blog Kesehatan -->
                <div
                    class="w-1/4 h-full bg-white shadow-lg rounded-3xl p-4 opacity-0 animate-fade-in-up animation-delay-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                        class="w-12 h-12 text-blue-500 mb-4">
                        <path
                            d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v14c0 1.103.897 2 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM5 20V9h14l.002 11H5z">
                        </path>
                        <path d="M7 11h5v2H7zm0 4h10v2H7z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2 border-t-2 border-black pt-1">Blog Kesehatan</h3>
                    <p class="text-gray-600 mb-4">Berisi Artikel Peduli Kesehatan</p>
                    <a href="/blog"
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-3xl hover:bg-blue-700">Masuk Ke
                        Halaman</a>
                </div>


                <!-- Hasil Analisa -->
                <div
                    class="w-1/4 h-full bg-white shadow-lg rounded-3xl p-4 opacity-0 animate-fade-in-up animation-delay-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="w-12 h-12 text-blue-500 mb-4">
                        <g fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6.25 1.5a4.75 4.75 0 1 0 0 9.5a4.75 4.75 0 0 0 0-9.5M0 6.25a6.25 6.25 0 1 1 11.32 3.656l2.387 2.387a1 1 0 1 1-1.414 1.414L9.906 11.32A6.25 6.25 0 0 1 0 6.25m5.962-1.723a.625.625 0 0 0-1.095-.044L4.101 5.75H3.046a.625.625 0 1 0 0 1.25h1.408a.63.63 0 0 0 .535-.302l.36-.596l.93 1.87a.625.625 0 0 0 1.016.15L8.345 7h1.11a.625.625 0 1 0 0-1.25h-1.38a.63.63 0 0 0-.456.197l-.621.663z"
                                clip-rule="evenodd" />
                        </g>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2 border-t-2 border-black pt-1">Hasil Analisa</h3>
                    <p class="text-gray-600 mb-4">Berisi Jurnal Sistem Pakar</p>
                    <a href="#"
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-3xl hover:bg-blue-700">Masuk Ke
                        Halaman</a>
                </div>
            </div>

        </div>
    </div>

    <!-- sistem pakar -->
    <div class="mt-8">
        <div id="fullPage" class="w-full">
            <!-- Carousel Container -->
            <div class="carousel-container relative">
                <div class="carousel-slides">
                    <div class="section bg-gradient-to-b from-white p-8" style="--tw-gradient-to: #00C8FF;">
                        <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center">

                            <div class="md:w-1/2 text-white">
                                <h1 class="text-3xl md:text-4xl font-bold text-black mb-4 ml-16">Sistem Pakar</h1>
                                <p class="text-lg text-black mb-6 leading-relaxed text-justify ml-16">Sistem pakar
                                    adalah suatu sistem komputer yang bisa menyamai atau meniru kemampuan seorang pakar.
                                    Pakar yang dimaksud disini ialah orang yang mempunyai keahlian khusus yang dapat
                                    menyelesaikan masalah yang tidak dapat diselesaikan orang awam. Contohnya dokter,
                                    mekanik, psikolog dan lain-lain.</p>
                                <a href="#"
                                    class="bg-white text-black font-semibold px-6 py-2 rounded-full shadow-md hover:bg-blue-50 transition ml-16">Sistem
                                    Pakar</a>
                            </div>
                            <div class="md:w-1/2 flex justify-center mt-6 md:mt-0">
                                <div class="bg-transparan">
                                    <img src="{{ asset('/assets/home-1.gif') }}" alt="Layanan Kesehatan"
                                        class=" rounded-lg h-96 w-full object-cover"
                                        onerror="this.src='/api/placeholder/400/300'; this.alt='Placeholder Image'">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section bg-gradient-to-b from-white p-8" style="--tw-gradient-to: #00C8FF;">
                        <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center">

                            <div class="md:w-1/2 text-white md:pl-8">
                                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-black ml-16">Diagnosa Penyakit</h1>
                                <p class="text-lg mb-6 text-black leading-relaxed text-justify ml-16">Sistem ini bekerja
                                    dengan mengumpulkan data tentang gejala-gejala yang dirasakan oleh pasien, melakukan
                                    analisis dan pemrosesan data, dan membandingkan data tersebut dengan basis
                                    pengetahuan tentang berbagai macam penyakit. Setelah itu, sistem akan memberikan
                                    hasil diagnosa yang sesuai dengan gejala-gejala yang dirasakan oleh pasien.</p>
                                <a href="#"
                                    class="bg-white text-black font-semibold px-6 py-2 rounded-full shadow-md hover:bg-green-50 transition ml-16">Diagnosa
                                    Penyakit</a>
                            </div>
                            <div class="md:w-1/2 flex justify-center mb-6 md:mb-0">
                                <div class="bg-transparan">
                                    <img src="{{ asset('/assets/home-1.gif') }}" alt="Dokter Spesialis"
                                        class="rounded-lg h-96  w-full object-cover"
                                        onerror="this.src='/api/placeholder/400/300'; this.alt='Placeholder Image'">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section bg-gradient-to-b from-white p-8" style="--tw-gradient-to: #00C8FF;">
                        <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center">

                            <div class="md:w-1/2 text-white md:pl-8">
                                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-black ml-16">Fitur Diagnosa</h1>
                                <p class="text-lg mb-6 text-black leading-relaxed text-justify ml-16">Seluruh data yang
                                    dianalisis dan diproses dalam sistem kami, mulai dari gejala, penyakit, hingga
                                    pengambilan keputusan tindakan, bersumber dari jurnal-jurnal terpercaya. Sistem ini
                                    memiliki sejumlah keunggulan, seperti tingkat akurasi diagnosa yang tinggi,
                                    efisiensi waktu dan biaya, ketersediaan selama 24 jam, serta dapat menjadi panduan
                                    bagi masyarakat. Namun demikian, sistem ini juga memiliki keterbatasan, antara lain
                                    tidak dapat menggantikan peran dokter, tidak mempertimbangkan faktor emosional
                                    pasien, memiliki pengetahuan yang masih terbatas, serta menimbulkan ketergantungan
                                    terhadap teknologi.</p>
                                <a href="#"
                                    class="bg-white text-black font-semibold px-6 py-2 rounded-full shadow-md hover:bg-green-50 transition ml-16">Diagnosa
                                    Penyakit</a>
                            </div>
                            <div class="md:w-1/2 flex justify-center mb-6 md:mb-0">
                                <div class="bg-transparan">
                                    <img src="{{ asset('/assets/home-1.gif') }}" alt="Dokter Spesialis"
                                        class="rounded-lg h-96  w-full object-cover"
                                        onerror="this.src='/api/placeholder/400/300'; this.alt='Placeholder Image'">
                                </div>
                            </div>
                        </div>
                    </div>



                </div>


                <!-- Tombol Navigasi -->
                <div class="carousel-button carousel-button-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevron-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </div>

                <div class="carousel-button carousel-button-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>

                <!-- Indikator Slide (Dots) -->
                <div class="carousel-dots">
                    <div class="carousel-dot active"></div>
                    <div class="carousel-dot"></div>
                    <div class="carousel-dot"></div>

                </div>

            </div>
        </div>
    </div>
    <!-- rumah sakit -->
    <div class="my-0">
        <div id="fullPage2" class="w-full">
            <!-- Carousel Container -->
            <div class="carousel-container relative">
                <div class="carousel-slides">


                    <div class="section bg-gradient-to-b from-white to-white p-8"
                        style="--tw-gradient-from: #04C8FF; --tw-gradient-to: #832BFF;">
                        <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 flex justify-center mb-6 md:mb-0">
                                <div class="bg-transparan">
                                    <img src="{{ asset('/assets/home-2.gif') }}" alt="Dokter Spesialis"
                                        class="rounded-lg h-96 w-full object-cover"
                                        onerror="this.src='/api/placeholder/400/300'; this.alt='Placeholder Image'">
                                </div>
                            </div>
                            <div class="md:w-1/2 text-white md:pl-8">
                                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-black mr-16">Rumah Sakit</h1>
                                <p class="text-lg mb-6 text-black leading-relaxed text-justify mr-16">Fitur ini
                                    memberikan informasi mengenai ketersediaan rumah sakit dan tempat tidur untuk pasien
                                    COVID-19 maupun non-COVID di seluruh Indonesia. Namun, karena data dari pusat dapat
                                    berubah sewaktu-waktu, kemungkinan kesalahan informasi bisa terjadi. Jika menemukan
                                    ketidaksesuaian, silakan hubungi kontak kami untuk melaporkan.</p>
                                <a href="#"
                                    class="bg-white text-black font-semibold px-6 py-2 rounded-full shadow-md hover:bg-green-50 transition mr-16">Cek
                                    Ketersediaan</a>
                            </div>
                        </div>
                    </div>

                    <div class="section bg-gradient-to-b from-white to-white p-8"
                        style="--tw-gradient-from: #04C8FF; --tw-gradient-to: #832BFF;">
                        <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 flex justify-center mt-6 md:mt-0">
                                <div class="bg-transparan p-4">
                                    <img src="{{ asset('/assets/home-2.gif') }}" alt="Fasilitas Modern"
                                        class="rounded-lg h-96 w-full object-cover"
                                        onerror="this.src='/api/placeholder/400/300'; this.alt='Placeholder Image'">
                                </div>
                            </div>

                            <div class="md:w-1/2 text-white">
                                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-black mr-16">Informasi Ketersediaan
                                    RS</h1>
                                <p class="text-lg mb-6 text-black leading-relaxed text-justify mr-16">Layanan ini
                                    menyediakan informasi mengenai rumah sakit yang tersedia di seluruh Indonesia.
                                    Pengguna dapat memilih provinsi untuk melihat daftar rumah sakit yang berada di
                                    wilayah tersebut. Informasi yang ditampilkan mencakup nama rumah sakit, lokasi,
                                    serta ketersediaan layanan rumah sakit yang dapat membantu masyarakat dalam mencari
                                    rumah sakit yang sesuai dengan kebutuhan mereka.</p>
                                <a href="#"
                                    class="bg-white text-black font-semibold px-6 py-2 rounded-full shadow-md hover:bg-purple-50 transition mr-16">Cek
                                    Ketersediaan</a>
                            </div>

                        </div>
                    </div>





                </div>


                <!-- Tombol Navigasi -->
                <div class="carousel-button carousel-button-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevron-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </div>

                <div class="carousel-button carousel-button-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>

                <!-- Indikator Slide (Dots) -->
                <div class="carousel-dots">
                    <div class="carousel-dot active"></div>
                    <div class="carousel-dot"></div>

                </div>

            </div>
        </div>
    </div>
    <!-- blog -->
    <div class="mb-8">
        <div id="fullPage3" class="w-full">
            <!-- Carousel Container -->
            <div class="carousel-container relative">
                <div class="carousel-slides">
                    <div class="section bg-gradient-to-b from-white to-white p-8 mb-20"
                        style="--tw-gradient-from: #822DFF; --tw-gradient-to: #FFFFFF;">
                        <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 text-white md:pl-8">
                                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-black ml-16">Blog Kesehatan</h1>
                                <p class="text-lg mb-6 text-black leading-relaxed text-justify ml-16">Fitur ini berisi
                                    artikel-artikel tentang kesehatan dan gaya hidup sehat yang dapat dibaca oleh
                                    pengunjung. Artikel-artikel ini ditujukan untuk membantu meningkatkan kesadaran
                                    masyarakat akan pentingnya menjaga kesehatan dan memberikan informasi serta saran
                                    yang berguna untuk menjaga kesehatan secara umum. Pengguna dapat menjelajahi
                                    berbagai topik, mulai dari tips hidup sehat, pola makan yang baik, hingga cara
                                    menjaga kesehatan mental.</p>
                                <a href="#"
                                    class="bg-white text-black font-semibold px-6 py-2 rounded-full shadow-md hover:bg-green-50 transition ml-16">Baca
                                    Blog</a>
                            </div>

                            <div class="md:w-1/2 flex justify-center mb-6 md:mb-0">
                                <div class="bg-transparan">
                                    <img src="{{ asset('/assets/home-3.gif') }}" alt="Dokter Spesialis"
                                        class="rounded-lg h-96 w-full object-cover"
                                        onerror="this.src='/api/placeholder/400/300'; this.alt='Placeholder Image'">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>






</x-layout>

<!-- CSS untuk Carousel -->
<style>
    .carousel-container {
        overflow: hidden;
        position: relative;
    }

    .carousel-slides {
        display: flex;
        transition: transform 0.5s ease;
    }

    .section {
        flex: 0 0 100%;
        min-height: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .carousel-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .carousel-button-left {
        left: 20px;
    }

    .carousel-button-right {
        right: 20px;
    }

    .carousel-dots {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
    }

    .carousel-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .carousel-dot.active {
        background-color: white;
        transform: scale(1.2);
    }
</style>

<!-- JS untuk Carousel -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk menginisialisasi setiap carousel
        function initCarousel(carouselId) {
            const carouselContainer = document.querySelector(carouselId);
            if (!carouselContainer) return; // Pastikan carousel ada

            const slidesContainer = carouselContainer.querySelector('.carousel-slides');
            const slides = carouselContainer.querySelectorAll('.section');
            const slideCount = slides.length;
            const dots = carouselContainer.querySelectorAll('.carousel-dot');
            const leftButton = carouselContainer.querySelector('.carousel-button-left');
            const rightButton = carouselContainer.querySelector('.carousel-button-right');

            let currentSlide = 0;

            // Function to go to a specific slide
            function goToSlide(slideIndex) {
                currentSlide = slideIndex;

                // Adjust the position of the slides
                slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;

                // Update the active dot
                carouselContainer.querySelectorAll('.carousel-dot').forEach((dot, index) => {
                    if (index === currentSlide) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }

            // Buat dots sesuai dengan jumlah slide di carousel ini
            const dotsContainer = carouselContainer.querySelector('.carousel-dots');
            if (dotsContainer) {
                // Hapus semua dots yang ada
                dotsContainer.innerHTML = '';

                // Buat dots baru sesuai jumlah slide
                for (let i = 0; i < slideCount; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
                    dot.addEventListener('click', function() {
                        goToSlide(i);
                    });
                    dotsContainer.appendChild(dot);
                }
            }

            // Event listeners untuk tombol navigasi
            if (leftButton) {
                leftButton.addEventListener('click', function() {
                    if (currentSlide > 0) {
                        goToSlide(currentSlide - 1);
                    } else {
                        goToSlide(slideCount - 1); // Wrap around to the last slide
                    }
                });
            }

            if (rightButton) {
                rightButton.addEventListener('click', function() {
                    if (currentSlide < slideCount - 1) {
                        goToSlide(currentSlide + 1);
                    } else {
                        goToSlide(0); // Wrap around to the first slide
                    }
                });
            }

            // Add swipe support for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            carouselContainer.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            }, false);

            carouselContainer.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, false);

            function handleSwipe() {
                if (touchEndX < touchStartX - 50) {
                    // Swipe left
                    if (currentSlide < slideCount - 1) {
                        goToSlide(currentSlide + 1);
                    } else {
                        goToSlide(0);
                    }
                }

                if (touchEndX > touchStartX + 50) {
                    // Swipe right
                    if (currentSlide > 0) {
                        goToSlide(currentSlide - 1);
                    } else {
                        goToSlide(slideCount - 1);
                    }
                }
            }

            // Auto-slide functionality
            let autoSlideInterval = setInterval(function() {
                if (currentSlide < slideCount - 1) {
                    goToSlide(currentSlide + 1);
                } else {
                    goToSlide(0);
                }
            }, 7000); // Change slide every 7 seconds

            // Pause auto-slide when interacting with carousel
            carouselContainer.addEventListener('mouseenter', function() {
                clearInterval(autoSlideInterval);
            });

            carouselContainer.addEventListener('mouseleave', function() {
                autoSlideInterval = setInterval(function() {
                    if (currentSlide < slideCount - 1) {
                        goToSlide(currentSlide + 1);
                    } else {
                        goToSlide(0);
                    }
                }, 7000);
            });
        }

        // Inisialisasi ketiga carousel secara terpisah
        initCarousel('#fullPage');
        initCarousel('#fullPage2');
        initCarousel('#fullPage3');

        // Tambahkan keyboard support
        document.addEventListener('keydown', function(e) {
            // Tentukan carousel mana yang sedang aktif/terlihat
            // Ini contoh sederhana, Anda mungkin perlu logika yang lebih kompleks
            // berdasarkan posisi scroll atau interaksi user terakhir
            const activeCarousel = document.querySelector(':hover > .carousel-container') ||
                document.querySelector('#fullPage');

            if (!activeCarousel) return;

            const slides = activeCarousel.querySelectorAll('.section');
            const slideCount = slides.length;
            let currentSlide = parseInt(activeCarousel.getAttribute('data-current-slide') || '0');

            if (e.key === 'ArrowLeft') {
                currentSlide = currentSlide > 0 ? currentSlide - 1 : slideCount - 1;
            } else if (e.key === 'ArrowRight') {
                currentSlide = currentSlide < slideCount - 1 ? currentSlide + 1 : 0;
            } else {
                return;
            }

            // Trigger click pada dot yang sesuai untuk mengubah slide
            const dots = activeCarousel.querySelectorAll('.carousel-dot');
            if (dots[currentSlide]) {
                dots[currentSlide].click();
            }

            activeCarousel.setAttribute('data-current-slide', currentSlide.toString());
        });
    });
    // Make the animation delay slightly different for each card to create a sequenced effect
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.animate-fade-in-up');

        // Apply slight delay between animations
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 150}ms`;
        });
    });
</script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                animation: {
                    'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                },
                keyframes: {
                    fadeInUp: {
                        '0%': {
                            opacity: '0',
                            transform: 'translateY(20px)'
                        },
                        '100%': {
                            opacity: '1',
                            transform: 'translateY(0)'
                        }
                    }
                }
            }
        }
    }
</script>
<style type="text/tailwind">
    @layer utilities {
        .animation-delay-100 {
            animation-delay: 100ms;
        }

        .animation-delay-200 {
            animation-delay: 200ms;
        }

        .animation-delay-300 {
            animation-delay: 300ms;
        }

        .animation-delay-400 {
            animation-delay: 400ms;
        }

        .full-width-underline::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: white;
            transition: width 0.3s ease;
        }
    }
</style>
