<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rumah Sakit</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'doctor-bg': '#f2d4d4'
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom styles yang tidak bisa digantikan Tailwind */
        .nav-arrow:hover {
            color: #007bff;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }

        .doctor-avatar img {
            object-fit: contain;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-center my-5 text-2xl font-bold">Detail Rumah Sakit</h2>

        <!-- Hospital Info - Menggunakan data dari database -->
        <div class="bg-white rounded-lg p-5 mb-8 shadow-md">
            <div id="hospitalDetails" class="hospital-details">
                <h3 id="hospitalName" class="text-xl mb-2.5 text-gray-800">{{ $hospital->nama ?? 'Nama tidak tersedia' }}</h3>
                <p id="hospitalAddress" class="my-2 text-gray-600 text-sm">Alamat: {{ $hospital->alamat ?? 'Alamat tidak tersedia' }}</p>
                <p id="hospitalCapacity" class="my-2 text-gray-600 text-sm">Kapasitas: <span id="capacityDisplay">{{ $hospital->kapasitas ?? 'Tidak diketahui' }}</span></p>
                <p id="hospitalRating" class="my-2 text-gray-600 text-sm">Rating: {{ $hospital->rating ?? 0 }}/5</p>
            </div>
        </div>

        <h3 class="text-center my-4 text-lg font-bold">Jadwal Praktik Harian</h3>
        <h4 class="text-center my-2.5 text-base font-bold" id="hospitalNameSchedule">{{ $hospital->nama ?? 'Nama tidak tersedia' }}</h4>

        <div class="flex justify-center items-center my-5">
            <div class="text-xl cursor-pointer px-4 select-none nav-arrow transition-colors duration-200 hover:text-blue-600" id="prevDate">&#10094;</div>
            <div class="font-bold mx-5" id="currentDate">-</div>
            <div class="text-xl cursor-pointer px-4 select-none nav-arrow transition-colors duration-200 hover:text-blue-600" id="nextDate">&#10095;</div>
        </div>

        <!-- Doctors List - Menggunakan data dari database -->
        <div id="loadingDoctors" class="text-center py-5 text-gray-600">Memuat jadwal dokter...</div>
        <div id="doctorsList" class="hidden"></div>
        <div id="errorDoctors" class="bg-red-100 text-red-800 p-4 rounded-md my-5 text-center hidden">
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
                    
                    let statusClasses = 'bg-red-100 text-red-800';
                    let statusText = 'Penuh';
                    
                    if (percentage >= 70) {
                        statusClasses = 'bg-green-100 text-green-800';
                        statusText = 'Tersedia Banyak';
                    } else if (percentage >= 30) {
                        statusClasses = 'bg-yellow-100 text-yellow-800';
                        statusText = 'Tersedia Terbatas';
                    } else if (percentage > 0) {
                        statusClasses = 'bg-red-100 text-red-800';
                        statusText = 'Tersedia Sedikit';
                    }

                    const capacityHtml = `${current}/${total} <span class="inline-block py-1 px-2 rounded-xl text-xs font-bold ml-2.5 ${statusClasses}">${statusText}</span>`;
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
                doctorsList.innerHTML = '<div class="text-center py-5 text-gray-600">Tidak ada dokter yang bertugas hari ini</div>';
            } else {
                doctors.forEach(doctor => {
                    const doctorCard = document.createElement('div');
                    doctorCard.className = 'bg-white rounded-lg p-5 mb-5 shadow-md flex items-center';
                    doctorCard.innerHTML = `
                        <div class="w-24 h-24 rounded-full mr-5 overflow-hidden bg-doctor-bg relative flex-shrink-0">
                            <img src="{{ asset('assets/1a.png') }}" alt="${doctor.name}" class="w-full h-full" onerror="this.src='{{ asset('assets/default-doctor.png') }}'">
                        </div>
                        <div class="flex-1">
                            <p class="my-1.5">
                                <span class="inline-block w-28 font-bold">Nama Dokter :</span> 
                                ${doctor.name || 'Nama tidak tersedia'}
                            </p>
                            <p class="my-1.5">
                                <span class="inline-block w-28 font-bold">Spesialis :</span> 
                                ${doctor.specialty || 'Umum'}
                            </p>
                            <p class="my-1.5">
                                <span class="inline-block w-28 font-bold">Jam Praktek :</span> 
                                ${doctor.schedule || 'Jadwal tidak tersedia'}
                            </p>
                        </div>
                    `;
                    doctorsList.appendChild(doctorCard);
                });
            }

            // Show doctors list and hide loading
            document.getElementById('loadingDoctors').style.display = 'none';
            document.getElementById('doctorsList').classList.remove('hidden');
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
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            
            const dayName = days[currentDate.getDay()];
            const date = currentDate.getDate();
            const month = months[currentDate.getMonth()];
            
            document.getElementById('currentDate').textContent = `${dayName}, ${date} ${month}`;
        }

        // Show error message
        function showError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-100 text-red-800 p-4 rounded-md my-5 text-center';
            errorDiv.textContent = message;
            document.querySelector('.container').insertBefore(errorDiv, document.querySelector('h2'));
        }

        // Show doctors error
        function showDoctorsError(message) {
            document.getElementById('loadingDoctors').style.display = 'none';
            document.getElementById('errorDoctors').textContent = message;
            document.getElementById('errorDoctors').classList.remove('hidden');
        }
    </script>
</body>

</html>