@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Tambah Aset Bergerak</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form class="space y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div>
                    <label for="namaAset" class="block text-sm font-medium text-gray-700 mb-1">Nama Aset</label>
                    <input type="text" id="namaAset"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="bidang" class="block text-sm font-medium text-gray-700 mb-1">Bidang</label>
                    <input type="text" id="bidang"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="tanggalPengembalian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengembalian</label>
                    <input type="date" id="tanggalPengembalian"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div>
                    <label for="pic" class="block text-sm font-medium text-gray-700 mb-1">PIC</label>
                    <input type="text" id="pic"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="tanggalPeminjaman" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Peminjaman</label>
                    <input type="date" id="tanggalPeminjaman"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-1">Tujuan Penggunaan</label>
                    <input type="text" id="tujuan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>
        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
            <input type="text" id="keterangan"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                Batal
            </button>
            <button type="button"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                Simpan
            </button>
        </div>
    </div>
    {{-- </main> --}}

@endsection
