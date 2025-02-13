<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<body x-data
      class="flex flex-col lg:min-h-screen bg-zinc-50 dark:bg-zinc-900">
<x-app.sidebar />

<div class="flex flex-col min-h-screen pl-0 justify-stretch lg:pl-64">

    {{-- Mobile Header --}}
    <header
        class="lg:hidden px-5 flex justify-between sticky top-0 z-40 bg-gray-50 dark:bg-zinc-900 -mb-px border-b border-zinc-200/70 dark:border-zinc-700 h-[72px] items-center">
        <button x-on:click="window.dispatchEvent(new CustomEvent('open-sidebar'))"
                class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-md text-zinc-700 dark:text-zinc-200 hover:bg-gray-200/70 dark:hover:bg-zinc-700/70">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
            </svg>
        </button>
        <x-app.user-menu position="top" />
    </header>
    {{-- End Mobile Header --}}

    <main class="flex flex-col flex-1 xl:px-0 lg:pt-4 lg:h-screen">
        <div
            class="flex-1 h-full overflow-hidden bg-white border-t border-l-0 lg:border-l dark:bg-zinc-800 lg:rounded-tl-xl border-zinc-200/70 dark:border-zinc-700">
            <div class="w-full h-full px-5 sm:px-8 lg:overflow-y-scroll scrollbar-hidden lg:pt-5 lg:px-5">
                {{ $slot }}

            </div>
        </div>
    </main>
</div>

<x-banner />

@stack('modals')
@livewireScripts
@livewire('wire-elements-modal')
@stack('js')

<script>
    if (localStorage.getItem("theme") === "dark" ||
        (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
</script>
</body>
</html>
