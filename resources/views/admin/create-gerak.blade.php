@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Tambah Aset Bergerak</h1>
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
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <input type="text" id="kategori"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" id="jumlah"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="nilaiPembelian" class="block text-sm font-medium text-gray-700 mb-1">Nilai Pembelian</label>
                    <input type="number" id="nilaiPembelian"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                {{-- bergerak --}}
                <div>
                    <label for="merk" class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                    <input type="text" id="merk"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="serialNumber" class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
                        <input type="text" id="serialNumber"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    {{-- gada --}}
                    <div>
                        <label for="tahunProduksi" class="block text-sm font-medium text-gray-700 mb-1">Tahun
                            Produksi</label>
                        <input type="text" id="tahunProduksi"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div>
                    <label for="namaAset" class="block text-sm font-medium text-gray-700 mb-1">Nama Aset</label>
                    <input type="text" id="namaAset"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>



                <div>
                    <label for="grupKategori" class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori</label>
                    <input type="text" id="grupKategori"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                {{-- <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <input type="text" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div> --}}

                {{-- gada , status mungkin , enum --}}
                <div>
                    <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                    <input type="text" id="kondisi"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="tanggalPembelian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                        Pembelian</label>
                    <input type="date" id="tanggalPembelian"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="lokasiTerakhir" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir</label>
                    <input type="text" id="lokasiTerakhir"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <input type="text" id="type"
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
            <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
               <a href="{{ route('admin.dashboard') }}">
             Batal</a>
            </button>
                    
            <button type="button"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                Simpan
            </button>
        </div>
    </div>
    {{-- </main> --}}

@endsection
