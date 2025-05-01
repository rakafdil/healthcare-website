<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit - Peta Ketersediaan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        /* Modifikasi section hero agar menyesuaikan lebar layar */
        .hero-section {
            position: relative;
            height: 610px;
            width: 100vw; /* Ubah menjadi viewport width */
            margin: 0;
            margin-bottom: 20px;
            margin-top: -20px;
            background-color: #555;
            display: flex;
            align-items: center;
            color: white;
            padding: 0;
            overflow: hidden;
            /* Posisi untuk membuat gambar penuh lebar layar */
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
            padding-left: 50px; /* Menambahkan padding agar teks tidak terlalu mepet ke kiri */
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
            margin-bottom: 30px;
            border: 1px solid #ddd;
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
        
        /* Menambahkan media query untuk responsivitas di layar kecil */
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
    </style>
</head>
<body>
    <!-- Hapus div container yang membatasi lebar hero section -->
    <div class="hero-section">
        <img src="assets/foto fitur rumah sakit.png" alt="Rumah Sakit" class="hero-image">
        <div class="hero-text">
            <h1>RUMAH SAKIT</h1>
            <h2>KETERSEDIAAN KAMAR</h2>
            <a href="/" class="btn">Beranda</a>
        </div>
    </div>
    
    <div class="container">
        <h2 class="title">Peta Ketersediaan Rumah Sakit</h2>
        <p class="text-center">Lokasi: <span id="selectedLocation"></span></p>
        
        <div class="map-container" id="map">
            <!-- Map will be loaded here -->
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
    
    <script>
        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const provinsi = urlParams.get('provinsi');
        const kabupaten = urlParams.get('kabupaten');
        const kota = urlParams.get('kota');
        
        // Check if all parameters are present
        if (!provinsi || !kabupaten || !kota) {
            alert('Parameter lokasi tidak lengkap. Silakan pilih lokasi terlebih dahulu.');
            window.location.href = '/hospital'; // Redirect back to the form
        }
        
        // Display selected location
        document.getElementById('selectedLocation').textContent = `${kota}, ${kabupaten}, ${provinsi.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}`;
        
        // Global variables
        let map;
        let centerLat, centerLng;
        let markers = [];
        
        // Map coordinates based on province (simplified for demo)
        const provinceCoordinates = {
            jawa_barat: { lat: -6.9147, lng: 107.6098 },
            jawa_tengah: { lat: -7.0051, lng: 110.4381 },
            jawa_timur: { lat: -7.2575, lng: 112.7521 },
            dki_jakarta: { lat: -6.2088, lng: 106.8456 },
            di_yogyakarta: { lat: -7.7971, lng: 110.3688 }
        };
        
        // Initialize the map
        function initMap() {
            // Set center based on selected province
            const coordinates = provinceCoordinates[provinsi] || { lat: -6.200000, lng: 106.816666 };
            centerLat = coordinates.lat;
            centerLng = coordinates.lng;
            
            // Create map
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: centerLat, lng: centerLng },
                zoom: 12
            });
            
            // Get nearby hospitals once the map is loaded
            getNearbyHospitals(centerLat, centerLng);
        }
        
        // Function to get nearby hospitals using the controller
        function getNearbyHospitals(lat, lng) {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Make API request
            fetch(`/api/hospitals/nearby?lat=${lat}&lng=${lng}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                // Process hospital data
                processHospitalData(data);
            })
            .catch(error => {
                console.error('Error fetching hospital data:', error);
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center">Error: Tidak dapat memuat data rumah sakit.</td>
                    </tr>
                `;
                
                // Use dummy data for demonstration if API fails
                useDummyData();
            });
        }
        
        // Process hospital data from API
        function processHospitalData(data) {
            // Clear previous markers
            clearMarkers();
            
            if (data && data.results && data.results.length > 0) {
                const hospitals = data.results.map(place => {
                    // Calculate distance (simplified)
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
                        capacity: getRandomCapacity(), // You'd get real capacity from your database
                        lat: place.geometry.location.lat,
                        lng: place.geometry.location.lng,
                        rating: place.rating || 'N/A',
                        vicinity: place.vicinity
                    };
                });
                
                // Sort hospitals by distance
                hospitals.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));
                
                // Display hospitals
                displayHospitals(hospitals);
                
                // Add markers to map
                addMarkersToMap(hospitals);
            } else {
                document.getElementById('hospitalList').innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada rumah sakit yang ditemukan di area ini.</td>
                    </tr>
                `;
                
                // Use dummy data for demonstration
                useDummyData();
            }
        }
        
        // Calculate distance between two coordinates using Haversine formula
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the earth in km
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            const distance = R * c; // Distance in km
            return distance;
        }
        
        function deg2rad(deg) {
            return deg * (Math.PI/180);
        }
        
        // Generate random capacity for demo purposes
        function getRandomCapacity() {
            const available = Math.floor(Math.random() * 40) + 10;
            const total = available + Math.floor(Math.random() * 60) + 40;
            return `${available}/${total}`;
        }
        
        // Display hospitals in the table
        function displayHospitals(hospitals) {
            const hospitalList = document.getElementById('hospitalList');
            hospitalList.innerHTML = '';
            
            hospitals.forEach(hospital => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${hospital.name}</td>
                    <td>${hospital.distance}</td>
                    <td>${hospital.capacity}</td>
                    <td><a href="/detail" class="see-more">See More</a></td>
                `;
                hospitalList.appendChild(row);
            });
        }
        
        // Add markers to the map
        function addMarkersToMap(hospitals) {
            hospitals.forEach(hospital => {
                const marker = new google.maps.Marker({
                    position: { lat: hospital.lat, lng: hospital.lng },
                    map: map,
                    title: hospital.name
                });
                
                // Add info window
                const infoContent = `
                    <div style="max-width: 300px;">
                        <h3 style="margin-bottom: 5px;">${hospital.name}</h3>
                        <p><strong>Alamat:</strong> ${hospital.vicinity}</p>
                        <p><strong>Jarak:</strong> ${hospital.distance}</p>
                        <p><strong>Kapasitas:</strong> ${hospital.capacity}</p>
                        <p><strong>Rating:</strong> ${hospital.rating}</p>
                        <a href="/detail" style="color: #3498db; text-decoration: none;">Lihat Detail</a>
                        // <a href="/hospital/detail/${hospital.id}" style="color: #3498db; text-decoration: none;">Lihat Detail</a>
                    </div>
                `;
                
                const infoWindow = new google.maps.InfoWindow({
                    content: infoContent
                });
                
                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });
                
                markers.push(marker);
            });
        }
        
        // Clear all markers from the map
        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
        }
        
        // Use dummy data if API fails (for demonstration)
        function useDummyData() {
            const dummyHospitals = [
                { id: 1, name: 'Rumah Sakit Bhakti Wira Tamtama', distance: '1.2 KM', capacity: '20/80', lat: centerLat - 0.02, lng: centerLng + 0.03, vicinity: 'Jl. Dr. Sutomo No.17', rating: '4.2' },
                { id: 2, name: 'RSUD Dr. Soetomo', distance: '0.8 KM', capacity: '15/100', lat: centerLat + 0.01, lng: centerLng - 0.02, vicinity: 'Jl. Mayjen Prof. Dr. Moestopo No.6-8', rating: '4.5' },
                { id: 3, name: 'Rumah Sakit Mitra Keluarga', distance: '0.5 KM', capacity: '35/50', lat: centerLat - 0.01, lng: centerLng - 0.01, vicinity: 'Jl. Raya Kemang No.39', rating: '4.3' },
                { id: 4, name: 'RSUP Dr. Sardjito', distance: '1.0 KM', capacity: '40/80', lat: centerLat + 0.02, lng: centerLng + 0.02, vicinity: 'Jl. Kesehatan No.1', rating: '4.1' },
                { id: 5, name: 'Rumah Sakit Hermina', distance: '1.5 KM', capacity: '25/60', lat: centerLat + 0.03, lng: centerLng - 0.03, vicinity: 'Jl. Jatinegara Barat No.126', rating: '4.4' }
            ];
            
            displayHospitals(dummyHospitals);
            addMarkersToMap(dummyHospitals);
        }
    </script>
    
    <!-- Load Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
</body>
</html>