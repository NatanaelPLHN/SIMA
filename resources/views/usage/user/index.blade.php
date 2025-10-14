@extends('layouts.app')
@section('title', 'Manajemen Aset')
@include('components.alert')
@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Asset Tabs -->
        <div class="mb-6">
            <div class="flex space-x-1 bg-white rounded-lg shadow-sm">
                <button id="tab-bergerak"
                    class="tab-button px-4 py-2 text-sm font-medium text-white bg-indigo-800 rounded-lg active">
                    Bergerak
                </button>
                <button id="tab-tidak-bergerak"
                    class="tab-button px-4 py-2 text-sm font-medium text-indigo-800 hover:text-indigo-900 hover:bg-indigo-100 rounded-lg">
                    Tidak Bergerak
                </button>
                <button id="tab-habis-pakai"
                    class="tab-button px-4 py-2 text-sm font-medium text-indigo-800 hover:text-indigo-900 hover:bg-indigo-100 rounded-lg">
                    Habis Pakai
                </button>
            </div>
        </div>

        <!-- Table 1 - Bergerak -->
        <div id="table-bergerak" class="table-content">
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <label for="entries-bergerak" class="text-sm font-medium text-gray-700">Tampilkan</label>
                        <select id="entries-bergerak"
                            class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <span class="text-sm text-gray-700">entri</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <label for="search-bergerak" class="text-sm font-medium text-gray-700">Cari:</label>
                        <input type="text" id="search-bergerak"
                            class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    </div>
                </div>
            </div>

            <!-- Data Table Bergerak -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-800">
                            <tr>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Kode</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Nama
                                    Aset</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Pengguna
                                </th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Tanggal Mulai</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Tujuan
                                </th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Keterangan
                                </th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-32">
                                    Status
                                </th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-32">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($usagesBergerak as $index => $usage)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">
                                        {{ $usage->asset->kode }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">
                                        {{ $usage->asset->nama_aset }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->user->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->start_date ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->tujuan_penggunaan ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->keterangan ?? '-' }}</td>
                                    <td class="text-center">{{ ucfirst($usage->status) }}</td>
                                    <td>
                                        <div class="flex items-center justify-center gap-x-3">
                                            <!-- Show -->
                                            <a class="fas fa-eye text-blue-600 hover:text-blue-800"
                                                href="{{ routeForRole('asset-usage', 'show', $usage->id) }}"></a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{ $usagesBergerak->links() }}
                    </table>
                </div>
            </div>
        </div>

        <!-- Table 2 - Tidak Bergerak -->
        <div id="table-tidak-bergerak" class="table-content hidden">
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <label for="entries-tidak-bergerak" class="text-sm font-medium text-gray-700">Tampilkan</label>
                        <select id="entries-tidak-bergerak"
                            class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <span class="text-sm text-gray-700">entri</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <label for="search-tidak-bergerak" class="text-sm font-medium text-gray-700">Cari:</label>
                        <input type="text" id="search-tidak-bergerak"
                            class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    </div>
                </div>
            </div>

            <!-- Data Table Tidak Bergerak -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-800">
                            <tr>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Kode</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Nama
                                    Aset</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Pengguna
                                </th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Tanggal Mulai</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Tujuan
                                </th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Keterangan
                                </th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-32">
                                    Status
                                </th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-32">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($usagesTidakBergerak as $index => $usage)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">
                                        {{ $usage->asset->kode }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">
                                        {{ $usage->asset->nama_aset }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->user->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->start_date ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->tujuan_penggunaan ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->keterangan ?? '-' }}</td>
                                    <td class="text-center">{{ ucfirst($usage->status) }}</td>
                                    <td>
                                        <div class="flex items-center justify-center gap-x-3">
                                            <!-- Show -->
                                            <a class="fas fa-eye text-blue-600 hover:text-blue-800"
                                                href="{{ routeForRole('asset-usage', 'show', $usage->id) }}"></a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{ $usagesTidakBergerak->links() }}
                    </table>
                </div>
            </div>
        </div>

        <!-- Table 3 - Habis Pakai -->
        <div id="table-habis-pakai" class="table-content hidden">
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <label for="entries-habis-pakai" class="text-sm font-medium text-gray-700">Tampilkan</label>
                        <select id="entries-habis-pakai"
                            class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <span class="text-sm text-gray-700">entri</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <label for="search-habis-pakai" class="text-sm font-medium text-gray-700">Cari:</label>
                        <input type="text" id="search-habis-pakai"
                            class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    </div>
                </div>
            </div>

            <!-- Data Table Habis Pakai -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 bg-indigo-800">
                        <thead class="bg-indigo-800">
                            <tr>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs fongit-medium text-white uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Kode</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Nama
                                    Aset</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Register</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Satuan
                                    Produksi</th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @foreach ($usagesHabisPakai as $index => $usage)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">
                                        {{ $usage->asset->kode }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">
                                        {{ $usage->asset->nama_aset }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->user->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->start_date ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->tujuan_penggunaan ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                        {{ $usage->keterangan ?? '-' }}</td>
                                    <td class="text-center">{{ ucfirst($usage->status) }}</td>
                                    <td>
                                        <div class="flex items-center justify-center gap-x-3">
                                            <!-- Show -->
                                            <a class="fas fa-eye text-blue-600 hover:text-blue-800"
                                                href="{{ routeForRole('asset-usage', 'show', $usage->id) }}"></a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        {{ $usagesHabisPakai->links() }}
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function switchTab(targetTab) {
                console.log('switchTab ->', targetTab);
                document.querySelectorAll('.table-content').forEach(c => {
                    c.classList.add('hidden');
                    c.classList.remove('block');
                });

                document.querySelectorAll('.tab-button').forEach(b => {
                    b.classList.remove('bg-indigo-800', 'text-white'); // contoh reset style
                });

                const tabBtn = document.getElementById(`tab-${targetTab}`);
                if (tabBtn) tabBtn.classList.add('bg-indigo-800', 'text-white');

                const table = document.getElementById(`table-${targetTab}`);
                if (table) {
                    table.classList.remove('hidden');
                    table.classList.add('block');
                } else {
                    console.warn('table element not found:', `table-${targetTab}`);
                }
            }

            // pasang event listener
            ['bergerak', 'tidak-bergerak', 'habis-pakai'].forEach(t => {
                const el = document.getElementById(`tab-${t}`);
                if (el) el.addEventListener('click', () => switchTab(t));
            });

            // set default aktif
            switchTab('bergerak');
        });
    </script>


@endsection
