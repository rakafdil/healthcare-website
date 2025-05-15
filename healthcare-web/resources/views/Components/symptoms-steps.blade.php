{{-- @php dd(get_defined_vars()); @endphp --}}

<div class="flex my-6 justify-center">
    @foreach (range(1, $totalSteps) as $i)
        @php
            if ($i == 1) {
                $stepName = 'Info';
            } elseif ($i == 2) {
                $stepName = 'Gejala';
            } elseif ($i == 3) {
                $stepName = 'Kondisi';
            } elseif ($i == 4) {
                $stepName = 'Detail';
            } else {
                $stepName = 'Perawatan';
            }
        @endphp
        <div class="flex flex-col items-center mx-4 px-6">
            <div class="text-2x1 font-medium text-gray-700 mb-2 w-full text-center">{{ $stepName }}</div>
            <a href="{{ url('/sistem-pakar/' . $userId . '/symptoms') }}?step={{ $i }}"
                class="w-12 h-12 flex items-center justify-center rounded-full border
                    {{ $currentStep == $i ? 'bg-blue-500 text-white border-blue-500' : 'border-black text-gray-600' }}
                    hover:bg-blue-100 hover:border-blue-500 transition">
                {{ $i }}
            </a>
        </div>
    @endforeach
</div>
