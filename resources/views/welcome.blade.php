<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM ASET Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        
        .sidebar {
            width: 250px;
            background-color: #3a2a7d;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
        }
        
        .logo-container {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo img {
            width: 30px;
            height: 30px;
        }
        
        .logo-text {
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .nav-menu {
            padding: 20px;
            list-style: none;
        }
        
        .nav-item {
            padding: 15px 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        
        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        
        .nav-icon {
            width: 20px;
            height: 20px;
        }
        
        .nav-text {
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .logout:hover {
            color: white;
        }
        
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: #3a2a7d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .dashboard-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #3a2a7d;
            margin-bottom: 20px;
        }
        
        .welcome-card {
            background-color: #3a2a7d;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .welcome-message {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
        
        .welcome-subtext {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .stats-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            flex: 1;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .stat-title {
            font-weight: 600;
            font-size: 1rem;
        }
        
        .stat-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .card-blue {
            background-color: #2196f3;
        }
        
        .card-teal {
            background-color: #00bcd4;
        }
        
        .card-purple {
            background-color: #3a2a7d;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #888;
            font-size: 0.9rem;
        }
    </style>
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
            <li class="nav-item active">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                    <path d="M2 17l10 5 10-5"></path>
                    <path d="M2 12l10 5 10-5"></path>
                </svg>
                <span class="nav-text">DASHBOARD</span>
            </li>
            <li class="nav-item">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span class="nav-text">Peminjaman Aset</span>
            </li>
        </ul>
        
        <div class="logout">
            Log Out
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                <path d="M9 21H5a4 4 0 0 1-4-4V5a4 4 0 0 1 4-4h4"></path>
                <line x1="16" y1="3" x2="16" y2="21"></line>
                <line x1="21" y1="3" x2="16" y2="8"></line>
                <line x1="21" y1="16" x2="16" y2="21"></line>
            </svg>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="user-profile">
                <div class="user-avatar">JD</div>
                <div class="user-name">John Doe</div>
            </div>
        </div>
        
        <div class="dashboard-title">DASHBOARD</div>
        
        <div class="welcome-card">
            <div class="welcome-message">Selamat pagi, John Doe</div>
            <div class="welcome-subtext">Selamat Datang di Website Sistem Informasi Manajemen Aset DISKOMINFO Kota Samarinda</div>
        </div>
        
        <div class="stats-container">
            <div class="stat-card card-purple">
                <div class="stat-card-header">
                    <div class="stat-title">Total Aset Bergerak</div>
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                            <line x1="9" y1="21" x2="9" y2="9"></line>
                        </svg>
                    </div>
                </div>
                <div class="stat-value">11</div>
            </div>
            
            <div class="stat-card card-blue">
                <div class="stat-card-header">
                    <div class="stat-title">Total Aset Tetap</div>
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    </div>
                </div>
                <div class="stat-value">5</div>
            </div>
            
            <div class="stat-card card-teal">
                <div class="stat-card-header">
                    <div class="stat-title">Total Aset Habis Pakai</div>
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                            <line x1="9" y1="21" x2="9" y2="9"></line>
                            <line x1="15" y1="15" x2="15" y2="21"></line>
                            <line x1="15" y1="15" x2="21" y2="15"></line>
                        </svg>
                    </div>
                </div>
                <div class="stat-value">3</div>
            </div>
        </div>
        
        <div class="footer">
            2025 Dinas Komunikasi dan Informatika, Allright Reserved
        </div>
    </div>
</body>
</html>