{{-- resources/views/symptoms-page.blade.php --}}

<x-layout title="Healthcare Alomany - Melakukan Diagnosa - Sistem Pakar">
    <x-hero.sistem-pakar />

    <div class="flex justify-center">
        <h1 class="text-3xl font-bold m-6 text-black">Diagnosa Penyakit</h1>
    </div>
    {{-- <pre>{{ print_r(session()->all(), true) }}</pre> --}}
    {{-- @dd(session()) --}}
    <div class="flex my-6 justify-center">
        @foreach (range(1, 4) as $i)
            @php
                // Set step names
                $stepName = match ($i) {
                    1 => ['Info'],
                    2 => ['Gejala'],
                    3 => ['Kondisi'],
                    4 => ['Artikel &', 'Perawatan'], // Array untuk multiple lines
                };

                // Default: enabled
                $disabled = false;

                // Logic to disable based on session
                if (session('diagnosis.gender') === null && $i > 1) {
                    $disabled = true; // Step 2 to 4
                } elseif (session('diagnosis.gejala') === null && $i > 2) {
                    $disabled = true; // Step 3 to 4
                } elseif (session('diagnosis.result') === null && $i > 3) {
                    $disabled = true; // Step 4
                }

                // Style class for disabled state
                $linkClass = $disabled
                    ? 'border-gray-400 text-gray-400 pointer-events-none cursor-not-allowed'
                    : ($step == $i
                        ? 'bg-blue-500 text-white border-blue-500'
                        : 'border-black text-gray-600 hover:bg-blue-100 hover:border-blue-500');
            @endphp

            <div class="flex flex-col items-center mx-4 px-6">
                <div
                    class="h-16 flex flex-col justify-center items-center text-center text-2xl font-medium text-gray-700 mb-2">
                    @foreach ($stepName as $line)
                        <div>{{ $line }}</div>
                    @endforeach
                </div>
                <a href="{{ $disabled ? '#' : url('/sistem-pakar/symptoms') . '?step=' . $i }}"
                    class="w-12 h-12 flex items-center justify-center rounded-full border transition {{ $linkClass }}">
                    {{ $i }}
                </a>
            </div>
        @endforeach
    </div>

    <div class="px-20 py-8 text-2xl">

        @if ($step == 1)
            <div class="justify-self-center text-center">
                <form id="diagnosisForm" method="POST"
                    action="{{ url('/sistem-pakar/symptoms?step=' . ($step + 1)) }}">
                    @csrf

                    <label class="block mb-2 pb-3" for="umur">Umur</label>
                    <input type="number" id="umur" name="umur" required min="0"
                        placeholder="Masukkan umur Anda" value="{{ session('diagnosis.umur') }}"
                        class="w-full px-4 py-2 border-2 border-black  rounded-lg">

                    <br>

                    <div class="py-10">
                        <label class="block text-lg font-medium mb-2">Jenis Kelamin:</label>

                        <div class="flex gap-4">
                            <input type="radio" id="laki-laki" name="gender" value="Laki-laki" required
                                class="hidden peer/laki"
                                {{ session('diagnosis.gender') == 'Laki-laki' ? 'checked' : '' }}>
                            <label for="laki-laki"
                                class="px-6 py-2 border-2 border-gray-400 text-gray-600 rounded-lg cursor-pointer
                                       peer-checked/laki:bg-blue-500 peer-checked/laki:border-blue-500
                                       peer-checked/laki:text-white transition">
                                Laki-laki
                            </label>
                            <input type="radio" id="perempuan" name="gender" value="Perempuan"
                                class="hidden peer/perempuan"
                                {{ session('diagnosis.gender') == 'Perempuan' ? 'checked' : '' }}>
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

                    validateForm();
                </script>

            </div>
        @elseif($step == 2)
            @php
                $previousSymptoms = session('diagnosis.gejala', []);
            @endphp

            <form id="diagnosisForm" method="POST" action="{{ url('/sistem-pakar/symptoms/predict') }}">
                @csrf

                <label for="gejala" class="block text-xl font-semibold mb-3">Apa yang Anda alami?</label>

                <!-- Filter dropdown -->
                <div class="mb-4">
                    <select id="group-filter" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg bg-white">
                        <option value="">Filter berdasarkan kategori gejala</option>
                    </select>
                </div>

                <input type="text" id="gejala-input" placeholder="Ketik gejala atau klik untuk melihat semua..."
                    autocomplete="off" class="w-full px-4 py-2 border-2 border-black rounded-lg">
                <div id="suggestions"
                    class="max-h-80 overflow-y-auto bg-white shadow-md rounded-md mt-1 border border-gray-300"
                    style="display: none;"></div>
                <div class="mb-6"></div>

                <div class="mt-8 bg-gray-50 py-4 px-4 rounded-lg">
                    <h4 class="text-lg font-semibold mb-3">Gejala yang dipilih:</h4>
                    <ul id="selected-symptoms" class="list-disc pl-6"></ul>
                    <input type="hidden" name="gejala" id="gejala-hidden">
                </div>

                <div class="mt-8 flex justify-between">
                    <button type="button" id="backBtn"
                        class="w-3/14 bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Kembali
                    </button>

                    <button type="submit" id="submit-btn" disabled
                        class="w-3/14 bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed transition">
                        Lanjut
                    </button>
                </div>

            </form>
            <script>
                // Get grouped symptoms data from controller
                const allSymptomsData = @json($allSymptoms->toArray());
                const symptomsMap = @json($allSymptoms->pluck('nama_gejala_eng', 'nama_gejala_ind')->toArray());
                const previousSymptoms = @json($previousSymptoms);

                // Group symptoms by tipe
                const groupedSymptoms = {};
                allSymptomsData.forEach(symptom => {
                    const tipe = symptom.tipe || 'LAINNYA';
                    if (!groupedSymptoms[tipe]) {
                        groupedSymptoms[tipe] = [];
                    }
                    groupedSymptoms[tipe].push(symptom.nama_gejala_ind);
                });

                // Define the order of groups
                const groupOrder = [
                    'GEJALA UMUM & SISTEMIK',
                    'SISTEM SARAF & NEUROLOGIS',
                    'SISTEM KARDIOVASKULAR',
                    'SISTEM PERNAPASAN',
                    'SISTEM PENCERNAAN',
                    'SISTEM URINARI',
                    'SISTEM MUSKULOSKELETAL',
                    'MATA & PENGLIHATAN',
                    'KULIT & DERMATOLOGI',
                    'KUKU',
                    'SISTEM HEMATOLOGI & PENDARAHAN',
                    'SISTEM ENDOKRIN & METABOLIK',
                    'KESEHATAN MENTAL & PSIKOLOGIS',
                    'GEJALA KHUSUS & LAINNYA',
                    'RIWAYAT & FAKTOR RISIKO'
                ];

                const input = document.getElementById('gejala-input');
                const suggestions = document.getElementById('suggestions');
                const selectedList = document.getElementById('selected-symptoms');
                const hiddenInput = document.getElementById('gejala-hidden');
                const submitBtn = document.getElementById('submit-btn');
                const groupFilter = document.getElementById('group-filter');

                let selected = [...previousSymptoms]; // Initialize with previous selections if any
                let isShowingAll = false;
                let currentFilter = '';

                // Initial rendering of any previously selected symptoms
                window.addEventListener('DOMContentLoaded', () => {
                    populateGroupFilter();
                    renderSelected();
                    validateForm();
                });

                document.getElementById('backBtn').addEventListener('click', function() {
                    const urlParams = new URLSearchParams(window.location.search);
                    let step = parseInt(urlParams.get('step') || '1');
                    step = Math.max(1, step - 1);

                    const baseUrl = window.location.origin + window.location.pathname;
                    window.location.href = `${baseUrl}?step=${step}`;
                });

                // Group filter change event
                groupFilter.addEventListener('change', (e) => {
                    currentFilter = e.target.value;
                    input.value = '';

                    if (currentFilter) {
                        showFilteredSymptoms(currentFilter);
                    } else {
                        suggestions.style.display = 'none';
                        isShowingAll = false;
                    }
                });

                // Show all symptoms grouped when input is clicked
                input.addEventListener('click', () => {
                    if (input.value === '') {
                        if (currentFilter) {
                            showFilteredSymptoms(currentFilter);
                        } else {
                            showAllGroupedSymptoms();
                        }
                    }
                });

                input.addEventListener('input', () => {
                    const keyword = input.value.toLowerCase();
                    suggestions.innerHTML = '';
                    isShowingAll = false;

                    if (keyword.length > 0) {
                        const matchedSymptoms = [];

                        // Search through all symptoms or filtered symptoms
                        allSymptomsData.forEach(symptom => {
                            if (symptom.nama_gejala_ind.toLowerCase().includes(keyword) &&
                                !selected.includes(symptom.nama_gejala_ind)) {

                                // Apply group filter if active
                                if (!currentFilter || symptom.tipe === currentFilter) {
                                    matchedSymptoms.push(symptom);
                                }
                            }
                        });

                        if (matchedSymptoms.length > 0) {
                            suggestions.style.display = 'block';

                            // Group matched symptoms
                            const matchedGrouped = {};
                            matchedSymptoms.forEach(symptom => {
                                const tipe = symptom.tipe || 'LAINNYA';
                                if (!matchedGrouped[tipe]) {
                                    matchedGrouped[tipe] = [];
                                }
                                matchedGrouped[tipe].push(symptom.nama_gejala_ind);
                            });

                            // Render grouped results
                            groupOrder.forEach(groupName => {
                                if (matchedGrouped[groupName] && matchedGrouped[groupName].length > 0) {
                                    renderGroup(groupName, matchedGrouped[groupName]);
                                }
                            });

                            // Render any remaining groups not in the order
                            Object.keys(matchedGrouped).forEach(groupName => {
                                if (!groupOrder.includes(groupName)) {
                                    renderGroup(groupName, matchedGrouped[groupName]);
                                }
                            });
                        } else {
                            suggestions.style.display = 'none';
                        }
                    } else {
                        if (currentFilter) {
                            showFilteredSymptoms(currentFilter);
                        } else {
                            showAllGroupedSymptoms();
                        }
                    }
                });

                function populateGroupFilter() {
                    // Clear existing options except the first one
                    while (groupFilter.children.length > 1) {
                        groupFilter.removeChild(groupFilter.lastChild);
                    }

                    // Add options based on available groups in order
                    groupOrder.forEach(groupName => {
                        if (groupedSymptoms[groupName] && groupedSymptoms[groupName].length > 0) {
                            const option = document.createElement('option');
                            option.value = groupName;
                            option.textContent = groupName;
                            groupFilter.appendChild(option);
                        }
                    });

                    // Add any remaining groups not in the order
                    Object.keys(groupedSymptoms).forEach(groupName => {
                        if (!groupOrder.includes(groupName) && groupedSymptoms[groupName].length > 0) {
                            const option = document.createElement('option');
                            option.value = groupName;
                            option.textContent = groupName;
                            groupFilter.appendChild(option);
                        }
                    });
                }

                function showFilteredSymptoms(filterGroup) {
                    suggestions.innerHTML = '';
                    suggestions.style.display = 'block';
                    isShowingAll = true;

                    if (groupedSymptoms[filterGroup]) {
                        const availableSymptoms = groupedSymptoms[filterGroup].filter(symptom => !selected.includes(symptom));
                        if (availableSymptoms.length > 0) {
                            renderGroup(filterGroup, availableSymptoms);
                        }
                    }
                }

                function showAllGroupedSymptoms() {
                    suggestions.innerHTML = '';
                    suggestions.style.display = 'block';
                    isShowingAll = true;

                    // Render all groups in order
                    groupOrder.forEach(groupName => {
                        if (groupedSymptoms[groupName] && groupedSymptoms[groupName].length > 0) {
                            const availableSymptoms = groupedSymptoms[groupName].filter(symptom => !selected.includes(
                                symptom));
                            if (availableSymptoms.length > 0) {
                                renderGroup(groupName, availableSymptoms);
                            }
                        }
                    });

                    // Render any remaining groups not in the order
                    Object.keys(groupedSymptoms).forEach(groupName => {
                        if (!groupOrder.includes(groupName)) {
                            const availableSymptoms = groupedSymptoms[groupName].filter(symptom => !selected.includes(
                                symptom));
                            if (availableSymptoms.length > 0) {
                                renderGroup(groupName, availableSymptoms);
                            }
                        }
                    });
                }

                function renderGroup(groupName, symptoms) {
                    if (symptoms.length === 0) return;

                    // Create group header
                    const groupHeader = document.createElement('div');
                    groupHeader.classList.add('px-3', 'py-2', 'bg-blue-100', 'font-semibold', 'text-blue-800', 'text-sm',
                        'border-b');
                    groupHeader.textContent = groupName;
                    suggestions.appendChild(groupHeader);

                    // Create symptoms list for this group
                    symptoms.forEach(symptom => {
                        const li = document.createElement('div');
                        li.textContent = symptom;
                        li.classList.add('px-4', 'py-2', 'hover:bg-blue-50', 'cursor-pointer', 'text-sm', 'border-b',
                            'border-gray-100');
                        li.onclick = () => {
                            selected.push(symptom);
                            renderSelected();
                            validateForm();
                            input.value = '';
                            suggestions.innerHTML = '';
                            suggestions.style.display = 'none';
                            isShowingAll = false;
                        };
                        suggestions.appendChild(li);
                    });
                }

                // Close suggestions when clicking outside
                document.addEventListener('click', (event) => {
                    if (!event.target.closest('#gejala-input') && !event.target.closest('#suggestions')) {
                        suggestions.style.display = 'none';
                        isShowingAll = false;
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
                            li.classList.add(
                                'list-item',
                                'flex',
                                'items-center',
                                'mb-2',
                                'border-b',
                                'border-gray-300',
                                'pb-2'
                            );

                            const textSpan = document.createElement('span');
                            textSpan.textContent = symptom;
                            textSpan.classList.add('flex-grow'); // push the trash icon to far right

                            const removeBtn = document.createElement('button');
                            removeBtn.classList.add('ml-4'); // Space between text and icon
                            removeBtn.type = 'button';

                            const trashImg = document.createElement('img');
                            trashImg.src = '{{ asset('assets/trash-bin.png') }}';
                            trashImg.alt = 'Trash Icon';
                            trashImg.classList.add('w-5', 'h-5');

                            removeBtn.appendChild(trashImg);
                            removeBtn.classList.add('shrink-0', 'ml-4'); // keep size, spacing

                            removeBtn.onclick = (e) => {
                                e.preventDefault();
                                selected = selected.filter(s => s !== symptom);
                                renderSelected();
                                validateForm();

                                // Refresh suggestions if showing all or filtered
                                if (isShowingAll) {
                                    if (currentFilter) {
                                        showFilteredSymptoms(currentFilter);
                                    } else {
                                        showAllGroupedSymptoms();
                                    }
                                }
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
            <h2 class="text-center font-medium mb-5">Kondisi - Kondisi yang Memungkinkan</h2>
            <p class="text-lg font-semibold text-gray-800 mb-0.2">Gejala yang sudah dipilih:</p>

            @foreach (session('diagnosis.gejala') as $gejala)
                <span
                    class="inline-block bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full">
                    {{ $gejala }}
                </span>
            @endforeach

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 mt-6">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 mt-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="ml-3 text-sm text-yellow-700">
                        <span class="font-medium">Perhatian:</span> Sistem ini hanya memberikan perkiraan awal
                        dan tidak menggantikan diagnosis medis profesional. Selalu konsultasikan dengan tenaga
                        medis untuk penanganan yang tepat.
                    </p>
                </div>
            </div>

            @foreach (session('diagnosis.result') as $item)
                @if ($item->probability > 0)
                    <x-sistem-pakar.diagnosis-list :probability="$item->probability" :disease="$item->disease" :description="$item->description"
                        :precautions="$item->precautions" />
                @endif
            @endforeach
        @elseif($step == 4)
            <x-sistem-pakar.diagnosis-last :step="$step" :datas="session('diagnosis.result')" />
        @endif

        @if ($step == 3 || $step == 4)
            <div class="mt-8 flex justify-between">
                <button type="button"
                    onclick="saveScrollAndGo('{{ url('/sistem-pakar/symptoms?step=' . ($step - 1)) }}')"
                    class="w-3/14 bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg transition">
                    Kembali
                </button>
                @if ($step == 4)
                    <form id="finishForm" method="POST" action="{{ url('/sistem-pakar/symptoms/finish') }}">
                        @csrf
                        <button type="submit"
                            class="w-3/14 bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg transition">
                            Selesai
                        </button>
                    </form>
                @else
                    <button type="button"
                        onclick="saveScrollAndGo('{{ url('/sistem-pakar/symptoms?step=' . ($step + 1)) }}')"
                        class="w-3/14 bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Lanjut
                    </button>
                @endif
            </div>
        @endif

    </div>

    <script>
        function saveScrollAndGo(url) {
            localStorage.setItem('scrollPos', window.scrollY);
            window.location.href = url;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const scrollPos = localStorage.getItem('scrollPos');
            if (scrollPos !== null) {
                window.scrollTo(0, parseInt(scrollPos));
                localStorage.removeItem('scrollPos');
            }
        });

        document.getElementById('diagnosisForm').addEventListener('submit', function(e) {
            localStorage.setItem('scrollPos', window.scrollY);
        });
    </script>
</x-layout>
