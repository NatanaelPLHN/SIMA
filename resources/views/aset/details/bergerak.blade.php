@extends('layouts.app')

@section('title', 'Detail Aset Bergerak')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Grid Utama -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Kolom Kiri -->
                <div class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode:</label>
                            <div
                                class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal">
                                {{ $asset->kode }}
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aset:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal"
                                title="{{ $asset->nama_aset }}">
                                {{ $asset->nama_aset }}
                            </div>
                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Merk:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->bergerak->merk ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->bergerak->tipe ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->category->nama ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->category->CategoryGroup->nama ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Serial Number:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->bergerak->nomor_serial ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Produksi:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->bergerak->tahun_produksi ?? '?' }}
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->jumlah ?? '?' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-6">
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $asset->bergerak->qr_code_path) }}" alt="QR Code" class="w-48 h-48 sm:w-64 sm:h-64 object-contain">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->tgl_pembelian ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Pembelian:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->nilai_pembelian ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->lokasi_terakhir ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->status ?? '?' }}
                            </div>
                        </div>
                        {{-- <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $asset->bergerak->qr_code_path ?? '?' }}
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection