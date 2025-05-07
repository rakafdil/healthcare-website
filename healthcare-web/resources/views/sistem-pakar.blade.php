<x-layout>

    <x-sistem-pakar-hero />

    <div class="px-20 py-8 text-2xl">
        <h1 class="text-5xl font-bold text-center">Pengecekan Gejala</h1>
        <h2 class="pt-10">Langkah-langkah:</h2>
        <ul class="font-thin">
            @foreach ($steps as $step)
                <li><strong>{{ $step }}</strong></li>
            @endforeach
        </ul>

        @if (isset($user_id))
            x <a href="/sistem-pakar/{{ $user_id }}/symptoms" class="text-red-600">Tes di Sini!</a>
            <hr>
            <h2>Riwayat Pemeriksaan Anda:</h2>
            <ul>
                @foreach ($history['history_penyakit'] as $key => $item)
                    <li>
                        <strong>{{ $key }}</strong>: Tanggal {{ $item['tanggal'] }}, Waktu {{ $item['waktu'] }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layout>
