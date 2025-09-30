
@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Form Groups -->
            <div class="space-y-4">
                <!-- Tanggal dan Bidang -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" id="tanggal"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="bidang" class="block text-sm font-medium text-gray-700 mb-1">Bidang</label>
                        <select id="bidang" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Bidang</option>
                            <option value="bidang1">Bidang 1</option>
                            <option value="bidang2">Bidang 2</option>
                            <option value="bidang3">Bidang 3</option>
                        </select>
                    </div>
                </div>

                <!-- Kategori Aset dan Lokasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori Aset</label>
                        <select id="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Kategori</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="perabotan">Perabotan</option>
                            <option value="kendaraan">Kendaraan</option>
                            <option value="perlengkapan">Perlengkapan</option>
                        </select>
                    </div>

                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <select id="lokasi" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Lokasi</option>
                            <option value="ruang1">Ruang 1</option>
                            <option value="ruang2">Ruang 2</option>
                            <option value="ruang3">Ruang 3</option>
                        </select>
                    </div>
                </div>

                <!-- Status dan Jenis Opname -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <div>
                        <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Jenis Opname</label>
                        <select id="jenis" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Jenis</option>
                            <option value="rutin">Rutin</option>
                            <option value="insidental">Insidental</option>
                            <option value="tahunan">Tahunan</option>
                        </select>
                    </div>
                </div>

                <!-- Petugas dan Catatan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="petugas" class="block text-sm font-medium text-gray-700 mb-1">Petugas</label>
                        <select id="petugas" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Petugas</option>
                            <option value="petugas1">Petugas 1</option>
                            <option value="petugas2">Petugas 2</option>
                            <option value="petugas3">Petugas 3</option>
                        </select>
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <input type="text" id="catatan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </form>

        <!-- Buttons -->
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                Batal
            </button>
            <button type="button"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                Simpan
            </button>
        </div>
    </div>
@endsection
