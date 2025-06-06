@props(['active' => false, 'mobile' => false])

@if ($attributes->has('onclick'))
    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit"
            class="{{ $active ? 'bg-gray-900 text-white' : 'text-black hover:bg-gray-700 hover:text-white' }} {{ $mobile ? 'block rounded-md px-3 py-2 text-base font-medium w-full text-left' : 'self-center rounded-md px-3 py-2 text-sm font-medium' }}"
            aria-current="{{ $active ? 'page' : 'false' }}">
            {{ $slot }}
        </button>
    </form>
@else
    <a class="{{ $active ? 'bg-gray-900 text-white' : 'text-black hover:bg-gray-700 hover:text-white' }} {{ $mobile ? 'block rounded-md px-3 py-2 text-base font-medium' : 'self-center rounded-md px-3 py-2 text-sm font-medium' }}"
        aria-current="{{ $active ? 'page' : 'false' }}" {{ $attributes }}>
        {{ $slot }}
    </a>
@endif
