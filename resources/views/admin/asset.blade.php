@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Asset Tabs -->
            {{-- <div class="space-x-2 mb-4">
    <button onclick="showTable('bergerak')" class="px-4 py-2 bg-indigo-600 text-white rounded">Aset Bergerak</button>
    <button onclick="showTable('tetap')" class="px-4 py-2 bg-green-600 text-white rounded">Aset Tidak Bergerak</button>
    <button onclick="showTable('lainnya')" class="px-4 py-2 bg-gray-600 text-white rounded">Aset Lainnya</button>
</div> --}}

     <div class="mb-6">
    <div class="flex space-x-1 bg-white rounded-lg shadow-sm">
        <button id="btn-bergerak" onclick="setActive('bergerak')" class="tab-btn px-4 py-2 text-sm font-medium rounded-lg">
            Bergerak
        </button>
        <button id="btn-tetap" onclick="setActive('tetap')" class="tab-btn px-4 py-2 text-sm font-medium rounded-lg">
            Tidak Bergerak
        </button>
        <button id="btn-habis" onclick="setActive('habis')" class="tab-btn px-4 py-2 text-sm font-medium rounded-lg">
            Habis Pakai
        </button>
    </div>
</div>

        <!-- Table Controls -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label for="entries" class="text-sm font-medium text-gray-700">Tampilkan</label>
                    <select id="entries"
                        class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    <span class="text-sm text-gray-700">entri</span>
                </div>

                <div class="flex items-center space-x-2">
                    <label for="search" class="text-sm font-medium text-gray-700">Cari:</label>
                    <input type="text" id="search"
                        class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    {{-- <button
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                        Tambah
                    </button> --}}
                    <a href="{{ route('admin.create_gerak') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                        Tambah
                    </a>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div id="table-bergerak" class="hidden bg-indigo-50 rounded-lg shadow-md overflow-hidden">

            <table class="min-w-full divide-y divide-gray==-200 bg-indigo-800">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Aset
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Serial
                            Number</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Merk/Type
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tahun
                            Produksi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kondisi</th>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
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

     <div id="table-tetap" class="hidden" class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray==-200 bg-indigo-800">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Aset
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Serial
                            Numssssssber</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Merk/Type
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tahun
                            Produksi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kondisi</th>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
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



         <div id="table-habis" class="hidden" class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray==-200 bg-indigo-800">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Aset
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Serial
                            Nuaaaaaamber</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Merk/Type
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tahun
                            Produksi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kondisi</th>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
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
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
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

<!-- Tabel Bergerak -->
{{-- <div id="table-bergerak" class="hidden">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white">Nama Aset</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white">Serial Number</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="px-4 py-3">1</td><td class="px-4 py-3">Motor</td><td class="px-4 py-3">SN-001</td></tr>
            </tbody>
        </table>
    </div>
</div> --}}

<!-- Tabel Tidak Bergerak -->
{{-- <div id="table-tetap" class="hidden">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white">Nama Aset</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white">Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="px-4 py-3">1</td><td class="px-4 py-3">Gedung</td><td class="px-4 py-3">Jl. Merdeka</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Tabel Lainnya -->
<div id="table-lainnya" class="hidden">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="px-4 py-3">1</td><td class="px-4 py-3">Lain-lain</td></tr>
            </tbody>
        </table>
    </div>
</div> --}}

<script>
    function showTable(type) {
        // sembunyikan semua tabel
        document.querySelectorAll('[id^="table-"]').forEach(el => el.classList.add('hidden'));

        // tampilkan tabel sesuai tombol yang diklik
        document.getElementById('table-' + type).classList.remove('hidden');
    }

    // default: tampilkan tabel bergerak
    showTable('bergerak');
</script>

<script>
    function setActive(type) {
        // reset semua tombol ke default
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-indigo-800', 'text-white');
            btn.classList.add('text-indigo-800', 'hover:text-indigo-900', 'hover:bg-indigo-100');
        });

        // aktifkan tombol yang diklik
        const activeBtn = document.getElementById('btn-' + type);
        activeBtn.classList.remove('text-indigo-800', 'hover:text-indigo-900', 'hover:bg-indigo-100');
        activeBtn.classList.add('bg-indigo-800', 'text-white');

        // tampilkan tabel sesuai tombol
        showTable(type);
    }

    // default: aktifkan bergerak
    setActive('bergerak');
</script>

    </div>

    @endsection