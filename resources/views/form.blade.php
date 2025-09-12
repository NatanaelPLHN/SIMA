<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aset Bergerak</title>
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
                    <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                        <i class="fas fa-cube mr-2"></i>
                        Aset
                    </li>
                    <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                        Penggunaan Aset
                    </li>
                    <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                        Peminjaman Aset
                    </li>
                    <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                        Mutasi Aset
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
                    <h1 class="text-lg font-semibold text-gray-800">Tambah Aset Bergerak</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center">
                        <i class="fas fa-user text-indigo-600 mr-2"></i>
                        <span class="me-3 fw-bold text-primary">
                            <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                            ({{ ucfirst(auth()->user()->role) }})
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Form Content -->
            <main class="flex-1 p-6 overflow-auto">
                <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
                    <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Kode</label>
                                <input type="text" id="kode"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="merk" class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                                <input type="text" id="merk"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="kategori"
                                    class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <input type="text" id="kategori"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="serialNumber"
                                        class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
                                    <input type="text" id="serialNumber"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="tahunProduksi"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tahun Produksi</label>
                                    <input type="text" id="tahunProduksi"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div>
                                <label for="jumlah"
                                    class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                <input type="number" id="jumlah"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="nilaiPembelian" class="block text-sm font-medium text-gray-700 mb-1">Nilai
                                    Pembelian</label>
                                <input type="text" id="nilaiPembelian"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="namaAset" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                    Aset</label>
                                <input type="text" id="namaAset"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                <input type="text" id="type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="grupKategori" class="block text-sm font-medium text-gray-700 mb-1">Grup
                                    Kategori</label>
                                <input type="text" id="grupKategori"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="kondisi"
                                    class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                                <input type="text" id="kondisi"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="tanggalPembelian"
                                    class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian</label>
                                <input type="date" id="tanggalPembelian"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="lokasiTerakhir"
                                    class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir</label>
                                <input type="text" id="lokasiTerakhir"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </form>

                    <!-- Generate Code Section -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center space-x-4">
                            <label class="text-sm font-medium text-gray-700">Generate Code?</label>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <input type="radio" id="yes" name="generateCode" value="yes"
                                        class="text-indigo-600 focus:ring-indigo-500">
                                    <label for="yes" class="ml-2 text-sm text-gray-700">Yes</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="no" name="generateCode" value="no"
                                        class="text-indigo-600 focus:ring-indigo-500">
                                    <label for="no" class="ml-2 text-sm text-gray-700">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <button type="button"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                            Simpan
                        </button>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-3 text-center text-sm text-gray-500">
                <p>2025 Dinas Komunikasi dan Informatika, Allright Reserved</p>
            </footer>
        </div>
    </div>
</body>

</html>
