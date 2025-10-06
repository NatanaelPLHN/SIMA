@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Form Controls -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <form id="opname-form" action="{{ route('superadmin.opname.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <input type="hidden" name="status" value="bergerak">

                    <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 w-full">
                        <div class="w-full md:w-1/4">
                            <label for="tanggal_dijadwalkan"
                                class="text-sm font-medium text-gray-700">Tanggal Dijadwalkan</label>
                            <input type="date" id="tanggal_dijadwalkan" name="tanggal_dijadwalkan"
                            min="{{ date('Y-m-d') }}"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <div class="w-full md:w-2/5">
                            <label for="departement_id" class="text-sm font-medium text-gray-700">Bidang</label>
                            <select id="departement_id" name="departement_id"
                                class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Pilih Bidang</option>
                                @foreach ($departements as $bidang)
                                    <option value="{{ $bidang->id }}">{{ $bidang->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full md:w-1/5">
                            <label for="jenis_aset" class="text-sm font-medium text-gray-700">Jenis Aset</label>
                            <select id="jenis_aset" name="jenis_aset"
                                class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Pilih Jenis Aset</option>
                                    <option value="bergerak">Bergerak</option>
                                    <option value="tidak_bergerak">Tidak Bergerak</option>
                                    <option value="habis_pakai">Habis Pakai</option>
                             </select>
                        </div>
                        {{-- <div class="w-full md:w-1/5">
                            <label for="category_group_id" class="text-sm font-medium text-gray-700">Kategori</label>
                            <select id="category_group_id" name="category_group_id"
                                class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categoryGroups as $group)
                                    <option value="{{ $group->id }}">{{ $group->nama }}</option>
                                @endforeach
                             </select>
                        </div> --}}
                        <div class="w-full md:w-1/6 flex items-end">
                            <button type="submit"
                                class="w-full bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                                Tambah
                            </button>
                        </div>
            </form>
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
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Bidang</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kategori
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($sessions as $index => $session)
                <tr>
                    {{-- <td class="px-4 py-3 text-sm text-gray-900">{{ $session }}</td> --}}
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $session->nama }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $session->tanggal_dijadwalkan }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900"> {{ $session->departement->nama }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900"> {{ $session->details->first()?->asset->category->categoryGroup->nama }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $session->status }}</td>

                    <td class="px-4 py-3 text-sm">
                        <div class="flex space-x-2">
                            <a class="fas fa-eye text-blue-600 hover:text-blue-800" href="{{ route('superadmin.opname.show', $session->id) }}"></a>
                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
