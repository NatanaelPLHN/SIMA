@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Tambah Aset Bergerak</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.assets.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Left Column -->
            <div class="space-y-4">
                <div>
                    <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Kode</label>
                    <input type="text" id="kode" name="kode"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <input type="text" id="kategori" name="kategori"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="nilai_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Nilai
                        Pembelian</label>
                    <input type="number" id="nilai_pembelian" name="nilai_pembelian"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- bergerak --}}
                <div>
                    <label for="merk" class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                    <input type="text" id="merk" name="merk"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-1">Serial
                            Number</label>
                        <input type="text" id="serial_number" name="serial_number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="tahun_produksi" class="block text-sm font-medium text-gray-700 mb-1">Tahun
                            Produksi</label>
                        <input type="date" id="tahun_produksi" name="tahun_produksi"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div>
                    <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-1">Nama Aset</label>
                    <input type="text" id="nama_aset" name="nama_aset"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="group_kategori" class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori</label>
                    <input type="text" id="group_kategori" name="group_kategori"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="tersedia">Tersedia</option>
                        <option value="dipakai">Dipakai</option>
                        <option value="rusak">Rusak</option>
                        <option value="hilang">Hilang</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>

                <div>
                    <label for="tgl_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                        Pembelian</label>
                    <input type="date" id="tgl_pembelian" name="tgl_pembelian"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="lokasi_terakhir" class="block text-sm font-medium text-gray-700 mb-1">Lokasi
                        Terakhir</label>
                    <input type="text" id="lokasi_terakhir" name="lokasi_terakhir"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="tipe" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <input type="text" id="tipe" name="tipe"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Hidden field: jenis_aset -->
            <input type="hidden" name="jenis_aset" value="bergerak">
            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.assets.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                    Simpan
                </button>
            </div>
        </form>

    </div>
@endsection
