<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
    <div class="min-h-full">
        <nav class="bg-white">
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
                                        Healthcare System
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="hidden md:flex gap-x-8">
                        <a href="/sistem-pakar"
                            class="self-center rounded-md px-3 py-2 text-sm font-medium text-black hover:bg-gray-700 hover:text-white">
                            Sistem Pakar
                        </a>
                        <a href="/rumah-sakit"
                            class="self-center rounded-md px-3 py-2 text-sm font-medium text-black hover:bg-gray-700 hover:text-white">
                            Rumah Sakit
                        </a>
                        <a href="/blog"
                            class="self-center rounded-md px-3 py-2 text-sm font-medium text-black hover:bg-gray-700 hover:text-white">
                            Blog
                        </a>
                        <a href="/masuk"
                            class="self-center rounded-md px-3 py-2 text-sm font-medium text-black hover:bg-gray-700 hover:text-white">
                            Masuk
                        </a>
                    </div>

                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-black hover:bg-gray-700 hover:text-white" -->
                    <a href="/" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white"
                        aria-current="page">Home</a>
                    <a href="/sistem-pakar"
                        class="block rounded-md px-3 py-2 text-base font-medium text-black hover:bg-gray-700 hover:text-white">Sistem
                        Pakar</a>
                    <a href="/rumah-sakit"
                        class="block rounded-md px-3 py-2 text-base font-medium text-black hover:bg-gray-700 hover:text-white">Rumah
                        Sakit</a>
                    <a href="/blog"
                        class="block rounded-md px-3 py-2 text-base font-medium text-black hover:bg-gray-700 hover:text-white">Blog</a>
                    <a href="/masuk"
                        class="block rounded-md px-3 py-2 text-base font-medium text-black hover:bg-gray-700 hover:text-white">Masuk</a>
                </div>

            </div>
        </nav>

        <header class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $heading }}</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <!-- Your content -->
                {{ $slot }}
            </div>
        </main>
    </div>

</body>

</html>
