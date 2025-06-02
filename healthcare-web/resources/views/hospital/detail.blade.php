<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rumah Sakit</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .hero-section {
            position: relative;
            height: 100vh;
            width: 99vw;
            margin: 0;
            margin-bottom: 20px;
            margin-top: -25px;
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
            pointer-events: none;
        }

        .hero-section img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-text {
            position: absolute;
            top: 50%;
            left: 50px;
            transform: translateY(-50%);
            color: white;
            z-index: 2;
        }

        .hero-text h1 {
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .hero-text h2 {
            font-size: 35px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .hospital-info {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .schedule-title {
            text-align: center;
            margin: 15px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .hospital-name {
            text-align: center;
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .navigation {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .nav-arrow {
            font-size: 20px;
            cursor: pointer;
            padding: 0 15px;
            user-select: none;
        }

        .nav-arrow:hover {
            color: #007bff;
        }

        .nav-date {
            font-weight: bold;
            margin: 0 20px;
        }

        .doctor-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .doctor-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
            overflow: hidden;
            background-color: #f2d4d4;
            position: relative;
        }

        .doctor-avatar img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .doctor-info {
            flex: 1;
        }

        .doctor-info p {
            margin: 5px 0;
        }

        .doctor-info .label {
            display: inline-block;
            width: 110px;
            font-weight: bold;
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

        .hero-text .btn {
            background-color: white;
            color: #333;
            font-weight: bold;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }

        .availability-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }

        .availability-high { background-color: #d4edda; color: #155724; }
        .availability-medium { background-color: #fff3cd; color: #856404; }
        .availability-low { background-color: #f8d7da; color: #721c24; }
        .availability-full { background-color: #f8d7da; color: #721c24; }

        .hospital-details h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }

        .hospital-details p {
            margin: 8px 0;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <img id="hospitalHeaderImage" src="{{ asset('assets/foto fitur rumah sakit.png') }}" alt="Gambar Rumah Sakit" class="hero-image">
            <div class="hero-text">
                <h1>RUMAH SAKIT</h1>
                <h2>KETERSEDIAAN KAMAR</h2>
                <a href="{{ route('peta', ['provinsi' => request('provinsi', 'jawa_barat'), 'kabupaten' => request('kabupaten', 'Bandung'), 'kota' => request('kota', 'Bandung')]) }}" class="btn">Kembali ke Peta</a>
            </div>
        </div>

        <h2 class="title">Detail Rumah Sakit</h2>

        <!-- Hospital Info - Menggunakan data dari database -->
        <div class="hospital-info">
            <div id="hospitalDetails" class="hospital-details">
                <h3 id="hospitalName">{{ $hospital->nama ?? 'Nama tidak tersedia' }}</h3>
                <p id="hospitalAddress">Alamat: {{ $hospital->alamat ?? 'Alamat tidak tersedia' }}</p>
                <p id="hospitalCapacity">Kapasitas: <span id="capacityDisplay">{{ $hospital->kapasitas ?? 'Tidak diketahui' }}</span></p>
                <p id="hospitalRating">Rating: {{ $hospital->rating ?? 0 }}/5</p>
            </div>
        </div>

        <h3 class="schedule-title">Jadwal Praktik Harian</h3>
        <h4 class="hospital-name" id="hospitalNameSchedule">{{ $hospital->nama ?? 'Nama tidak tersedia' }}</h4>

        <div class="navigation">
            <div class="nav-arrow" id="prevDate">&#10094;</div>
            <div class="nav-date" id="currentDate">-</div>
            <div class="nav-arrow" id="nextDate">&#10095;</div>
        </div>

        <!-- Doctors List - Menggunakan data dari database -->
        <div id="loadingDoctors" class="loading">Memuat jadwal dokter...</div>
        <div id="doctorsList" style="display: none;"></div>
        <div id="errorDoctors" class="error" style="display: none;">
            Gagal memuat jadwal dokter
        </div>
    </div>

    <script>
        // Global variables
        let currentDate = new Date();
        let hospitalData = @json($hospital ?? null);

        // Get hospital ID from Laravel variable
        const hospitalId = {{ $hospital_id ?? 'null' }};

        document.addEventListener('DOMContentLoaded', function() {
            if (hospitalId) {
                updateCapacityDisplay();
                loadHospitalDoctors(hospitalId);
                initializeDateNavigation();
            } else {
                showError('Hospital ID tidak ditemukan');
                setTimeout(() => window.location.href = '{{ route("peta") }}', 3000);
            }
        });

        // Load hospital capacity
        async function updateCapacityDisplay() {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch(`/api/hospital/capacity/${hospitalId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const capacityData = await response.json();
                
                if (capacityData.success) {
                    const current = capacityData.current || 0;
                    const total = capacityData.total || 0;
                    const percentage = total > 0 ? Math.round((current / total) * 100) : 0;
                    
                    let status = 'full';
                    let statusText = 'Penuh';
                    
                    if (percentage >= 70) {
                        status = 'high';
                        statusText = 'Tersedia Banyak';
                    } else if (percentage >= 30) {
                        status = 'medium';
                        statusText = 'Tersedia Terbatas';
                    } else if (percentage > 0) {
                        status = 'low';
                        statusText = 'Tersedia Sedikit';
                    }

                    const capacityHtml = `${current}/${total} <span class="availability-status availability-${status}">${statusText}</span>`;
                    document.getElementById('capacityDisplay').innerHTML = capacityHtml;
                }
            } catch (error) {
                console.error('Error loading capacity:', error);
                // Gunakan data fallback dari server
                document.getElementById('capacityDisplay').textContent = hospitalData ? hospitalData.kapasitas : 'Tidak diketahui';
            }
        }

        // Load hospital doctors
        async function loadHospitalDoctors(id) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch(`/api/hospital/doctors/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const doctorsData = await response.json();
                
                if (doctorsData.success) {
                    updateDoctorsList(doctorsData.doctors);
                } else {
                    showDoctorsError('Tidak ada jadwal dokter tersedia');
                }
            } catch (error) {
                console.error('Error loading doctors:', error);
                showDoctorsError('Gagal memuat jadwal dokter');
            }
        }

        // Update doctors list
        function updateDoctorsList(doctors) {
            const doctorsList = document.getElementById('doctorsList');
            doctorsList.innerHTML = '';

            if (doctors.length === 0) {
                doctorsList.innerHTML = '<div class="loading">Tidak ada dokter yang bertugas hari ini</div>';
            } else {
                doctors.forEach(doctor => {
                    const doctorCard = document.createElement('div');
                    doctorCard.className = 'doctor-card';
                    doctorCard.innerHTML = `
                        <div class="doctor-avatar">
                            <img src="{{ asset('assets/1a.png') }}" alt="${doctor.name}" onerror="this.src='{{ asset('assets/default-doctor.png') }}'">
                        </div>
                        <div class="doctor-info">
                            <p><span class="label">Nama Dokter :</span> ${doctor.name || 'Nama tidak tersedia'}</p>
                            <p><span class="label">Spesialis :</span> ${doctor.specialty || 'Umum'}</p>
                            <p><span class="label">Jam Praktek :</span> ${doctor.schedule || 'Jadwal tidak tersedia'}</p>
                        </div>
                    `;
                    doctorsList.appendChild(doctorCard);
                });
            }

            // Show doctors list and hide loading
            document.getElementById('loadingDoctors').style.display = 'none';
            document.getElementById('doctorsList').style.display = 'block';
        }

        // Initialize date navigation
        function initializeDateNavigation() {
            updateDateDisplay();
            
            document.getElementById('prevDate').addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() - 1);
                updateDateDisplay();
                if (hospitalId) loadHospitalDoctors(hospitalId);
            });

            document.getElementById('nextDate').addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() + 1);
                updateDateDisplay();
                if (hospitalId) loadHospitalDoctors(hospitalId);
            });
        }

        // Update date display
        function updateDateDisplay() {
            const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            
            const dayName = days[currentDate.getDay()];
            const date = currentDate.getDate();
            const month = months[currentDate.getMonth()];
            
            document.getElementById('currentDate').textContent = `${dayName}, ${date} ${month}`;
        }

        // Show error message
        function showError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error';
            errorDiv.textContent = message;
            document.querySelector('.container').insertBefore(errorDiv, document.querySelector('.title'));
        }

        // Show doctors error
        function showDoctorsError(message) {
            document.getElementById('loadingDoctors').style.display = 'none';
            document.getElementById('errorDoctors').textContent = message;
            document.getElementById('errorDoctors').style.display = 'block';
        }
    </script>
</body>

</html>