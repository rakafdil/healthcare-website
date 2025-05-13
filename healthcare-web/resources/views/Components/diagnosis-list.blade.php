@php
    static $index = 0;
    $index++;
@endphp

<div x-data="{ open: false }" class="mb-2 border rounded shadow-sm">
    <button @click="open = !open"
        class="w-full text-left px-4 py-2 bg-blue-100 hover:bg-blue-200 flex justify-between items-center">
        <span>{{ $item->disease }}</span>
        <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transform transition-transform"
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
