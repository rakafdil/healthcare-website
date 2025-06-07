<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit - Ketersediaan Kamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">

    <div class="container mx-auto p-5 max-w-lg">
        <h2 class="text-center text-xl font-bold text-gray-800 my-5">
            Pilih Lokasi Rumah Sakit
        </h2>

        <form id="locationForm" action="/peta" method="GET" class="space-y-5">
            <div>
                <select 
                    class="w-full p-4 border border-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white" 
                    id="provinsi" 
                    name="provinsi"
                >
                    <option value="">Pilih Provinsi</option>
                    <option value="jawa_barat">Jawa Barat</option>
                    <option value="jawa_tengah">Jawa Tengah</option>
                    <option value="jawa_timur">Jawa Timur</option>
                    <option value="dki_jakarta">DKI Jakarta</option>
                    <option value="di_yogyakarta">DI Yogyakarta</option>
                </select>
            </div>

            <div>
                <select 
                    class="w-full p-4 border border-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white" 
                    id="kabupaten" 
                    name="kabupaten"
                >
                    <option value="">Pilih Kabupaten</option>
                    <!-- Opsi akan diisi melalui JavaScript -->
                </select>
            </div>

            <div>
                <select 
                    class="w-full p-4 border border-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white" 
                    id="kota" 
                    name="kota"
                >
                    <option value="">Pilih Kota</option>
                    <!-- Opsi akan diisi melalui JavaScript -->
                </select>
            </div>

            <button 
                type="submit" 
                class="w-full py-4 px-6 rounded-lg font-medium text-base transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 text-white"
                style="background-color: #499BE8; hover:background-color: #3a7bc8; focus:ring-color: #499BE8;"
                id="cariRumahSakit"
                onmouseover="this.style.backgroundColor='#3a7bc8'" 
                onmouseout="this.style.backgroundColor='#499BE8'"
            >
                Telusuri
            </button>
        </form>
    </div>

    <script>
        const dataKabupaten = {
            jawa_barat: ['Bandung', 'Bekasi', 'Bogor', 'Cianjur', 'Cirebon'],
            jawa_tengah: ['Semarang', 'Solo', 'Magelang', 'Pekalongan', 'Tegal'],
            jawa_timur: ['Surabaya', 'Malang', 'Sidoarjo', 'Kediri', 'Jember'],
            dki_jakarta: ['Jakarta Pusat', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Selatan', 'Jakarta Utara'],
            di_yogyakarta: ['Sleman', 'Bantul', 'Gunung Kidul', 'Kulon Progo', 'Yogyakarta Kota']
        };

        const dataKota = {
            'Bandung': ['Bandung Kota', 'Cimahi', 'Lembang'],
            'Bekasi': ['Bekasi Kota', 'Cikarang', 'Tambun'],
            'Bogor': ['Bogor Kota', 'Cibinong', 'Cisarua'],
            'Cianjur': ['Cianjur Kota', 'Cugenang', 'Sukaluyu'],
            'Cirebon': ['Cirebon Kota', 'Sumber', 'Arjawinangun'],
            'Semarang': ['Semarang Kota', 'Ungaran', 'Ambarawa'],
            'Solo': ['Solo Kota', 'Laweyan', 'Banjarsari'],
            'Magelang': ['Magelang Kota', 'Mertoyudan', 'Secang'],
            'Pekalongan': ['Pekalongan Kota', 'Kajen', 'Wonopringgo'],
            'Tegal': ['Tegal Kota', 'Slawi', 'Adiwerna'],
            'Surabaya': ['Surabaya Pusat', 'Surabaya Timur', 'Surabaya Selatan'],
            'Malang': ['Malang Kota', 'Kepanjen', 'Turen'],
            'Sidoarjo': ['Sidoarjo Kota', 'Waru', 'Taman'],
            'Kediri': ['Kediri Kota', 'Pare', 'Ngasem'],
            'Jember': ['Jember Kota', 'Patrang', 'Sumbersari'],
            'Jakarta Pusat': ['Menteng', 'Tanah Abang', 'Kemayoran'],
            'Jakarta Barat': ['Grogol', 'Kalideres', 'Cengkareng'],
            'Jakarta Timur': ['Cakung', 'Duren Sawit', 'Jatinegara'],
            'Jakarta Selatan': ['Kebayoran Baru', 'Pasar Minggu', 'Tebet'],
            'Jakarta Utara': ['Koja', 'Kelapa Gading', 'Pademangan'],
            'Sleman': ['Depok', 'Ngaglik', 'Mlati'],
            'Bantul': ['Bantul Kota', 'Pundong', 'Srandakan'],
            'Gunung Kidul': ['Wonosari', 'Playen', 'Semanu'],
            'Kulon Progo': ['Wates', 'Sentolo', 'Pengasih'],
            'Yogyakarta Kota': ['Gondokusuman', 'Jetis', 'Danurejan']
        };

        // Handle perubahan pada provinsi
        document.getElementById('provinsi').addEventListener('change', function() {
            const provinsi = this.value;
            const kabupatenSelect = document.getElementById('kabupaten');

            // Reset kabupaten dan kota
            kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten</option>';
            document.getElementById('kota').innerHTML = '<option value="">Pilih Kota</option>';

            if (provinsi) {
                dataKabupaten[provinsi].forEach(kab => {
                    const option = document.createElement('option');
                    option.value = kab;
                    option.textContent = kab;
                    kabupatenSelect.appendChild(option);
                });
            }
        });

        // Handle perubahan pada kabupaten
        document.getElementById('kabupaten').addEventListener('change', function() {
            const kabupaten = this.value;
            const kotaSelect = document.getElementById('kota');

            // Reset kota
            kotaSelect.innerHTML = '<option value="">Pilih Kota</option>';

            if (kabupaten && dataKota[kabupaten]) {
                dataKota[kabupaten].forEach(kota => {
                    const option = document.createElement('option');
                    option.value = kota;
                    option.textContent = kota;
                    kotaSelect.appendChild(option);
                });
            }
        });

        // Validasi form sebelum submit
        document.getElementById('locationForm').addEventListener('submit', function(event) {
            const provinsi = document.getElementById('provinsi').value;
            const kabupaten = document.getElementById('kabupaten').value;
            const kota = document.getElementById('kota').value;

            if (!provinsi || !kabupaten || !kota) {
                event.preventDefault(); // Mencegah form submit
                alert('Silakan pilih lokasi lengkap (Provinsi, Kabupaten, dan Kota)');
            }
        });
    </script>
</body>

</html>