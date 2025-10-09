@extends('layouts.app')

@section('title', 'Admin Dashboard')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Dashboard Admin</h1>
        </div>

        <div class="alert alert-warning bg-yellow-100 dark:bg-yellow-600 text-gray-800 dark:text-white p-4 rounded-lg mb-4">
            <p><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Admin Privileges:</strong> Aktif</p>
        </div>
    </div>
</div>

<!-- 🧾 Activity Log Table -->
<div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mt-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Aktivitas Sistem</h2>

        <div class="flex items-center space-x-2">
            <label for="activity-search" class="text-sm font-medium text-gray-700 dark:text-gray-300">Cari:</label>
            <input type="text" id="activity-search"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="Cari aktivitas...">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">No</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">Tanggal</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">User</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">Model</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">ID</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">Event</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">Deskripsi</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" id="activity-body">
                @forelse ($activities as $index => $activity)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">{{ $index + $activities->firstItem() }}</td>
                        <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                            {{ $activity->created_at->format('Y-m-d H:i:s') }}
                        </td>
                        <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                            {{ $activity->causer?->email ?? 'System' }}
                        </td>
                        <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                            {{ class_basename($activity->subject_type) }}
                        </td>
                        <td class="p-4 text-sm text-gray-900 dark:text-gray-300 text-center">
                            {{ $activity->subject_id }}
                        </td>
                        <td class="p-4 text-sm text-center">
                            @php
                                $colors = [
                                    'created' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                                    'updated' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                    'deleted' => 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100',
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$activity->event] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ ucfirst($activity->event ?? '-') }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-900 dark:text-gray-300 break-words">{{ $activity->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Belum ada aktivitas tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if ($activities->hasPages())
        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                Menampilkan <span class="font-medium">{{ $activities->firstItem() }}</span> sampai
                <span class="font-medium">{{ $activities->lastItem() }}</span> dari
                <span class="font-medium">{{ $activities->total() }}</span> hasil
            </div>
            <div>
                {{ $activities->links() }}
            </div>
        </div>
    @endif
</div>

{{-- 🔍 Client-side Search --}}
<script>
    document.getElementById('activity-search').addEventListener('keyup', function () {
        const term = this.value.toLowerCase();
        document.querySelectorAll('#activity-body tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endsection
