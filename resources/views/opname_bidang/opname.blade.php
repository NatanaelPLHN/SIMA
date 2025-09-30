@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Stock Opname Header -->
        <div class="bg-indigo-800 text-white rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div id="detail_ini">
                    <div class="font-medium">09-2023 | Elektronik</div>
                    <div class="text-sm">Tanggal Buat: 29-09-2023 23:59:59</div>
                    <div class="text-sm">Status: Proses</div>
                </div>

                {{-- <div class="w-full md:w-1/3">
                    <label for="keterangan" class="text-sm font-medium text-white">Keterangan</label>
                    <input type="text" id="keterangan" class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div> --}}

                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                    Scan QR
                </button>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Aset</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Sub Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">10</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">1</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">2</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">2</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">9</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection