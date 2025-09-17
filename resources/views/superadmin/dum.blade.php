<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: white;
            /* Ensure the iframe has a white background */
        }
    </style>
</head>

<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Instansi</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>

    <body class="bg-gray-100">
        <div class="flex h-screen">
            <!-- Sidebar -->
            <div class="w-64 bg-indigo-800 text-white flex flex-col min-h-screen">
                <!-- Logo and Title -->
                <div class="p-4 border-b border-indigo-700">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-key text-white"></i>
                        </div>
                        <span class="text-xl font-bold">SIM ASET</span>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 p-4">
                    <ul class="space-y-2">
                        <li class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-indigo-700">
                            <i class="fas fa-home mr-2"></i>
                            DASHBOARD
                        </li>

                        <li class="px-3 py-2 text-sm font-medium text-indigo-200 hover:text-white cursor-pointer">
                            Master Data
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium bg-indigo-700 cursor-pointer">
                            Instansi
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Bidang
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Pegawai
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Akun
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Kategori
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Grup Kategori
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Aset
                        </li>

                        <li class="px-3 py-2 text-sm font-medium text-indigo-200 hover:text-white cursor-pointer">
                            Monitoring Aset
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Data Peminjaman
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Mutasi Aset
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Stock Opname
                        </li>

                        <li class="px-3 py-2 text-sm font-medium text-indigo-200 hover:text-white cursor-pointer">
                            Report
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Label Barcode
                        </li>
                        <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                            Kartu Inventaris
                        </li>
                    </ul>
                </nav>

                <!-- Logout -->
                <div class="p-4 border-t border-indigo-700">
                    <button
                        class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-indigo-200 hover:text-white transition-colors">
                        Log Out
                        <i class="fas fa-sign-out-alt ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Header -->
                <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <button class="text-gray-600 hover:text-gray-800 mr-4">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-lg font-semibold text-gray-800">Instansi</h1>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center">
                            <i class="fas fa-user text-indigo-600 mr-2"></i>
                            <span class="font-medium text-gray-800">John Doe</span>
                        </div>
                    </div>
                </header>

                <!-- Main Content Area -->
                <main class="flex-1 p-6 overflow-auto">

                </main>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 px-6 py-3 text-center text-sm text-gray-500">
                    <p>2025 Dinas Komunikasi dan Informatika, Allright Reserved</p>
                </footer>
            </div>
        </div>
    </body>

    </html>



    <script></script>
</body>

</html>
