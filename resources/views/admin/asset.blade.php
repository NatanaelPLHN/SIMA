@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
@include()
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
                        <a href="{{ route('admin.assets.create_gerak') }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                            Tambah
                        </a>
                    </div>
                </div>
            </div>

            <!-- Data Table Bergerak -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-800">
                        <tr>
                            <th
                                class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                No</th>
                            <th
                                class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                Nama
                                Aset</th>
                            <th
                                class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                Serial Number</th>
                            <th
                                class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                Merk/Type
                            </th>
                            <th
                                class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                Tahun
                                Produksi</th>
                            <th
                                class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-32">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assetsBergerak as $index => $asset)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">
                                    {{ $asset->nama_aset }}</td>
                                <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                    {{ $asset->bergerak->nomor_serial }}</td>
                                <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">
                                    {{ $asset->bergerak->merk ?? '-' }}/{{ $asset->bergerak->tipe ?? '-' }}</td>
                                <td class="text-center">{{ $asset->bergerak->tahun_produksi ?? '-' }}</td>
                                <td class="text-center">{{ ucfirst($asset->status) }}</td>
                                <td>
                                    <div class="flex items-center justify-center space-x-3">
                                        <a class="fas fa-eye text-blue-600 hover:text-blue-800"
                                            href="{{ route('admin.assets.index', $asset->id) }}"></a>
                                        <a class="fas fa-edit text-yellow-600 hover:text-yellow-800"
                                            href="{{ route('admin.assets.edit', $asset->id) }}"></a>
                                        <form method="POST" action="{{ route('admin.assets.index', $asset->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="fas fa-trash text-red-600 hover:text-red-800"
                                                type="submit">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{ $assetsBergerak->links() }}
                </table>
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
                        <a href="{{ route('admin.assets.create_tidak_bergerak') }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                            Tambah
                        </a>
                    </div>
                </div>
            </div>

            <!-- Data Table Tidak Bergerak -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
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
                                Ukuran
                            </th>
                            <th
                                class="bg-indigo-800 px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                Bahan</th>
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
                    <tbody>
                        @foreach ($assetsTidakBergerak as $index => $asset)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">{{ $asset->kode }}</td>
                                <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">{{ $asset->nama_aset }}</td>
                                <td class="text-center">{{ $asset->tidakBergerak->ukuran }}</td>
                                <td class="text-center">{{ $asset->tidakBergerak->bahan ?? '-' }}</td>
                                <td class="text-center">{{ ucfirst($asset->status) }}</td>
                                <td>
                                    <div class="flex items-center justify-center space-x-3">
                                        <!-- Show -->
                                        <a class="fas fa-eye text-blue-600 hover:text-blue-800"
                                            href="{{ route('admin.assets.show', $asset->id) }}"></a>

                                        <!-- Edit -->
                                        <a class="fas fa-edit text-yellow-600 hover:text-yellow-800"
                                            href="{{ route('admin.assets.edit', $asset->id) }}"></a>

                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('admin.assets.destroy', $asset->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="fas fa-trash text-red-600 hover:text-red-800"
                                                type="submit"></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{ $assetsTidakBergerak->links() }}
                </table>
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
                        <a href="{{ route('admin.assets.create_habis') }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                            Tambah
                        </a>
                    </div>
                </div>
            </div>

            <!-- Data Table Habis Pakai -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
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
                    <tbody>
                        @foreach ($assetsHabisPakai as $index => $asset)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">{{ $asset->kode }}</td>
                                <td class="px-4 py-3 text-sm text-center text-gray-900 whitespace-normal break-words">{{ $asset->nama_aset }}</td>
                                <td class="text-center">{{ $asset->habisPakai->register }}</td>
                                <td class="text-center">{{ $asset->habisPakai->satuan ?? '-' }}</td>
                                <td class="text-center">{{ ucfirst($asset->status) }}</td>
                                <td>
                                <div class="flex items-center justify-center space-x-3">

                                    <!-- Show -->
                                    <a class="fas fa-eye text-blue-600 hover:text-blue-800"
                                        href="{{ route('admin.assets.show', $asset->id) }}"></a>

                                    <!-- Edit -->
                                    <a class="fas fa-edit text-yellow-600 hover:text-yellow-800"
                                        href="{{ route('admin.assets.edit', $asset->id) }}"></a>

                                    <!-- Delete -->
                                    <form method="POST" action="{{ route('admin.assets.destroy', $asset->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="fas fa-trash text-red-600 hover:text-red-800"
                                            type="submit"></button>
                                    </form>
                                </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    {{ $assetsHabisPakai->links() }}
                </table>
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
