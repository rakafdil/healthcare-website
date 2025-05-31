<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit - Peta Ketersediaan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #ffffff;
            font-family: Arial, sans-serif;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            width: 99vw;
            margin: 0;
            margin-bottom: 20px;
            background-color: #555;
            display: flex;
            align-items: center;
            color: white;
            padding: 0;
            overflow: hidden;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-text {
            position: relative;
            z-index: 2;
            padding-left: 50px;
        }

        .hero-section h1 {
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .hero-section h2 {
            font-size: 35px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .hero-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .btn {
            display: inline-block;
            background-color: white;
            color: #333;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 15px;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #f0f0f0;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 20px;
        }

        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 24px;
            font-weight: bold;
        }

        .map-container {
            width: 100%;
            height: 400px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            position: relative;
            z-index: 1;
        }

        .location-controls {
            margin-top: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .location-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
        }

        .location-btn:hover {
            background-color: #2980b9;
        }

        .location-btn:disabled {
            background-color: #bdc3c7;
            cursor: not-allowed;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .recommendations-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .loading {
            text-align: center;
            padding: 20px;
            font-size: 16px;
        }

        .availability-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .availability-high { background-color: #27ae60; }
        .availability-medium { background-color: #f39c12; }
        .availability-low { background-color: #e74c3c; }
        .availability-full { background-color: #95a5a6; }
        .availability-unknown { background-color: #bdc3c7; }

        .stats-container {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .stat-item {
            background: white;
            padding: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }

        .stat-label {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .hero-section {
                height: 450px;
            }

            .hero-section h1,
            .hero-section h2 {
                font-size: 28px;
            }

            .hero-text {
                padding-left: 30px;
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                height: 350px;
            }

            .hero-section h1,
            .hero-section h2 {
                font-size: 22px;
            }

            .hero-text {
                padding-left: 20px;
            }
        }

        .hospital-marker {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #3498db;
            color: white;
            text-align: center;
            line-height: 32px;
            font-weight: bold;
            border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 18px;
        }

        .leaflet-popup-content {
            width: 300px;
            padding: 5px;
        }

        .user-marker {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e74c3c;
            color: white;
            text-align: center;
            line-height: 40px;
            font-weight: bold;
            border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 18px;
        }

        .leaflet-marker-pane .user-marker {
            z-index: 1000 !important;
        }
        
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
            border-left: 4px solid #f44336;
        }
        
        .success-message {
            background-color: #e8f5e8;
            color: #2e7d32;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
            border-left: 4px solid #4caf50;
        }

        .location-selector {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            gap: 10px;
            flex-wrap: wrap;
        }

        .location-selector select {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            min-width: 200px;
        }

        .manual-location-btn {
            background-color: #2ecc71;
        }
    </style>
</head>

<body>
    <div class="hero-section">
        <img src="assets/foto fitur rumah sakit.png" alt="Rumah Sakit" class="hero-image">
        <div class="hero-text">
            <h1>RUMAH SAKIT</h1>
            <h2>KETERSEDIAAN KAMAR</h2>
            <a href="/rumah-sakit" class="btn">Pencarian</a>
        </div>
    </div>

    <div class="container">
        <h2 class="title">Peta Ketersediaan Rumah Sakit</h2>
        <p class="text-center">Lokasi: <span id="selectedLocation">Memuat lokasi...</span></p>

        <div id="locationSelector" class="location-selector" style="display: none;">
            <select id="provinsiSelect">
                <option value="">Pilih Provinsi</option>
            </select>
            <select id="kabupatenSelect" disabled>
                <option value="">Pilih Kabupaten/Kota</option>
            </select>
            <select id="kotaSelect" disabled>
                <option value="">Pilih Kecamatan/Kota</option>
            </select>
            <button id="applyLocationBtn" class="location-btn manual-location-btn" disabled>
                <i class="fas fa-map-marker-alt"></i> Terapkan Lokasi
            </button>
        </div>

        <div class="map-container" id="map">
            <!-- Map will be loaded here -->
        </div>

        <div class="location-controls">
            <button id="getLocationBtn" class="location-btn">
                <i class="fas fa-location-dot"></i> Gunakan Lokasi Saya
            </button>
            <button id="refreshDataBtn" class="location-btn" style="display: none;">
                <i class="fas fa-refresh"></i> Refresh Data
            </button>
            <button id="changeLocationBtn" class="location-btn">
                <i class="fas fa-map-marker-alt"></i> Pilih Lokasi Lain
            </button>
        </div>

        <div id="statsContainer" class="stats-container" style="display: none;">
            <h4>Statistik Area</h4>
            <div class="stats-grid" id="statsGrid">
                <!-- Stats akan ditampilkan di sini -->
            </div>
        </div>

        <h3 class="recommendations-title">Rekomendasi Berdasarkan Jarak dan Ketersediaan</h3>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nama Rumah Sakit</th>
                        <th>Jarak dari Anda</th>
                        <th>Kapasitas</th>
                        <th>Rating</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="hospitalList">
                    <tr>
                        <td colspan="5" class="loading">Memuat data rumah sakit...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Global variables
        let map;
        let centerLat = null;
        let centerLng = null;
        let markers = [];
        let userMarker = null;
        let userAccuracyCircle = null;
        let currentRadius = 10; // Default radius 10 km

        const locationCoordinates = {
            jawa_barat: {
                name: "Jawa Barat",
                coordinates: {
                    lat: -6.9147,
                    lng: 107.6098
                },
                kabupaten: {
                    Bandung: {
                        name: "Bandung",
                        coordinates: {
                            lat: -6.914744,
                            lng: 107.609810
                        },
                        kota: {
                            'Bandung': {
                                name: "Bandung",
                                lat: -6.914744,
                                lng: 107.609810
                            },
                            'Cimahi': {
                                name: "Cimahi",
                                lat: -6.87222,
                                lng: 107.5425
                            },
                            'Lembang': {
                                name: "Lembang",
                                lat: -6.8117,
                                lng: 107.6175
                            }
                        }
                    },
                    Bekasi: {
                        name: "Bekasi",
                        coordinates: {
                            lat: -6.2349,
                            lng: 107.0013
                        },
                        kota: {
                            'Bekasi': {
                                name: "Bekasi",
                                lat: -6.2349,
                                lng: 107.0013
                            },
                            'Cikarang': {
                                name: "Cikarang",
                                lat: -6.26111,
                                lng: 107.15278
                            },
                            'Tambun': {
                                name: "Tambun",
                                lat: -6.178763,
                                lng: 107.065758
                            }
                        }
                    },
                    Bogor: {
                        name: "Bogor",
                        coordinates: {
                            lat: -6.595038,
                            lng: 106.816635
                        },
                        kota: {
                            'Bogor': {
                                name: "Bogor",
                                lat: -6.595038,
                                lng: 106.816635
                            },
                            'Cibinong': {
                                name: "Cibinong",
                                lat: -6.497641,
                                lng: 106.828224
                            },
                            'Cisarua': {
                                name: "Cisarua",
                                lat: -6.679303,
                                lng: 106.939835
                            }
                        }
                    }
                }
            },
            jawa_tengah: {
                name: "Jawa Tengah",
                coordinates: {
                    lat: -7.0051,
                    lng: 110.4381
                },
                kabupaten: {
                    Semarang: {
                        name: "Semarang",
                        coordinates: {
                            lat: -7.0051,
                            lng: 110.4381
                        },
                        kota: {
                            'Semarang': {
                                name: "Semarang",
                                lat: -6.9667,
                                lng: 110.4050
                            },
                            'Ungaran': {
                                name: "Ungaran",
                                lat: -7.1381,
                                lng: 110.4051
                            },
                            'Ambarawa': {
                                name: "Ambarawa",
                                lat: -7.2633,
                                lng: 110.3975
                            }
                        }
                    },
                    Solo: {
                        name: "Solo",
                        coordinates: {
                            lat: -7.5695,
                            lng: 110.8290
                        },
                        kota: {
                            'Surakarta': {
                                name: "Surakarta",
                                lat: -7.5695,
                                lng: 110.8290
                            },
                            'Laweyan': {
                                name: "Laweyan",
                                lat: -7.5583,
                                lng: 110.8083
                            },
                            'Banjarsari': {
                                name: "Banjarsari",
                                lat: -7.5561,
                                lng: 110.8167
                            }
                        }
                    }
                }
            },
            jawa_timur: {
                name: "Jawa Timur",
                coordinates: {
                    lat: -7.2575,
                    lng: 112.7521
                },
                kabupaten: {
                    Surabaya: {
                        name: "Surabaya",
                        coordinates: {
                            lat: -7.2492,
                            lng: 112.7508
                        },
                        kota: {
                            'Surabaya pusat': {
                                name: "Surabaya Pusat",
                                lat: -7.2575,
                                lng: 112.7521
                            },
                            'Surabaya timur': {
                                name: "Surabaya Timur",
                                lat: -7.2575,
                                lng: 112.7521
                            },
                            'Surabaya selatan': {
                                name: "Surabaya Selatan",
                                lat: -7.2575,
                                lng: 112.7521
                            }
                        }
                    },
                    Malang: {
                        name: "Malang",
                        coordinates: {
                            lat: -7.9666,
                            lng: 112.6326
                        },
                        kota: {
                            'Malang kota': {
                                name: "Malang Kota",
                                lat: -7.9666,
                                lng: 112.6326
                            },
                            'Kepanjen': {
                                name: "Kepanjen",
                                lat: -8.1303,
                                lng: 112.5644
                            },
                            'Turen': {
                                name: "Turen",
                                lat: -8.1680,
                                lng: 112.6928
                            }
                        }
                    }
                }
            },
            dki_jakarta: {
                name: "DKI Jakarta",
                coordinates: {
                    lat: -6.2088,
                    lng: 106.8456
                },
                kabupaten: {
                    Jakarta_pusat: {
                        name: "Jakarta Pusat",
                        coordinates: {
                            lat: -6.1900,
                            lng: 106.8450
                        },
                        kota: {
                            'Menteng': {
                                name: "Menteng",
                                lat: -6.1870,
                                lng: 106.8370
                            },
                            'Tanah abang': {
                                name: "Tanah Abang",
                                lat: -6.1970,
                                lng: 106.8130
                            },
                            'Kemayoran': {
                                name: "Kemayoran",
                                lat: -6.1560,
                                lng: 106.8610
                            }
                        }
                    },
                    Jakarta_barat: {
                        name: "Jakarta Barat",
                        coordinates: {
                            lat: -6.1767,
                            lng: 106.7900
                        },
                        kota: {
                            'Grogol': {
                                name: "Grogol",
                                lat: -6.1611,
                                lng: 106.7944
                            },
                            'Kalideres': {
                                name: "Kalideres",
                                lat: -6.1300,
                                lng: 106.7200
                            },
                            'Cengkareng': {
                                name: "Cengkareng",
                                lat: -6.1415,
                                lng: 106.7464
                            }
                        }
                    }
                }
            },
            di_yogyakarta: {
                name: "DI Yogyakarta",
                coordinates: {
                    lat: -7.7971,
                    lng: 110.3688
                },
                kabupaten: {
                    sleman: {
                        name: "Sleman",
                        coordinates: {
                            lat: -7.7325,
                            lng: 110.4024
                        },
                        kota: {
                            'depok': {
                                name: "Depok",
                                lat: -7.7844,
                                lng: 110.4103
                            },
                            'ngaglik': {
                                name: "Ngaglik",
                                lat: -7.6902,
                                lng: 110.3420
                            },
                            'mlati': {
                                name: "Mlati",
                                lat: -7.7360,
                                lng: 110.3299
                            }
                        }
                    },
                    bantul: {
                        name: "Bantul",
                        coordinates: {
                            lat: -7.8881,
                            lng: 110.3289
                        },
                        kota: {
                            'bantul kota': {
                                name: "Bantul Kota",
                                lat: -7.8881,
                                lng: 110.3289
                            },
                            'pundong': {
                                name: "Pundong",
                                lat: -7.9522,
                                lng: 110.3289
                            },
                            'srandakan': {
                                name: "Srandakan",
                                lat: -7.9599,
                                lng: 110.2407
                            }
                        }
                    }
                }
            }
        };

        // Fungsi untuk mendapatkan parameter dari URL
        function getUrlParameter(name) {
            name = name.replace(/[\[\]]/g, '\\$&');
            const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
            const results = regex.exec(window.location.href);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        // Fungsi untuk mengatur lokasi awal berdasarkan parameter URL
        function setInitialLocationFromUrl() {
            const provinsi = getUrlParameter('provinsi');
            const kabupaten = getUrlParameter('kabupaten');
            const kota = getUrlParameter('kota');
            
            if (provinsi && locationCoordinates[provinsi]) {
                const provData = locationCoordinates[provinsi];
                
                if (kabupaten && provData.kabupaten[kabupaten]) {
                    const kabData = provData.kabupaten[kabupaten];
                    
                    if (kota && kabData.kota[kota]) {
                        // Set ke level kota
                        centerLat = kabData.kota[kota].lat;
                        centerLng = kabData.kota[kota].lng;
                        document.getElementById('selectedLocation').textContent = 
                            `${kabData.kota[kota].name}, ${kabData.name}, ${provData.name}`;
                        return true;
                    } else {
                        // Set ke level kabupaten
                        centerLat = kabData.coordinates.lat;
                        centerLng = kabData.coordinates.lng;
                        document.getElementById('selectedLocation').textContent = 
                            `${kabData.name}, ${provData.name}`;
                        return true;
                    }
                } else {
                    // Set ke level provinsi
                    centerLat = provData.coordinates.lat;
                    centerLng = provData.coordinates.lng;
                    document.getElementById('selectedLocation').textContent = provData.name;
                    return true;
                }
            }
            
            return false; // Tidak ada parameter valid
        }

        // Inisialisasi peta
        function initMap() {
            // Coba set lokasi dari URL parameter
            const hasLocationFromUrl = setInitialLocationFromUrl();
            
            if (hasLocationFromUrl) {
                // Buat peta dengan view ke lokasi yang sudah ditentukan
                map = L.map('map').setView([centerLat, centerLng], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Load hospital data dari lokasi yang sudah ditentukan
                loadInitialHospitals();
            } else {
                // Jika tidak ada parameter URL yang valid, minta lokasi pengguna
                document.getElementById('selectedLocation').textContent = "Menunggu lokasi Anda...";
                getUserLocation();
            }
        }

        // Memuat data rumah sakit awal
        function loadInitialHospitals() {
            if (centerLat && centerLng) {
                getNearbyHospitalsFromDB(centerLat, centerLng, currentRadius);
            } else {
                showError("Lokasi tidak tersedia. Silakan pilih lokasi manual atau izinkan akses lokasi.");
            }
        }

        // Fungsi untuk mendapatkan rumah sakit terdekat dari database
        function getNearbyHospitalsFromDB(lat, lng, radius = 10) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Tampilkan loading
            showLoading();
            
            // Konstruksi URL dengan parameter
            const url = `/api/nearby-hospitals?lat=${lat}&lng=${lng}&radius=${radius}&limit=20`;
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Hospital data received:', data);
                
                if (data.success && data.results) {
                    processHospitalData(data);
                    // Load stats
                    loadHospitalStats(lat, lng, radius);
                } else {
                    throw new Error(data.message || 'Gagal memuat data rumah sakit');
                }
            })
            .catch(error => {
                console.error('Error fetching hospital data:', error);
                showError(`Gagal memuat data rumah sakit: ${error.message}`);
            });
        }

        function showError(message) {
            document.getElementById('hospitalList').innerHTML = `
                <tr>
                    <td colspan="5" class="error-message">
                        <i class="fas fa-exclamation-triangle"></i> ${message}
                    </td>
                </tr>
            `;
        }

        function showLoading() {
            document.getElementById('hospitalList').innerHTML = `
                <tr>
                    <td colspan="5" class="loading">
                        <i class="fas fa-spinner fa-spin"></i> Memuat data rumah sakit...
                    </td>
                </tr>
            `;
        }

        function showSuccess(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'success-message';
            alertDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
            
            const container = document.querySelector('.container');
            container.insertBefore(alertDiv, container.firstChild);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Fungsi untuk memproses data rumah sakit dari database
        function processHospitalData(data) {
            clearMarkers();
            
            if (data.success && data.results && data.results.length > 0) {
                const hospitals = data.results.map(hospital => ({
                    id: hospital.id,
                    place_id: hospital.place_id,
                    name: hospital.name,
                    address: hospital.vicinity,
                    distance: hospital.distance,
                    rating: hospital.rating,
                    capacity: hospital.kapasitas,
                    availability: hospital.availability,
                    lat: hospital.geometry.location.lat,
                    lng: hospital.geometry.location.lng
                }));

                // Urutkan berdasarkan jarak terdekat
                hospitals.sort((a, b) => a.distance - b.distance);
                
                displayHospitalsInTable(hospitals);
                addHospitalMarkersToMap(hospitals);
                showSuccess(`Ditemukan ${hospitals.length} rumah sakit dalam radius ${currentRadius} km`);
            } else {
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 40px;">
                            <i class="fas fa-hospital" style="font-size: 48px; color: #bdc3c7; margin-bottom: 15px;"></i><br>
                            <strong>Tidak ada rumah sakit ditemukan</strong><br>
                            <span style="color: #7f8c8d;">Coba perluas radius pencarian atau ubah lokasi</span>
                        </td>
                    </tr>
                `;
            }
        }

        // Fungsi untuk menampilkan rumah sakit dalam tabel
        function displayHospitalsInTable(hospitals) {
            const hospitalList = document.getElementById('hospitalList');
            hospitalList.innerHTML = '';

            hospitals.forEach((hospital, index) => {
                const availabilityInfo = getAvailabilityInfo(hospital.availability);
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div style="display: flex; align-items: center;">
                            <span class="availability-indicator ${availabilityInfo.class}"></span>
                            <div>
                                <strong>${hospital.name}</strong><br>
                                <small style="color: #7f8c8d;">${hospital.address}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: bold; color: #2c3e50;">${hospital.distance} km</span>
                    </td>
                    <td>
                        <div>
                            ${hospital.capacity}<br>
                            <small style="color: ${availabilityInfo.color};">
                                ${availabilityInfo.text}
                            </small>
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-star" style="color: #f39c12; margin-right: 3px;"></i>
                            ${hospital.rating}
                        </div>
                    </td>
                    <td>
                        <button onclick="showHospitalDetail('${hospital.id}')" class="btn" style="font-size: 12px; padding: 6px 12px;">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                    </td>
                `;
                hospitalList.appendChild(row);
            });
        }

        // Fungsi untuk mendapatkan informasi ketersediaan
        function getAvailabilityInfo(availability) {
            if (!availability) {
                return {
                    class: 'availability-unknown',
                    color: '#95a5a6',
                    text: 'Tidak diketahui'
                };
            }

            const status = availability.status;
            const percentage = availability.percentage;

            switch (status) {
                case 'high':
                    return {
                        class: 'availability-high',
                        color: '#27ae60',
                        text: `Tersedia (${percentage}%)`
                    };
                case 'medium':
                    return {
                        class: 'availability-medium',
                        color: '#f39c12',
                        text: `Terbatas (${percentage}%)`
                    };
                case 'low':
                    return {
                        class: 'availability-low',
                        color: '#e67e22',
                        text: `Sedikit (${percentage}%)`
                    };
                case 'full':
                    return {
                        class: 'availability-full',
                        color: '#e74c3c',
                        text: 'Penuh (0%)'
                    };
                default:
                    return {
                        class: 'availability-unknown',
                        color: '#95a5a6',
                        text: 'Tidak diketahui'
                    };
            }
        }

        // Fungsi untuk menambahkan marker rumah sakit ke peta
        function addHospitalMarkersToMap(hospitals) {
            hospitals.forEach(hospital => {
                const availabilityInfo = getAvailabilityInfo(hospital.availability);
                
                const hospitalIcon = L.divIcon({
                    className: 'hospital-marker',
                    html: '<i class="fas fa-hospital"></i>',
                    iconSize: [32, 32],
                    iconAnchor: [16, 16],
                    popupAnchor: [0, -16]
                });

                const marker = L.marker([hospital.lat, hospital.lng], {
                    title: hospital.name,
                    icon: hospitalIcon
                }).addTo(map);

                const popupContent = `
                    <div style="max-width: 280px; font-size: 14px;">
                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                            <span class="availability-indicator ${availabilityInfo.class}" style="margin-right: 8px;"></span>
                            <h3 style="margin: 0; font-size: 16px;">${hospital.name}</h3>
                        </div>
                        <p style="margin: 5px 0;"><strong>📍 Alamat:</strong> ${hospital.address}</p>
                        <p style="margin: 5px 0;"><strong>📏 Jarak:</strong> ${hospital.distance} km</p>
                        <p style="margin: 5px 0;"><strong>🏥 Kapasitas:</strong> ${hospital.capacity}</p>
                        <p style="margin: 5px 0;"><strong>⭐ Rating:</strong> ${hospital.rating}</p>
                        <p style="margin: 5px 0; color: ${availabilityInfo.color};">
                            <strong>🛏 Ketersediaan:</strong> ${availabilityInfo.text}
                        </p>
                        <div style="text-align: center; margin-top: 10px;">
                            <button onclick="showHospitalDetail('${hospital.id}')" 
                                    style="background: #3498db; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-info-circle"></i> Lihat Detail
                            </button>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);
                markers.push(marker);
            });
        }

        // Fungsi untuk membersihkan marker
        function clearMarkers() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
        }

        // Fungsi untuk mendapatkan lokasi pengguna
        function getUserLocation() {
            const getLocationBtn = document.getElementById('getLocationBtn');
            
            getLocationBtn.disabled = true;
            getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengambil Lokasi...';
            
            showLoading();

            if (!navigator.geolocation) {
                showError('Browser Anda tidak mendukung fitur geolokasi');
                getLocationBtn.disabled = false;
                getLocationBtn.innerHTML = '<i class="fas fa-location-dot"></i> Gunakan Lokasi Saya';
                showLocationSelector();
                return;
            }

            const options = {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 60000
            };

            navigator.geolocation.getCurrentPosition(
                position => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const accuracy = position.coords.accuracy;

                    console.log('User location obtained:', { userLat, userLng, accuracy });

                    // Validasi koordinat
                    if (!isFinite(userLat) || !isFinite(userLng)) {
                        showError('Koordinat lokasi tidak valid');
                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML = '<i class="fas fa-location-dot"></i> Gunakan Lokasi Saya';
                        return;
                    }

                    // Update pusat peta ke lokasi pengguna
                    centerLat = userLat;
                    centerLng = userLng;
                    map.setView([userLat, userLng], 14);

                    // Hapus marker pengguna yang lama
                    if (userMarker) {
                        map.removeLayer(userMarker);
                    }
                    if (userAccuracyCircle) {
                        map.removeLayer(userAccuracyCircle);
                    }

                    // Tambahkan marker lokasi pengguna
                    addUserLocationMarker(userLat, userLng, accuracy);

                    // Update informasi lokasi
                    document.getElementById('selectedLocation').textContent = "Lokasi Anda Saat Ini";

                    // Ambil data rumah sakit terdekat dari database
                    getNearbyHospitalsFromDB(userLat, userLng, currentRadius);

                    // Update button states
                    getLocationBtn.innerHTML = '<i class="fas fa-check"></i> Lokasi Ditemukan';
                    getLocationBtn.style.backgroundColor = '#27ae60';
                    
                    refreshDataBtn.style.display = 'inline-block';
                    
                    setTimeout(() => {
                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML = '<i class="fas fa-location-dot"></i> Gunakan Lokasi Saya';
                        getLocationBtn.style.backgroundColor = '#3498db';
                    }, 3000);
                },
                error => {
                    console.error('Geolocation error:', error);
                    
                    let errorMessage = 'Gagal mendapatkan lokasi Anda';
                    
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Akses lokasi ditolak. Silakan izinkan akses lokasi pada browser.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Waktu habis dalam mendapatkan lokasi.';
                            break;
                    }
                    
                    showError(errorMessage);
                    
                    getLocationBtn.disabled = false;
                    getLocationBtn.innerHTML = '<i class="fas fa-location-dot"></i> Coba Lagi';
                },
                options
            );
        }

        // Fungsi untuk menambahkan marker lokasi pengguna
        function addUserLocationMarker(lat, lng, accuracy = 100) {
            const userIcon = L.divIcon({
                className: 'user-marker',
                html: '<i class="fas fa-user"></i>',
                iconSize: [40, 40],
                iconAnchor: [20, 20],
                popupAnchor: [0, -20]
            });

            userMarker = L.marker([lat, lng], {
                icon: userIcon,
                zIndexOffset: 1000
            }).addTo(map);

            userMarker.bindPopup(`
                <div style="text-align: center; font-size: 14px;">
                    <strong>📍 Lokasi Anda</strong><br>
                    <small>Lat: ${lat.toFixed(6)}</small><br>
                    <small>Lng: ${lng.toFixed(6)}</small><br>
                    <small>Akurasi: ~${Math.round(accuracy)}m</small>
                </div>
            `).openPopup();

            // Tambahkan circle akurasi jika akurasi > 50m
            if (accuracy > 50) {
                userAccuracyCircle = L.circle([lat, lng], {
                    radius: accuracy,
                    color: '#e74c3c',
                    fillColor: '#e74c3c',
                    fillOpacity: 0.1,
                    weight: 2,
                    dashArray: '5, 5'
                }).addTo(map);
            }
        }

        // Fungsi untuk refresh data
        function refreshHospitalData() {
            if (centerLat && centerLng) {
                getNearbyHospitalsFromDB(centerLat, centerLng, currentRadius);
            } else {
                loadInitialHospitals();
            }
        }

        // Fungsi untuk load statistik rumah sakit
        function loadHospitalStats(lat, lng, radius) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/api/hospital-stats?lat=${lat}&lng=${lng}&radius=${radius}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.stats) {
                    displayHospitalStats(data.stats);
                }
            })
            .catch(error => {
                console.error('Error loading hospital stats:', error);
            });
        }

        // Fungsi untuk menampilkan statistik
        function displayHospitalStats(stats) {
            const statsContainer = document.getElementById('statsContainer');
            const statsGrid = document.getElementById('statsGrid');
            
            statsGrid.innerHTML = `
                <div class="stat-item">
                    <div class="stat-value">${stats.total_hospitals}</div>
                    <div class="stat-label">Total Rumah Sakit</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">${stats.average_rating}</div>
                    <div class="stat-label">Rating Rata-rata</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">${stats.total_available_beds}</div>
                    <div class="stat-label">Tempat Tidur Tersedia</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">${stats.occupancy_rate}%</div>
                    <div class="stat-label">Tingkat Okupansi</div>
                </div>
            `;
            
            statsContainer.style.display = 'block';
        }

        // Fungsi untuk menampilkan detail rumah sakit
        function showHospitalDetail(hospitalId) {
            // Buka halaman detail rumah sakit
            window.location.href = `/hospital/${hospitalId}`;
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            
            // Event listener untuk tombol lokasi
            document.getElementById('getLocationBtn').addEventListener('click', getUserLocation);
            
            // Event listener untuk tombol refresh
            document.getElementById('refreshDataBtn').addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
                this.disabled = true;
                
                refreshHospitalData();
                
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-refresh"></i> Refresh Data';
                    this.disabled = false;
                }, 2000);
            });
        });

        // Fungsi utilitas untuk debugging
        function debugLocation() {
            console.log('Current center:', { centerLat, centerLng });
            console.log('Current radius:', currentRadius);
            console.log('Total markers:', markers.length);
        }
    </script>
</body>

</html>