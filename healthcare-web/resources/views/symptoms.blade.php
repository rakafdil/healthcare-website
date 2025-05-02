{{-- resources/views/symptoms-page.blade.php --}}
<x-layout>
    <x-slot:heading>Gejala</x-slot:heading>

    <x-symptoms-steps :user_id="$user_id" :current_step="$step" :total_steps="5" />

    @if ($step == 1)
        <form action="{{ url("/sistem-pakar/$user_id/symptoms?step=2") }}" method="POST">
            @csrf

            <div>
                <label for="umur">Umur:</label><br>
                <input type="number" id="umur" name="umur" required min="0" placeholder="Masukkan umur Anda"
                    value="{{ old('umur') }}">
            </div>

            <br>

            <div>
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
    @elseif($step == 2)
        <form action="{{ url("/sistem-pakar/$user_id/symptoms?step=3") }}" method="POST">
            @csrf

            <div>
                <label for="gejala">Apa yang Anda alami?</label><br>
                <input type="text" id="gejala" name="gejala" required
                    placeholder="Ketikkan apa yang Anda alami di sini" value="{{ old('gejala') }}">
            </div>

            <br>

            <button type="submit">Lanjut</button>
        </form>
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
</x-layout>
