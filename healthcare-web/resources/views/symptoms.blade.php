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
                        <label>Jenis Kelamin:</label><br>

                        <input type="radio" id="laki-laki" name="gender" value="Laki-laki" required
                            {{ old('gender') == 'Laki-laki' ? 'checked' : '' }}>
                        <label for="laki-laki">Laki-laki</label><br>

                        <input type="radio" id="perempuan" name="gender" value="Perempuan"
                            {{ old('gender') == 'Perempuan' ? 'checked' : '' }}>
                        <label for="perempuan">Perempuan</label>
                    </div>

                    <br>

                    <button type="submit">Lanjut</button>
                </form>
            </div>
        @elseif($step == 2)
            @php
                $allSymptoms = ['Batuk', 'Demam', 'Sesak Napas', 'Pusing', 'Sakit Tenggorokan', 'Mual', 'Lemas']; // contoh
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
