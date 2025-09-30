@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Table Controls -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label for="entries" class="text-sm font-medium text-gray-700">Tampilkan</label>
                    <select id="entries" class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    <span class="text-sm text-gray-700">entri</span>
                </div>

                <div class="flex items-center space-x-2">
                    <label for="search" class="text-sm font-medium text-gray-700">Cari:</label>
                    <input type="text" id="search" class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Keterangan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">10</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Dijadwalkan
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <a href="/do" class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">1</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">laptop A</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Proses
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">2</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">laptop b</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Proses
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">2</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Proses
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">9</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Selesai
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection