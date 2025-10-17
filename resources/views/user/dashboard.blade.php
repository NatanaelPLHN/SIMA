@extends('layouts.app')

@section('title', 'Dashboard Pengguna')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="space-y-8">
        <!-- Header Selamat Datang - Versi Premium -->
<div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                Selamat Datang, <span class="text-blue-600 dark:text-blue-400">{{ Auth::user()->Employee->nama ?? '-' }}</span>!
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300 max-w-2xl">
                Ini adalah ringkasan aset instansi Anda hari ini. Kelola, pantau, dan pastikan setiap aset tercatat dengan akurat.
            </p>
        </div>
        <div class="flex-shrink-0">
            <div class="bg-white dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-3 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- Header Selamat Datang -->
        <div class="p-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Aset</h1>
            <p class="text-gray-600 dark:text-gray-400">Ringkasan total aset berdasarkan klasifikasi</p>
        </div>

        <!-- Summary Cards - 3 Kolom Utama -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4">
            <!-- Aset Bergerak -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aset Bergerak</p>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ $stats['aset_bergerak'] ?? 0 }}
                            </h2>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    {{-- <div class="mt-auto">
                        <span class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 font-medium">
                            Lihat detail
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div> --}}
                </div>
            </div>

            <!-- Aset Tetap -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aset Tetap</p>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ $stats['aset_tetap'] ?? 0 }}
                            </h2>
                        </div>
                        <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                    {{-- <div class="mt-auto">
                        <span class="inline-flex items-center text-sm text-emerald-600 dark:text-emerald-400 font-medium">
                            Lihat detail
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div> --}}
                </div>
            </div>

            <!-- Aset Habis Pakai -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aset Habis Pakai</p>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ $stats['aset_habis_pakai'] ?? 0 }}
                            </h2>
                        </div>
                        <div class="p-3 bg-violet-100 dark:bg-violet-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </div>
                    </div>
                    {{-- <div class="mt-auto">
                        <span class="inline-flex items-center text-sm text-violet-600 dark:text-violet-400 font-medium">
                            Lihat detail
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Catatan Tambahan (Opsional) -->
        <div class="px-4">
            {{-- <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 text-center">
                <p class="text-sm text-blue-800 dark:text-blue-300">
                    Data aset diperbarui secara real-time. Klik "Lihat detail" untuk menjelajahi daftar aset per kategori.
                </p>
            </div> --}}
        </div>
    </div>
@endsection