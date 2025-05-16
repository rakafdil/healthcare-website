<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="flex flex-col min-h-screen">
    <div class="flex-grow">
        <!-- saya tambahkan id navbar untuk keperluan snap-scroll page home-->
        <nav id="navbar" class="bg-white sticky top-0 z-50">
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
                        <x-nav-link href="/blog" :active="request()->is('blog') || request()->is('blog/*')"> Blog </x-nav-link>
                        <x-nav-link href="/masuk" :active="request()->is('masuk') || request()->is('masuk/*')"> Masuk </x-nav-link>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-black hover:bg-gray-700 hover:text-white" -->
                    <a href="/"
                        class="{{ request()->is('/') ? 'bg-gray-900 text-white' : 'text-black hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium"
                        aria-current="page">Home</a>
                    <a href="/sistem-pakar"
                        class="{{ request()->is('sistem-pakar') ? 'bg-gray-900 text-white' : 'text-black hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium ">Sistem
                        Pakar</a>
                    <a href="/rumah-sakit"
                        class="{{ request()->is('rumah-sakit') ? 'bg-gray-900 text-white' : 'text-black hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium ">Rumah
                        Sakit</a>
                    <a href="/blog"
                        class=" {{ request()->is('blog') ? 'bg-gray-900 text-white' : 'text-black hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium ">Blog</a>
                    <a href="/masuk"
                        class="{{ request()->is('masuk') ? 'bg-gray-900 text-white' : 'text-black hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium ">Masuk</a>
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


</body>

</html>
