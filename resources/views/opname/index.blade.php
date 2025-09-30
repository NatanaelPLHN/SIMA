@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Form Controls -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 w-full">
                    <div class="w-full md:w-1/4">
                        <label for="tanggal" class="text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" id="tanggal"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="w-full md:w-2/5">
                        <label for="bidang" class="text-sm font-medium text-gray-700">Bidang</label>
                        <select id="bidang"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Bidang</option>
                            <option value="bidang1">Bidang 1</option>
                            <option value="bidang2">Bidang 2</option>
                            <option value="bidang3">Bidang 3</option>
                        </select>
                    </div>

                    <div class="w-full md:w-1/5">
                        <label for="kategori" class="text-sm font-medium text-gray-700">Kategori</label>
                        <select id="kategori"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Kategori</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="perabotan">Perabotan</option>
                            <option value="kendaraan">Kendaraan</option>
                            <option value="perlengkapan">Perlengkapan</option>
                        </select>
                    </div>

                    <div class="w-full md:w-1/6 flex items-end">
                        <button
                            class="w-full bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                            Tambah
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-4 flex items-center space-x-2">
                <label for="search" class="text-sm font-medium text-gray-700">Cari:</label>
                <input type="text" id="search"
                    class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Bidang</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kategori
                        </th>
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
                            <div class="flex space-x-2">
                                <a class="fas fa-eye text-blue-600 hover:text-blue-800"
                                    href="/show"></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">1</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
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
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
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
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
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
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
