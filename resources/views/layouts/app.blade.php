<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Multi Auth')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- Alpine.js untuk handle toggle sidebar --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">

        <!-- Overlay untuk mobile -->
        <div 
            x-show="sidebarOpen"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
        ></div>

        <!-- Sidebar Mobile -->
        <div 
            x-show="sidebarOpen"
            x-transition:enter="transition transform duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 w-64 bg-indigo-800 text-white z-50 md:hidden"
        >
            @auth
                @include('layouts.sidebar')
            @endauth
        </div>

        <!-- Sidebar Desktop -->
        <div class="hidden md:flex md:w-64 bg-indigo-800 text-white">
            @auth
                @include('layouts.sidebar')
            @endauth
        </div>

        <!-- Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            @auth
                @include('layouts.header')
            @endauth

            <main class="flex-1 overflow-y-auto p-4">
                @yield('content')
            </main>

            @auth
                @include('layouts.footer')
            @endauth
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
