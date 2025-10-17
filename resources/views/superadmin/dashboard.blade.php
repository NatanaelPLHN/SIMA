@extends('layouts.app')

@section('title', 'Super Admin Dashboard')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="space-y-8">
        <!-- Header Selamat Datang - Premium -->
        <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                        Halo, <span class="text-indigo-600 dark:text-indigo-400">SUPER ADMIN</span>!
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-300 max-w-2xl">
                        Anda memiliki akses penuh ke seluruh sistem manajemen aset instansi. Pantau, kelola, dan audit semua data dari satu tempat.
                    </p>
                </div>
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

        <!-- Summary Cards - 5 Kolom Sekarang -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 px-4">
            @php
                $summary = [
                    [
                        'title' => 'Total Instansi (OPD)',
                        'value' => $institutionCount,
                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                        'color' => 'from-blue-500 to-cyan-500',
                    ],
                    [
                        'title' => 'Total Kategori',
                        'value' => $totalCategories,
                        'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M9 11a2 2 0 114 0m-4 0V9a2 2 0 012-2m0 0V5a2 2 0 012-2m-2 0V1',
                        'color' => 'from-emerald-500 to-teal-500',
                    ],
                    [
                        'title' => 'Total Grup Kategori',
                        'value' => $totalCategoryGroups,
                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                        'color' => 'from-orange-500 to-amber-500',
                    ],
                    [
                        'title' => 'Total Pengguna',
                        'value' => $totalUsers,
                        'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                        'color' => 'from-violet-500 to-purple-500',
                    ],
                    // Kartu baru: Total Pegawai
                    [
                        'title' => 'Total Pegawai',
                        'value' => $totalEmployees,
                        'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                        'color' => 'from-rose-500 to-pink-500',
                    ],
                ];
            @endphp

            @foreach ($summary as $card)
                <div class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-xl overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ $card['title'] }}</p>
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $card['value'] }}</h3>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br {{ $card['color'] }} rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Distribusi Aset per OPD -->
       
    </div>
@endsection