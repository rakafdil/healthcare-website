<x-layout title="Healthcare Alomany - Dashboard">
    <x-slot name="heading">Dashboard</x-slot>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Alomany - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .pulse-dot {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Hero Section -->
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="relative z-10">
                    <h1 class="text-4xl font-bold text-white mb-2">Selamat Datang, Admin</h1>
                    <p class="text-xl text-blue-100 max-w-3xl">
                        Pantau aktivitas dan statistik sistem Healthcare Alomany secara real-time melalui dashboard ini.
                    </p>
                    <div class="mt-6 flex space-x-4">
                        <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i> Refresh Data
                        </button>
                        <button class="bg-blue-800 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                            <i class="fas fa-download mr-2"></i> Export Laporan
                        </button>
                    </div>
                </div>
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-500 rounded-full opacity-20"></div>
                <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-purple-500 rounded-full opacity-20"></div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Pengunjung -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-100 rounded-full opacity-20"></div>
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-200 rounded-full opacity-20"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pengunjung</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">12,845</p>
                            <p class="text-green-500 text-xs font-medium mt-1 flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 24.5% dari bulan lalu
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Registrasi Pengguna -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-100 rounded-full opacity-20"></div>
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-200 rounded-full opacity-20"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Pengguna Terdaftar</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">3,742</p>
                            <p class="text-green-500 text-xs font-medium mt-1 flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 18.2% dari bulan lalu
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-plus text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Diagnosa -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-100 rounded-full opacity-20"></div>
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-200 rounded-full opacity-20"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Diagnosa</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">8,156</p>
                            <p class="text-green-500 text-xs font-medium mt-1 flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 32.1% dari bulan lalu
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-diagnoses text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pencarian Artikel -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-100 rounded-full opacity-20"></div>
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-200 rounded-full opacity-20"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Pencarian Artikel</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">5,893</p>
                            <p class="text-green-500 text-xs font-medium mt-1 flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 12.7% dari bulan lalu
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-search text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Pengunjung Harian -->
                {{-- <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-50 card-hover">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Pengunjung Harian</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-lg">Minggu Ini</button>
                            <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-lg">Bulan Ini</button>
                        </div>
                    </div>
                    <canvas id="visitorsChart" class="w-full h-80"></canvas>
                </div> --}}

                <!-- Penggunaan Fitur -->
                {{-- <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-50 card-hover">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Penggunaan Fitur</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-lg">7 Hari</button>
                            <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-lg">30 Hari</button>
                        </div>
                    </div>
                    <canvas id="featuresChart" class="w-full h-80"></canvas>
                </div> --}}
            </div>

            <!-- Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Pencarian Artikel Terpopuler -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-newspaper mr-2"></i> Artikel Terpopuler
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                                    <span class="text-gray-700 font-medium">Cara Mencegah Penyakit Jantung</span>
                                </div>
                                <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-bold">2,845</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                                    <span class="text-gray-700 font-medium">Gejala Awal Diabetes dan Pencegahannya</span>
                                </div>
                                <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-bold">1,932</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                                    <span class="text-gray-700 font-medium">Pola Makan Sehat untuk Kolesterol Tinggi</span>
                                </div>
                                <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-bold">1,567</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
                                    <span class="text-gray-700 font-medium">Manfaat Olahraga Rutin untuk Kesehatan Mental</span>
                                </div>
                                <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-bold">1,245</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">5</span>
                                    <span class="text-gray-700 font-medium">Cara Mengatasi Insomnia Secara Alami</span>
                                </div>
                                <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-bold">987</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gejala yang Sering Dialami -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-800 p-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-head-side-virus mr-2"></i> Gejala Tersering
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-head-side-virus text-red-500 mr-3"></i>
                                    <span class="text-gray-700 font-medium">Sakit Kepala</span>
                                </div>
                                <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold">1,245</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-thermometer-half text-red-500 mr-3"></i>
                                    <span class="text-gray-700 font-medium">Demam Tinggi</span>
                                </div>
                                <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold">987</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-lungs text-red-500 mr-3"></i>
                                    <span class="text-gray-700 font-medium">Sesak Napas</span>
                                </div>
                                <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold">845</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-tooth text-red-500 mr-3"></i>
                                    <span class="text-gray-700 font-medium">Sakit Gigi</span>
                                </div>
                                <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold">732</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-stomach text-red-500 mr-3"></i>
                                    <span class="text-gray-700 font-medium">Sakit Perut</span>
                                </div>
                                <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold">689</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Location & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Lokasi Pengguna -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-800 p-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i> Lokasi Pengguna
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-city text-blue-500 mr-2"></i>
                                        <span class="text-gray-700 font-medium">Jakarta</span>
                                    </div>
                                    <span class="text-gray-600 font-bold">42.5%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full shadow-sm" style="width: 42.5%"></div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-city text-blue-500 mr-2"></i>
                                        <span class="text-gray-700 font-medium">Bandung</span>
                                    </div>
                                    <span class="text-gray-600 font-bold">18.3%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full shadow-sm" style="width: 18.3%"></div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-city text-blue-500 mr-2"></i>
                                        <span class="text-gray-700 font-medium">Surabaya</span>
                                    </div>
                                    <span class="text-gray-600 font-bold">15.7%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full shadow-sm" style="width: 15.7%"></div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-city text-blue-500 mr-2"></i>
                                        <span class="text-gray-700 font-medium">Medan</span>
                                    </div>
                                    <span class="text-gray-600 font-bold">8.2%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full shadow-sm" style="width: 8.2%"></div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-city text-blue-500 mr-2"></i>
                                        <span class="text-gray-700 font-medium">Lainnya</span>
                                    </div>
                                    <span class="text-gray-600 font-bold">15.3%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full shadow-sm" style="width: 15.3%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Terbaru -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-800 p-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-history mr-2"></i> Aktivitas Terbaru
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 pulse-dot"></div>
                                <div class="flex-1">
                                    <p class="text-gray-800 font-medium">
                                        <span class="text-blue-600 font-bold">Andi Wijaya</span> 
                                        melakukan diagnosa untuk gejala sakit kepala dan demam
                                    </p>
                                    <p class="text-gray-500 text-sm flex items-center mt-1">
                                        <i class="far fa-clock mr-1"></i>
                                        5 menit yang lalu
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 pulse-dot"></div>
                                <div class="flex-1">
                                    <p class="text-gray-800 font-medium">
                                        <span class="text-blue-600 font-bold">Budi Santoso</span> 
                                        membaca artikel "Cara Mencegah Penyakit Jantung"
                                    </p>
                                    <p class="text-gray-500 text-sm flex items-center mt-1">
                                        <i class="far fa-clock mr-1"></i>
                                        12 menit yang lalu
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 pulse-dot"></div>
                                <div class="flex-1">
                                    <p class="text-gray-800 font-medium">
                                        <span class="text-blue-600 font-bold">Citra Dewi</span> 
                                        mendaftar sebagai pengguna baru
                                    </p>
                                    <p class="text-gray-500 text-sm flex items-center mt-1">
                                        <i class="far fa-clock mr-1"></i>
                                        25 menit yang lalu
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 pulse-dot"></div>
                                <div class="flex-1">
                                    <p class="text-gray-800 font-medium">
                                        <span class="text-blue-600 font-bold">Dian Permata</span> 
                                        melakukan konsultasi online dengan Dr. Ahmad
                                    </p>
                                    <p class="text-gray-500 text-sm flex items-center mt-1">
                                        <i class="far fa-clock mr-1"></i>
                                        1 jam yang lalu
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 pulse-dot"></div>
                                <div class="flex-1">
                                    <p class="text-gray-800 font-medium">
                                        <span class="text-blue-600 font-bold">Eko Prasetyo</span> 
                                        mencari rumah sakit terdekat untuk periksa mata
                                    </p>
                                    <p class="text-gray-500 text-sm flex items-center mt-1">
                                        <i class="far fa-clock mr-1"></i>
                                        2 jam yang lalu
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data untuk chart pengunjung harian
        const visitorLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        const visitorCounts = [1245, 1892, 2103, 1987, 2345, 1876, 1567];

        // Chart untuk Pengunjung Harian
        const visitorsCtx = document.getElementById('visitorsChart').getContext('2d');
        new Chart(visitorsCtx, {
            type: 'line',
            data: {
                labels: visitorLabels,
                datasets: [{
                    label: 'Pengunjung',
                    data: visitorCounts,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        cornerRadius: 12,
                        padding: 12
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            stepSize: 500
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Chart untuk Penggunaan Fitur
        const featuresCtx = document.getElementById('featuresChart').getContext('2d');
        new Chart(featuresCtx, {
            type: 'doughnut',
            data: {
                labels: ['Diagnosa', 'Konsultasi', 'Artikel', 'Rumah Sakit'],
                datasets: [{
                    data: [2156, 1245, 1893, 876],
                    backgroundColor: [
                        '#3B82F6',
                        '#10B981',
                        '#F59E0B',
                        '#8B5CF6'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        cornerRadius: 12,
                        padding: 12
                    }
                },
                cutout: '70%',
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });
    </script>
</body>
</html>

</x-layout>