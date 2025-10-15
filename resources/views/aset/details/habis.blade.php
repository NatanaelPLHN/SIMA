@extends('layouts.app')

@section('title', 'Detail Habis Pakai')

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <!-- Breadcrumb -->
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="inline-flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ routeForRole('assets', 'index') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                Daftar Aset
                            </a>
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
                                    Detail Aset</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Aset Habis Pakai</h1>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <!-- Grid Utama -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <!-- Kolom Kiri -->
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                {{-- <div class="sm:col-span-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Kode:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ $asset->kode }}
                                    </div>
                                </div> --}}

                                <div class="sm:col-span-2">
                                    <label class="block dark:text-gray-100 text-sm font-medium text-gray-700 mb-1">Nama
                                        Aset:</label>
                                    <div class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white"
                                        title="{{ $asset->nama_aset }}">
                                        {{ $asset->nama_aset }}
                                    </div>
                                </div>


                                <div>
                                    <label
                                        class="block text-sm dark:text-gray-100 font-medium text-gray-700 mb-1">Register:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ $asset->habisPakai?->register ?? '?' }}
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block dark:text-gray-100 text-sm font-medium text-gray-700 mb-1">Satuan:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ $asset->habisPakai?->satuan ?? '?' }}
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block dark:text-gray-100 text-sm font-medium text-gray-700 mb-1">Kategori:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ $asset->category->nama ?? '?' }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block dark:text-gray-100 text-sm font-medium text-gray-700 mb-1">Grup
                                        Kategori:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ $asset->category->CategoryGroup->nama ?? '?' }}
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        class="block dark:text-gray-100 text-sm font-medium text-gray-700 mb-1">Jumlah:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ $asset->jumlah ?? '?' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-6">
                            {{-- <div class="flex justify-center">
                                <div class="bg-white dark:bg-white p-4 rounded-lg">
                                    <img src="{{ asset('storage/' . $asset->bergerak->qr_code_path) }}" alt="QR Code"
                                        class="w-48 h-48 sm:w-64 sm:h-64 object-contain">
                                </div>
                            </div> --}}

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block dark:text-gray-100 text-sm font-medium text-gray-700 mb-1">Tanggal
                                        Pembelian:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ $asset->tgl_pembelian ? \Carbon\Carbon::parse($asset->tgl_pembelian)->format('d M Y') : '?' }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block dark:text-gray-100 text-sm font-medium text-gray-700 mb-1">Nilai
                                        Pembelian:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ $asset->nilai_pembelian ? 'Rp ' . number_format($asset->nilai_pembelian, 0, ',', '.') : '?'  }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block dark:text-gray-100 text-sm font-medium text-gray-700 mb-1">Lokasi
                                        Terakhir:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ $asset->lokasi_terakhir ?? '?' }}
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class=" dark:text-gray-100 block text-sm font-medium text-gray-700 mb-1">Status:</label>
                                    <div
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                                        {{ ucfirst($asset->status ?? '?')    }}
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
        </div>

        {{-- Asset Activity Log Section --}}
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg mt-8 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Riwayat Aktivitas Aset Ini
            </h2>

            @if ($logs->isEmpty())
                <div class="text-gray-500 dark:text-gray-400 text-center py-6">
                    Belum ada aktivitas tercatat untuk aset ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    No</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    Tanggal</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    User</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    Event</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    Deskripsi</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    Perubahan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($logs as $index => $activity)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-4 text-sm text-center text-gray-900 dark:text-gray-300">
                                        {{ $index + $logs->firstItem() }}
                                    </td>
                                    <td class="p-4 text-sm text-center text-gray-900 dark:text-gray-300">
                                        {{ $activity->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td class="p-4 text-sm text-center text-gray-900 dark:text-gray-300">
                                        {{ $activity->causer?->email ?? 'System' }}
                                    </td>
                                    <td class="p-4 text-sm text-center">
                                        @php
                                            $colors = [
                                                'created' =>
                                                    'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                                                'updated' =>
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                                'deleted' =>
                                                    'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100',
                                                'Status Changed' =>
                                                    'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100',
                                            ];
                                        @endphp
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$activity->event] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ ucfirst($activity->event ?? '-') }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ $activity->description ?? '-' }}
                                    </td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-300">
                                        @if ($activity->properties && isset($activity->properties['old'], $activity->properties['attributes']))
                                            @foreach ($activity->properties['attributes'] as $field => $newValue)
                                                @php
                                                    $oldValue = $activity->properties['old'][$field] ?? '—';
                                                @endphp
                                                <div>
                                                    <strong>{{ ucfirst($field) }}:</strong>
                                                    <span class="text-red-500">{{ $oldValue }}</span>
                                                    →
                                                    <span class="text-green-600">{{ $newValue }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($logs->hasPages())
                    <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                            Menampilkan <span class="font-medium">{{ $logs->firstItem() }}</span> sampai
                            <span class="font-medium">{{ $logs->lastItem() }}</span> dari
                            <span class="font-medium">{{ $logs->total() }}</span> hasil
                        </div>
                        <div>{{ $logs->links() }}</div>
                    </div>
                @endif
            @endif
        </div>
    @endsection
