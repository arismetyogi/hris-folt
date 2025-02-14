<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body x-data class="flex flex-col min-h-screen overflow-x-hidden @if($bodyClass ?? false){{ $bodyClass }}@endif" x-cloak>

    <x-guest.header/>

    <main class="flex-grow overflow-x-hidden">
        {{ $slot }}
    </main>

    @livewireScripts
    @include('partials.footer')
</body>
</html>
