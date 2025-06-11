<x-layout title="Healthcare Alomany - Tentang Kami">
    <x-slot:heading>About</x-slot:heading>
    
    <!-- Main Content -->
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white">
        <!-- Hero Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="flex flex-col lg:flex-row items-center">
                    <div class="lg:w-1/2 mb-10 lg:mb-0">
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                            Revolusi <span class="text-blue-600">Diagnosis Kesehatan</span> Digital
                        </h1>
                        <p class="text-lg text-gray-600 mb-8">
                            Healthcare Alomany hadir untuk memberikan solusi diagnosis penyakit berbasis AI 
                            yang akurat, cepat, dan terpercaya. Platform kami menggabungkan teknologi 
                            mutakhir dengan pengetahuan medis untuk membantu Anda memahami kondisi kesehatan.
                        </p>
                        <div class="flex space-x-4">
                            <a href="/sistem-pakar" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
                                Coba Diagnosis Sekarang
                            </a>
                            <a href="/blog" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-medium transition duration-300">
                                Baca Artikel Kesehatan
                            </a>
                        </div>
                    </div>
                    <div class="lg:w-1/2 flex justify-center">
                        <img src="/assets/Logo.png" alt="Healthcare Illustration" class="w-full max-w-md lg:max-w-lg">
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="py-16 bg-blue-50">
            <div class="container mx-auto px-6 lg:px-12">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Misi Kami</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-800">Diagnosis Akurat</h3>
                        <p class="text-gray-600">
                            Menggunakan algoritma AI terbaru yang terus diperbarui dengan basis pengetahuan medis terkini untuk memberikan hasil diagnosis yang dapat diandalkan.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-800">Rekomendasi Personal</h3>
                        <p class="text-gray-600">
                            Tidak hanya diagnosis, kami memberikan rekomendasi artikel kesehatan terkait dan rumah sakit terdekat berdasarkan lokasi Anda.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-800">Privasi Terjaga</h3>
                        <p class="text-gray-600">
                            Data kesehatan Anda aman bersama kami. Sistem enkripsi mutakhir melindungi semua informasi pribadi dan riwayat diagnosis Anda.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6 lg:px-12">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Bagaimana Healthcare Alomany Bekerja?</h2>
                <p class="text-lg text-center text-gray-600 max-w-3xl mx-auto mb-12">
                    Hanya dengan 3 langkah sederhana, dapatkan diagnosis awal dan rekomendasi kesehatan yang Anda butuhkan.
                </p>
                
                <div class="relative">
                    <!-- Timeline -->
                    <div class="hidden md:block absolute top-1/2 left-0 right-0 h-1 bg-gray-200 transform -translate-y-1/2"></div>
                    
                    <div class="grid md:grid-cols-3 gap-8 relative">
                        <!-- Step 1 -->
                        <div class="bg-blue-50 p-8 rounded-xl text-center">
                            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6 mx-auto">1</div>
                            <h3 class="text-xl font-semibold mb-3 text-gray-800">Masukkan Gejala</h3>
                            <p class="text-gray-600">
                                Jelaskan gejala yang Anda alami melalui antarmuka yang mudah digunakan atau pilih dari daftar gejala yang tersedia.
                            </p>
                        </div>
                        
                        <!-- Step 2 -->
                        <div class="bg-blue-50 p-8 rounded-xl text-center">
                            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6 mx-auto">2</div>
                            <h3 class="text-xl font-semibold mb-3 text-gray-800">Analisis AI</h3>
                            <p class="text-gray-600">
                                Sistem AI kami akan menganalisis gejala Anda dengan membandingkan ribuan kasus medis dan literatur terkini.
                            </p>
                        </div>
                        
                        <!-- Step 3 -->
                        <div class="bg-blue-50 p-8 rounded-xl text-center">
                            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6 mx-auto">3</div>
                            <h3 class="text-xl font-semibold mb-3 text-gray-800">Hasil & Rekomendasi</h3>
                            <p class="text-gray-600">
                                Dapatkan diagnosis awal, artikel kesehatan terkait, dan rekomendasi fasilitas kesehatan terdekat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Technology Section -->
        <section class="py-16 bg-blue-50">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="flex flex-col lg:flex-row items-center">
                    <div class="lg:w-1/2 mb-10 lg:mb-0 lg:pr-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">Teknologi Canggih di Balik Platform Kami</h2>
                        <p class="text-lg text-gray-600 mb-8">
                            Healthcare Alomany menggunakan model machine learning terbaru yang dilatih dengan jutaan data medis untuk memberikan hasil yang akurat dan dapat dipercaya.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Natural Language Processing untuk memahami deskripsi gejala secara alami</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Algoritma prediktif berbasis deep learning</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Database medis yang terus diperbarui</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Sistem geolokasi untuk rekomendasi fasilitas kesehatan</span>
                            </li>
                        </ul>
                    </div>
                    <div class="lg:w-1/2">
                        <div class="bg-white p-8 rounded-xl shadow-lg">
                            <div class="relative h-80">
                                <div class="absolute top-0 left-0 w-full h-full bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                    </svg>
                                </div>
                                <div class="absolute top-1/4 right-1/4 w-32 h-32 bg-white rounded-lg shadow-md flex items-center justify-center transform rotate-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div class="absolute bottom-1/4 left-1/4 w-24 h-24 bg-white rounded-lg shadow-md flex items-center justify-center transform -rotate-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6 lg:px-12">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Tim Kami</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Team Member 1 -->
                    <div class="bg-blue-50 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2">
                        <div class="h-48 bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Dzaky Rezandi</h3>
                            <p class="text-blue-600 mb-3">Authentication & Security Lead</p>
                            <p class="text-gray-600 text-sm">
                                Mengelola sistem autentikasi pengguna dan memastikan keamanan data dalam platform.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Team Member 2 -->
                    <div class="bg-blue-50 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2">
                        <div class="h-48 bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Muhammad Raka Fadillah</h3>
                            <p class="text-blue-600 mb-3">Expert System Lead</p>
                            <p class="text-gray-600 text-sm">
                                Bertanggung jawab dalam pengembangan sistem pakar berbasis machine learning untuk diagnosis dan prediksi penyakit.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Team Member 3 -->
                    <div class="bg-blue-50 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2">
                        <div class="h-48 bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Very Fachrurozi</h3>
                            <p class="text-blue-600 mb-3">Location Services & Hospital Integration Lead</p>
                            <p class="text-gray-600 text-sm">
                                Mengembangkan fitur pelacakan lokasi real-time untuk menampilkan rumah sakit terdekat serta integrasi data rumah sakit berdasarkan wilayah pengguna.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Team Member 4 -->
                    <div class="bg-blue-50 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2">
                        <div class="h-48 bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Rifki Cahyono</h3>
                            <p class="text-blue-600 mb-3">Content Recommendation & Medical Content Lead</p>
                            <p class="text-gray-600 text-sm">
                                Mengembangkan sistem rekomendasi blog/artikel terkait penyakit dan bertanggung jawab atas kualitas konten edukasi medis di platform.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800">
            <div class="container mx-auto px-6 lg:px-12 text-center">
                <h2 class="text-3xl font-bold text-white mb-6">Siap Memulai Perjalanan Kesehatan Digital Anda?</h2>
                <p class="text-lg text-blue-100 mb-8 max-w-3xl mx-auto">
                    Bergabunglah dengan ribuan pengguna yang telah merasakan kemudahan diagnosis awal secara digital dengan Healthcare Alomany.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="/sistem-pakar" class="bg-white text-blue-600 hover:bg-blue-50 px-8 py-3 rounded-lg font-medium transition duration-300">
                        Diagnosis Sekarang
                    </a>
                    <a href="/register" class="border border-white text-white hover:bg-blue-700 px-8 py-3 rounded-lg font-medium transition duration-300">
                        Daftar Akun
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layout>