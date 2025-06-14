<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/Logo-removebg-preview.png') }}">
    <title>{{ $title ?? 'Healthcare Alomany - Rumah Sakit - Detail Rumah Sakit' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="flex flex-col min-h-screen overflow-x-hidden">
    <nav class="sticky top-0 z-50 bg-white">
        <div class="block md:hidden">
            <button type="button"
                class="inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 gap-x-2"
                id="mobile-menu-button">
                <span class="sr-only">Open main menu</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <a href="#" class="-m-1.5 p-1.5">
                    <div class="flex items-baseline gap-x-2">
                        <div class="shrink-0">
                            <img class="h-8" src="{{ asset('assets/Logo.png') }}" alt="Your Company">
                        </div>
                        <div class="text-1xl font-bold self-center" style="color: #FF0763;">
                            HEALTH CARE
                        </div>
                    </div>
                </a>
            </button>
            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden hidden" role="dialog" aria-modal="true" id="mobile-menu">
                <!-- Background backdrop, show/hide based on slide-over state. -->
                <div class="fixed inset-0 z-50 bg-black bg-opacity-25" id="mobile-backdrop"></div>
                <div
                    class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <a href="#" class="-m-1.5 p-1.5">
                            <div class="flex items-baseline gap-x-4">
                                <div class="shrink-0">
                                    <img class="h-8" src="{{ asset('assets/Logo.png') }}" alt="Your Company">
                                </div>
                                <div class="text-1xl font-bold self-center" style="color: #FF0763;">
                                    HEALTH CARE
                                </div>
                            </div>
                        </a>
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" id="mobile-close-button">
                            <span class="sr-only">Close menu</span>
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/5">
                            <div class="space-y-2 py-6">

                                <x-nav-link href="/" :active="request()->is('') || request()->is('/*')" :mobile="true"> Home
                                </x-nav-link>
                                <x-nav-link href="/sistem-pakar" :active="request()->is('sistem-pakar') || request()->is('sistem-pakar/*')" :mobile="true"> Sistem Pakar
                                </x-nav-link>
                                <x-nav-link href="/rumah-sakit" :active="request()->is('rumah-sakit') || request()->is('rumah-sakit/*')" :mobile="true"> Rumah Sakit
                                </x-nav-link>
                                <x-nav-link href="/artikel" :active="request()->is('artikel') || request()->is('artikel/*')" :mobile="true"> Artikel
                                </x-nav-link>
                            </div>
                        </div>
                        <div class="py-6">

                            @auth
                                <x-nav-link href="{{ route('logout') }}" :mobile="true"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Keluar
                                </x-nav-link>
                            @else
                                <x-nav-link href="/masuk" :active="request()->is('masuk') || request()->is('masuk/*')" :mobile="true"> Masuk </x-nav-link>
                            @endauth

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden md:block flex-grow">
            <!-- saya tambahkan id navbar untuk keperluan snap-scroll page home-->
            <nav id="navbar" class="sticky bg-white top-0 z-50">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <!-- Kiri: Logo + Menu -->
                        <div class="flex items-center space-x-10">
                            <div class="hidden md:block">
                                <div class="flex items-baseline gap-x-4">
                                    <a href="/" class="flex items-center gap-x-4 self-center">
                                        <div class="shrink-0">
                                            <img class="h-8" src="{{ asset('assets/Logo.png') }}" alt="Your Company">
                                        </div>
                                        <div class="text-1xl font-bold" style="color: #FF0763;">
                                            HEALTH CARE
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="hidden md:flex gap-x-8">
                            <x-nav-link href="/sistem-pakar" :active="request()->is('sistem-pakar') || request()->is('sistem-pakar/*')"> Sistem Pakar </x-nav-link>
                            <x-nav-link href="/rumah-sakit" :active="request()->is('rumah-sakit') || request()->is('rumah-sakit/*')"> Rumah Sakit </x-nav-link>
                            <x-nav-link href="/artikel" :active="request()->is('artikel') || request()->is('artikel/*')"> Blog </x-nav-link>
                            @auth
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="text-black hover:bg-gray-700 hover:text-white self-center rounded-md px-3 py-2 text-sm font-medium">
                                        Keluar
                                    </button>
                                </form>
                            @else
                                <x-nav-link href="/masuk" :active="request()->is('masuk') || request()->is('masuk/*')"> Masuk </x-nav-link>
                            @endauth
                        </div>
                    </div>
                </div>
        </div>
    </nav>

    <main>
        {{ $slot }}

    </main>

    </div>



    <!-- Footer Section -->
    <footer class="text-white" style="background-color: #499BE8;">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-x-3 mb-4 md:mb-0">
                    <img class="h-8" src="{{ asset('assets/footer.png') }}" alt="Healthcare Logo">
                    <span class="text-lg font-medium uppercase">HEALTH CARE</span>
                </div>

                <div class="flex items-center gap-x-6">
                    <!-- Social Media Icons -->
                    <a href="#" class="text-white hover:text-gray-200">
                        <img src="{{ asset('assets/whatsapp.png') }}" alt="WhatsApp" class="h-6 w-6">
                    </a>
                    <a href="#" class="text-white hover:text-gray-200">
                        <img src="{{ asset('assets/facebook.png') }}" alt="facebook" class="h-6 w-6">
                    </a>
                    <a href="#" class="text-white hover:text-gray-200">
                        <img src="{{ asset('assets/email.png') }}" alt="email" class="h-6 w-6">
                    </a>
                </div>

                <div class="mt-4 md:mt-0">
                    <a href="mailto:alomany.tif@gmail.com" class="text-white hover:text-gray-200">
                        alomany.tif@gmail.com
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileCloseButton = document.getElementById('mobile-close-button');
            const mobileBackdrop = document.getElementById('mobile-backdrop');

            // Open mobile menu
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.remove('hidden');
            });

            // Close mobile menu
            function closeMobileMenu() {
                mobileMenu.classList.add('hidden');
            }

            mobileCloseButton.addEventListener('click', closeMobileMenu);
            mobileBackdrop.addEventListener('click', closeMobileMenu);

            // Close menu when pressing Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                    closeMobileMenu();
                }
            });
        });
    </script>
</body>

</html>
