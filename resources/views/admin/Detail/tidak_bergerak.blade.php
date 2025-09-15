@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="text-lg font-semibold text-gray-800">Detail Aset Tidak Bergerak</h1>
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            AST-01
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama
                            Aset:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            Laptop
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            Acer
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bahan:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            Nitro 5
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            Elektronik
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Grup
                            Kategori:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            Elektronik
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Serial
                            Number:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            8820-2016
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun
                            Produksi:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            20029
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            Baik
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            5
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div class="flex justify-center">
                    <img src="https://placehold.co/300x300?text=QR+Code" alt="QR Code"
                        class="w-64 h-64 object-contain">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Pembelian:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            16/01/2004
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nilai
                            Pembelian:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            -
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi
                            Terakhir:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            Ruang Rapat
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            -
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
