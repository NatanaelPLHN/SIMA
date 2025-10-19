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
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 px-4">
            @php
                $summary = [
                    // ['title' => 'Total Bidang', 'value' => $stats['bidang'], 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'color' => 'from-blue-500 to-cyan-500', 'change' => '', 'changeType' => 'up'],
                    [
                        'title' => 'Total Pegawai',
                        'value' => $stats['pegawai'],
                        'icon' =>
                            'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                        'color' => 'from-emerald-500 to-teal-500',
                        'change' => '+5',
                        'changeType' => 'up',
                    ],
                    [
                        'title' => 'Akun Aktif',
                        'value' => $stats['akun_aktif'],
                        'icon' =>
                            'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
                        'color' => 'from-violet-500 to-purple-500',
                        'change' => '-1',
                        'changeType' => 'down',
                    ],
                    [
                        'title' => 'Total Aset',
                        'value' => $stats['aset'],
                        'icon' =>
                            'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M9 11a2 2 0 114 0m-4 0V9a2 2 0 012-2m0 0V5a2 2 0 012-2m-2 0V1',
                        'color' => 'from-orange-500 to-amber-500',
                        'change' => '+12',
                        'changeType' => 'up',
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

        <!-- Charts and Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4">
            <!-- Distribusi Aset per Bidang -->
            {{-- <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Distribusi Aset per Bidang</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Total aset yang terdaftar di setiap bidang</p>
            <div class="space-y-4">
                @foreach ($asetPerStatus as $index => $item)
                    @php
                        $percentage = $stats['aset'] > 0 ? ($item->jumlah / $stats['aset']) * 100 : 0;
                        $colors = ['bg-blue-500', 'bg-emerald-500', 'bg-violet-500', 'bg-orange-500', 'bg-cyan-500'];
                        $color = $colors[$index % count($colors)];
                    @endphp
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $item->nama_bidang }}</span>
                            <span class="text-gray-500 dark:text-gray-400">{{ $item->jumlah }} aset ({{ number_format($percentage, 1) }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="{{ $color }} h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div> --}}
            <!-- Ringkasan Status Aset -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Ringkasan Status Aset</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Total aset berdasarkan status saat ini</p>
                <div class="space-y-4">
                    @forelse($asetPerStatus as $status => $jumlah)
                        @php
                            // Menghitung persentase
                            $percentage = $stats['aset'] > 0 ? ($jumlah / $stats['aset']) * 100 : 0;

                            // Menentukan warna berdasarkan status untuk konsistensi
                            $statusColors = [
                                'tersedia' => 'bg-blue-500',
                                'dipakai' => 'bg-emerald-500',
                                'rusak' => 'bg-red-500',
                                'hilang' => 'bg-gray-500',
                                'habis' => 'bg-orange-500',
                            ];
                            $color = $statusColors[$status] ?? 'bg-violet-500';
                        @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($status) }}</span>
                                <span class="text-gray-500 dark:text-gray-400">{{ $jumlah }} aset
                                    ({{ number_format($percentage, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                <div class="{{ $color }} h-full rounded-full transition-all duration-500"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 dark:text-gray-400">Tidak ada data status aset untuk
                            ditampilkan.</p>
                    @endforelse
                </div>
            </div>
            <!-- Kategori Aset -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Kategori Aset</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Berdasarkan jenis aset</p>
                <div class="space-y-4">
                    <div
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Aset Bergerak</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['aset_bergerak'] }}</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Aset Tidak Bergerak</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['aset_tidak_bergerak'] }}
                            </p>
                        </div>
                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <div
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 rounded-xl">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Aset Habis Pakai</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['aset_habis_pakai'] }}
                            </p>
                        </div>
                        <svg class="w-8 h-8 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Opname & Aktivitas Terbaru -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 px-4">
            <!-- Jadwal Stock Opname -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Jadwal Stock Opname</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">5 jadwal terdekat</p>
                    </div>
                    <a href="{{ route('subadmin.opname.index') }}"
                        class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @foreach ($upcomingSchedules as $schedule)
                        <div
                            class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $schedule->departement->nama ?? '—' }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                            <span
                                class="px-2 py-1 text-xs font-medium rounded-full
                            @if ($schedule->status === 'selesai') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400
                            @elseif($schedule->status === 'berlangsung') bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400
                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Riwayat Aktivitas Terbaru (Ringkas) -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Riwayat Aktivitas Terbaru</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">5 aktivitas terakhir</p>
                <div class="space-y-4">
                    @foreach ($recentActivities as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ ucfirst($activity->event ?? 'Aktivitas') }}
                                    {{ class_basename($activity->subject_type ?? '') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $activity->description ?? '—' }} • {{ $activity->causer?->email ?? 'System' }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    {{ $activity->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Status Stock Opname -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 mx-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Status Stock Opname</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Persentase kelengkapan stock opname periode ini</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="text-center p-6 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl">
                    <div class="text-4xl font-bold text-emerald-600 dark:text-emerald-400 mb-2">
                        {{ $stockStatus['selesai'] }}</div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Selesai</p>
                    <div class="mt-2 text-2xl">
                        {{ $stockStatus['total'] ? round(($stockStatus['selesai'] / $stockStatus['total']) * 100) : 0 }}%
                    </div>
                </div>
                <div
                    class="text-center p-6 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl">
                    <div class="text-4xl font-bold text-amber-600 dark:text-amber-400 mb-2">
                        {{ $stockStatus['berlangsung'] }}</div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sedang Berlangsung</p>
                    <div class="mt-2 text-2xl">
                        {{ $stockStatus['total'] ? round(($stockStatus['berlangsung'] / $stockStatus['total']) * 100) : 0 }}%
                    </div>
                </div>
                <div
                    class="text-center p-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800/30 dark:to-gray-700/30 rounded-2xl">
                    <div class="text-4xl font-bold text-gray-600 dark:text-gray-400 mb-2">{{ $stockStatus['belum'] }}
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Belum Dimulai</p>
                    <div class="mt-2 text-2xl">
                        {{ $stockStatus['total'] ? round(($stockStatus['belum'] / $stockStatus['total']) * 100) : 0 }}%
                    </div>
                </div>
            </div>
        </div>

        <!-- 🧾 Activity Log Table (Versi Lengkap) -->
        <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mx-4">
            <!-- ... (sama seperti kode Anda sebelumnya untuk tabel lengkap) ... -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Aktivitas Sistem (Lengkap)</h2>
                <form action="{{ routeForRole('activity', 'export') }}" method="post"
                    class="inline-flex items-center justify-center w-1/2 sm:w-auto">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-center text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 3a2 2 0 012-2h10a2 2 0 012 2v7a1 1 0 11-2 0V3H5v14h5a1 1 0 110 2H5a2 2 0 01-2-2V3zm9 10a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L12 16.586V13z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Export LOG
                    </button>
                </form>
                <div class="flex items-center space-x-2">
                    <label for="activity-search"
                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Cari:</label>
                    <input type="text" id="activity-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Cari aktivitas...">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <!-- ... (thead dan tbody sama seperti sebelumnya) ... -->
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
                                Model</th>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                ID</th>
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
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                        id="activity-body">
                        @forelse ($activities as $index => $activity)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 align-top">
                                <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                                    {{ $index + $activities->firstItem() }}</td>
                                <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                                    {{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                                <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                                    {{ $activity->causer?->email ?? 'System' }}</td>
                                <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                                    {{ class_basename($activity->subject_type) }}</td>
                                <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                                    {{ $activity->subject_id }}</td>
                                <td class="p-4 text-sm text-center">
                                    @php
                                        $colors = [
                                            'created' =>
                                                'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                                            'updated' =>
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                            'deleted' => 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100',
                                            'Stock Opname' =>
                                                'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$activity->event] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ ucfirst($activity->event ?? '-') }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-900 dark:text-gray-300 break-words">
                                    {{ $activity->description ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-900 dark:text-gray-300" x-data="{ open: false }">
                                    @if (isset($activity->properties['attributes']))
                                        <button @click="open = !open"
                                            class="text-xs font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 focus:outline-none mb-1">
                                            <span x-show="!open">Lihat Detail</span>
                                            <span x-show="open">Sembunyikan</span>
                                        </button>
                                        <ul x-show="open" x-transition
                                            class="list-disc list-inside space-y-1 mt-1 border-t border-gray-200 dark:border-gray-700 pt-2">
                                            @foreach ($activity->properties['attributes'] as $field => $newValue)
                                                @php $oldValue = $activity->properties['old'][$field] ?? '—'; @endphp
                                                <li>
                                                    <span
                                                        class="font-medium text-indigo-700 dark:text-indigo-400">{{ ucfirst($field) }}:</span>
                                                    <span class="text-gray-700 dark:text-gray-300">"{{ $oldValue }}" →
                                                        "{{ $newValue }}"</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-4 text-center text-gray-500 dark:text-gray-400">Belum ada
                                    aktivitas tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($activities->hasPages())
                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                        Menampilkan <span class="font-medium">{{ $activities->firstItem() }}</span> sampai
                        <span class="font-medium">{{ $activities->lastItem() }}</span> dari
                        <span class="font-medium">{{ $activities->total() }}</span> hasil
                    </div>
                    <div>{{ $activities->links() }}</div>
                </div>
            @endif
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
