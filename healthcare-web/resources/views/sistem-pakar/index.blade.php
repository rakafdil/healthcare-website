<x-layout>

    <x-sistem-pakar-hero />

    <div class="px-4 md:px-8 lg:px-20 py-8">
        <header class="text-center mb-10 pb-6 border-b-2 border-blue-500">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-2">Pengecekan Gejala Kesehatan</h1>
            <p class="text-gray-600">Dapatkan informasi awal tentang kondisi kesehatan Anda berdasarkan gejala yang
                dialami</p>
        </header>

        <div class="flex flex-col lg:flex-row items-start justify-between gap-10 mb-12">
            {{-- Kiri: Langkah-langkah --}}
            <div class="flex-1 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-semibold text-blue-600 border-b-2 border-gray-200 pb-3 mb-4">Cara Menggunakan
                    Sistem Ini</h2>
                <ol class="list-decimal list-inside space-y-3 text-gray-700">
                    <li>Pastikan Anda telah daftar dan masuk ke sistem, jika belum Anda dapat mendaftar terlebih dahulu.
                    </li>
                    <li>Tekan tombol "Mulai Diagnosa" di sebelah untuk melanjutkan pengecekan.</li>
                    <li>Masukkan informasi diri Anda yang telah diminta oleh sistem (usia, jenis kelamin, riwayat
                        kesehatan).</li>
                    <li>Masukkan gejala-gejala yang Anda alami dengan detail untuk hasil yang lebih akurat.</li>
                    <li>Sistem akan menampilkan kondisi-kondisi yang mungkin terjadi pada Anda beserta tingkat
                        kemungkinannya.</li>
                    <li>Riwayat pengecekan Anda akan tersimpan dan dapat dilihat kembali kapan saja.</li>
                </ol>
                <div class="flex justify-around mt-6">
                    <span class="text-2xl text-blue-500">🧬</span>
                    <span class="text-2xl text-blue-500">💊</span>
                    <span class="text-2xl text-blue-500">🏥</span>
                    <span class="text-2xl text-blue-500">👨‍⚕️</span>
                    <span class="text-2xl text-blue-500">🩺</span>
                </div>
            </div>

            {{-- Kanan: Tombol Diagnosa --}}
            <div
                class="flex-shrink-0 flex flex-col items-center bg-blue-50 rounded-xl shadow-md p-6 hover:translate-y-[-5px] transition-all duration-300">
                @if (isset($user_id))
                    <a href="/sistem-pakar/{{ $user_id }}/symptoms/#" class="inline-block">
                        <div
                            class="w-44 h-44 md:w-48 md:h-48 bg-blue-500 rounded-full flex flex-col items-center justify-center text-white font-bold transition-all duration-300 shadow-lg hover:bg-blue-600 hover:scale-105">
                            <div class="text-4xl mb-2">📱</div>
                            <div>TEKAN DI SINI</div>
                            <div>UNTUK DIAGNOSA</div>
                        </div>
                    </a>
                @else
                    <a href="/sistem-pakar/login" class="inline-block">
                        <div
                            class="w-44 h-44 md:w-48 md:h-48 bg-blue-500 rounded-full flex flex-col items-center justify-center text-white font-bold transition-all duration-300 shadow-lg hover:bg-blue-600 hover:scale-105">
                            <div class="text-4xl mb-2">📱</div>
                            <div>TEKAN DI SINI</div>
                            <div>UNTUK DIAGNOSA</div>
                        </div>
                    </a>
                @endif
                <p class="mt-4 text-center text-gray-600">Pengecekan ini hanya membutuhkan waktu sekitar 3-5 menit</p>
            </div>
        </div>

        {{-- Riwayat --}}
        @if (isset($user_id))
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-semibold text-blue-600 border-b-2 border-gray-200 pb-3 mb-4">Riwayat Pengecekan
                </h2>

                @isset($history['history_penyakit'])
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left py-3 px-4 bg-gray-50 text-gray-700 border-b-2 border-gray-200">
                                        Tanggal</th>
                                    <th class="text-left py-3 px-4 bg-gray-50 text-gray-700 border-b-2 border-gray-200">
                                        Waktu</th>
                                    <th
                                        class="text-left py-3 px-4 bg-gray-50 text-gray-700 border-b-2 border-gray-200 hidden md:table-cell">
                                        Gejala Utama</th>
                                    <th
                                        class="text-left py-3 px-4 bg-gray-50 text-gray-700 border-b-2 border-gray-200 hidden lg:table-cell">
                                        Hasil Diagnosa</th>
                                    <th class="text-left py-3 px-4 bg-gray-50 text-gray-700 border-b-2 border-gray-200">
                                        Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history['history_penyakit'] as $key => $item)
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            {{ \Carbon\Carbon::parse($item['tanggal'])->format('d F Y') }}
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            {{ $item['waktu'] }}
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200 hidden md:table-cell">
                                            {{ $item['gejala_utama'] ?? 'Beragam gejala' }}
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200 hidden lg:table-cell">
                                            {{ $item['hasil_diagnosa'] ?? 'Lihat detail' }}
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            <a href="{{ route('sistem-pakar.history', ['user_id' => $user_id, 'history_id' => $key]) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-sm transition-colors duration-200">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-6">Belum ada riwayat pemeriksaan.</p>
                @endisset
            </div>
        @endif
    </div>

</x-layout>
