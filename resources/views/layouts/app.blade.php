<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@extends('components/alert')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIM ASET')</title>
    <script>
    if (
        localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>

    {{-- @include('components.theme-init') --}}
    {{-- @include('components.theme-init') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-white">
    @include('layouts.header')
    @include('layouts.sidebar')

    <!-- Wrapper utama -->
    <div id="main-wrapper" class="flex flex-col min-h-screen pt-16 lg:pl-64 transition-all duration-300">
        <main class="flex-grow p-4 sm:p-6">
            @yield('content')
        </main>
        <footer>
            @include('layouts.footer')
        </footer>
    </div>
    @stack('scripts')
</body>


</html>
{{-- @stack('scripts') --}}