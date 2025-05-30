<x-layout title="Healthcare Alomany - Riwayat Sistem Pakar">
    <x-sistem-pakar-hero />

    <div class="px-4 md:px-8 lg:px-20 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header with navigation and actions -->
            <div class="bg-gray-50 border-b border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ url()->previous() }}"
                            class="mr-4 text-gray-700 hover:text-blue-600 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Riwayat Pengecekan</h1>
                    </div>
                    <div class="flex items-center">
                        <button onclick="window.print()"
                            class="flex items-center text-gray-700 hover:text-blue-600 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Date and time information -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="mb-3 md:mb-0">
                        <span class="text-sm text-gray-500">Tanggal & Waktu Pemeriksaan</span>
                        <p class="text-lg font-medium text-gray-800">20 Agustus 2025 | 02:45 a.m</p>
                    </div>
                    <div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <span class="mr-1 h-2 w-2 rounded-full bg-blue-500"></span>
                            Riwayat Pemeriksaan #12345
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main content with symptoms and diagnosis -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left column: Symptoms reported -->
                    <div>
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Gejala yang dialami
                            </h2>
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                                @foreach ($session->gejalas as $gejala)
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <span
                                                class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-500 flex items-center justify-center mt-1">
                                                <svg class="h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                            <span class="ml-3 text-gray-700">Sakit gigi</span>
                                        </li>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right column: Diagnosis results -->
                    <div>
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                                Kemungkinan Sakit yang Dialami
                            </h2>
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                                <ul class="space-y-4">
                                    <li>
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-gray-700 font-medium">Sakit hati</span>
                                            <span class="text-sm font-medium text-red-600">85%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-red-500 h-2 rounded-full" style="width: 85%"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-gray-700 font-medium">Depresi</span>
                                            <span class="text-sm font-medium text-yellow-600">65%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 65%"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-gray-700 font-medium">Radang gigi</span>
                                            <span class="text-sm font-medium text-blue-600">45%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: 45%"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-gray-700 font-medium">Karang gigi</span>
                                            <span class="text-sm font-medium text-green-600">25%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="c h-2 rounded-full" style="width: 25%"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendation section -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        Rekomendasi
                    </h2>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-5">
                        <p class="text-gray-700 mb-4">Berdasarkan gejala yang Anda alami, berikut adalah rekomendasi
                            untuk pemeriksaan lebih lanjut:</p>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="ml-3 text-gray-700">Konsultasikan dengan dokter gigi untuk mengatasi masalah
                                    gigi Anda</p>
                            </div>
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="ml-3 text-gray-700">Lakukan pemeriksaan kesehatan mental dengan psikolog atau
                                    psikiater</p>
                            </div>
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="ml-3 text-gray-700">Istirahat yang cukup dan minum air putih yang banyak</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disclaimer and actions -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 mt-1"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="ml-3 text-sm text-yellow-700">
                                <span class="font-medium">Perhatian:</span> Sistem ini hanya memberikan perkiraan awal
                                dan tidak menggantikan diagnosis medis profesional. Selalu konsultasikan dengan tenaga
                                medis untuk penanganan yang tepat.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:justify-between items-center">
                        <a href="#"
                            class="mb-4 md:mb-0 text-blue-600 hover:text-blue-800 transition-colors duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
                                    clip-rule="evenodd" />
                            </svg>
                            Buat Pengecekan Baru
                        </a>
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition-colors duration-200">
                            Jadwalkan Konsultasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
