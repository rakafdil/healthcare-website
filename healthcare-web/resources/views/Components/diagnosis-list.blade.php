@php
    static $index = 0;
    $index++;
@endphp



<div x-data="{ open: false }" class="mb-2 border rounded shadow-sm">
    <button @click="open = !open"
        class="w-full text-left px-4 py-4 bg-blue-100 hover:bg-blue-200 flex justify-between items-center space-x-2">

        <span class="truncate whitespace-nowrap overflow-hidden flex-1">{{ $item->disease }}</span>

        @php
            $percentage = number_format($item->probability * 100, 2);
            $barColor = 'green-500';
            $textColor = 'green-600';

            if ($item->probability >= 0.75) {
                $barColor = 'red-500';
                $textColor = 'red-600';
            } elseif ($item->probability >= 0.5) {
                $barColor = 'yellow-500';
                $textColor = 'yellow-600';
            } elseif ($item->probability >= 0.25) {
                $barColor = 'blue-500';
                $textColor = 'blue-600';
            }
        @endphp

        <div class="flex flex-col items-end w-1/3">
            <span class="text-sm font-medium text-{{ $textColor }}">{{ $percentage }}%</span>
            <div class="w-full bg-white rounded-full h-2 mt-1">
                <div class="bg-{{ $barColor }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
            </div>
        </div>

        <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transform transition-transform ml-2"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>


    <div x-show="open" x-transition class="px-4 py-2 bg-white border-t">
        <p><strong>Kemungkinan:</strong> {{ number_format($item->probability * 100, 2) }}%</p>
        <p><strong>Deskripsi:</strong> {{ $item->description }}</p>

        @if (!empty($item->precautions))
            <p><strong>Penanganan:</strong></p>
            <ul class="list-disc list-inside">
                @foreach ($item->precautions as $p)
                    <li>{{ $p }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
