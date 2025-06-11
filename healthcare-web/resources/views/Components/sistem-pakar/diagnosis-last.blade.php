<div class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Kondisi List (Left Panel) -->
            <div class="w-full md:w-1/2">
                <h2 class="text-sm font-semibold mb-4">Kondisi-Kondisi yang Memungkinkan</h2>
                <div id="kondisiList" class="space-y-3">
                    <!-- Sample diagnosis results -->
                    @foreach ($datas as $data)
                        <button
                            class="kondisi-btn w-full text-left py-4 px-6 rounded-xl transition-all duration-300 bg-blue-200 font-semibold"
                            data-index="{{ $loop->index }}" onclick="selectKondisi({{ $loop->index }})">
                            {{ $data->disease }} ({{ $data->probability * 100 }}%)
                        </button>
                    @endforeach

                </div>
            </div>

            <!-- Detail Kondisi (Right Panel) -->
            <div class="w-full md:w-3/4 pl-0 md:pl-6">
                <!-- Title at the top -->
                <h1 class="text-2xl font-semibold mb-6 text-center" id="kondisiTitle">Flu</h1>

                <!-- Centered tabs -->
                <div class="flex justify-center mb-6 border-b">
                    <div class="flex gap-8">
                        <a href="#"
                            class="px-4 py-2 border-b-2 border-blue-500 text-blue-500 transition-colors duration-200 tab-link"
                            id="blogTab" data-tab="blog" onclick="switchTab('blog'); return false;">Blog</a>
                        <a href="#"
                            class="px-4 py-2 border-b-2 border-transparent text-gray-500 transition-colors duration-200 tab-link"
                            id="rumahSakitTab" data-tab="hospital" onclick="switchTab('hospital'); return false;">Rumah
                            Sakit</a>
                    </div>
                </div>

                <!-- Loading indicator -->
                <div id="loadingIndicator" class="hidden text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                    <p class="mt-2 text-gray-600">Mencari rumah sakit terdekat...</p>
                </div>

                <!-- Location status -->
                <div id="locationStatus" class="hidden mb-4 p-3 rounded-lg"></div>

                <!-- Blog Content -->
                <div id="blogContent" class="grid grid-cols-1 gap-6">
                    <!-- Sample blog articles -->
                    <div
                        class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="flex flex-col md:flex-row">
                            <div class="w-full md:w-1/3 h-48">
                                <img src="https://via.placeholder.com/300x200" alt="Article image"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="w-full md:w-2/3 p-4">
                                <h3 class="font-semibold mb-2">5 Langkah Mudah Mengatasi Flu</h3>
                                <p class="text-sm text-gray-600 mb-4">Panduan lengkap untuk mengatasi gejala flu dengan
                                    cepat dan efektif.</p>
                                <a href="#"
                                    class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-200">Baca
                                    Artikel</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rumah Sakit Content -->
                <div id="rumahSakitContent" class="hidden">
                    <div id="hospitalStats" class="grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                            <div class="text-2xl font-bold text-blue-600" id="totalHospitals">-</div>
                            <div class="text-sm text-gray-600">Total RS</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                            <div class="text-2xl font-bold text-green-600" id="averageRating">-</div>
                            <div class="text-sm text-gray-600">Rata-rata Rating</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                            <div class="text-2xl font-bold text-orange-600" id="availableBeds">-</div>
                            <div class="text-sm text-gray-600">Tempat Tidur</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                            <div class="text-2xl font-bold text-purple-600" id="occupancyRate">-%</div>
                            <div class="text-sm text-gray-600">Tingkat Hunian</div>
                        </div>
                    </div>

                    <div id="hospitalList" class="space-y-4">
                        <!-- Hospital data will be populated here -->
                    </div>
                </div>

                <div class="text-right mt-4">
                    <a href="#" class="text-blue-500 hover:underline" id="seeMoreLink">See More</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentKondisi = 0;
        let currentTab = 'blog';
        let userLocation = null;
        let hospitals = [];

        // Sample diagnosis data
        const diagnosisResults = [{
                disease: 'Flu',
                probability: 0.852
            },
            {
                disease: 'Demam',
                probability: 0.728
            },
            {
                disease: 'Alergi',
                probability: 0.453
            }
        ];

        // Sample blog data for each condition
        const kondisiData = {
            0: {
                articles: [{
                        title: "5 Langkah Mudah Mengatasi Flu",
                        excerpt: "Panduan lengkap untuk mengatasi gejala flu dengan cepat dan efektif.",
                        image: "https://via.placeholder.com/300x200"
                    },
                    {
                        title: "Pencegahan Flu yang Efektif",
                        excerpt: "Tips mencegah penularan flu di lingkungan kerja dan rumah.",
                        image: "https://via.placeholder.com/300x200"
                    }
                ]
            },
            1: {
                articles: [{
                        title: "Cara Menurunkan Demam Secara Alami",
                        excerpt: "Metode alami untuk menurunkan demam tanpa obat-obatan kimia.",
                        image: "https://via.placeholder.com/300x200"
                    },
                    {
                        title: "Kapan Harus ke Dokter Saat Demam",
                        excerpt: "Tanda-tanda demam yang memerlukan penanganan medis segera.",
                        image: "https://via.placeholder.com/300x200"
                    }
                ]
            },
            2: {
                articles: [{
                        title: "Mengenal Berbagai Jenis Alergi",
                        excerpt: "Panduan lengkap tentang alergi makanan, udara, dan kulit.",
                        image: "https://via.placeholder.com/300x200"
                    },
                    {
                        title: "Tips Hidup dengan Alergi",
                        excerpt: "Cara mengelola kehidupan sehari-hari dengan kondisi alergi.",
                        image: "https://via.placeholder.com/300x200"
                    }
                ]
            }
        };

        // Function to get user location
        function getUserLocation() {
            return new Promise((resolve, reject) => {
                if (!navigator.geolocation) {
                    reject(new Error('Geolocation tidak didukung oleh browser ini'));
                    return;
                }

                const options = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 300000 // 5 minutes cache
                };

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const location = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                            accuracy: position.coords.accuracy
                        };
                        resolve(location);
                    },
                    (error) => {
                        let errorMessage = 'Gagal mendapatkan lokasi: ';
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Akses lokasi ditolak';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Informasi lokasi tidak tersedia';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Timeout saat mendapatkan lokasi';
                                break;
                            default:
                                errorMessage += 'Error tidak diketahui';
                                break;
                        }
                        reject(new Error(errorMessage));
                    },
                    options
                );
            });
        }

        // Function to fetch nearby hospitals
        async function fetchNearbyHospitals(lat, lng, radius = 10) {
            try {
                const response = await fetch(`/api/hospitals/nearby?lat=${lat}&lng=${lng}&radius=${radius}&limit=10`);
                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'Gagal mengambil data rumah sakit');
                }

                return data.results || [];
            } catch (error) {
                console.error('Error fetching hospitals:', error);
                throw error;
            }
        }

        // Function to fetch hospital statistics
        async function fetchHospitalStats(lat, lng, radius = 10) {
            try {
                const response = await fetch(`/api/hospitals/stats?lat=${lat}&lng=${lng}&radius=${radius}`);
                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'Gagal mengambil statistik rumah sakit');
                }

                return data.stats || {};
            } catch (error) {
                console.error('Error fetching hospital stats:', error);
                return {};
            }
        }

        // Function to display hospitals
        function displayHospitals(hospitalData) {
            const hospitalList = document.getElementById('hospitalList');
            hospitalList.innerHTML = '';

            if (!hospitalData || hospitalData.length === 0) {
                hospitalList.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada rumah sakit ditemukan</h3>
                        <p class="text-gray-500">Coba perluas radius pencarian atau aktifkan lokasi</p>
                    </div>
                `;
                return;
            }

            hospitalData.forEach(hospital => {
                const hospitalCard = document.createElement('div');
                hospitalCard.className =
                    'border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 bg-white';

                // Determine availability status and color
                let availabilityColor = 'gray';
                let availabilityText = 'Tidak diketahui';

                if (hospital.availability) {
                    switch (hospital.availability.status) {
                        case 'high':
                            availabilityColor = 'green';
                            availabilityText = `${hospital.availability.available} tersedia`;
                            break;
                        case 'medium':
                            availabilityColor = 'yellow';
                            availabilityText = `${hospital.availability.available} tersedia`;
                            break;
                        case 'low':
                            availabilityColor = 'orange';
                            availabilityText = `${hospital.availability.available} tersedia`;
                            break;
                        case 'full':
                            availabilityColor = 'red';
                            availabilityText = 'Penuh';
                            break;
                    }
                }

                hospitalCard.innerHTML = `
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/3 h-48">
                            <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                <svg class="h-16 w-16 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <div class="w-full md:w-2/3 p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-lg">${hospital.name}</h3>
                                <div class="flex items-center">
                                    <span class="text-yellow-400">⭐</span>
                                    <span class="text-sm text-gray-600 ml-1">${hospital.rating || 'N/A'}</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">${hospital.vicinity || 'Alamat tidak tersedia'}</p>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    📍 ${hospital.distance ? hospital.distance + ' km' : 'Jarak tidak diketahui'}
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-${availabilityColor}-100 text-${availabilityColor}-800">
                                    🏥 ${availabilityText}
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <a href="/hospital/${hospital.id}"
                                   class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-200 text-sm">
                                    Lihat Detail
                                </a>
                                <button onclick="showDirections(${hospital.geometry.location.lat}, ${hospital.geometry.location.lng})"
                                        class="inline-block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-200 text-sm">
                                    Petunjuk Arah
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                hospitalList.appendChild(hospitalCard);
            });
        }

        // Function to display hospital statistics
        function displayHospitalStats(stats) {
            if (!stats || Object.keys(stats).length === 0) {
                document.getElementById('hospitalStats').classList.add('hidden');
                return;
            }

            document.getElementById('totalHospitals').textContent = stats.total_hospitals || 0;
            document.getElementById('averageRating').textContent = stats.average_rating || 'N/A';
            document.getElementById('availableBeds').textContent = stats.total_available_beds || 0;
            document.getElementById('occupancyRate').textContent = stats.occupancy_rate ? stats.occupancy_rate + '%' :
                'N/A';

            document.getElementById('hospitalStats').classList.remove('hidden');
        }

        // Function to load hospital data
        async function loadHospitalData() {
            const loadingIndicator = document.getElementById('loadingIndicator');
            const locationStatus = document.getElementById('locationStatus');

            try {
                loadingIndicator.classList.remove('hidden');
                locationStatus.classList.add('hidden');

                // Get user location
                userLocation = await getUserLocation();

                // Show location success message
                locationStatus.innerHTML = `
                    <div class="flex items-center text-green-700 bg-green-100">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        Lokasi berhasil ditemukan. Mencari rumah sakit terdekat...
                    </div>
                `;
                locationStatus.classList.remove('hidden');

                // Fetch hospitals and stats
                const [hospitalData, stats] = await Promise.all([
                    fetchNearbyHospitals(userLocation.lat, userLocation.lng),
                    fetchHospitalStats(userLocation.lat, userLocation.lng)
                ]);

                hospitals = hospitalData;

                // Display results
                displayHospitals(hospitals);
                displayHospitalStats(stats);

                // Update location status
                locationStatus.innerHTML = `
                    <div class="flex items-center text-green-700 bg-green-100">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Ditemukan ${hospitals.length} rumah sakit dalam radius 10 km
                    </div>
                `;

            } catch (error) {
                console.error('Error loading hospital data:', error);

                // Show error message
                locationStatus.innerHTML = `
                    <div class="flex items-center text-red-700 bg-red-100">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        ${error.message}. Menampilkan daftar umum rumah sakit.
                    </div>
                `;
                locationStatus.classList.remove('hidden');

                // Load default hospitals (without location)
                try {
                    const defaultHospitals = await fetchNearbyHospitals(-6.2088, 106.8456); // Jakarta coordinates
                    hospitals = defaultHospitals;
                    displayHospitals(hospitals);
                } catch (defaultError) {
                    console.error('Error loading default hospitals:', defaultError);
                    displayHospitals([]);
                }
            } finally {
                loadingIndicator.classList.add('hidden');
            }
        }

        // Function to show directions
        function showDirections(lat, lng) {
            if (userLocation) {
                const url = `https://www.google.com/maps/dir/${userLocation.lat},${userLocation.lng}/${lat},${lng}`;
                window.open(url, '_blank');
            } else {
                const url = `https://www.google.com/maps/search/${lat},${lng}`;
                window.open(url, '_blank');
            }
        }

        // Function to select a condition
        function selectKondisi(kondisiNumber) {
            currentKondisi = kondisiNumber;

            // Update button styles
            document.querySelectorAll('.kondisi-btn').forEach((btn, index) => {
                if (index === kondisiNumber) {
                    btn.classList.add('bg-blue-200', 'font-semibold');
                    btn.classList.remove('bg-blue-100');
                } else {
                    btn.classList.add('bg-blue-100');
                    btn.classList.remove('bg-blue-200', 'font-semibold');
                }
            });

            // Update title
            document.getElementById('kondisiTitle').textContent = diagnosisResults[kondisiNumber].disease;

            // Update content based on current tab
            updateContent();
        }

        // Function to switch between tabs
        function switchTab(tab) {
            currentTab = tab;

            // Update tab styles
            if (tab === 'blog') {
                document.getElementById('blogTab').classList.add('border-blue-500', 'text-blue-500');
                document.getElementById('blogTab').classList.remove('border-transparent', 'text-gray-500');
                document.getElementById('rumahSakitTab').classList.add('border-transparent', 'text-gray-500');
                document.getElementById('rumahSakitTab').classList.remove('border-blue-500', 'text-blue-500');

                document.getElementById('blogContent').classList.remove('hidden');
                document.getElementById('rumahSakitContent').classList.add('hidden');
                document.getElementById('seeMoreLink').href = '/blog';
            } else {
                document.getElementById('rumahSakitTab').classList.add('border-blue-500', 'text-blue-500');
                document.getElementById('rumahSakitTab').classList.remove('border-transparent', 'text-gray-500');
                document.getElementById('blogTab').classList.add('border-transparent', 'text-gray-500');
                document.getElementById('blogTab').classList.remove('border-blue-500', 'text-blue-500');

                document.getElementById('blogContent').classList.add('hidden');
                document.getElementById('rumahSakitContent').classList.remove('hidden');
                document.getElementById('seeMoreLink').href = '/rumah-sakit';

                // Load hospital data when hospital tab is first opened
                if (hospitals.length === 0) {
                    loadHospitalData();
                }
            }

            // Update content based on selected tab
            updateContent();
        }

        // Function to update content based on current tab and selected condition
        function updateContent() {
            if (currentTab === 'blog') {
                // Populate blog content
                const blogContent = document.getElementById('blogContent');
                const kondisi = kondisiData[currentKondisi];

                if (kondisi && kondisi.articles) {
                    blogContent.innerHTML = '';

                    kondisi.articles.forEach(article => {
                        const articleCard = document.createElement('div');
                        articleCard.className =
                            'border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300';
                        articleCard.innerHTML = `
                            <div class="flex flex-col md:flex-row">
                                <div class="w-full md:w-1/3 h-48">
                                    <img src="${article.image}" alt="Article image" class="w-full h-full object-cover">
                                </div>
                                <div class="w-full md:w-2/3 p-4">
                                    <h3 class="font-semibold mb-2">${article.title}</h3>
                                    <p class="text-sm text-gray-600 mb-4">${article.excerpt}</p>
                                    <a href="#" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-200">Baca Artikel</a>
                                </div>
                            </div>
                        `;
                        blogContent.appendChild(articleCard);
                    });
                }
            }
            // Hospital content is handled separately in loadHospitalData()
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateContent();
        });
    </script>
