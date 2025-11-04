@extends('layouts.app')

@section('title', 'Detail Aset Habis Pakai')

@section('content')
    <div class=" px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            @switch(auth()->user()->role)
                            @case('subadmin')
                            <a href="{{ route('subadmin.dashboard') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                            @break
                            @case('user')
                            <a href="{{ route('user.dashboard') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                            @break
                        @endswitch
                        </li>
                        <li class="inline-flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            @switch(auth()->user()->role)
                            @case('subadmin')
                            <a href="{{ route('subadmin.asset-usage.index') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                Daftar Penggunaddan Aset
                            </a>
                            @break
                            @case('user')
                            <a href="{{ route('user.asset-usage.index') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                Daftar Penggunaan Aset
                            </a>
                            @break
                        @endswitch

                            </svg>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">
                                    Detail Penggunaan Aset</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Detail Penggunaan Aset</h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode:</label>
                            <div
                                class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 break-words whitespace-normal text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->kode ?? '-' }}
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Aset:</label>
                            <div
                                class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 break-words whitespace-normal text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->nama_aset ?? '-' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori:</label>
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->category->nama ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Grup Kategori:</label>
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->category->CategoryGroup->nama ?? '?' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Register:</label>
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->habisPakai->register ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Satuan:</label>
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->habisPakai->satuan ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah:</label>
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->jumlah ?? '?' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi Terakhir:</label>
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->lokasi_terakhir ?? '?' }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pembelian:</label>
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->tgl_pembelian ?? '?' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nilai Pembelian:</label>
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                {{ $assetUsage->asset->nilai_pembelian ?? '?' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PIC</label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 break-words whitespace-normal text-gray-900 dark:text-white">
                            {{ $assetUsage->pic->nama ?? '-' }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Peminjam</label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 break-words whitespace-normal text-gray-900 dark:text-white">
                            {{ $assetUsage->user->nama ?? '-' }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Penggunaan</label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 break-words whitespace-normal text-gray-900 dark:text-white">
                            {{ $assetUsage->start_date ?? '-' }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Kembali</label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 break-words whitespace-normal text-gray-900 dark:text-white">
                            {{ $assetUsage->end_date ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status:</label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                            {{ ucfirst($assetUsage->status) ?? '?' }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tujuan Penggunaan</label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 break-words whitespace-normal text-gray-900 dark:text-white">
                            {{ $assetUsage->tujuan_penggunaan ?? '-' }}
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 break-words whitespace-normal text-gray-900 dark:text-white">
                            {{ $assetUsage->keterangan ?? '-' }}
                        </div>
                    </div>
                </div>

                @if ($assetUsage->status == 'dipakai' && $user->role == 'subadmin')
                    <form method="POST" action="{{ routeForRole('asset-usage', 'return', $assetUsage) }}" class="return-form mt-6">
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