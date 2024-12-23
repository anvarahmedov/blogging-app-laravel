@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ isset($title) ? $title . ' - ' : '' }} {{ config('app.name', '') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-light antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        <header class="flex items-center justify-between py-3 px-6 border-b border-gray-100">
            <div id="header-left" class="flex items-center">
                <div class="text-gray-800 font-semibold">
                    <span class="text-purple-500">&lt;PURPLE&gt;</span>
                </div>
                <div class="top-menu ml-10">
                    <ul class="flex space-x-4">
                        <li>
                            <a class="flex space-x-2 items-center hover:text-purple-900 text-sm text-purple-500"
                                href="http://127.0.0.1:8000">
                                Home
                            </a>
                        </li>

                        <li>
                            <a class="flex space-x-2 items-center hover:text-purple-500 text-sm text-gray-500"
                                href="http://127.0.0.1:8000/blog">
                                Blog
                            </a>
                        </li>

                        <li>
                            <a class="flex space-x-2 items-center hover:text-purple-500 text-sm text-gray-500"
                                href="http://127.0.0.1:8000/blog">
                                About Us
                            </a>
                        </li>

                        <li>
                            <a class="flex space-x-2 items-center hover:text-purple-500 text-sm text-gray-500"
                                href="http://127.0.0.1:8000/blog">
                                Contact Us
                            </a>
                        </li>

                        <li>
                            <a class="flex space-x-2 items-center hover:text-purple-500 text-sm text-gray-500"
                                href="http://127.0.0.1:8000/blog">
                                Terms
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            @include('layouts.partials.header-right-guest')
        </header>




        <main class="container mx-auto px-5 flex flex-grow">
            {{ $slot }}
        </main>

        @include('layouts.partials.footer')
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
