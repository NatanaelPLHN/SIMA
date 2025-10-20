@extends('layouts.app')

@section('title', 'Dashboard Pengguna')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="space-y-8">
        <!-- Header Selamat Datang - Versi Premium -->
        <div
            class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                        Selamat Datang, <span
                            class="text-blue-600 dark:text-blue-400">{{ Auth::user()->Employee->nama ?? '-' }}</span>!
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-300 max-w-2xl">
                        Ini adalah ringkasan aset instansi Anda hari ini. Kelola, pantau, dan pastikan setiap aset tercatat
                        dengan akurat.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <div
                        class="bg-white dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-3 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aset Bergerak</p>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ $stats['aset_bergerak'] ?? 0 }}
                            </h2>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aset Tetap -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aset Tetap</p>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ $stats['aset_tetap'] ?? 0 }}
                            </h2>
                        </div>
                        <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aset Habis Pakai -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aset Habis Pakai</p>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ $stats['aset_habis_pakai'] ?? 0 }}
                            </h2>
                        </div>
                        <div class="p-3 bg-violet-100 dark:bg-violet-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tampilkan bagian ini hanya jika pengguna adalah Kepala Instansi --}}
        @if ($isHeadOfInstitution)
            <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mx-4 mt-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Aktivitas Instansi</h2>
                    {{-- Form export akan berfungsi karena kita sudah memperbaiki ActivityLogExport.php --}}
                    <form action="{{ route('user.activity.export') }}" method="post"
                        class="inline-flex items-center justify-center w-1/2 sm:w-auto">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-center text-white
          bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-600
          dark:focus:ring-blue-800">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 3a2 2 0 012-2h10a2 2 0 012 2v7a1 1 0 11-2 0V3H5v14h5a1 1 0 110 2H5a2 2 0 01-2-2V3zm9 10a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L12 16.586V13z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Export LOG
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
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
                                    Deskripsi</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    Perubahan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($activities as $index => $activity)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 align-top">
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                                        {{ $index + $activities->firstItem() }}</td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                                        {{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                                        {{ $activity->causer?->employee?->nama ?? ($activity->causer?->email ?? 'System') }}
                                    </td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-300 break-words">
                                        {{ $activity->description ?? '-' }}</td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-300" x-data="{ open: false }">
                                        @if (isset($activity->properties['attributes']) && !empty($activity->properties['attributes']))
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
                                                        <span
                                                            class="text-gray-700 dark:text-gray-300">"{{ $oldValue }}"
                                                            → "{{ $newValue }}"</span>
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
                                    <td colspan="5" class="p-4 text-center text-gray-500 dark:text-gray-400">Belum ada
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
        @endif
    </div>
@endsection
