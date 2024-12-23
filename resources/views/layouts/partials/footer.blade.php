<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<!-- {{ __('menu.login') }}  {{ __('menu.profile') }} {{ __('menu.blog') }}-->

<body>
    <footer class="text-sm flex items-center border-t border-gray-100 flex-wrap justify-between py-4 px-4">
        <div class="flex space-x-4">
            @foreach (config('app.supported_locales') as $locale => $data)
                <a href="{{ route('language.switch', $locale) }}"> <x-dynamic-component :component="'flag-country-' . $data['icon']"
                        class="w-6 h-6" /></a>
            @endforeach
        </div>
        <div class="flex space-x-4">
            <a class="text-gray-500 hover:text-purple-500" href="/login">{{ __('menu.login') }}</a>
            <a class="text-gray-500 hover:text-purple-500" href="/user/profile">{{ __('menu.profile') }}</a>
            <a class="text-gray-500 hover:text-purple-500" href="/blog">{{ __('menu.blog') }}</a>
        </div>
    </footer>
</body>
