@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
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
                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                    Tambah
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Aset</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Penanggung Jawab</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jumlah</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal Pinjam</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal Kembali</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900">10</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                    <td class="px-4 py-3 text-sm text-gray-900">1</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Dipinjam
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900">1</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                    <td class="px-4 py-3 text-sm text-gray-900">1</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Dipinjam
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900">2</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                    <td class="px-4 py-3 text-sm text-gray-900">1</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Dipinjam
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900">2</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                    <td class="px-4 py-3 text-sm text-gray-900">1</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Dipinjam
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900">9</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                    <td class="px-4 py-3 text-sm text-gray-900">1</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                    <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Dipinjam
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection