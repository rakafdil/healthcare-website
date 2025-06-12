<x-layout title="Healthcare Alomany - Dashboard">
    <x-slot name="heading">Dashboard</x-slot>
    
    @push('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Styles tetap sama */
    </style>
    @endpush

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 mb-8">
        <!-- Konten hero tetap sama -->
    </div>

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pengunjung -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                <!-- ... -->
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Pengunjung</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalPengunjung) }}</p>
                        <!-- ... -->
                    </div>
                    <!-- ... -->
                </div>
            </div>

            <!-- Registrasi Pengguna -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                <!-- ... -->
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pengguna Terdaftar</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalPengguna) }}</p>
                        <!-- ... -->
                    </div>
                    <!-- ... -->
                </div>
            </div>

            <!-- Total Diagnosa -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                <!-- ... -->
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Diagnosa</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalDiagnosa) }}</p>
                        <!-- ... -->
                    </div>
                    <!-- ... -->
                </div>
            </div>

            <!-- Pencarian Artikel -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-50 card-hover relative overflow-hidden">
                <!-- ... -->
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pencarian Artikel</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalPencarianArtikel) }}</p>
                        <!-- ... -->
                    </div>
                    <!-- ... -->
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pengunjung Harian -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-50 card-hover">
                <!-- ... -->
                <canvas id="visitorsChart" class="w-full h-80"></canvas>
            </div>

            <!-- Penggunaan Fitur -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-50 card-hover">
                <!-- ... -->
                <canvas id="featuresChart" class="w-full h-80"></canvas>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pencarian Artikel Terpopuler -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                <!-- ... -->
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($artikelTerpopuler as $index => $artikel)
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <div class="flex items-center">
                                <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">{{ $index + 1 }}</span>
                                <span class="text-gray-700 font-medium">{{ $artikel->title }}</span>
                            </div>
                            <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-bold">{{ number_format($artikel->views) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Gejala yang Sering Dialami -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                <!-- ... -->
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($gejalaTersering as $gejala)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-head-side-virus text-red-500 mr-3"></i>
                                <span class="text-gray-700 font-medium">{{ $gejala->gejala }}</span>
                            </div>
                            <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold">{{ number_format($gejala->count) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- User Location & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lokasi Pengguna -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                <!-- ... -->
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($lokasiPengguna as $lokasi)
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-city text-blue-500 mr-2"></i>
                                    <span class="text-gray-700 font-medium">{{ $lokasi->city }}</span>
                                </div>
                                <span class="text-gray-600 font-bold">{{ round(($lokasi->count / $totalPengguna) * 100, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full shadow-sm" 
                                     style="width: {{ ($lokasi->count / $totalPengguna) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-50 card-hover overflow-hidden">
                <!-- ... -->
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($aktivitasTerbaru as $aktivitas)
                        <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 pulse-dot"></div>
                            <div class="flex-1">
                                <p class="text-gray-800 font-medium">
                                    <span class="text-blue-600 font-bold">{{ $aktivitas->user->name }}</span> 
                                    melakukan diagnosa untuk gejala {{ $aktivitas->gejala }}
                                </p>
                                <p class="text-gray-500 text-sm flex items-center mt-1">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $aktivitas->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    // Data untuk chart pengunjung harian
    const visitorData = @json($pengunjungHarian);
    const visitorLabels = visitorData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('id-ID', { weekday: 'long' });
    });
    const visitorCounts = visitorData.map(item => item.count);

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
        // ... options tetap sama
    });

    // Chart untuk Penggunaan Fitur
    const featuresCtx = document.getElementById('featuresChart').getContext('2d');
    new Chart(featuresCtx, {
        type: 'doughnut',
        data: {
            labels: ['Diagnosa', 'Konsultasi', 'Artikel', 'Rumah Sakit'],
            datasets: [{
                data: [
                    {{ $penggunaanFitur['diagnosa'] }},
                    {{ $penggunaanFitur['konsultasi'] }},
                    {{ $penggunaanFitur['artikel'] }},
                    {{ $penggunaanFitur['rumah_sakit'] }}
                ],
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
@endpush

</x-layout>