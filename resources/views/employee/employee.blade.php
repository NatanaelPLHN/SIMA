@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('content')
    <div class="max-w-6xl mx-auto">
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
                    <a href="{{ route('superadmin.employees.create') }}"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                        Tambah
                    </a>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            No</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            NIP</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Nama Pegawai</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Email</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Alamat</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Telepon</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Bidang</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($employees as $index => $pegawai)
                        <tr>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">{{ $index + 1 }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">{{ $pegawai->nip }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">{{ $pegawai->nama }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">{{ $pegawai->email }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">{{ $pegawai->alamat ?? '-' }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">{{ $pegawai->telepon ?? '-' }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">bidang 4</td>
                            <td class="text-center px-4 py-3 text-sm whitespace-normal break-words">
                                <div class="flex items-center justify-center gap-x-3">
                                    <a class="fas fa-edit text-yellow-600 hover:text-yellow-800"
                                        href="{{ route('superadmin.employees.edit', $pegawai->id) }}"></a>
                                    <form method="POST" action="{{ route('superadmin.employees.destroy', $pegawai->id) }}" class="delete-form">
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
                {{ $employees->links() }}
            </table>
        </div>
    </div>
@endsection
