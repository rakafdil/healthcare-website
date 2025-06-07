<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit - Peta Ketersediaan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3498db',
                        primaryHover: '#2980b9',
                        success: '#27ae60',
                        warning: '#f39c12',
                        danger: '#e74c3c',
                        disabled: '#bdc3c7'
                    }
                }
            }
        }
    </script>
    <style>
        .hospital-marker, .user-marker {
            border-radius: 50%;
            color: white;
            text-align: center;
            font-weight: bold;
            border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }
        .hospital-marker {
            width: 32px;
            height: 32px;
            line-height: 32px;
            background-color: #3498db;
            font-size: 18px;
        }
        .user-marker {
            width: 40px;
            height: 40px;
            line-height: 40px;
            background-color: #e74c3c;
            font-size: 18px;
            z-index: 1000 !important;
        }
        .leaflet-popup-content {
            width: 300px;
            padding: 5px;
        }
        .availability-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        .availability-high { background-color: #27ae60; }
        .availability-medium { background-color: #f39c12; }
        .availability-low { background-color: #e67e22; }
        .availability-full { background-color: #e74c3c; }
        .availability-unknown { background-color: #95a5a6; }
        .stat-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
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
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-5 max-w-6xl">
        <h2 class="text-2xl font-bold text-center my-5">Peta Ketersediaan Rumah Sakit</h2>
        <p class="text-center">Lokasi: <span id="selectedLocation" class="font-medium">Memuat lokasi...</span></p>

        <!-- Location Selector -->
        <div id="locationSelector" class="flex justify-center my-5 gap-2 flex-wrap hidden">
            <select id="provinsiSelect" class="px-3 py-2 border rounded">
                <option value="">Pilih Provinsi</option>
            </select>
            <select id="kabupatenSelect" class="px-3 py-2 border rounded" disabled>
                <option value="">Pilih Kabupaten/Kota</option>
            </select>
            <select id="kotaSelect" class="px-3 py-2 border rounded" disabled>
                <option value="">Pilih Kecamatan/Kota</option>
            </select>
            <button id="applyLocationBtn" class="bg-success text-white px-4 py-2 rounded disabled:bg-disabled disabled:cursor-not-allowed" disabled>
                <i class="fas fa-map-marker-alt mr-1"></i> Terapkan Lokasi
            </button>
        </div>

        <!-- Map -->
        <div class="w-full h-96 mb-4 border border-gray-300 relative z-10" id="map"></div>

        <!-- Control Buttons -->
        <div class="flex justify-center my-3 gap-2">
            <button id="getLocationBtn" class="bg-primary hover:bg-primaryHover text-white px-4 py-2 rounded">
                <i class="fas fa-location-dot mr-1"></i> Gunakan Lokasi Saya
            </button>
            <button id="refreshDataBtn" class="bg-primary hover:bg-primaryHover text-white px-4 py-2 rounded hidden">
                <i class="fas fa-refresh mr-1"></i> Refresh Data
            </button>
            <button id="changeLocationBtn" class="bg-primary hover:bg-primaryHover text-white px-4 py-2 rounded">
                <i class="fas fa-map-marker-alt mr-1"></i> Pilih Lokasi Lain
            </button>
        </div>

        <!-- Statistics -->
        <div id="statsContainer" class="bg-gray-50 p-4 rounded-lg my-5 hidden">
            <h4 class="text-center font-bold mb-3">Statistik Area</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3" id="statsGrid"></div>
        </div>

        <!-- Hospital List -->
        <h3 class="text-lg font-bold text-center my-5">Rekomendasi Berdasarkan Jarak dan Ketersediaan</h3>
        <div class="w-full overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left">Nama Rumah Sakit</th>
                        <th class="px-4 py-3 text-left">Jarak dari Anda</th>
                        <th class="px-4 py-3 text-left">Kapasitas</th>
                        <th class="px-4 py-3 text-left">Rating</th>
                        <th class="px-4 py-3 text-left"></th>
                    </tr>
                </thead>
                <tbody id="hospitalList">
                    <tr>
                        <td colspan="5" class="px-4 py-5 text-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Memuat data rumah sakit...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // =====================================
        // CONFIGURATION & CONSTANTS
        // =====================================
        const CONFIG = {
            DEFAULT_RADIUS: 10,
            DEFAULT_ZOOM: 13,
            USER_ZOOM: 14,
            API_ENDPOINTS: {
                NEARBY_HOSPITALS: '/api/nearby-hospitals',
                HOSPITAL_STATS: '/api/hospital-stats'
            }
        };

        const LOCATION_DATA = {
            jawa_barat: { name: "Jawa Barat", lat: -6.9147, lng: 107.6098 },
            jawa_tengah: { name: "Jawa Tengah", lat: -7.0051, lng: 110.4381 },
            jawa_timur: { name: "Jawa Timur", lat: -7.2575, lng: 112.7521 },
            dki_jakarta: { name: "DKI Jakarta", lat: -6.2088, lng: 106.8456 },
            di_yogyakarta: { name: "DI Yogyakarta", lat: -7.7971, lng: 110.3688 }
        };

        const dataKabupaten = {
            jawa_barat: [
                { name: 'Bandung', lat: -6.90389, lng: 107.61861 },
                { name: 'Bekasi', lat: -6.2349, lng: 106.9896 },
                { name: 'Bogor', lat: -6.595, lng: 106.8166 },
                { name: 'Cianjur', lat: -6.8222, lng: 107.1424 },
                { name: 'Cirebon', lat: -6.732, lng: 108.552 }
            ],
            jawa_tengah: [
                { name: 'Semarang', lat: -6.9667, lng: 110.4167 },
                { name: 'Solo', lat: -7.5667, lng: 110.8167 },
                { name: 'Magelang', lat: -7.4818, lng: 110.2177 },
                { name: 'Pekalongan', lat: -6.8833, lng: 109.667 },
                { name: 'Tegal', lat: -6.869, lng: 109.1256 }
            ],
            jawa_timur: [
                { name: 'Surabaya', lat: -7.25, lng: 112.75 },
                { name: 'Malang', lat: -7.9819, lng: 112.6265 },
                { name: 'Sidoarjo', lat: -7.45, lng: 112.717 },
                { name: 'Kediri', lat: -7.8166, lng: 112.0111 },
                { name: 'Jember', lat: -8.1737, lng: 113.7004 }
            ],
            dki_jakarta: [
                { name: 'Jakarta Pusat', lat: -6.1865, lng: 106.8341 },
                { name: 'Jakarta Barat', lat: -6.1683, lng: 106.7589 },
                { name: 'Jakarta Timur', lat: -6.2251, lng: 106.9004 },
                { name: 'Jakarta Selatan', lat: -6.2666, lng: 106.8133 },
                { name: 'Jakarta Utara', lat: -6.138, lng: 106.8827 }
            ],
            di_yogyakarta: [
                { name: 'Sleman', lat: -7.7167, lng: 110.3667 },
                { name: 'Bantul', lat: -7.8886, lng: 110.3282 },
                { name: 'Gunung Kidul', lat: -7.9949, lng: 110.6177 },
                { name: 'Kulon Progo', lat: -7.8244, lng: 110.1644 },
                { name: 'Yogyakarta Kota', lat: -7.8014, lng: 110.3649 }
            ]
        };

        const dataKota = {
            // Jawa Barat
            'Bandung': [
                { name: 'Bandung Kota', lat: -6.9147, lng: 107.6098 },
                { name: 'Cimahi', lat: -6.8728, lng: 107.5429 },
                { name: 'Lembang', lat: -6.8181, lng: 107.6155 }
            ],
            'Bekasi': [
                { name: 'Bekasi Kota', lat: -6.2383, lng: 106.9756 },
                { name: 'Cikarang', lat: -6.3066, lng: 107.1722 },
                { name: 'Tambun', lat: -6.2574, lng: 107.0505 }
            ],
            'Bogor': [
                { name: 'Bogor Kota', lat: -6.595, lng: 106.8166 },
                { name: 'Cibinong', lat: -6.4859, lng: 106.8543 },
                { name: 'Cisarua', lat: -6.6705, lng: 106.9328 }
            ],
            'Cianjur': [
                { name: 'Cianjur Kota', lat: -6.8222, lng: 107.1424 },
                { name: 'Cugenang', lat: -6.7703, lng: 107.1318 },
                { name: 'Sukaluyu', lat: -6.7802, lng: 107.125 }
            ],
            'Cirebon': [
                { name: 'Cirebon Kota', lat: -6.732, lng: 108.552 },
                { name: 'Sumber', lat: -6.7463, lng: 108.4803 },
                { name: 'Arjawinangun', lat: -6.729, lng: 108.4438 }
            ],

            // Jawa Tengah
            'Semarang': [
                { name: 'Semarang Kota', lat: -6.9667, lng: 110.4167 },
                { name: 'Ungaran', lat: -7.1397, lng: 110.4066 },
                { name: 'Ambarawa', lat: -7.2603, lng: 110.4031 }
            ],
            'Solo': [
                { name: 'Solo Kota', lat: -7.5667, lng: 110.8167 },
                { name: 'Laweyan', lat: -7.5691, lng: 110.7969 },
                { name: 'Banjarsari', lat: -7.5587, lng: 110.8221 }
            ],
            'Magelang': [
                { name: 'Magelang Kota', lat: -7.4818, lng: 110.2177 },
                { name: 'Mertoyudan', lat: -7.512, lng: 110.2342 },
                { name: 'Secang', lat: -7.4578, lng: 110.2811 }
            ],
            'Pekalongan': [
                { name: 'Pekalongan Kota', lat: -6.8833, lng: 109.667 },
                { name: 'Kajen', lat: -7.05, lng: 109.6 },
                { name: 'Wonopringgo', lat: -7.05, lng: 109.716 }
            ],
            'Tegal': [
                { name: 'Tegal Kota', lat: -6.869, lng: 109.1256 },
                { name: 'Slawi', lat: -6.9811, lng: 109.1336 },
                { name: 'Adiwerna', lat: -6.9526, lng: 109.1341 }
            ],

            // Jawa Timur
            'Surabaya': [
                { name: 'Surabaya Pusat', lat: -7.2575, lng: 112.7521 },
                { name: 'Surabaya Timur', lat: -7.275, lng: 112.787 },
                { name: 'Surabaya Selatan', lat: -7.321, lng: 112.730 }
            ],
            'Malang': [
                { name: 'Malang Kota', lat: -7.9819, lng: 112.6265 },
                { name: 'Kepanjen', lat: -8.1317, lng: 112.5666 },
                { name: 'Turen', lat: -8.1762, lng: 112.7086 }
            ],
            'Sidoarjo': [
                { name: 'Sidoarjo Kota', lat: -7.45, lng: 112.717 },
                { name: 'Waru', lat: -7.3757, lng: 112.7284 },
                { name: 'Taman', lat: -7.4062, lng: 112.6989 }
            ],
            'Kediri': [
                { name: 'Kediri Kota', lat: -7.8166, lng: 112.0111 },
                { name: 'Pare', lat: -7.7676, lng: 112.1955 },
                { name: 'Ngasem', lat: -7.8132, lng: 111.9726 }
            ],
            'Jember': [
                { name: 'Jember Kota', lat: -8.1737, lng: 113.7004 },
                { name: 'Patrang', lat: -8.1617, lng: 113.7093 },
                { name: 'Sumbersari', lat: -8.1664, lng: 113.7156 }
            ],

            // DKI Jakarta
            'Jakarta Pusat': [
                { name: 'Menteng', lat: -6.1907, lng: 106.8361 },
                { name: 'Tanah Abang', lat: -6.1905, lng: 106.8108 },
                { name: 'Kemayoran', lat: -6.1652, lng: 106.8531 }
            ],
            'Jakarta Barat': [
                { name: 'Grogol', lat: -6.1768, lng: 106.7907 },
                { name: 'Kalideres', lat: -6.1333, lng: 106.6956 },
                { name: 'Cengkareng', lat: -6.1488, lng: 106.7417 }
            ],
            'Jakarta Timur': [
                { name: 'Cakung', lat: -6.2034, lng: 106.9483 },
                { name: 'Duren Sawit', lat: -6.2294, lng: 106.9031 },
                { name: 'Jatinegara', lat: -6.2206, lng: 106.8828 }
            ],
            'Jakarta Selatan': [
                { name: 'Kebayoran Baru', lat: -6.2441, lng: 106.7997 },
                { name: 'Pasar Minggu', lat: -6.2699, lng: 106.8394 },
                { name: 'Tebet', lat: -6.236, lng: 106.8554 }
            ],
            'Jakarta Utara': [
                { name: 'Koja', lat: -6.1105, lng: 106.8905 },
                { name: 'Kelapa Gading', lat: -6.1543, lng: 106.9121 },
                { name: 'Pademangan', lat: -6.1289, lng: 106.8455 }
            ],

            // DI Yogyakarta
            'Sleman': [
                { name: 'Depok', lat: -7.7641, lng: 110.3852 },
                { name: 'Ngaglik', lat: -7.6954, lng: 110.3874 },
                { name: 'Mlati', lat: -7.7422, lng: 110.3578 }
            ],
            'Bantul': [
                { name: 'Bantul Kota', lat: -7.8886, lng: 110.3282 },
                { name: 'Pundong', lat: -7.986, lng: 110.3244 },
                { name: 'Srandakan', lat: -7.9591, lng: 110.1669 }
            ],
            'Gunung Kidul': [
                { name: 'Wonosari', lat: -7.9829, lng: 110.6038 },
                { name: 'Playen', lat: -7.9717, lng: 110.5514 },
                { name: 'Semanu', lat: -8.0112, lng: 110.6577 }
            ],
            'Kulon Progo': [
                { name: 'Wates', lat: -7.8897, lng: 110.1645 },
                { name: 'Sentolo', lat: -7.8362, lng: 110.2055 },
                { name: 'Pengasih', lat: -7.8454, lng: 110.1683 }
            ],
            'Yogyakarta Kota': [
                { name: 'Gondokusuman', lat: -7.7896, lng: 110.3758 },
                { name: 'Jetis', lat: -7.7879, lng: 110.3675 },
                { name: 'Danurejan', lat: -7.8004, lng: 110.3761 }
            ]
        };

        // =====================================
        // STATE MANAGEMENT
        // =====================================
        class AppState {
            constructor() {
                this.map = null;
                this.centerLat = null;
                this.centerLng = null;
                this.markers = [];
                this.userMarker = null;
                this.userAccuracyCircle = null;
                this.currentRadius = CONFIG.DEFAULT_RADIUS;
            }

            setCenter(lat, lng) {
                this.centerLat = lat;
                this.centerLng = lng;
            }

            clearMarkers() {
                this.markers.forEach(marker => this.map.removeLayer(marker));
                this.markers = [];
            }

            addMarker(marker) {
                this.markers.push(marker);
            }

            removeUserMarker() {
                if (this.userMarker) {
                    this.map.removeLayer(this.userMarker);
                    this.userMarker = null;
                }
                if (this.userAccuracyCircle) {
                    this.map.removeLayer(this.userAccuracyCircle);
                    this.userAccuracyCircle = null;
                }
            }
        }

        // =====================================
        // UTILITY FUNCTIONS
        // =====================================
        const Utils = {
            getUrlParameter(name) {
                const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
                const results = regex.exec(window.location.href);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            },

            getCsrfToken() {
                return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            },

            isValidCoordinate(lat, lng) {
                return isFinite(lat) && isFinite(lng);
            },

            formatDistance(distance) {
                return parseFloat(distance).toFixed(1);
            }
        };

        // =====================================
        // UI COMPONENTS
        // =====================================
        const UI = {
            updateLocationText(text) {
                document.getElementById('selectedLocation').textContent = text;
            },

            showLoading() {
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-5 text-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Memuat data rumah sakit...
                        </td>
                    </tr>
                `;
            },

            showError(message) {
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-5 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle mr-2"></i> ${message}
                        </td>
                    </tr>
                `;
            },

            showSuccess(message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4';
                alertDiv.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ${message}`;
                
                const container = document.querySelector('.container');
                container.insertBefore(alertDiv, container.children[2]);
                
                setTimeout(() => alertDiv.remove(), 5000);
            },

            showNoResults() {
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-5 text-center">
                            <i class="fas fa-hospital text-4xl text-gray-400 mb-3"></i><br>
                            <strong>Tidak ada rumah sakit ditemukan</strong><br>
                            <span class="text-gray-500">Coba perluas radius pencarian atau ubah lokasi</span>
                        </td>
                    </tr>
                `;
            },

            updateButtonState(buttonId, text, color = null, disabled = false) {
                const button = document.getElementById(buttonId);
                button.innerHTML = text;
                button.disabled = disabled;
                if (color) button.style.backgroundColor = color;
            }
        };

        // =====================================
        // AVAILABILITY HELPER
        // =====================================
        const AvailabilityHelper = {
            getInfo(availability) {
                if (!availability) {
                    return { class: 'availability-unknown', color: '#95a5a6', text: 'Tidak diketahui' };
                }

                const statusMap = {
                    high: { class: 'availability-high', color: '#27ae60', text: `Tersedia (${availability.percentage}%)` },
                    medium: { class: 'availability-medium', color: '#f39c12', text: `Terbatas (${availability.percentage}%)` },
                    low: { class: 'availability-low', color: '#e67e22', text: `Sedikit (${availability.percentage}%)` },
                    full: { class: 'availability-full', color: '#e74c3c', text: 'Penuh (0%)' }
                };

                return statusMap[availability.status] || statusMap.unknown;
            }
        };

        // =====================================
        // MAP MANAGER
        // =====================================
        class MapManager {
            constructor(state) {
                this.state = state;
            }

            initialize() {
                // Try to get location from URL parameters first
                if (this.setLocationFromUrl()) {
                    this.createMap();
                    HospitalService.loadNearbyHospitals();
                } else {
                    this.createMap();
                    LocationService.getUserLocation();
                }
            }

            createMap() {
                const lat = this.state.centerLat || -6.2088;
                const lng = this.state.centerLng || 106.8456;
                
                this.state.map = L.map('map').setView([lat, lng], CONFIG.DEFAULT_ZOOM);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(this.state.map);
            }

            setLocationFromUrl() {
                const provinsi = Utils.getUrlParameter('provinsi');
                if (provinsi && LOCATION_DATA[provinsi]) {
                    const location = LOCATION_DATA[provinsi];
                    this.state.setCenter(location.lat, location.lng);
                    UI.updateLocationText(location.name);
                    return true;
                }
                return false;
            }

            addUserMarker(lat, lng, accuracy = 100) {
                this.state.removeUserMarker();

                const userIcon = L.divIcon({
                    className: 'user-marker',
                    html: '<i class="fas fa-user"></i>',
                    iconSize: [40, 40],
                    iconAnchor: [20, 20],
                    popupAnchor: [0, -20]
                });

                this.state.userMarker = L.marker([lat, lng], {
                    icon: userIcon,
                    zIndexOffset: 1000
                }).addTo(this.state.map);

                this.state.userMarker.bindPopup(`
                    <div class="text-center">
                        <strong>📍 Lokasi Anda</strong><br>
                        <small>Lat: ${lat.toFixed(6)}</small><br>
                        <small>Lng: ${lng.toFixed(6)}</small><br>
                        <small>Akurasi: ~${Math.round(accuracy)}m</small>
                    </div>
                `).openPopup();

                if (accuracy > 50) {
                    this.state.userAccuracyCircle = L.circle([lat, lng], {
                        radius: accuracy,
                        color: '#e74c3c',
                        fillColor: '#e74c3c',
                        fillOpacity: 0.1,
                        weight: 2,
                        dashArray: '5, 5'
                    }).addTo(this.state.map);
                }
            }

            addHospitalMarkers(hospitals) {
                this.state.clearMarkers();
                
                hospitals.forEach(hospital => {
                    const availabilityInfo = AvailabilityHelper.getInfo(hospital.availability);
                    
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
                    }).addTo(this.state.map);

                    const popupContent = `
                        <div class="max-w-xs">
                            <div class="flex items-center mb-2">
                                <span class="availability-indicator ${availabilityInfo.class} mr-2"></span>
                                <h3 class="font-bold">${hospital.name}</h3>
                            </div>
                            <p class="mb-1"><strong>📍 Alamat:</strong> ${hospital.address}</p>
                            <p class="mb-1"><strong>📏 Jarak:</strong> ${hospital.distance} km</p>
                            <p class="mb-1"><strong>🏥 Kapasitas:</strong> ${hospital.capacity}</p>
                            <p class="mb-1"><strong>⭐ Rating:</strong> ${hospital.rating}</p>
                            <p class="mb-3" style="color: ${availabilityInfo.color};">
                                <strong>🛏 Ketersediaan:</strong> ${availabilityInfo.text}
                            </p>
                            <div class="text-center">
                                <button onclick="HospitalService.showDetail('${hospital.id}')" 
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                    <i class="fas fa-info-circle"></i> Lihat Detail
                                </button>
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    this.state.addMarker(marker);
                });
            }
        }

        // =====================================
        // LOCATION SERVICE
        // =====================================
        class LocationService {
            static getUserLocation() {
                const btn = document.getElementById('getLocationBtn');
                
                UI.updateButtonState('getLocationBtn', '<i class="fas fa-spinner fa-spin"></i> Mengambil Lokasi...', null, true);
                UI.showLoading();

                if (!navigator.geolocation) {
                    UI.showError('Browser Anda tidak mendukung fitur geolokasi');
                    UI.updateButtonState('getLocationBtn', '<i class="fas fa-location-dot"></i> Gunakan Lokasi Saya', null, false);
                    return;
                }

                const options = {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 60000
                };

                navigator.geolocation.getCurrentPosition(
                    position => this.onLocationSuccess(position),
                    error => this.onLocationError(error),
                    options
                );
            }

            static onLocationSuccess(position) {
                const { latitude: lat, longitude: lng, accuracy } = position.coords;

                if (!Utils.isValidCoordinate(lat, lng)) {
                    UI.showError('Koordinat lokasi tidak valid');
                    UI.updateButtonState('getLocationBtn', '<i class="fas fa-location-dot"></i> Gunakan Lokasi Saya', null, false);
                    return;
                }

                // Update state and map
                state.setCenter(lat, lng);
                state.map.setView([lat, lng], CONFIG.USER_ZOOM);
                
                // Add user marker
                mapManager.addUserMarker(lat, lng, accuracy);
                
                // Update UI
                UI.updateLocationText("Lokasi Anda Saat Ini");
                UI.updateButtonState('getLocationBtn', '<i class="fas fa-check"></i> Lokasi Ditemukan', '#27ae60');
                document.getElementById('refreshDataBtn').classList.remove('hidden');
                
                // Load hospital data
                HospitalService.loadNearbyHospitals();
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    UI.updateButtonState('getLocationBtn', '<i class="fas fa-location-dot"></i> Gunakan Lokasi Saya', '#3498db', false);
                }, 3000);
            }

            static onLocationError(error) {
                const errorMessages = {
                    [error.PERMISSION_DENIED]: 'Akses lokasi ditolak. Silakan izinkan akses lokasi pada browser.',
                    [error.POSITION_UNAVAILABLE]: 'Informasi lokasi tidak tersedia.',
                    [error.TIMEOUT]: 'Waktu habis dalam mendapatkan lokasi.'
                };
                
                const message = errorMessages[error.code] || 'Gagal mendapatkan lokasi Anda';
                UI.showError(message);
                UI.updateButtonState('getLocationBtn', '<i class="fas fa-location-dot"></i> Coba Lagi', null, false);
            }
        }

        // =====================================
        // HOSPITAL SERVICE
        // =====================================
        class HospitalService {
            static async loadNearbyHospitals() {
                if (!state.centerLat || !state.centerLng) {
                    UI.showError("Lokasi tidak tersedia");
                    return;
                }

                UI.showLoading();

                try {
                    const url = `${CONFIG.API_ENDPOINTS.NEARBY_HOSPITALS}?lat=${state.centerLat}&lng=${state.centerLng}&radius=${state.currentRadius}&limit=20`;
                    
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': Utils.getCsrfToken(),
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    
                    if (data.success && data.results) {
                        this.processHospitalData(data.results);
                        this.loadStats();
                        UI.showSuccess(`Ditemukan ${data.results.length} rumah sakit dalam radius ${state.currentRadius} km`);
                    } else {
                        throw new Error(data.message || 'Gagal memuat data rumah sakit');
                    }
                } catch (error) {
                    console.error('Error fetching hospital data:', error);
                    UI.showError(`Gagal memuat data rumah sakit: ${error.message}`);
                }
            }

            static processHospitalData(rawData) {
                if (!rawData || rawData.length === 0) {
                    UI.showNoResults();
                    return;
                }

                const hospitals = rawData.map(hospital => ({
                    id: hospital.id,
                    place_id: hospital.place_id,
                    name: hospital.name,
                    address: hospital.vicinity,
                    distance: Utils.formatDistance(hospital.distance),
                    rating: hospital.rating,
                    capacity: hospital.kapasitas,
                    availability: hospital.availability,
                    lat: hospital.geometry.location.lat,
                    lng: hospital.geometry.location.lng
                }));

                // Sort by distance
                hospitals.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));
                
                this.displayHospitalsTable(hospitals);
                mapManager.addHospitalMarkers(hospitals);
            }

            static displayHospitalsTable(hospitals) {
                const tbody = document.getElementById('hospitalList');
                tbody.innerHTML = '';

                hospitals.forEach(hospital => {
                    const availabilityInfo = AvailabilityHelper.getInfo(hospital.availability);
                    
                    const row = document.createElement('tr');
                    row.className = 'border-b hover:bg-gray-50';
                    row.innerHTML = `
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <span class="availability-indicator ${availabilityInfo.class}"></span>
                                <div>
                                    <div class="font-medium">${hospital.name}</div>
                                    <div class="text-sm text-gray-500">${hospital.address}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-bold text-gray-800">${hospital.distance} km</span>
                        </td>
                        <td class="px-4 py-3">
                            <div>
                                <div>${hospital.capacity}</div>
                                <small style="color: ${availabilityInfo.color};">
                                    ${availabilityInfo.text}
                                </small>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                ${hospital.rating}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <button onclick="HospitalService.showDetail('${hospital.id}')" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                <i class="fas fa-info-circle"></i> Detail
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }

            static async loadStats() {
                try {
                    const url = `${CONFIG.API_ENDPOINTS.HOSPITAL_STATS}?lat=${state.centerLat}&lng=${state.centerLng}&radius=${state.currentRadius}`;
                    
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': Utils.getCsrfToken(),
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    
                    if (data.success && data.stats) {
                        this.displayStats(data.stats);
                    }
                } catch (error) {
                    console.error('Error loading hospital stats:', error);
                }
            }

            static displayStats(stats) {
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
                
                document.getElementById('statsContainer').classList.remove('hidden');
            }

            static showDetail(hospitalId) {
                window.location.href = `/hospital/${hospitalId}`;
            }

            static refresh() {
                this.loadNearbyHospitals();
            }
        }

        // =====================================
        // INITIALIZE APPLICATION
        // =====================================
        let state, mapManager;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize application state
            state = new AppState();
            mapManager = new MapManager(state);
            
            // Initialize map
            mapManager.initialize();
            
            // Setup event listeners
            setupEventListeners();
        });

        function setupEventListeners() {
            // Get location button
            document.getElementById('getLocationBtn').addEventListener('click', () => {
                LocationService.getUserLocation();
            });
            
            // Refresh button
            document.getElementById('refreshDataBtn').addEventListener('click', function() {
                UI.updateButtonState('refreshDataBtn', '<i class="fas fa-spinner fa-spin"></i> Memuat...', null, true);
                
                HospitalService.refresh();
                
                setTimeout(() => {
                    UI.updateButtonState('refreshDataBtn', '<i class="fas fa-refresh"></i> Refresh Data', null, false);
                }, 2000);
            });
        }
        // Make HospitalService available globally for onclick handlers
        window.HospitalService = HospitalService;
    </script>
</body>
</html>