{{-- resources/views/symptoms-page.blade.php --}}

<x-layout>
    <x-sistem-pakar-hero />

    <x-symptoms-steps :user_id="$user_id" :current_step="$step" :total_steps="5" />
    <div class="px-20 py-8 text-2xl">
        @if ($step == 1)
            <div class="justify-self-center text-center">
                <form action="{{ url("/sistem-pakar/$user_id/symptoms?step=" . ($step + 1)) }}" method="POST">
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
                    'gatal' => 'itching',
                    'ruam kulit' => 'skin_rash',
                    'erupsi nodul kulit' => 'nodal_skin_eruptions',
                    'bersin terus menerus' => 'continuous_sneezing',
                    'menggigil' => 'shivering',
                    'kedinginan' => 'chills',
                    'nyeri sendi' => 'joint_pain',
                    'sakit perut' => 'stomach_pain',
                    'asam lambung' => 'acidity',
                    'luka di lidah' => 'ulcers_on_tongue',
                    'penyusutan otot' => 'muscle_wasting',
                    'muntah' => 'vomiting',
                    'nyeri saat buang air kecil' => 'burning_micturition',
                    'bercak saat buang air kecil' => 'spotting_urination',
                    'kelelahan' => 'fatigue',
                    'penambahan berat badan' => 'weight_gain',
                    'kecemasan' => 'anxiety',
                    'tangan dan kaki dingin' => 'cold_hands_and_feets',
                    'perubahan suasana hati' => 'mood_swings',
                    'penurunan berat badan' => 'weight_loss',
                    'gelisah' => 'restlessness',
                    'lemas' => 'lethargy',
                    'bercak di tenggorokan' => 'patches_in_throat',
                    'gula darah tidak teratur' => 'irregular_sugar_level',
                    'batuk' => 'cough',
                    'demam tinggi' => 'high_fever',
                    'mata cekung' => 'sunken_eyes',
                    'sesak napas' => 'breathlessness',
                    'keringat berlebihan' => 'sweating',
                    'dehidrasi' => 'dehydration',
                    'gangguan pencernaan' => 'indigestion',
                    'sakit kepala' => 'headache',
                    'kulit menguning' => 'yellowish_skin',
                    'urin gelap' => 'dark_urine',
                    'mual' => 'nausea',
                    'hilang nafsu makan' => 'loss_of_appetite',
                    'sakit di belakang mata' => 'pain_behind_the_eyes',
                    'sakit punggung' => 'back_pain',
                    'sembelit' => 'constipation',
                    'sakit perut bagian bawah' => 'abdominal_pain',
                    'diare' => 'diarrhoea',
                    'demam ringan' => 'mild_fever',
                    'urin kuning' => 'yellow_urine',
                    'mata menguning' => 'yellowing_of_eyes',
                    'gagal hati akut' => 'acute_liver_failure',
                    'kelebihan cairan' => 'fluid_overload',
                    'perut bengkak' => 'swelling_of_stomach',
                    'pembengkakan kelenjar getah bening' => 'swelled_lymph_nodes',
                    'malaise' => 'malaise',
                    'penglihatan buram dan terdistorsi' => 'blurred_and_distorted_vision',
                    'dahak' => 'phlegm',
                    'iritasi tenggorokan' => 'throat_irritation',
                    'kemerahan pada mata' => 'redness_of_eyes',
                    'tekanan sinus' => 'sinus_pressure',
                    'hidung meler' => 'runny_nose',
                    'hidung tersumbat' => 'congestion',
                    'nyeri dada' => 'chest_pain',
                    'kelemahan anggota tubuh' => 'weakness_in_limbs',
                    'detak jantung cepat' => 'fast_heart_rate',
                    'nyeri saat buang air besar' => 'pain_during_bowel_movements',
                    'nyeri di daerah anus' => 'pain_in_anal_region',
                    'tinja berdarah' => 'bloody_stool',
                    'iritasi di anus' => 'irritation_in_anus',
                    'sakit leher' => 'neck_pain',
                    'pusing' => 'dizziness',
                    'kram' => 'cramps',
                    'memar' => 'bruising',
                    'obesitas' => 'obesity',
                    'kaki bengkak' => 'swollen_legs',
                    'pembuluh darah bengkak' => 'swollen_blood_vessels',
                    'wajah dan mata bengkak' => 'puffy_face_and_eyes',
                    'pembesaran tiroid' => 'enlarged_thyroid',
                    'kuku rapuh' => 'brittle_nails',
                    'ekstremitas bengkak' => 'swollen_extremeties',
                    'lapar berlebihan' => 'excessive_hunger',
                    'kontak di luar pernikahan' => 'extra_marital_contacts',
                    'bibir kering dan kesemutan' => 'drying_and_tingling_lips',
                    'bicara pelo' => 'slurred_speech',
                    'nyeri lutut' => 'knee_pain',
                    'nyeri sendi pinggul' => 'hip_joint_pain',
                    'kelemahan otot' => 'muscle_weakness',
                    'leher kaku' => 'stiff_neck',
                    'sendi bengkak' => 'swelling_joints',
                    'kekakuan gerakan' => 'movement_stiffness',
                    'gerakan berputar' => 'spinning_movements',
                    'kehilangan keseimbangan' => 'loss_of_balance',
                    'ketidakstabilan' => 'unsteadiness',
                    'kelemahan satu sisi tubuh' => 'weakness_of_one_body_side',
                    'kehilangan penciuman' => 'loss_of_smell',
                    'ketidaknyamanan kandung kemih' => 'bladder_discomfort',
                    'bau urin tidak sedap' => 'foul_smell_ofurine',
                    'rasa ingin buang air kecil terus menerus' => 'continuous_feel_of_urine',
                    'keluar gas' => 'passage_of_gases',
                    'gatal dari dalam' => 'internal_itching',
                    'wajah tampak toksik (tifus)' => 'toxic_look_(typhos)',
                    'depresi' => 'depression',
                    'mudah marah' => 'irritability',
                    'nyeri otot' => 'muscle_pain',
                    'kesadaran terganggu' => 'altered_sensorium',
                    'bintik merah di tubuh' => 'red_spots_over_body',
                    'sakit perutt' => 'belly_pain',
                    'menstruasi tidak normal' => 'abnormal_menstruation',
                    'bercak diskromik' => 'dischromic_patches',
                    'mata berair' => 'watering_from_eyes',
                    'nafsu makan meningkat' => 'increased_appetite',
                    'sering buang air kecil' => 'polyuria',
                    'riwayat keluarga' => 'family_history',
                    'dahak berlendir' => 'mucoid_sputum',
                    'dahak berkarat' => 'rusty_sputum',
                    'kurang konsentrasi' => 'lack_of_concentration',
                    'gangguan penglihatan' => 'visual_disturbances',
                    'menerima transfusi darah' => 'receiving_blood_transfusion',
                    'menerima suntikan tidak steril' => 'receiving_unsterile_injections',
                    'koma' => 'coma',
                    'perdarahan lambung' => 'stomach_bleeding',
                    'perut kembung' => 'distention_of_abdomen',
                    'riwayat konsumsi alkohol' => 'history_of_alcohol_consumption',
                    'darah dalam dahak' => 'blood_in_sputum',
                    'pembuluh darah betis menonjol' => 'prominent_veins_on_calf',
                    'jantung berdebar' => 'palpitations',
                    'nyeri saat berjalan' => 'painful_walking',
                    'jerawat bernanah' => 'pus_filled_pimples',
                    'komedo' => 'blackheads',
                    'kerak kulit' => 'scurring',
                    'kulit mengelupas' => 'skin_peeling',
                    'seperti debu perak' => 'silver_like_dusting',
                    'lekukan kecil di kuku' => 'small_dents_in_nails',
                    'kuku meradang' => 'inflammatory_nails',
                    'lepuhan' => 'blister',
                    'luka merah di sekitar hidung' => 'red_sore_around_nose',
                    'kerak kuning yang keluar' => 'yellow_crust_ooze',
                ];
                // Get previously selected symptoms if any
                $previousSymptoms = session('symptoms', []);
            @endphp

            <form action="{{ url("/sistem-pakar/$user_id/symptoms/predict") }}" method="POST">

                @csrf

                <div class="mb-6">
                    <label for="gejala" class="block text-xl font-semibold mb-3">Apa yang Anda alami?</label>
                    <input type="text" id="gejala-input" placeholder="Ketik gejala..." autocomplete="off"
                        class="w-full px-4 py-2 border-2 border-black rounded-lg">
                    <ul id="suggestions" class="max-h-60 overflow-y-auto bg-white shadow-md rounded-md mt-1"
                        style="display: none;"></ul>
                </div>

                <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold mb-3">Gejala yang dipilih:</h4>
                    <ul id="selected-symptoms" class="list-disc pl-6"></ul>
                    <input type="hidden" name="gejala" id="gejala-hidden">
                </div>

                <div class="mt-8">
                    <button type="submit" id="submit-btn" disabled
                        class="w-full bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed transition">
                        Lanjut
                    </button>
                </div>
            </form>

            <script>
                const symptoms = @json(array_keys($allSymptoms));
                const symptomsMap = @json($allSymptoms);
                const previousSymptoms = @json($previousSymptoms);

                const input = document.getElementById('gejala-input');
                const suggestions = document.getElementById('suggestions');
                const selectedList = document.getElementById('selected-symptoms');
                const hiddenInput = document.getElementById('gejala-hidden');
                const submitBtn = document.getElementById('submit-btn');

                let selected = [...previousSymptoms]; // Initialize with previous selections if any

                // Initial rendering of any previously selected symptoms
                window.addEventListener('DOMContentLoaded', () => {
                    renderSelected();
                    validateForm();
                });

                input.addEventListener('input', () => {
                    const keyword = input.value.toLowerCase();
                    suggestions.innerHTML = '';
                    if (keyword.length > 0) {
                        const matchedSymptoms = symptoms
                            .filter(item => item.toLowerCase().includes(keyword) && !selected.includes(item));

                        if (matchedSymptoms.length > 0) {
                            suggestions.style.display = 'block';

                            matchedSymptoms.forEach(symptom => {
                                const li = document.createElement('li');
                                li.textContent = symptom;
                                li.classList.add('p-2', 'hover:bg-blue-100', 'cursor-pointer');
                                li.onclick = () => {
                                    selected.push(symptom);
                                    renderSelected();
                                    validateForm();
                                    input.value = '';
                                    suggestions.innerHTML = '';
                                    suggestions.style.display = 'none';
                                };
                                suggestions.appendChild(li);
                            });
                        } else {
                            suggestions.style.display = 'none';
                        }
                    } else {
                        suggestions.style.display = 'none';
                    }
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', (event) => {
                    if (event.target !== input && event.target !== suggestions) {
                        suggestions.style.display = 'none';
                    }
                });

                function renderSelected() {
                    selectedList.innerHTML = '';

                    if (selected.length === 0) {
                        const emptyItem = document.createElement('li');
                        emptyItem.textContent = 'Belum ada gejala yang dipilih';
                        emptyItem.classList.add('text-gray-500', 'italic');
                        selectedList.appendChild(emptyItem);
                    } else {
                        selected.forEach((symptom, index) => {
                            const li = document.createElement('li');
                            li.classList.add('flex', 'justify-between', 'items-center', 'mb-2');

                            const textSpan = document.createElement('span');
                            textSpan.textContent = symptom;

                            const removeBtn = document.createElement('button');
                            removeBtn.textContent = '×';
                            removeBtn.classList.add('ml-2', 'text-red-500', 'font-bold', 'text-xl');
                            removeBtn.type = 'button';
                            removeBtn.onclick = (e) => {
                                e.preventDefault();
                                selected = selected.filter(s => s !== symptom);
                                renderSelected();
                                validateForm();
                            };

                            li.appendChild(textSpan);
                            li.appendChild(removeBtn);
                            selectedList.appendChild(li);
                        });
                    }

                    hiddenInput.value = selected.join(',');
                }

                function validateForm() {
                    if (selected.length > 0) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                        submitBtn.classList.add('bg-blue-500', 'cursor-pointer');
                    } else {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                        submitBtn.classList.remove('bg-blue-500', 'cursor-pointer');
                    }
                }
            </script>
        @elseif($step == 3)
            <h2>Hasil Prediksi Penyakit</h2>
            @foreach ($result as $item)
                <div style="margin-bottom: 20px">
                    <strong>{{ $item->disease }}</strong><br>
                    Probabilitas: {{ number_format($item->probability * 100, 2) }}%<br>
                    Deskripsi: {{ $item->description }}<br>
                    Pencegahan:
                    <ul>
                        @foreach ($item->precautions as $p)
                            <li>{{ $p }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach


            <a href="{{ url("/sistem-pakar/$user_id/symptoms?step=" . ($step + 1)) }}" method="POST">
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
