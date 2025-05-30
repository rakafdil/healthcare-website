<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit - Ketersediaan Kamar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #fffff;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            width: 99vw;
            /* Ubah menjadi viewport width */
            margin: 0;
            margin-bottom: 20px;
            margin-top: -25px;
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

        .hero-container {
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .hero-text {
            position: relative;
            z-index: 2;
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
            width: 100vw;
            /* Gunakan viewport width untuk mengisi seluruh lebar layar */
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
            margin: 0 auto;
            padding: 20px;
        }

        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 20px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: block;
            margin: 0 auto;
            width: 150px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="hero-section">
        <img src="assets/foto fitur rumah sakit.png" alt="Rumah Sakit" class="hero-image">
        <div class="hero-container">
            <div class="hero-text">
                <h1>RUMAH SAKIT</h1>
                <h2>KETERSEDIAAN KAMAR</h2>
                <a href="/" class="btn">Beranda</a>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="title">Pilih Lokasi Rumah Sakit</h2>

        <form id="locationForm" action="/peta" method="GET">
            <div class="form-group">
                <select class="form-control" id="provinsi" name="provinsi">
                    <option value="">Pilih Provinsi</option>
                    <option value="jawa_barat">Jawa Barat</option>
                    <option value="jawa_tengah">Jawa Tengah</option>
                    <option value="jawa_timur">Jawa Timur</option>
                    <option value="dki_jakarta">DKI Jakarta</option>
                    <option value="di_yogyakarta">DI Yogyakarta</option>
                </select>
            </div>

            <div class="form-group">
                <select class="form-control" id="kabupaten" name="kabupaten">
                    <option value="">Pilih Kabupaten</option>
                    <!-- Opsi akan diisi melalui JavaScript -->
                </select>
            </div>

            <div class="form-group">
                <select class="form-control" id="kota" name="kota">
                    <option value="">Pilih Kota</option>
                    <!-- Opsi akan diisi melalui JavaScript -->
                </select>
            </div>

            <button type="submit" class="btn-primary" id="cariRumahSakit">Telusuri</button>
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
