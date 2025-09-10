<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIM ASET Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="sidebar">
        <div class="logo-container">
            <div class="logo">
                <img src="https://placehold.co/30x30/3a2a7d/ffffff?text=SA" alt="Logo">
            </div>
            <div class="logo-text">SIM ASET</div>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item @yield('menu-dashboard-active')">
                <span class="nav-text">DASHBOARD</span>
            </li>
            <li class="nav-item @yield('menu-peminjaman-active')">
                <span class="nav-text">Peminjaman Aset</span>
            </li>
        </ul>
        
        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">
                    Log Out
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="user-name">{{ auth()->user()->name }}</div>
            </div>
        </div>
        
        <div class="dashboard-title">@yield('page-title')</div>
        
        @yield('content')

        <div class="footer">
            2025 Dinas Komunikasi dan Informatika, Allright Reserved
        </div>
    </div>
</body>
</html>
