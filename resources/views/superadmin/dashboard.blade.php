@extends('layouts.app')

@section('title', 'Admin Dashboard')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Dashboard Admin</h1>
            </div>

            <div
                class="alert alert-warning bg-yellow-100 dark:bg-yellow-600 text-gray-800 dark:text-white p-4 rounded-lg mb-4">
                <p><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Admin Privileges:</strong> Aktif</p>
            </div>
        </div>
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
        document.getElementById('activity-search').addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#activity-body tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    </script>
@endsection
