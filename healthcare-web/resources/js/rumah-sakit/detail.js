// Hospital Detail JavaScript
// Global variables
let currentDate = new Date();
let hospitalData = null;
let hospitalId = null;

// Initialize hospital detail page
function initializeHospitalDetail(data, id) {
    hospitalData = data;
    hospitalId = id;
    
    if (hospitalId) {
        updateCapacityDisplay();
        loadHospitalDoctors(hospitalId);
        initializeDateNavigation();
    } else {
        showError('Hospital ID tidak ditemukan');
        setTimeout(() => {
            if (typeof window.hospitalDetailConfig !== 'undefined' && window.hospitalDetailConfig.redirectUrl) {
                window.location.href = window.hospitalDetailConfig.redirectUrl;
            }
        }, 3000);
    }
}

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
            const capacityDisplay = document.getElementById('capacityDisplay');
            if (capacityDisplay) {
                capacityDisplay.innerHTML = capacityHtml;
            }
        }
    } catch (error) {
        console.error('Error loading capacity:', error);
        // Gunakan data fallback dari server
        const capacityDisplay = document.getElementById('capacityDisplay');
        if (capacityDisplay) {
            capacityDisplay.textContent = hospitalData ? hospitalData.kapasitas : 'Tidak diketahui';
        }
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
    if (!doctorsList) return;
    
    doctorsList.innerHTML = '';

    if (doctors.length === 0) {
        doctorsList.innerHTML = '<div class="loading">Tidak ada dokter yang bertugas hari ini</div>';
    } else {
        doctors.forEach(doctor => {
            const doctorCard = document.createElement('div');
            doctorCard.className = 'doctor-card';
            
            // Get asset URLs from global config
            const defaultDoctorImage = window.hospitalDetailConfig?.defaultDoctorImage || '/assets/1a.png';
            const fallbackDoctorImage = window.hospitalDetailConfig?.fallbackDoctorImage || '/assets/default-doctor.png';
            
            doctorCard.innerHTML = `
                <div class="doctor-avatar">
                    <img src="${defaultDoctorImage}" alt="${doctor.name}" onerror="this.src='${fallbackDoctorImage}'">
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
    const loadingDoctors = document.getElementById('loadingDoctors');
    const doctorsListElement = document.getElementById('doctorsList');
    
    if (loadingDoctors) loadingDoctors.style.display = 'none';
    if (doctorsListElement) doctorsListElement.style.display = 'block';
}

// Initialize date navigation
function initializeDateNavigation() {
    updateDateDisplay();
    
    const prevDateBtn = document.getElementById('prevDate');
    const nextDateBtn = document.getElementById('nextDate');
    
    if (prevDateBtn) {
        prevDateBtn.addEventListener('click', () => {
            currentDate.setDate(currentDate.getDate() - 1);
            updateDateDisplay();
            if (hospitalId) loadHospitalDoctors(hospitalId);
        });
    }

    if (nextDateBtn) {
        nextDateBtn.addEventListener('click', () => {
            currentDate.setDate(currentDate.getDate() + 1);
            updateDateDisplay();
            if (hospitalId) loadHospitalDoctors(hospitalId);
        });
    }
}

// Update date display
function updateDateDisplay() {
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    
    const dayName = days[currentDate.getDay()];
    const date = currentDate.getDate();
    const month = months[currentDate.getMonth()];
    
    const currentDateElement = document.getElementById('currentDate');
    if (currentDateElement) {
        currentDateElement.textContent = `${dayName}, ${date} ${month}`;
    }
}

// Show error message
function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error';
    errorDiv.textContent = message;
    
    const container = document.querySelector('.container');
    const title = document.querySelector('.title');
    
    if (container && title) {
        container.insertBefore(errorDiv, title);
    }
}

// Show doctors error
function showDoctorsError(message) {
    const loadingDoctors = document.getElementById('loadingDoctors');
    const errorDoctors = document.getElementById('errorDoctors');
    
    if (loadingDoctors) loadingDoctors.style.display = 'none';
    if (errorDoctors) {
        errorDoctors.textContent = message;
        errorDoctors.style.display = 'block';
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if hospital data is available from global scope
    if (typeof window.hospitalDetailData !== 'undefined' && typeof window.hospitalDetailId !== 'undefined') {
        initializeHospitalDetail(window.hospitalDetailData, window.hospitalDetailId);
    }
});