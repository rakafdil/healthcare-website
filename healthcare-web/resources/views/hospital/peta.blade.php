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
        
        const locationCoordinates = {
            jawa_barat: {
                coordinates: { lat: -6.9147, lng: 107.6098 },
                kabupaten: {
                    Bandung: {
                        coordinates: { lat: -6.914744, lng: 107.609810 },
                        kota: {
                            'Bandung': { lat: -6.914744, lng: 107.609810 },
                            'Cimahi': { lat: -6.87222, lng: 107.5425 },
                            'Lembang': { lat: -6.8117, lng: 107.6175 }
                        }
                    },
                    Bekasi: {
                        coordinates: { lat: -6.2349, lng: 107.0013 },
                        kota: {
                            'Bekasi': { lat: -6.2349, lng: 107.0013 },
                            'Cikarang': { lat: -6.26111, lng: 107.15278 },
                            'Tambun': { lat: -6.178763, lng: 107.065758 }
                        }
                    },
                    Bogor: {
                        coordinates: { lat: -6.595038, lng: 106.816635 },
                        kota: {
                            'Bogor': { lat: -6.595038, lng: 106.816635 },
                            'Cibinong': { lat: -6.497641, lng: 106.828224 },
                            'Cisarua': { lat: -6.679303, lng: 106.939835 }
                        }
                    },
                    Cianjur: {
                        coordinates: { lat: -6.820762, lng: 107.142960 },
                        kota: {
                            'Cianjur': { lat: -6.820762, lng: 107.142960 },
                            'Cugenang': { lat: -6.808, lng: 107.094 },
                            'Sukaluyu': { lat: -6.803080, lng: 107.237083 }
                        }
                    },
                    Cirebon: {
                        coordinates: { lat: -6.737246, lng: 108.550659 },
                        kota: {
                            'Cirebon': { lat: -6.737246, lng: 108.550659 },
                            'Sumber': { lat: -6.7603, lng: 108.4831 },
                            'Arjawinangun': { lat: -6.6468482, lng: 108.4092794 }
                        }
                    }
                }
            },
            jawa_tengah: {
                coordinates: { lat: -7.0051, lng: 110.4381 },
                kabupaten: {
                    Semarang: {
                        coordinates: { lat: -7.0051, lng: 110.4381 },
                        kota: {
                            'Semarang': { lat: -6.9667, lng: 110.4050 },
                            'Ungaran': { lat: -7.1381, lng: 110.4051 },
                            'Ambarawa': { lat: -7.2633, lng: 110.3975 }
                        }
                    },
                    Solo: {
                        coordinates: { lat: -7.5695, lng: 110.8290 },
                        kota: {
                            'Surakarta': { lat: -7.5695, lng: 110.8290 },
                            'Laweyan': { lat: -7.5583, lng: 110.8083 },
                            'Banjarsari': { lat: -7.5561, lng: 110.8167 }
                        }
                    },
                    Magelang: {
                        coordinates: { lat: -7.4706, lng: 110.2176 },
                        kota: {
                            'Magelang': { lat: -7.4706, lng: 110.2176 },
                            'Mertoyudana': { lat: -7.5025, lng: 110.2306 },
                            'Secang': { lat: -7.5561, lng: 110.8167 }
                        }
                    },
                    Pekalongan: {
                        coordinates: { lat: -6.8896, lng: 109.6753 },
                        kota: {
                            'Pekalongan': { lat: -6.8896, lng: 109.6753 },
                            'Kajen': { lat: -7.0500, lng: 109.6167 },
                            'Wonopringgo': { lat: -7.0500, lng: 109.7000 }
                        }
                    },
                    Tegal: {
                        coordinates: { lat: -6.8694, lng: 109.1406 },
                        kota: {
                            'Tegal': { lat: -6.8684, lng: 109.1406 },
                            'Slawi': { lat: -6.9828, lng: 109.1333 },
                            'Dukuhturi': { lat: -6.9333, lng: 109.1500 }
                        }
                    }
                }
            },
            jawa_timur: {
                coordinates: { lat: -7.2575, lng: 112.7521 },
                kabupaten: {
                    Surabaya: {
                        coordinates: { lat: -7.2492, lng: 112.7508 },
                        kota: {
                        'Surabaya pusat': { lat: -7.2575, lng: 112.7521 },
                        'Surabaya timur': { lat: -7.2575, lng: 112.7521 },
                        'Surabaya selatan': { lat: -7.2575, lng: 112.7521 }
                        }
                    },
                    Malang: {
                        coordinates: { lat: -7.9666, lng: 112.6326 },
                        kota: {
                        'Malang kota': { lat: -7.9666, lng: 112.6326 },
                        'Kepanjen': { lat: -8.1303, lng: 112.5644 },
                        'Turen': { lat: -8.1680, lng: 112.6928 }
                        }
                    },
                    Sidoarjo: {
                        coordinates: { lat: -7.4477, lng: 112.6983 },
                        kota: {
                        'Sidoarjo kota': { lat: -7.4477, lng: 112.6983 },
                        'Waru': { lat: -7.3511, lng: 112.7688 },
                        'Taman': { lat: -7.3631, lng: 112.6757 }
                        }
                    },
                    Kediri: {
                        coordinates: { lat: -7.8167, lng: 112.0170 },
                        kota: {
                        'Kediri kota': { lat: -7.8167, lng: 112.0170 },
                        'Pare': { lat: -7.7689, lng: 112.1965 },
                        'Ngasem': { lat: -7.7926, lng: 112.0465 }
                        }
                    },
                    Jember: {
                        coordinates: { lat: -8.1648, lng: 113.7036 },
                        kota: {
                        'Jember kota': { lat: -8.1648, lng: 113.7036 },
                        'Patrang': { lat: -8.1343, lng: 113.7011 },
                        'Sumbersari': { lat: -8.1700, lng: 113.7000 }
                        }
                    }
                }
            },
            dki_jakarta: {
                coordinates: { lat: -6.2088, lng: 106.8456 },
                kabupaten: {
                    Jakarta_pusat: {
                        coordinates: { lat: -6.1900, lng: 106.8450 },
                        kota: {
                        'Menteng': { lat: -6.1870, lng: 106.8370 },
                        'Tanah abang': { lat: -6.1970, lng: 106.8130 },
                        'Kemayoran': { lat: -6.1560, lng: 106.8610 }
                        }
                    },
                    Jakarta_barat: {
                        coordinates: { lat: -6.1767, lng: 106.7900 },
                        kota: {
                        'Grogol': { lat: -6.1611, lng: 106.7944 },
                        'Kalideres': { lat: -6.1300, lng: 106.7200 },
                        'Cengkareng': { lat: -6.1415, lng: 106.7464 }
                        }
                    },
                    Jakarta_timur: {
                        coordinates: { lat: -6.2250, lng: 106.9000 },
                        kota: {
                        'Cakung': { lat: -6.1830, lng: 106.9500 },
                        'Duren sawit': { lat: -6.2352, lng: 106.9159 },
                        'Jatinegara': { lat: -6.2330, lng: 106.8830 }
                        }
                    },
                    Jakarta_selatan: {
                        coordinates: { lat: -6.2667, lng: 106.8000 },
                        kota: {
                        'Kebayoran baru': { lat: -6.2432, lng: 106.8008 },
                        'Pasar minggu': { lat: -6.2936, lng: 106.8378 },
                        'Tebet': { lat: -6.2299, lng: 106.8524 }
                        }
                    },
                    Jakarta_utara: {
                        coordinates: { lat: -6.1214, lng: 106.7741 },
                        kota: {
                        'Koja': { lat: -6.1173, lng: 106.9020 },
                        'Kelapa gading': { lat: -6.1500, lng: 106.9000 },
                        'Pademangan': { lat: -6.1364, lng: 106.8463 }
                        }
                    }
                }
            },
            di_yogyakarta: {
                coordinates: { lat: -7.7971, lng: 110.3688 },
                kabupaten: {
                    sleman: {
                        coordinates: { lat: -7.7325, lng: 110.4024 },
                        kota: {
                        'depok': { lat: -7.7844, lng: 110.4103 },
                        'ngaglik': { lat: -7.6902, lng: 110.3420 },
                        'mlati': { lat: -7.7360, lng: 110.3299 }
                        }
                    },
                    bantul: {
                        coordinates: { lat: -7.8881, lng: 110.3289 },
                        kota: {
                        'bantul kota': { lat: -7.8881, lng: 110.3289 },
                        'pundong': { lat: -7.9522, lng: 110.3289 },
                        'srandakan': { lat: -7.9599, lng: 110.2407 }
                        }
                    },
                    gunung_kidul: {
                        coordinates: { lat: -7.9656, lng: 110.6169 },
                        kota: {
                        'wonosari': { lat: -7.9804, lng: 110.5952 },
                        'playen': { lat: -7.9397, lng: 110.5357 },
                        'semanu': { lat: -8.0373, lng: 110.6472 }
                        }
                    },
                    kulon_progo: {
                        coordinates: { lat: -7.8123, lng: 110.1480 },
                        kota: {
                        'wates': { lat: -7.8859, lng: 110.1408 },
                        'sentolo': { lat: -7.8369, lng: 110.2184 },
                        'pengasih': { lat: -7.6450, lng: 110.0269 }
                        }
                    },
                    yogyakarta_kota: {
                        coordinates: { lat: -7.8014, lng: 110.3649 },
                        kota: {
                        'gondokusuman': { lat: -7.7868, lng: 110.3812 },
                        'jetis': { lat: -7.6800, lng: 110.2200 },
                        'danurejan': { lat: -7.7928, lng: 110.3718 }
                        }
                    }
                }
            }
        };

        // Fungsi helper untuk mendapatkan koordinat berdasarkan provinsi, kabupaten, dan kota
        function getCoordinates(provinsi, kabupaten, kota) {
            try {
                // Coba dapatkan koordinat berdasarkan kota
                if (locationCoordinates[provinsi]?.kabupaten[kabupaten]?.kota[kota]) {
                    return locationCoordinates[provinsi].kabupaten[kabupaten].kota[kota];
                }
                
                // Jika tidak ada kota, gunakan koordinat kabupaten
                if (locationCoordinates[provinsi]?.kabupaten[kabupaten]?.coordinates) {
                    return locationCoordinates[provinsi].kabupaten[kabupaten].coordinates;
                }
                
                // Jika tidak ada kabupaten, gunakan koordinat provinsi
                if (locationCoordinates[provinsi]?.coordinates) {
                    return locationCoordinates[provinsi].coordinates;
                }
                
                // Default koordinat (Jakarta)
                return { lat: -6.200000, lng: 106.816666 };
            } catch (error) {
                console.error("Error saat mendapatkan koordinat:", error);
                return { lat: -6.200000, lng: 106.816666 };
            }
        }
        
        function initMap() {
            // Gunakan fungsi getCoordinates untuk mendapatkan koordinat berdasarkan hierarki
            const coordinates = getCoordinates(provinsi, kabupaten, kota);
            centerLat = coordinates.lat;
            centerLng = coordinates.lng;
            
            map = L.map('map').setView([centerLat, centerLng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            getNearbyHospitals(centerLat, centerLng);
        }

        function addUserLocationMarker(lat, lng) {
            if (!isFinite(lat) || !isFinite(lng)) {
                console.error("addUserLocationMarker: Koordinat tidak valid", lat, lng);
                return;
            }
            
            console.log("Menambahkan marker pengguna di:", lat, lng);
            
            // Hapus marker pengguna lama jika ada
            if (window.userMarker) {
                map.removeLayer(window.userMarker);
            }
            
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

            window.userAccuracyCircle = L.circle([lat, lng], {
                radius: 100, // meter
                color: '#3388ff',
                fillColor: '#3388ff',
                fillOpacity: 0.15,
                weight: 2
            }).addTo(map);
        }
        
        function getNearbyHospitals(lat, lng) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/api/nearby-hospitals?lat=${lat}&lng=${lng}&provinsi=${provinsi}&kabupaten=${kabupaten}&kota=${kota}`, {
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
                    <td>
                        <a href="/hospital/${hospital.id}?provinsi=${provinsi}&kabupaten=${kabupaten}&kota=${kota}">
                            Lihat Detail
                        </a>
                    </td>
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

            console.log("Memulai proses geolocation...");

            if (window.location.protocol !== 'https:' && window.location.hostname !== 'localhost') {
                console.warn("Geolocation mungkin memerlukan HTTPS! Protokol saat ini:", window.location.protocol);
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        
                        console.log("Lokasi user ditemukan:", userLat, userLng);

                        if (!isFinite(userLat) || !isFinite(userLng)) {
                            console.error("Koordinat tidak valid:", userLat, userLng);
                            alert("Koordinat lokasi tidak valid. Silakan coba lagi.");
                            return;
                        }

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

                        userMarker.bindPopup('<strong>Lokasi Anda</strong>').openPopup();

                        markers.push(userMarker);
                        
                        getNearbyHospitals(userLat, userLng);

                        document.getElementById('selectedLocation').textContent = "Lokasi Anda Saat Ini";
                    },
                    function(error) {
                        // Handler error berdasarkan kode error
                        console.error("Geolocation error code:", error.code);
                        console.error("Geolocation error message:", error.message);
                        
                        let errorMessage = "";
                        let helpMessage = "";
                        
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                eerrorMessage = "Akses lokasi ditolak.";
                                helpMessage = "Untuk mengizinkan akses lokasi:<br>" +
                                            "1. Klik ikon kunci/info di address bar<br>" +
                                            "2. Pilih 'Izin' atau 'Izinkan lokasi'<br>" +
                                            "3. Muat ulang halaman dan coba lagi";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = "Informasi lokasi tidak tersedia.";
                                helpMessage = "Pastikan GPS atau layanan lokasi perangkat Anda aktif.";
                                break;
                            case error.TIMEOUT:
                                errorMessage = "Waktu permintaan lokasi habis.";
                                helpMessage = "Periksa koneksi internet Anda dan coba lagi.";
                                break;
                            case error.UNKNOWN_ERROR:
                            default:
                                errorMessage = "Error tidak dikenal.";
                                helpMessage = "Detail error: " + error.message;
                                break;
                        }
                        
                        console.error("Geolocation error:", error.code, error.message);
                        alert(errorMessage);
                        
                        // Update tabel dengan informasi error
                        document.getElementById('hospitalList').innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div style="color: #e74c3c; margin-bottom: 10px;">
                                        <i class="fas fa-exclamation-triangle"></i> ${errorMessage}
                                    </div>
                                    <div style="font-size: 14px; color: #666;">
                                        ${helpMessage}
                                    </div>
                                </td>
                            </tr>
                        `;
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 15000, // Menaikkan timeout ke 10 detik
                        maximumAge: 0
                    }
                );
            } else {
                alert("Browser Anda tidak mendukung Geolocation API.");
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center">
                            <div style="color: #e74c3c;">
                                <i class="fas fa-exclamation-triangle"></i> 
                                Browser Anda tidak mendukung fitur lokasi.
                            </div>
                            <div style="margin-top: 10px; font-size: 14px;">
                                Silakan gunakan browser modern seperti Chrome, Firefox, atau Safari terbaru.
                            </div>
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