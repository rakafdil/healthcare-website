<x-layout>

    <x-sistem-pakar-hero />

    <div class="px-20 py-8 text-2xl">
        <h1 class="text-5xl font-bold text-center mb-10">Pengecekan Gejala</h1>

        <div class="flex flex-col lg:flex-row items-start justify-between gap-10">
            {{-- Kiri: Langkah-langkah --}}
            <div class="flex-1">
                <h2 class="text-2xl font-semibold mb-4">Cara Menggunakan Sistem Ini:</h2>
                <ol class="list-decimal list-inside font-light space-y-2">
                    <li>Pastikan Anda telah daftar dan masuk ke sistem, jika belum Anda dapat mendaftar terlebih dahulu.
                    </li>
                    <li>Jika sudah, Anda dapat menekan tombol di sebelah untuk melanjutkan pengecekan.</li>
                    <li>Masukkan informasi Anda yang telah diminta oleh sistem.</li>
                    <li>Masukkan gejala-gejala yang Anda alami.</li>
                    <li>Sistem lalu menampilkan kondisi-kondisi yang mungkin terjadi pada Anda.</li>
                </ol>
            </div>

            {{-- Kanan: Tombol Diagnosa --}}
            <div class="flex-shrink-0 text-center">
                @if (isset($user_id))
                    <a href="/sistem-pakar/{{ $user_id }}/symptoms/#" class="inline-block">
                        <img src="{{ asset('assets/tombol-diagnosa.png') }}" alt="Tombol Diagnosa"
                            class="w-52 hover:scale-105 transition-transform duration-300">
                    </a>
                @else
                    <a href="/sistem-pakar/login" class="inline-block">
                        <img src="{{ asset('assets/tombol-diagnosa.png') }}" alt="Tombol Diagnosa"
                            class="w-52 hover:scale-105 transition-transform duration-300">
                    </a>
                @endif
            </div>
        </div>

        {{-- Riwayat --}}
        @if (isset($user_id))
            <hr class="my-10">
            <h2 class="text-2xl font-semibold mb-4">Riwayat Pemeriksaan Anda:</h2>
            <div class="space-y-4">
                @isset($history['history_penyakit'])
                    @foreach ($history['history_penyakit'] as $key => $item)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div class="text-base">
                                {{ \Carbon\Carbon::parse($item['tanggal'])->format('d F Y') }}
                            </div>
                            <div class="text-base">
                                {{ $item['waktu'] }}
                            </div>
                            <a href="{{ route('sistem-pakar.history', ['user_id' => $user_id, 'history_id' => $key]) }}">
                                See More
                            </a>

                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Belum ada riwayat pemeriksaan.</p>
                @endisset
            </div>
        @endif
    </div>
</x-layout>
