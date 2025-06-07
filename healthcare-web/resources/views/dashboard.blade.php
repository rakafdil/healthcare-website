<x-layout title="Healthcare Alomany - Dashboard">
    <x-slot name="heading">Dashboard</x-slot>
    
    @push('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-bg-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .gradient-bg-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .gradient-bg-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .pulse-dot { animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .glass-effect { background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.18); }
        .text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF',
                        accent: '#F59E0B'
                    }
                }
            }
        }
    </script>
    @endpush

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 mb-8">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-4 text-shadow">
                    <i class="fas fa-heartbeat mr-3"></i>Healthcare Analytics
                </h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    Monitor dan analisis data kesehatan secara real-time untuk memberikan pelayanan terbaik
                </p>
            </div>
        </div>
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-24 h-24 bg-white opacity-5 rounded-full"></div>
    </div>

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pengunjung -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 gradient-bg-1 rounded-full -mr-10 -mt-10 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Pengunjung</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">15,847</p>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                            <p class="text-green-500 text-sm font-medium">+12.5% dari bulan lalu</p>
                        </div>
                    </div>
                    <div class="gradient-bg-1 p-4 rounded-xl">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Registrasi Pengguna -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 gradient-bg-2 rounded-full -mr-10 -mt-10 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pengguna Terdaftar</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">3,249</p>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                            <p class="text-green-500 text-sm font-medium">+8.2% dari bulan lalu</p>
                        </div>
                    </div>
                    <div class="gradient-bg-2 p-4 rounded-xl">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Diagnosa -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 gradient-bg-3 rounded-full -mr-10 -mt-10 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Diagnosa</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">1,892</p>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-arrow-up text-orange-500 text-xs mr-1"></i>
                            <p class="text-orange-500 text-sm font-medium">+5.4% dari bulan lalu</p>
                        </div>
                    </div>
                    <div class="gradient-bg-3 p-4 rounded-xl">
                        <i class="fas fa-file-medical text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pencarian Artikel -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 gradient-bg-4 rounded-full -mr-10 -mt-10 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pencarian Artikel</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">8,654</p>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-arrow-up text-blue-500 text-xs mr-1"></i>
                            <p class="text-blue-500 text-sm font-medium">+15.7% dari bulan lalu</p>
                        </div>
                    </div>
                    <div class="gradient-bg-4 p-4 rounded-xl">
                        <i class="fas fa-search text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pengunjung Harian -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-50 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Pengunjung Harian</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full pulse-dot"></div>
                        <span class="text-sm text-gray-500">7 Hari Terakhir</span>
                    </div>
                </div>
                <canvas id="visitorsChart" class="w-full h-80"></canvas>
            </div>

            <!-- Penggunaan Fitur -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-50 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Penggunaan Fitur</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full pulse-dot"></div>
                        <span class="text-sm text-gray-500">Real-time</span>
                    </div>
                </div>
                <canvas id="featuresChart" class="w-full h-80"></canvas>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pencarian Artikel Terpopuler -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-fire mr-3"></i>
                        Artikel Terpopuler
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <div class="flex items-center">
                                <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                                <span class="text-gray-700 font-medium">Diabetes</span>
                            </div>
                            <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-bold">1,234</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                            <div class="flex items-center">
                                <span class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                                <span class="text-gray-700 font-medium">Hipertensi</span>
                            </div>
                            <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-bold">987</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-colors">
                            <div class="flex items-center">
                                <span class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                                <span class="text-gray-700 font-medium">Jantung</span>
                            </div>
                            <span class="bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-bold">756</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
                            <div class="flex items-center">
                                <span class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
                                <span class="text-gray-700 font-medium">Asma</span>
                            </div>
                            <span class="bg-purple-500 text-white px-4 py-2 rounded-full text-sm font-bold">643</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-pink-50 rounded-xl hover:bg-pink-100 transition-colors">
                            <div class="flex items-center">
                                <span class="w-8 h-8 bg-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">5</span>
                                <span class="text-gray-700 font-medium">Migrain</span>
                            </div>
                            <span class="bg-pink-500 text-white px-4 py-2 rounded-full text-sm font-bold">521</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gejala yang Sering Dialami -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-pink-600 p-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        Gejala Tersering
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-head-side-virus text-red-500 mr-3"></i>
                                <span class="text-gray-700 font-medium">Sakit Kepala</span>
                            </div>
                            <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold">2,145</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl hover:bg-orange-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-thermometer-half text-orange-500 mr-3"></i>
                                <span class="text-gray-700 font-medium">Demam</span>
                            </div>
                            <span class="bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold">1,876</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-lungs text-yellow-600 mr-3"></i>
                                <span class="text-gray-700 font-medium">Batuk</span>
                            </div>
                            <span class="bg-yellow-600 text-white px-4 py-2 rounded-full text-sm font-bold">1,654</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-dizzy text-green-600 mr-3"></i>
                                <span class="text-gray-700 font-medium">Mual</span>
                            </div>
                            <span class="bg-green-600 text-white px-4 py-2 rounded-full text-sm font-bold">1,432</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-circle text-purple-600 mr-3"></i>
                                <span class="text-gray-700 font-medium">Pusing</span>
                            </div>
                            <span class="bg-purple-600 text-white px-4 py-2 rounded-full text-sm font-bold">1,298</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Location & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lokasi Pengguna -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-blue-600 p-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-map-marker-alt mr-3"></i>
                        Distribusi Lokasi
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
                                <span class="text-gray-600 font-bold">24.5%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full shadow-sm" style="width: 24.5%"></div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-city text-green-500 mr-2"></i>
                                    <span class="text-gray-700 font-medium">Surabaya</span>
                                </div>
                                <span class="text-gray-600 font-bold">18.2%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full shadow-sm" style="width: 18.2%"></div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-city text-yellow-500 mr-2"></i>
                                    <span class="text-gray-700 font-medium">Bandung</span>
                                </div>
                                <span class="text-gray-600 font-bold">15.7%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-3 rounded-full shadow-sm" style="width: 15.7%"></div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-city text-purple-500 mr-2"></i>
                                    <span class="text-gray-700 font-medium">Medan</span>
                                </div>
                                <span class="text-gray-600 font-bold">12.3%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-3 rounded-full shadow-sm" style="width: 12.3%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clock mr-3"></i>
                        Aktivitas Real-time
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 pulse-dot"></div>
                            <div class="flex-1">
                                <p class="text-gray-800 font-medium">
                                    <span class="text-blue-600 font-bold">John Doe</span> melakukan diagnosa untuk gejala sakit kepala
                                </p>
                                <p class="text-gray-500 text-sm flex items-center mt-1">
                                    <i class="far fa-clock mr-1"></i>
                                    2 menit yang lalu
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                            <div class="w-3 h-3 bg-green-500 rounded-full mt-2 pulse-dot"></div>
                            <div class="flex-1">
                                <p class="text-gray-800 font-medium">
                                    <span class="text-green-600 font-bold">Jane Smith</span> mendaftar sebagai pengguna baru
                                </p>
                                <p class="text-gray-500 text-sm flex items-center mt-1">
                                    <i class="far fa-clock mr-1"></i>
                                    5 menit yang lalu
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-colors">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mt-2 pulse-dot"></div>
                            <div class="flex-1">
                                <p class="text-gray-800 font-medium">
                                    <span class="text-yellow-600 font-bold">Ahmad Reza</span> mencari artikel tentang diabetes
                                </p>
                                <p class="text-gray-500 text-sm flex items-center mt-1">
                                    <i class="far fa-clock mr-1"></i>
                                    8 menit yang lalu
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
                            <div class="w-3 h-3 bg-purple-500 rounded-full mt-2 pulse-dot"></div>
                            <div class="flex-1">
                                <p class="text-gray-800 font-medium">
                                    <span class="text-purple-600 font-bold">Siti Nurhaliza</span> menyimpan hasil diagnosa
                                </p>
                                <p class="text-gray-500 text-sm flex items-center mt-1">
                                    <i class="far fa-clock mr-1"></i>
                                    12 menit yang lalu
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                            <div class="w-3 h-3 bg-red-500 rounded-full mt-2 pulse-dot"></div>
                            <div class="flex-1">
                                <p class="text-gray-800 font-medium">
                                    <span class="text-red-600 font-bold">Budi Santoso</span> menggunakan fitur konsultasi
                                </p>
                                <p class="text-gray-500 text-sm flex items-center mt-1">
                                    <i class="far fa-clock mr-1"></i>
                                    15 menit yang lalu
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    // Chart untuk Pengunjung Harian
    const visitorsCtx = document.getElementById('visitorsChart').getContext('2d');
    new Chart(visitorsCtx, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Pengunjung',
                data: [1200, 1900, 3000, 2500, 2200, 3000, 2800],
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
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    });
</script>
@endpush

</x-layout>: