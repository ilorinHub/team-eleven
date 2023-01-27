<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        x-cloak
        x-data="{
            open: false,
        }"
        x-init="async() => await $nextTick()"
        class="min-h-screen font-sans text-gray-600 antialiased grid grid-rows-[auto_1fr_auto]">
        @include('layouts.nav')
        <main class="font-sans antialiased">

                {{ $slot }}

        </main>
        @include('layouts.footer')
    </body>
</html>
