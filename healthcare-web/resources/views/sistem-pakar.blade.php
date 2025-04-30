<x-layout>
    <x-slot:heading>Sistem Pakar</x-slot:heading>

    @foreach ($steps as $step)
        <li>
            <strong> {{ $step }} </strong>
        </li>
    @endforeach
</x-layout>
