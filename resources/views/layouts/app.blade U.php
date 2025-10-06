<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIM ASET')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script>
        // Jalankan sebelum CSS di-load
        (function () {
            const html = document.documentElement;
            const savedTheme = localStorage.getItem("color-theme");

            if (savedTheme === "dark" ||
                (!savedTheme && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                html.classList.add("dark");
            } else {
                html.classList.remove("dark");
            }
        })();
    </script>
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-white">

    @include('layouts.header')
    @include('layouts.sidebar')

    <!-- Wrapper utama -->
    <!-- Wrapper utama -->
    <div id="main-wrapper" class="flex flex-col min-h-screen pt-16 lg:pl-64 transition-all duration-300">
        <main class="flex-grow p-4 sm:p-6">
            @yield('content')
        </main>

        <footer>
            @include('layouts.footer')
        </footer>
    </div>


    <!-- Script toggle theme -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const html = document.documentElement;
            const savedTheme = localStorage.getItem("color-theme");

            // Set awal sesuai preferensi user atau sistem
            if (savedTheme === "dark" ||
                (!savedTheme && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                html.classList.add("dark");
            } else {
                html.classList.remove("dark");
            }

            // Fungsi global toggle (bisa dipanggil dari tombol di header)
            window.toggleTheme = function () {
                if (html.classList.contains("dark")) {
                    html.classList.remove("dark");
                    localStorage.setItem("color-theme", "light");
                } else {
                    html.classList.add("dark");
                    localStorage.setItem("color-theme", "dark");
                }
            }
        });
    </script>
</body>

</html>