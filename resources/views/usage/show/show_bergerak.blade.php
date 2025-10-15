@extends('layouts.app')

@section('title', 'Detail Aset Tidak Bergerak')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode:</label>
                            <div
                                class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal">
                                {{ $assetUsage->asset->kode }}
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama
                                Aset:</label>
                            <div
                                class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal">
                                {{ $assetUsage->asset->nama_aset }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->category->nama ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->category->CategoryGroup->nama ?? '?' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Merk:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->bergerak->merk ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->bergerak->tipe ?? '?' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Serial Number:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->bergerak->nomor_serial ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Produksi:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->bergerak->tahun_produksi ?? '?' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->jumlah ?? '?' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->lokasi_terakhir ?? '?' }}
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->tgl_pembelian ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nilai
                                Pembelian:</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                                {{ $assetUsage->asset->nilai_pembelian ?? '?' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    {{-- <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $assetUsage->asset->tidakBergerak->qr_code_path) }}" alt="QR Code" class="w-64 h-64 object-contain">
                    </div> --}}


                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">PIC</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal">
                            {{ $assetUsage->department->kepala->nama }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peminjam</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal">
                            {{ $assetUsage->user->nama }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Penggunaan</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal">
                            {{ $assetUsage->start_date }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal">
                            {{ $assetUsage->end_date ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                            {{ ucfirst($assetUsage->status) ?? '?' }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Penggunaan</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal">
                            {{ $assetUsage->tujuan_penggunaan ?? '-' }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200 break-words whitespace-normal">
                            {{ $assetUsage->keterangan ?? '-' }}
                        </div>
                    </div>
                </div>
                @if ($assetUsage->status == 'dipakai' && $user->role == 'subadmin')
                    <form method="POST" action="{{ routeForRole('asset-usage', 'return', $assetUsage) }}"
                        class="return-form">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Kembalikan Aset
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>


@endsection
