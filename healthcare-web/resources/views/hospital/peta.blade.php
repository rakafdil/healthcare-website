<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit - Peta Ketersediaan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #ffffff;
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #f0f0f0;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        }
        
        .location-btn:hover {
            background-color: #2980b9;
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
        
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }
        
        .see-more {
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }
        
        .see-more:hover {
            text-decoration: underline;
        }
        
        .loading {
            text-align: center;
            padding: 20px;
            font-size: 16px;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                height: 450px;
            }
            
            .hero-section h1, .hero-section h2 {
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
            
            .hero-section h1, .hero-section h2 {
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
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
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
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 18px;
        }

        .leaflet-marker-pane .user-marker {
            z-index: 1000 !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <!-- Navbar sudah ada di template utama, tidak perlu dibuat lagi -->
    
    <!-- Hero section -->
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
        <p class="text-center">Lokasi: <span id="selectedLocation"></span></p>
        
        <div class="map-container" id="map">
            <!-- Map will be loaded here -->
        </div>
        
        <div class="location-controls">
            <button id="getLocationBtn" class="location-btn">
                <i class="fas fa-location-dot"></i> Gunakan Lokasi Saya
            </button>
        </div>
        
        <h3 class="recommendations-title">Rekomendasi Berdasarkan Jarak dan Ketersediaan</h3>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nama Rumah Sakit</th>
                        <th>Jarak dari Anda</th>
                        <th>Kapasitas</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="hospitalList">
                    <tr>
                        <td colspan="4" class="loading">Memuat data rumah sakit...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const provinsi = urlParams.get('provinsi');
        const kabupaten = urlParams.get('kabupaten');
        const kota = urlParams.get('kota');
        
        if (!provinsi || !kabupaten || !kota) {
            alert('Parameter lokasi tidak lengkap. Silakan pilih lokasi terlebih dahulu.');
            window.location.href = '/hospital';
        }
        
        document.getElementById('selectedLocation').textContent = `${kota}, ${kabupaten}, ${provinsi.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}`;
        
        let map;
        let centerLat, centerLng;
        let markers = [];
        
        const provinceCoordinates = {
            jawa_barat: { lat: -6.9147, lng: 107.6098 },
            jawa_tengah: { lat: -7.0051, lng: 110.4381 },
            jawa_timur: { lat: -7.2575, lng: 112.7521 },
            dki_jakarta: { lat: -6.2088, lng: 106.8456 },
            di_yogyakarta: { lat: -7.7971, lng: 110.3688 }
        };
        
        function initMap() {
            const coordinates = provinceCoordinates[provinsi] || { lat: -6.200000, lng: 106.816666 };
            centerLat = coordinates.lat;
            centerLng = coordinates.lng;
            
            map = L.map('map').setView([centerLat, centerLng], 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            getNearbyHospitals(centerLat, centerLng);
        }

        function addUserLocationMarker(lat, lng) {
            const userIcon = L.divIcon({
                className: 'hospital-marker',
                html: '<i class="fas fa-user-location"></i>',
                iconSize: [40, 40],
                iconAnchor: [20, 20],
                popupAnchor: [0, -20]
            });
            
            const userMarker = L.marker([lat, lng], {
                icon: userIcon,
                zIndexOffset: 1000
            }).addTo(map);
            
            userMarker.bindPopup('<strong>Lokasi Anda</strong>').openPopup();
        }
        
        function getNearbyHospitals(lat, lng) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/api/nearby-hospitals?lat=${lat}&lng=${lng}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                processHospitalData(data);
            })
            .catch(error => {
                console.error('Error fetching hospital data:', error);
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center">Error: Tidak dapat memuat data rumah sakit.</td>
                    </tr>
                `;
                
                useDummyData();
            });
        }
        
        function processHospitalData(data) {
            clearMarkers();
            
            if (data && data.results && data.results.length > 0) {
                const hospitals = data.results.map(place => {
                    const distance = calculateDistance(
                        centerLat,
                        centerLng,
                        place.geometry.location.lat,
                        place.geometry.location.lng
                    );
                    
                    return {
                        id: place.place_id,
                        name: place.name,
                        distance: `${distance.toFixed(1)} KM`,
                        capacity: getRandomCapacity(),
                        lat: place.geometry.location.lat,
                        lng: place.geometry.location.lng,
                        rating: place.rating || 'N/A',
                        vicinity: place.vicinity
                    };
                });
                
                hospitals.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));
                
                displayHospitals(hospitals);
                
                addMarkersToMap(hospitals);
            } else {
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada rumah sakit yang ditemukan di area ini.</td>
                    </tr>
                `;
            }
        }
        
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            const distance = R * c;
            return distance;
        }
        
        function deg2rad(deg) {
            return deg * (Math.PI/180);
        }
        
        function getRandomCapacity() {
            const available = Math.floor(Math.random() * 40) + 10;
            const total = available + Math.floor(Math.random() * 60) + 40;
            return `${available}/${total}`;
        }
        
        function displayHospitals(hospitals) {
            const hospitalList = document.getElementById('hospitalList');
            hospitalList.innerHTML = '';
            
            hospitals.forEach(hospital => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${hospital.name}</td>
                    <td>${hospital.distance}</td>
                    <td>${hospital.capacity}</td>
                    <td><a href="/hospital/${hospital.id}" class="see-more">See More</a></td>
                `;
                hospitalList.appendChild(row);
            });
        }
        
        function addMarkersToMap(hospitals) {
            hospitals.forEach(hospital => {
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
                    <div style="max-width: 300px;">
                        <h3 style="margin-bottom: 5px;">${hospital.name}</h3>
                        <p><strong>Alamat:</strong> ${hospital.vicinity}</p>
                        <p><strong>Jarak:</strong> ${hospital.distance}</p>
                        <p><strong>Kapasitas:</strong> ${hospital.capacity}</p>
                        <p><strong>Rating:</strong> ${hospital.rating}</p>
                        <a href="/hospital/${hospital.id}" style="color: #3498db; text-decoration: none;">Lihat Detail</a>
                    </div>
                `;
                
                marker.bindPopup(popupContent);
                
                markers.push(marker);
            });
        }
        
        function clearMarkers() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
        }

        function getUserLocation() {
            document.getElementById('hospitalList').innerHTML = `
                <tr>
                    <td colspan="4" class="text-center">
                        <i class="fas fa-spinner fa-spin"></i> Mengambil lokasi Anda...
                    </td>
                </tr>
            `;
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        
                        console.log("Lokasi user ditemukan:", userLat, userLng);

                        map.setView([userLat, userLng], 13);
                        
                        centerLat = userLat;
                        centerLng = userLng;
                        
                        clearMarkers();
                        
                        const userIcon = L.divIcon({
                            className: 'user-marker',
                            html: '<i class="fas fa-user"></i>',
                            iconSize: [40, 40],
                            iconAnchor: [20, 20],
                            popupAnchor: [0, -20]
                        });

                        const userMarker = L.marker([userLat, userLng], {
                            icon: userIcon,
                            zIndexOffset: 1000
                        }).addTo(map);

                        addUserLocationMarker(userLat, userLng);
                        userMarker.bindPopup('<strong>Lokasi Anda</strong>').openPopup();
                        
                        getNearbyHospitals(userLat, userLng);

                        document.getElementById('selectedLocation').textContent = "Lokasi Anda Saat Ini";
                    },
                    function(error) {
                        // Handler error berdasarkan kode error
                        let errorMessage = "";
                        
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = "Anda menolak permintaan untuk mengakses lokasi. Silakan izinkan akses lokasi pada browser dan coba lagi.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = "Informasi lokasi tidak tersedia. Pastikan GPS atau layanan lokasi perangkat Anda aktif.";
                                break;
                            case error.TIMEOUT:
                                errorMessage = "Permintaan untuk mendapatkan lokasi terlalu lama. Silakan coba lagi.";
                                break;
                            case error.UNKNOWN_ERROR:
                            default:
                                errorMessage = "Terjadi kesalahan yang tidak diketahui saat mengambil lokasi Anda.";
                                break;
                        }
                        
                        console.error("Geolocation error:", error.code, error.message);
                        alert(errorMessage);
                        
                        // Update tabel dengan informasi error
                        document.getElementById('hospitalList').innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="fas fa-exclamation-triangle"></i> ${errorMessage}
                                </td>
                            </tr>
                        `;
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000, // Menaikkan timeout ke 10 detik
                        maximumAge: 0
                    }
                );
            } else {
                alert("Browser Anda tidak mendukung Geolocation API.");
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center">
                            Browser Anda tidak mendukung fitur lokasi. Silakan gunakan browser modern.
                        </td>
                    </tr>
                `;
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            
            document.getElementById('getLocationBtn').addEventListener('click', getUserLocation);
        });
    </script>
</body>
</html>