<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Multi Auth')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
{{-- <body> --}}

<body class="bg-gray-100">
    {{-- <div class="d-flex" id="wrapper"> --}}

    <div class="flex h-screen">
        {{-- Sidebar --}}
        @auth
            {{-- @include('layouts.sidebar') --}}
            @include('layouts.sidebar-super')
        @endauth

        {{-- <div id="page-content-wrapper" class="w-100"> --}}
            <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Topbar --}}
            @auth
                @include('layouts.header')
            @endauth

            <main class="flex-1 overflow-y-auto p-4">
                @yield('content')
            </main>

            {{-- Footer --}}
            @auth
                @include('layouts.footer')
            @endauth

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
