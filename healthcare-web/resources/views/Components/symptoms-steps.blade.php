{{-- @php dd(get_defined_vars()); @endphp --}}

<div class="flex gap-4 my-6 justify-center">
    @foreach (range(1, $totalSteps) as $i)
        <a href="{{ url('/sistem-pakar/' . $userId . '/symptoms') }}?step={{ $i }}"
            class="w-10 h-10 flex items-center justify-center rounded-full border-2
                  {{ $currentStep == $i ? 'bg-blue-500 text-white border-blue-500' : 'border-gray-300 text-gray-600' }}
                  hover:bg-blue-100 hover:border-blue-500 transition">
            {{ $i }}
        </a>
    @endforeach
</div>
