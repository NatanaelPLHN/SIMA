@extends('layouts.app')

@section('title', 'Admin Dashboard')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="p-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
            <p class="text-gray-600 dark:text-gray-400">Selamat datang di sistem manajemen aset instansi</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
            @php
                $summary = [
                    [
                        'title' => 'Total Instansi',
                        'value' => $institutionCount,
                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                        'color' => 'from-blue-500 to-cyan-500',
                    ],
                    [
                        'title' => 'Total Pegawai',
                        'value' => $employeeCount,
                        'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                        'color' => 'from-emerald-500 to-teal-500',
                    ],
                ];
            @endphp

            @foreach ($summary as $card)
                <div
                    class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-xl overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ $card['title'] }}</p>
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $card['value'] }}</h3>
                            </div>
                            <div
                                class="w-14 h-14 bg-gradient-to-br {{ $card['color'] }} rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $card['icon'] }}"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.getElementById('activity-search').addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#activity-body tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    </script>
@endsection
