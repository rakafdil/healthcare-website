{{-- resources/views/symptoms-page.blade.php --}}

<x-layout>
    <x-sistem-pakar-hero />

    <x-symptoms-steps :user_id="$user_id" :current_step="$step" :total_steps="5" />
    <div class="px-20 py-8 text-2xl">
        @if ($step == 1)
            <div class="justify-self-center text-center">
                <form action="{{ url("/sistem-pakar/$user_id/symptoms?step=2") }}" method="POST">
                    @csrf

                    <label class="block mb-2 pb-3" for="umur">Umur</label>
                    <input type="number" id="umur" name="umur" required min="0"
                        placeholder="Masukkan umur Anda" value="{{ old('umur') }}"
                        class="w-full px-4 py-2 border-2 border-black  rounded-lg">

                    <br>

                    <div class="py-10">
                        <label class="block text-lg font-medium mb-2">Jenis Kelamin:</label>

                        <div class="flex gap-4">
                            <input type="radio" id="laki-laki" name="gender" value="Laki-laki" required
                                class="hidden peer/laki" {{ old('gender') == 'Laki-laki' ? 'checked' : '' }}>
                            <label for="laki-laki"
                                class="px-6 py-2 border-2 border-gray-400 text-gray-600 rounded-lg cursor-pointer
                                       peer-checked/laki:bg-blue-500 peer-checked/laki:border-blue-500
                                       peer-checked/laki:text-white transition">
                                Laki-laki
                            </label>

                            <input type="radio" id="perempuan" name="gender" value="Perempuan"
                                class="hidden peer/perempuan" {{ old('gender') == 'Perempuan' ? 'checked' : '' }}>
                            <label for="perempuan"
                                class="px-6 py-2 border-2 border-gray-400 text-gray-600 rounded-lg cursor-pointer
                                       peer-checked/perempuan:bg-blue-500 peer-checked/perempuan:border-blue-500
                                       peer-checked/perempuan:text-white transition">
                                Perempuan
                            </label>
                        </div>
                    </div>

                    <br>

                    <button type="submit" id="submitBtn" disabled
                        class="w-full bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed transition">
                        Lanjut
                    </button>

                </form>

                <script>
                    const umurInput = document.getElementById('umur');
                    const genderInputs = document.querySelectorAll('input[name="gender"]');
                    const submitBtn = document.getElementById('submitBtn');

                    function validateForm() {
                        const umurFilled = umurInput.value.trim() !== '';
                        const genderChecked = [...genderInputs].some(input => input.checked);

                        if (umurFilled && genderChecked) {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                            submitBtn.classList.add('bg-blue-500', 'cursor-pointer');
                        } else {
                            submitBtn.disabled = true;
                            submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                            submitBtn.classList.remove('bg-blue-500', 'cursor-pointer');
                        }
                    }

                    umurInput.addEventListener('input', validateForm);
                    genderInputs.forEach(input => input.addEventListener('change', validateForm));
                </script>

            </div>
        @elseif($step == 2)
            @php
                $allSymptoms = [
                    'Gatal',
                    'Ruam kulit',
                    'Benjolan pada kulit',
                    'Bersin terus-menerus',
                    'Menggigil',
                    'Kedinginan',
                    'Nyeri sendi',
                    'Sakit perut',
                    'Asam lambung',
                    'Luka pada lidah',
                    'Pengecilan otot',
                    'Muntah',
                    'Rasa terbakar saat buang air kecil',
                    'Tetesan urin',
                    'Kelelahan',
                    'Penambahan berat badan',
                    'Kecemasan',
                    'Tangan dan kaki dingin',
                    'Perubahan suasana hati',
                    'Penurunan berat badan',
                    'Gelisah',
                    'Lesu',
                    'Bercak di tenggorokan',
                    'Kadar gula tidak normal',
                    'Batuk',
                    'Demam tinggi',
                    'Mata cekung',
                    'Sesak napas',
                    'Berkeringat',
                    'Dehidrasi',
                    'Gangguan pencernaan',
                    'Sakit kepala',
                    'Kulit menguning',
                    'Urin gelap',
                    'Mual',
                    'Kehilangan nafsu makan',
                    'Nyeri di belakang mata',
                    'Nyeri punggung',
                    'Sembelit',
                    'Sakit perut bagian bawah',
                    'Diare',
                    'Demam ringan',
                    'Urin kuning',
                    'Mata menguning',
                    'Gagal hati akut',
                    'Penumpukan cairan',
                    'Perut membengkak',
                    'Kelenjar getah bening bengkak',
                    'Tidak enak badan',
                    'Penglihatan kabur dan terganggu',
                    'Dahak',
                    'Iritasi tenggorokan',
                    'Mata merah',
                    'Tekanan pada sinus',
                    'Hidung meler',
                    'Hidung tersumbat',
                    'Nyeri dada',
                    'Lemah pada anggota tubuh',
                    'Detak jantung cepat',
                    'Nyeri saat buang air besar',
                    'Nyeri di daerah anus',
                    'Tinja berdarah',
                    'Iritasi pada anus',
                    'Sakit leher',
                    'Pusing',
                    'Kram',
                    'Memar',
                    'Obesitas',
                    'Kaki bengkak',
                    'Pembuluh darah bengkak',
                    'Wajah dan mata bengkak',
                    'Tiroid membesar',
                    'Kuku rapuh',
                    'Pembengkakan anggota tubuh',
                    'Lapar berlebihan',
                    'Kontak seksual di luar nikah',
                    'Bibir kering dan kesemutan',
                    'Bicara pelo',
                    'Sakit lutut',
                    'Nyeri sendi panggul',
                    'Lemah otot',
                    'Leher kaku',
                    'Sendi bengkak',
                    'Kekakuan gerakan',
                    'Gerakan berputar (vertigo)',
                    'Kehilangan keseimbangan',
                    'Ketidakseimbangan',
                    'Lemah pada satu sisi tubuh',
                    'Kehilangan penciuman',
                    'Ketidaknyamanan kandung kemih',
                    'Bau urin menyengat',
                    'Ingin terus buang air kecil',
                    'Buang angin',
                    'Gatal dari dalam',
                    'Wajah tampak sakit parah (tifus)',
                    'Depresi',
                    'Mudah marah',
                    'Nyeri otot',
                    'Kesadaran terganggu',
                    'Bintik merah di tubuh',
                    'Nyeri perut',
                    'Menstruasi tidak normal',
                    'Bercak warna tidak normal di kulit',
                    'Mata berair',
                    'Nafsu makan meningkat',
                    'Sering buang air kecil',
                    'Riwayat keluarga',
                    'Dahak berlendir',
                    'Dahak berwarna karat',
                    'Kurang konsentrasi',
                    'Gangguan penglihatan',
                    'Pernah transfusi darah',
                    'Pernah disuntik dengan alat tidak steril',
                    'Koma',
                    'Pendarahan lambung',
                    'Perut membesar/kembung',
                    'Riwayat konsumsi alkohol',
                    'Darah dalam dahak',
                    'Pembuluh darah mencuat di betis',
                    'Jantung berdebar',
                    'Nyeri saat berjalan',
                    'Jerawat bernanah',
                    'Komedo hitam',
                    'Kerak kulit',
                    'Kulit mengelupas',
                    'Debu seperti perak di kulit',
                    'Lekukan kecil di kuku',
                    'Peradangan kuku',
                    'Lepuh',
                    'Luka merah di sekitar hidung',
                    'Keluarnya kerak kuning',
                ];
            @endphp

            <form action="{{ url("/sistem-pakar/$user_id/symptoms?step=3") }}" method="POST">
                @csrf

                <div>
                    <label for="gejala">Apa yang Anda alami?</label><br>
                    <input type="text" id="gejala-input" placeholder="Ketik gejala..." autocomplete="off">
                    <ul id="suggestions" style="border: 1px solid #ccc; max-height: 100px; overflow-y: auto;"></ul>
                </div>

                <div>
                    <h4>Gejala yang dipilih:</h4>
                    <ul id="selected-symptoms"></ul>
                    <input type="hidden" name="gejala" id="gejala-hidden">
                </div>

                <br>

                <button type="submit">Lanjut</button>
            </form>

            <script>
                const symptoms = @json($allSymptoms);
                const input = document.getElementById('gejala-input');
                const suggestions = document.getElementById('suggestions');
                const selectedList = document.getElementById('selected-symptoms');
                const hiddenInput = document.getElementById('gejala-hidden');

                let selected = [];

                input.addEventListener('input', () => {
                    const keyword = input.value.toLowerCase();
                    suggestions.innerHTML = '';
                    if (keyword.length > 0) {
                        symptoms
                            .filter(item => item.toLowerCase().includes(keyword) && !selected.includes(item))
                            .forEach(symptom => {
                                const li = document.createElement('li');
                                li.textContent = symptom;
                                li.style.cursor = 'pointer';
                                li.onclick = () => {
                                    selected.push(symptom);
                                    renderSelected();
                                    input.value = '';
                                    suggestions.innerHTML = '';
                                };
                                suggestions.appendChild(li);
                            });
                    }
                });

                function renderSelected() {
                    selectedList.innerHTML = '';
                    selected.forEach((symptom, index) => {
                        const li = document.createElement('li');
                        li.textContent = `${index + 1}. ${symptom}`;
                        selectedList.appendChild(li);
                    });
                    hiddenInput.value = selected.join(',');
                }
            </script>
        @elseif($step == 3)
            <li>

            </li>

            <a href="{{ url("/sistem-pakar/$user_id/symptoms?step=4") }}" method="POST">
                <button type="submit">Lanjut</button>
            </a>
        @elseif($step == 4)
            <a href="{{ url("/sistem-pakar/$user_id/symptoms?step=5") }}" method="POST">
                <button type="submit">Lanjut</button>
            </a>
        @elseif($step == 5)
        @endif
    </div>
</x-layout>
