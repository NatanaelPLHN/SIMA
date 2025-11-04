@extends('layouts.app')
@section('title', 'Manajemen Aset')
@include('components.alert')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- CARD BERGERAK -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-800
                hover:border-green-500/30 dark:hover:border-green-500/30 transition-colors group">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <!-- Ikon Mobil -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8v-2H8v2z" />
                    </svg>
                </div>
                <span
                    class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                    Bergerak
                </span>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{-- 75.005 Aset --}}
                    {{ number_format($jumlahAsetBergerak, 0, ',', '.') }} Aset
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Nilai</p>
                <p class="text-lg font-semibold text-green-600 dark:text-green-400 mt-1">
                    Rp {{ number_format($totalNilaiAsetBergerak, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- CARD TIDAK BERGERAK -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-800
                hover:border-blue-500/30 dark:hover:border-blue-500/30 transition-colors group">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <!-- Ikon Gedung -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v16M5 5a2 2 0 00-2 2v16l3.5-2 3.5 2V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <span
                    class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300">
                    Tidak Bergerak
                </span>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ number_format($jumlahAsetTidakBergerak, 0, ',', '.') }} Aset
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Nilai</p>
                <p class="text-lg font-semibold text-blue-600 dark:text-blue-400 mt-1">
                    Rp {{ number_format($totalNilaiAsetTidakBergerak, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- CARD HABIS PAKAI -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-800
                hover:border-purple-500/30 dark:hover:border-purple-500/30 transition-colors group">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                    <!-- Ikon Kotak (Package) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 dark:text-purple-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 6l-8 4m8-4v6l-8 4m0-6v6l8 4" />
                    </svg>
                </div>
                <span
                    class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300">
                    Habis Pakai
                </span>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ number_format($jumlahAsetHabisPakai, 0, ',', '.') }}
                    Aset
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Nilai</p>
                <p class="text-lg font-semibold text-purple-600 dark:text-purple-400 mt-1">
                    Rp {{ number_format($totalNilaiAsetHabisPakai, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
    <!-- === TABS (dari versi sebelumnya) === -->
    <div class="mb-4">
        <ul class="grid grid-cols-1 md:grid-cols-3 gap-2" id="default-tab" data-tabs-toggle="#default-tab-content"
            role="tablist">
            <li role="presentation">
                <button
                    class="w-full py-2 px-3 text-xs font-semibold text-center rounded-full
                       text-gray-600 hover:text-gray-800 hover:bg-gray-100
                       dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800
                       [&[aria-selected='true']]:text-indigo-800
                       [&[aria-selected='true']]:bg-indigo-100
                       [&[aria-selected='true']]:dark:text-indigo-200
                       [&[aria-selected='true']]:dark:bg-indigo-900"
                    id="tab-bergerak" data-tabs-target="#bergerak" type="button" role="tab" aria-controls="bergerak"
                    aria-selected="true">
                    Bergerak
                </button>
            </li>
            <li role="presentation">
                <button
                    class="w-full py-2 px-3 text-xs font-semibold text-center rounded-full
                       text-gray-600 hover:text-gray-800 hover:bg-gray-100
                       dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800
                       [&[aria-selected='true']]:text-indigo-800
                       [&[aria-selected='true']]:bg-indigo-100
                       [&[aria-selected='true']]:dark:text-indigo-200
                       [&[aria-selected='true']]:dark:bg-indigo-900"
                    id="tab-tidak-bergerak" data-tabs-target="#tidakbergerak" type="button" role="tab"
                    aria-controls="tidakbergerak" aria-selected="false">
                    Tidak Bergerak
                </button>
            </li>
            <li role="presentation">
                <button
                    class="w-full py-2 px-3 text-xs font-semibold text-center rounded-full
                       text-gray-600 hover:text-gray-800 hover:bg-gray-100
                       dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800
                       [&[aria-selected='true']]:text-indigo-800
                       [&[aria-selected='true']]:bg-indigo-100
                       [&[aria-selected='true']]:dark:text-indigo-200
                       [&[aria-selected='true']]:dark:bg-indigo-900"
                    id="tab-habis-pakai" data-tabs-target="#habispakai" type="button" role="tab"
                    aria-controls="habispakai" aria-selected="false">
                    Habis Pakai
                </button>
            </li>
        </ul>
    </div>

    <!-- === TAB CONTENT (contoh) === -->

    {{-- Konten Tab --}}
    <div id="default-tab-content">

        <!-- Tab: Bergerak -->
        <div id="bergerak" class="table-content hidden p-4" role="tabpanel" aria-labelledby="tab-bergerak">
            <div class="items-center justify-between block sm:flex mb-4">
                <form method="GET" action="{{ routeForRole('assets', 'index') }}"
                    class="flex items-center space-x-2 sm:pl-4">
                    {{-- <input type="hidden" name="tab" value="bergerak"> --}}
                    <input type="hidden" name="tab" value="bergerak">
                    <div class="relative w-48 sm:w-64">
                        <input type="text" name="search_bergerak" value="{{ request('search_bergerak') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Cari nama, serial number, dll...">
                    </div>
                    {{-- live search --}}
                    {{-- <div class="flex items-center space-x-2">
                        <label for="bergerak-search"
                            class="text-sm font-medium text-gray-700 dark:text-gray-300">Cari:</label>
                        <input type="text" id="bergerak-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Cari nama, serial number, dll...">
                    </div> --}}
                    @if (request('search_bergerak'))
                        <a href="{{ routeForRole('assets', 'index', ['tab' => 'bergerak']) }}"
                            class="text-sm font-medium px-2.5 py-1 rounded-md bg-red-200 text-red-700 hover:bg-red-300
                            dark:bg-red-900/80 dark:text-red-300 dark:hover:bg-red-800/100 transition-colors">
                            Clear</a>
                    @endif
                </form>
                @if (auth()->user()->role == 'subadmin')
                    <a href="{{ route('subadmin.assets.create_gerak') }}"
                        class="mt-2 sm:mt-0 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                        Tambah Aset Bergerak
                    </a>
                @endif
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    No</th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'kode', 'direction' => request('sort') === 'kode' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Kode
                                        @if (request('sort') === 'kode')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('sort') === 'nama' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Nama Aset
                                        @if (request('sort') === 'nama')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'serialnumber', 'direction' => request('sort') === 'serialnumber' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Serial Number
                                        @if (request('sort') === 'serialnumber')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Status
                                        @if (request('sort') === 'status')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'merk', 'direction' => request('sort') === 'merk' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Merk/Type
                                        @if (request('sort') === 'merk')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'tahun_produksi', 'direction' => request('sort') === 'tahun_produksi' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Tahun Produksi
                                        @if (request('sort') === 'tahun_produksi')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>

                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bergerak-body"
                            class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($assetsBergerak as $index => $asset)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                        {{ $index + $assetsBergerak->firstItem() }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $asset->kode }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $asset->nama_aset }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $asset->bergerak->nomor_serial ?? '-' }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        @switch(strtolower($asset->status))
                                            @case('tersedia')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Tersedia
                                                </span>
                                            @break

                                            @case('dipakai')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Dipakai
                                                </span>
                                            @break

                                            @case('rusak')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    Rusak
                                                </span>
                                            @break

                                            @case('hilang')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    Hilang
                                                </span>
                                            @break

                                            @default
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                    {{ ucfirst($asset->status ?? 'Tidak Diketahui') }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $asset->bergerak->merk ?? '-' }}/{{ $asset->bergerak->tipe ?? '-' }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $asset->bergerak->tahun_produksi ?? '-' }}
                                    </td>

                                    <td class="p-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-x-3">
                                            <!-- View -->
                                            <a href="{{ routeForRole('assets', 'show', $asset->id) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                            bg-blue-500 text-white/90 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300
                                            dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-800/60 dark:focus:ring-blue-800/50
                                            transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                            @if (auth()->user()->role == 'subadmin')
                                                <!-- Edit -->
                                                <a href="{{ route('subadmin.assets.edit', $asset->id) }}"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                            bg-yellow-500 text-white/90 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300
                                            dark:bg-yellow-900/40 dark:text-yellow-300 dark:hover:bg-yellow-800/60 dark:focus:ring-yellow-800/50
                                            transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </a>

                                                <!-- Delete -->
                                                <form method="POST"
                                                    action="{{ route('subadmin.assets.destroy', $asset->id) }}"
                                                    class="inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                                    bg-red-500 text-white/90 hover:bg-red-600 focus:ring-4 focus:ring-red-300
                                                    dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-800/60 dark:focus:ring-red-800/50
                                                    transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                            data aset bergerak.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($assetsBergerak->hasPages())
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                Menampilkan <span class="font-medium">{{ $assetsBergerak->firstItem() }}</span> sampai
                                <span class="font-medium">{{ $assetsBergerak->lastItem() }}</span> dari
                                <span class="font-medium">{{ $assetsBergerak->total() }}</span> hasil
                            </div>
                            <div>{{ $assetsBergerak->links() }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tab: Tidak Bergerak -->
            <div id="tidakbergerak" class="table-content hidden p-4" role="tabpanel" aria-labelledby="tab-tidak-bergerak">
                <div class="items-center justify-between block sm:flex mb-4">
                    <form method="GET" action="{{ routeForRole('assets', 'index') }}"
                        class="flex items-center space-x-2 sm:pl-4">
                        <input type="hidden" name="tab" value="tidakbergerak">
                        <div class="relative w-48 sm:w-64">
                            <input type="text" name="search_tidak_bergerak"
                                value="{{ request('search_tidak_bergerak') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Cari nama, kode, dll...">
                        </div>
                        {{-- live search --}}
                        {{-- <div class="flex items-center space-x-2">
                            <label for="tidak-bergerak-search"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">Cari:</label>
                            <input type="text" id="tidak-bergerak-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Cari nama, serial number, dll...">
                        </div> --}}
                        @if (request('search_tidak_bergerak'))
                            <a href="{{ routeForRole('assets', 'index', ['tab' => 'tidakbergerak']) }}"
                                class="text-sm font-medium px-2.5 py-1 rounded-md bg-red-200 text-red-700 hover:bg-red-300
                                dark:bg-red-900/80 dark:text-red-300 dark:hover:bg-red-800/100 transition-colors">
                                Clear</a>
                        @endif
                    </form>
                    @if (auth()->user()->role == 'subadmin')
                        <a href="{{ route('subadmin.assets.create_tidak_bergerak') }}"
                            class="mt-2 sm:mt-0 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                            Tambah Aset Tidak Bergerak
                        </a>
                    @endif
                </div>

                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                        No</th>
                                    <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'kode', 'direction' => request('sort') === 'kode' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Kode
                                            @if (request('sort') === 'kode')
                                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('sort') === 'nama' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Nama Aset
                                            @if (request('sort') === 'nama')
                                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'ukuran', 'direction' => request('sort') === 'ukuran' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Ukuran
                                            @if (request('sort') === 'ukuran')
                                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'bahan', 'direction' => request('sort') === 'bahan' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Bahan
                                            @if (request('sort') === 'bahan')
                                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Status
                                            @if (request('sort') === 'status')
                                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tidak-bergerak-body"
                                class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($assetsTidakBergerak as $index => $asset)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                            {{ $index + $assetsTidakBergerak->firstItem() }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $asset->kode }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $asset->nama_aset }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $asset->tidakBergerak->ukuran ?? '-' }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $asset->tidakBergerak->bahan ?? '-' }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            @switch(strtolower($asset->status))
                                                @case('tersedia')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        Tersedia
                                                    </span>
                                                @break

                                                @case('dipakai')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                        Dipakai
                                                    </span>
                                                @break

                                                @case('rusak')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                        Rusak
                                                    </span>
                                                @break

                                                @case('hilang')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                        Hilang
                                                    </span>
                                                @break

                                                @default
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                        {{ ucfirst($asset->status ?? 'Tidak Diketahui') }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td class="p-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-x-3">
                                                <!-- View -->
                                                <a href="{{ routeForRole('assets', 'show', $asset->id) }}"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                            bg-blue-500 text-white/90 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300
                                            dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-800/60 dark:focus:ring-blue-800/50
                                            transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                @if (auth()->user()->role == 'subadmin')
                                                    <!-- Edit -->
                                                    <a href="{{ route('subadmin.assets.edit', $asset->id) }}"
                                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                            bg-yellow-500 text-white/90 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300
                                            dark:bg-yellow-900/40 dark:text-yellow-300 dark:hover:bg-yellow-800/60 dark:focus:ring-yellow-800/50
                                            transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                            </path>
                                                        </svg>
                                                    </a>

                                                    <!-- Delete -->
                                                    <form method="POST"
                                                        action="{{ route('subadmin.assets.destroy', $asset->id) }}"
                                                        class="inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                                    bg-red-500 text-white/90 hover:bg-red-600 focus:ring-4 focus:ring-red-300
                                                    dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-800/60 dark:focus:ring-red-800/50
                                                    transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                                data aset tidak bergerak.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($assetsTidakBergerak->hasPages())
                            <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                    Menampilkan <span class="font-medium">{{ $assetsTidakBergerak->firstItem() }}</span> sampai
                                    <span class="font-medium">{{ $assetsTidakBergerak->lastItem() }}</span> dari
                                    <span class="font-medium">{{ $assetsTidakBergerak->total() }}</span> hasil
                                </div>
                                <div>{{ $assetsTidakBergerak->links() }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tab: Habis Pakai -->
                <div id="habispakai" class="table-content hidden p-4" role="tabpanel" aria-labelledby="tab-habis-pakai">
                    <div class="items-center justify-between block sm:flex mb-4">
                        <form method="GET" action="{{ routeForRole('assets', 'index') }}"
                            class="flex items-center space-x-2 sm:pl-4">
                            <input type="hidden" name="tab" value="habispakai">
                            <div class="relative w-48 sm:w-64">
                                <input type="text" name="search_habis_pakai" value="{{ request('search_habis_pakai') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Cari nama, kode, dll...">
                            </div>
                            {{-- live search --}}
                            {{-- <div class="flex items-center space-x-2">
                                <label for="habis-search"
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">Cari:</label>
                                <input type="text" id="habis-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Cari nama, serial number, dll...">
                            </div> --}}
                            @if (request('search_habis_pakai'))
                                <a href="{{ routeForRole('assets', 'index', ['tab' => 'habispakai']) }}"
                                    class="text-sm font-medium px-2.5 py-1 rounded-md bg-red-200 text-red-700 hover:bg-red-300
                                            dark:bg-red-900/80 dark:text-red-300 dark:hover:bg-red-800/100 transition-colors">
                                    Clear</a>
                            @endif
                        </form>
                        @if (auth()->user()->role == 'subadmin')
                            <a href="{{ route('subadmin.assets.create_habis') }}"
                                class="mt-2 sm:mt-0 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                Tambah Aset Habis Pakai
                            </a>
                        @endif
                    </div>

                    <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                            No</th>
                                        <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'kode', 'direction' => request('sort') === 'kode' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Kode
                                                @if (request('sort') === 'kode')
                                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('sort') === 'nama' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Nama Aset
                                                @if (request('sort') === 'nama')
                                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'register', 'direction' => request('sort') === 'register' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Register
                                                @if (request('sort') === 'register')
                                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'satuan', 'direction' => request('sort') === 'satuan' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Satuan
                                                @if (request('sort') === 'satuan')
                                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Status
                                                @if (request('sort') === 'status')
                                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="habis-body"
                                    class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @forelse($assetsHabisPakai as $index => $asset)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                                {{ $index + $assetsHabisPakai->firstItem() }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $asset->kode }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $asset->nama_aset }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $asset->habisPakai->register ?? '-' }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $asset->habisPakai->satuan ?? '-' }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                @switch(strtolower($asset->status))
                                                    @case('tersedia')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                            Tersedia
                                                        </span>
                                                    @break

                                                    @case('dipakai')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                            Dipakai
                                                        </span>
                                                    @break

                                                    @case('rusak')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                            Rusak
                                                        </span>
                                                    @break

                                                    @case('hilang')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                            Hilang
                                                        </span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                            {{ ucfirst($asset->status ?? 'Tidak Diketahui') }}
                                                        </span>
                                                @endswitch
                                            </td>

                                            <td class="p-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-x-3">
                                                    <!-- View -->
                                                    <a href="{{ routeForRole('assets', 'show', $asset->id) }}"
                                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                            bg-blue-500 text-white/90 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300
                                            dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-800/60 dark:focus:ring-blue-800/50
                                            transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                    @if (auth()->user()->role == 'subadmin')
                                                        <!-- Edit -->
                                                        <a href="{{ route('subadmin.assets.edit', $asset->id) }}"
                                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                            bg-yellow-500 text-white/90 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300
                                            dark:bg-yellow-900/40 dark:text-yellow-300 dark:hover:bg-yellow-800/60 dark:focus:ring-yellow-800/50
                                            transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                </path>
                                                            </svg>
                                                        </a>

                                                        <!-- Delete -->
                                                        <form method="POST"
                                                            action="{{ route('subadmin.assets.destroy', $asset->id) }}"
                                                            class="inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            {{-- <input type="hidden" name="tab" value="{{ request('tab', 'habispakai') }}"> --}}
                                                            <button type="submit"
                                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                                    bg-red-500 text-white/90 hover:bg-red-600 focus:ring-4 focus:ring-red-300
                                                    dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-800/60 dark:focus:ring-red-800/50
                                                    transition-all">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                                    data aset habis pakai.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($assetsHabisPakai->hasPages())
                                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                        Menampilkan <span class="font-medium">{{ $assetsHabisPakai->firstItem() }}</span> sampai
                                        <span class="font-medium">{{ $assetsHabisPakai->lastItem() }}</span> dari
                                        <span class="font-medium">{{ $assetsHabisPakai->total() }}</span> hasil
                                    </div>
                                    <div>{{ $assetsHabisPakai->links() }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        function switchTab(targetTab) {
                            // Sembunyikan semua konten tab
                            document.querySelectorAll('.table-content').forEach(el => {
                                el.classList.add('hidden');
                            });
                            // Reset semua tombol tab
                            document.querySelectorAll('[role="tab"]').forEach(btn => {
                                btn.setAttribute('aria-selected', 'false');
                            });
                            // Aktifkan tombol dan konten yang dipilih
                            const activeBtn = document.querySelector(`[data-tabs-target="#${targetTab}"]`);
                            const activeContent = document.getElementById(targetTab);
                            if (activeBtn) {
                                activeBtn.setAttribute('aria-selected', 'true');
                            }
                            if (activeContent) {
                                activeContent.classList.remove('hidden');
                            }
                        }

                        // Daftar tab yang valid (sesuai ID konten)
                        const validTabs = ['bergerak', 'tidakbergerak', 'habispakai'];

                        // Baca tab dari URL
                        const urlParams = new URLSearchParams(window.location.search);
                        let activeTab = urlParams.get('tab');

                        // Jika tab tidak valid atau tidak ada, gunakan 'bergerak' sebagai default
                        if (!activeTab || !validTabs.includes(activeTab)) {
                            activeTab = 'bergerak';
                            // Opsional: update URL agar selalu ada parameter tab
                            const newUrl = new URL(window.location);
                            newUrl.searchParams.set('tab', activeTab);
                            window.history.replaceState({}, '', newUrl);
                        }

                        // Pasang event listener ke setiap tombol tab
                        document.querySelectorAll('[role="tab"]').forEach(button => {
                            button.addEventListener('click', () => {
                                const target = button.getAttribute('data-tabs-target').replace('#', '');
                                const newUrl = new URL(window.location);
                                newUrl.searchParams.set('tab', target);
                                window.history.replaceState({}, '', newUrl);
                                switchTab(target);
                            });
                        });

                        // Aktifkan tab berdasarkan URL
                        switchTab(activeTab);
                    });
                </script>

            @endsection
