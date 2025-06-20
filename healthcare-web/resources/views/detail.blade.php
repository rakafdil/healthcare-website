<x-layout title="Healthcare Alomany - Rumah Sakit - Detail">
    <x-slot:heading></x-slot:heading>
<div class="relative left-1/2 right-1/2 -translate-x-1/2 text-white">
    <img src="{{ asset('assets/foto fitur rumah sakit.png') }}" alt="Rumah Sakit"
        class="w-full h-screen object-cover object-center">
    <div class="absolute" style="left: 10%; top: 30%;">
        <h1 class="text-4xl font-bold">RUMAH SAKIT</h1>
        <h1 class="text-4xl font-bold py-1">KETERSEDIAAN KAMAR</h1>

        <!-- Garis di atas tombol -->
        <div class="w-30 h-0.5 bg-white my-4 rounded-full"></div>

<form action="{{ route('rumah-sakit.peta') }}" method="GET">
    <input type="hidden" name="provinsi">
    <input type="hidden" name="kabupaten">
    <input type="hidden" name="kota">
    <button type="submit" class="bg-white text-blue-600 font-semibold px-10 py-2 rounded-3xl">
        Peta
    </button>
</form>

    </div>
</div>
    @include('hospital.detail')
</x-layout>