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
            background-color: #fffff;
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
            /* agar gambar tidak terdistorsi dan penuh menyesuaikan kontainer */
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
            /* text-shadow: 1px 1px 3px rgba(0,0,0,0.7); */
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
    </style>
</head>

<body>
    <div class="container">
        <!-- Tombol "Kembali ke Peta" di atas telah dihapus -->

        <!-- Gambar header rumah sakit dengan teks overlay -->
        <div class="hero-section">
            <img id="hospitalHeaderImage" src="/assets/foto fitur rumah sakit.png" alt="Gambar Rumah Sakit"
                class="hero-image">
            <div class="hero-text">
                <h1>RUMAH SAKIT</h1>
                <h2>KETERSEDIAAN KAMAR</h2>
                <a href="/peta?provinsi={{ request('provinsi') ?? 'jawa_barat' }}&kabupaten={{ request('kabupaten') ?? 'Bandung' }}&kota={{ request('kota') ?? 'Bandung' }}"
                    class="btn">Kembali ke Peta</a>
            </div>
        </div>

        <h2 class="title">Detail Rumah Sakit</h2>

        <div class="hospital-info">
            <h3 id="hospitalName">Rumah Sakit Bhakti Wira Tamtama</h3>
            <p id="hospitalAddress">Alamat: Jl. Dr. Sutomo No.17</p>
            <p id="hospitalCapacity">Kapasitas: 20/80</p>
            <p id="hospitalRating">Rating: 4.2/5</p>
        </div>

        <h3 class="schedule-title">Jadwal Praktik Harian</h3>
        <h4 class="hospital-name" id="hospitalNameSchedule">Rumah Sakit Bhakti Wira Tamtama</h4>

        <div class="navigation">
            <div class="nav-arrow" id="prevDate">&#10094;</div>
            <div class="nav-date" id="currentDate">Kam, 24</div>
            <div class="nav-arrow" id="nextDate">&#10095;</div>
        </div>

        <div id="doctorsList">
            <!-- Doctor Card 1 -->
            <div class="doctor-card">
                <div class="doctor-avatar">
                    <img src="/assets/1a.png" alt="Dr. Hendrik Cahyono">
                </div>
                <div class="doctor-info">
                    <p><span class="label">Nama Dokter :</span> dr. Hendrik Cahyono, Sp.PD</p>
                    <p><span class="label">Spesialis :</span> Penyakit Dalam</p>
                    <p><span class="label">Jam Praktek :</span> 18.00 - Selesai</p>
                </div>
            </div>

            <!-- Doctor Card 2 -->
            <div class="doctor-card">
                <div class="doctor-avatar">
                    <img src="/assets/1a.png" alt="Dr. Tessy Mubarok">
                </div>
                <div class="doctor-info">
                    <p><span class="label">Nama Dokter :</span> dr. Tessy Mubarok, Sp.B</p>
                    <p><span class="label">Spesialis :</span> Bedah Umum</p>
                    <p><span class="label">Jam Praktek :</span> 06.30 - Selesai</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get hospital ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const hospitalId = window.location.pathname.split('/').pop();

        document.addEventListener('DOMContentLoaded', function() {
            // Ambil hospital_id dari halaman
            const hospitalId = {!! json_encode($hospital_id ?? null) !!};

            if (hospitalId) {
                loadHospitalDetails(hospitalId);
            } else {
                console.error('Hospital ID not provided');
                window.location.href = '/peta'; // Redirect to map if no ID
            }
        });
        // Function to load hospital details
        function loadHospitalDetails(id) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Fetch hospital basic info
            fetch(`/api/hospital/${id}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateHospitalInfo(data);
                    
                    // Fetch hospital capacity
                    return fetch(`/api/hospital/capacity/${id}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                } else {
                    throw new Error(data.message || 'Gagal memuat data rumah sakit');
                }
            })
            .then(response => response.json())
            .then(capacityData => {
                if (capacityData.success) {
                    const capacity = `${capacityData.current}/${capacityData.total}`;
                    document.getElementById('hospitalCapacity').textContent = `Kapasitas: ${capacity}`;
                }
                
                // Fetch doctors data
                return fetch(`/api/hospital/doctors/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
            })
            .then(response => response.json())
            .then(doctorsData => {
                if (doctorsData.success) {
                    updateDoctorsList(doctorsData.doctors);
                }
            })
            .catch(error => {
                console.error('Error fetching hospital data:', error);
                useDummyData(id);
            });
        }

        // Update hospital information on the page
        function updateHospitalInfo(hospital) {
            document.getElementById('hospitalName').textContent = hospital.name;
            document.getElementById('hospitalNameSchedule').textContent = hospital.name;
            document.getElementById('hospitalAddress').textContent = `Alamat: ${hospital.address}`;
            document.getElementById('hospitalCapacity').textContent = `Kapasitas: ${hospital.capacity}`;
            document.getElementById('hospitalRating').textContent = `Rating: ${hospital.rating}/5`;

            // Update hospital header image if available
            if (hospital.imageUrl) {
                document.getElementById('hospitalHeaderImage').src = hospital.imageUrl;
            }

            // Update doctors list (in a real app, this would be dynamic)
            updateDoctorsList(hospital.doctors);
        }

        // Update doctors list
        function updateDoctorsList(doctors) {
            const doctorsList = document.getElementById('doctorsList');
            doctorsList.innerHTML = '';

            doctors.forEach(doctor => {
                const doctorCard = document.createElement('div');
                doctorCard.className = 'doctor-card';

                const gender = doctor.gender || (Math.random() > 0.5 ? 'male' : 'female');

                doctorCard.innerHTML = `
                    <div class="doctor-avatar">
                        <img src="/assets/1a.png" alt="${doctor.name}">
                    </div>
                    <div class="doctor-info">
                        <p><span class="label">Nama Dokter :</span> ${doctor.name}</p>
                        <p><span class="label">Spesialis :</span> ${doctor.specialty}</p>
                        <p><span class="label">Jam Praktek :</span> ${doctor.schedule}</p>
                    </div>
                `;

                doctorsList.appendChild(doctorCard);
            });
        }


        // Fungsi untuk mengubah tinggi gambar
        document.getElementById('applyHeight').addEventListener('click', () => {
            const heightInput = document.getElementById('imageHeight');
            const heroSection = document.querySelector('.hero-section');

            // Validasi input
            let height = parseInt(heightInput.value);
            if (isNaN(height) || height < 100) {
                height = 100; // Minimal height
                heightInput.value = 100;
            } else if (height > 600) {
                height = 600; // Maksimal height
                heightInput.value = 600;
            }

            // Terapkan tinggi baru
            heroSection.style.height = `${height}px`;
        });

        // Load hospital details when page loads
        window.onload = function() {
            updateDateDisplay();
            if (hospitalId) {
                loadHospitalDetails(hospitalId);
            }
        };
    </script>
</body>

</html>
