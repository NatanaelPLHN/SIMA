@extends('layouts.app')
@section('title', 'Manajemen Pengguna Aset')
@include('components.alert')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')

{{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6"> --}}
        <!-- CARD BERGERAK -->
{{-- <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700"> --}}
    <div class="w-full mb-1">
        <!-- Breadcrumb -->
        <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <li class="inline-flex items-center">
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
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Pengguna Aset</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar Pengguna Aset</h1>
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
                    <div class="relative w-48 sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Cari nama, kode, dll...">
                    </div>
                    @if (request('search'))
                        <a href="{{ routeForRole('assets', 'index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">Clear</a>
                    @endif
                </form>
                {{-- @if (auth()->user()->role == 'subadmin') --}}
                    <a href="{{ routeForRole('asset-usage', 'create', 'bergerak') }}"
                        class="mt-2 sm:mt-0 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                        Tambah Pengguna Aset
                    </a>
                {{-- @endif --}}
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
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'pengguna', 'direction' => request('sort') === 'pengguna' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Pengguna
                                        @if (request('sort') === 'pengguna')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'tgl_mulai', 'direction' => request('sort') === 'tgl_mulai' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Tanggal Mulai
                                        @if (request('sort') === 'tgl_mulai')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'tujuan', 'direction' => request('sort') === 'tujuan' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Tujuan
                                        @if (request('sort') === 'tujuan')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'keterangan', 'direction' => request('sort') === 'keterangan' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Keterangan
                                        @if (request('sort') === 'keterangan')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    Status
                                </th>

                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($usagesBergerak as $index => $usage)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                        {{ $index + $usagesBergerak->firstItem() }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $usage->asset->kode }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $usage->asset->nama_aset }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $usage->user->nama ?? '-' }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $usage->start_date ?? '-' }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $usage->tujuan_penggunaan ?? '-' }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $usage->keterangan ?? '-' }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        @switch(strtolower($usage->status))
                                            @case('selesai')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Selesai
                                                </span>
                                            @break

                                            @case('dipakai')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Dipakai
                                                </span>
                                            @break

                                            @case('dikembalikan')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    Dikembalikan
                                                </span>
                                            @break
                                            @default
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                    {{ ucfirst($usage->status ?? 'Tidak Diketahui') }}
                                                </span>
                                        @endswitch
                                    </td>
                                
                                    <td class="p-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-x-3">
                                            <!-- View -->
                                            <a href="{{ routeForRole('asset-usage', 'show', $usage->id) }}"
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
                                                @if ($usage->status == 'dipakai')
                                                <form method="POST"
                                                    action="{{ routeForRole('asset-usage', 'return', $usage) }}"
                                                    class="return-form">
                                                    @csrf
                                                    @method('PUT')
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
                    @if ($usagesBergerak->hasPages())
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                Menampilkan <span class="font-medium">{{ $usagesBergerak->firstItem() }}</span> sampai
                                <span class="font-medium">{{ $usagesBergerak->lastItem() }}</span> dari
                                <span class="font-medium">{{ $usagesBergerak->total() }}</span> hasil
                            </div>
                            <div>{{ $usagesBergerak->links() }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tab: Tidak Bergerak -->
            <div id="tidakbergerak" class="table-content hidden p-4" role="tabpanel" aria-labelledby="tab-tidak-bergerak">
                <div class="items-center justify-between block sm:flex mb-4">
                    <form method="GET" action="{{ routeForRole('assets', 'index') }}"
                        class="flex items-center space-x-2 sm:pl-4">
                        <div class="relative w-48 sm:w-64">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Cari nama, kode, dll...">
                        </div>
                        @if (request('search'))
                            <a href="{{ routeForRole('assets', 'index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">Clear</a>
                        @endif
                    </form>
                    {{-- @if (auth()->user()->role == 'subadmin') --}}
                        <a href="{{ routeForRole('asset-usage', 'create', 'tidak_bergerak') }}"
                            class="mt-2 sm:mt-0 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                            Tambah Pengguna Aset
                        </a>
                    {{-- @endif --}}
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
                                            Pengguna
                                            @if (request('sort') === 'ukuran')
                                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'bahan', 'direction' => request('sort') === 'bahan' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Tanggal Mulai
                                            @if (request('sort') === 'bahan')
                                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Tujuan
                                            @if (request('sort') === 'status')
                                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Keterangan
                                            @if (request('sort') === 'status')
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
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($usagesTidakBergerak as $index => $asset)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                            {{ $index + $usagesTidakBergerak->firstItem() }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $usage->asset->kode }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $usage->asset->nama_aset }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $usage->user->nama ?? '-' }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $usage->start_date ?? '-' }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $usage->tujuan_penggunaan ?? '-' }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            {{ $usage->keterangan ?? '-' }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                            @switch(strtolower($usage->status))
                                                @case('selesai')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        Selesai
                                                    </span>
                                                @break

                                                @case('dipakai')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                        Dipakai
                                                    </span>
                                                @break

                                                @case('dikembalikan')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                        Dikembalikan
                                                    </span>
                                                @break

                                                @default
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                        {{ ucfirst($usage->status ?? 'Tidak Diketahui') }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td class="p-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-x-3">
                                                <!-- View -->
                                            <a href="{{ routeForRole('asset-usage', 'show', $usage->id) }}"
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
                                                @if ($usage->status == 'dipakai')
                                                <form method="POST"
                                                    action="{{ routeForRole('asset-usage', 'return', $usage) }}"
                                                    class="return-form">
                                                    @csrf
                                                    @method('PUT')
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
                        @if ($usagesTidakBergerak->hasPages())
                            <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                    Menampilkan <span class="font-medium">{{ $usagesTidakBergerak->firstItem() }}</span> sampai
                                    <span class="font-medium">{{ $usagesTidakBergerak->lastItem() }}</span> dari
                                    <span class="font-medium">{{ $usagesTidakBergerak->total() }}</span> hasil
                                </div>
                                <div>{{ $usagesTidakBergerak->links() }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tab: Habis Pakai -->
                <div id="habispakai" class="table-content hidden p-4" role="tabpanel" aria-labelledby="tab-habis-pakai">
                    <div class="items-center justify-between block sm:flex mb-4">
                        <form method="GET" action="{{ routeForRole('assets', 'index') }}"
                            class="flex items-center space-x-2 sm:pl-4">
                            <div class="relative w-48 sm:w-64">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Cari nama, kode, dll...">
                            </div>
                            @if (request('search'))
                                <a href="{{ routeForRole('assets', 'index') }}"
                                    class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">Clear</a>
                            @endif
                        </form>
                        {{-- @if (auth()->user()->role == 'subadmin') --}}
                            <a href="{{ routeForRole('asset-usage', 'create', 'habis_pakai') }}"
                                class="mt-2 sm:mt-0 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                Tambah Pengguna Aset
                            </a>
                        {{-- @endif --}}
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
                                                Pengguna
                                                @if (request('sort') === 'register')
                                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'satuan', 'direction' => request('sort') === 'satuan' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Tanggal Mulai
                                                @if (request('sort') === 'satuan')
                                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Tujuan
                                                @if (request('sort') === 'status')
                                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                Keterangan
                                                @if (request('sort') === 'status')
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
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @forelse($usagesHabisPakai as $index => $asset)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                                {{ $index + $usagesHabisPakai->firstItem() }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $usage->asset->kode }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $usage->asset->nama_aset }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $usage->user->nama ?? '-' }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $usage->start_date ?? '-' }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $usage->tujuan_penggunaan ?? '-' }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                {{ $usage->keterangan ?? '-' }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                                @switch(strtolower($usage->status))
                                                    @case('Selesai')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                            Selesai
                                                        </span>
                                                    @break

                                                    @case('dipakai')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                            Dipakai
                                                        </span>
                                                    @break

                                                    @case('dikembalikan')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                            Dikembalikan
                                                        </span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                            {{ ucfirst($usage->status ?? 'Tidak Diketahui') }}
                                                        </span>
                                                @endswitch
                                            </td>

                                            <td class="p-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-x-3">
                                                    <!-- View -->
                                                    <a href="{{ routeForRole('asset-usage', 'show', $usage->id) }}"
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
                                                @if ($usage->status == 'dipakai')
                                                <form method="POST"
                                                    action="{{ routeForRole('asset-usage', 'return', $usage) }}"
                                                    class="return-form">
                                                    @csrf
                                                    @method('PUT')
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
                            @if ($usagesHabisPakai->hasPages())
                                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                        Menampilkan <span class="font-medium">{{ $usagesHabisPakai->firstItem() }}</span> sampai
                                        <span class="font-medium">{{ $usagesHabisPakai->lastItem() }}</span> dari
                                        <span class="font-medium">{{ $usagesHabisPakai->total() }}</span> hasil
                                    </div>
                                    <div>{{ $usagesHabisPakai->links() }}</div>
                                </div>
                            @endif
                        </div>
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
