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
        x-data="{
            showMobileSidebar: false
        }"
        x-cloak
        class="font-sans antialiased"
    >
        <div class="grid grid-cols-1 lg:grid-cols-[238px_1fr] min-h-screen bg-gray-50">
            <!-- Dashboard Navigation -->
            @if (isset($sidebar))
                <aside class="hidden lg:grid bg-white bg-[#f1f3f4] w-[238px]">
                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        {{ $sidebar }}
                    </div>
                </aside>

                <aside {{-- @click.outside="showMobileSidebar = false" --}} class="mobile bg-[#f1f3f4] w-[238px] transition-transform transform-gpu lg:grid fixed h-screen z-40" :class="{'-translate-x-[238px]': !showMobileSidebar}">
                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        {{ $sidebar }}
                    </div>
                </aside>

            @endif

            <!-- Page Content -->
            <main>
                @include('layouts.dashboard-header')
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
