<x-layout>
    <x-slot:heading>Sistem Pakar</x-slot:heading>

    <h2>Langkah-langkah:</h2>
    <ul>
        @foreach ($steps as $step)
            <li><strong>{{ $step }}</strong></li>
        @endforeach
    </ul>

    @isset($history)
        <hr>
        <h2>Riwayat Pemeriksaan Anda:</h2>
        <ul>
            @foreach ($history['history_penyakit'] as $key => $item)
                <li>
                    <strong>{{ $key }}</strong>: Tanggal {{ $item['tanggal'] }}, Waktu {{ $item['waktu'] }}
                </li>
            @endforeach
        </ul>
    @endisset
</x-layout>
