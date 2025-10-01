@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Stock Opname Header -->
        <div class="bg-indigo-800 text-white rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div id="detail_ini">
                    <div class="font-medium">{{$opname->nama}}</div>
                    {{-- <div class="font-medium"></div> --}}
                    {{-- <div class="font-medium">09-2023 | Elektronik</div> --}}
                    <div class="text-sm">Tanggal Buat: {{$opname->tanggal_dijadwalkan}}</div>
                    <div class="text-sm">Status: {{$opname->status}}</div>
                </div>

                <div class="w-full md:w-1/3">
                    <label for="keterangan" class="text-sm font-medium text-white">Keterangan</label>
                    <input type="text" id="keterangan"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <button
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                    Jadwalkan
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Aset
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Sub Kategori
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($opname->details as $index => $detail)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->kode ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->nama_aset ?? '-' }}</td>
                                {{-- <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->category ?? '-' }}</td> --}}
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->category->nama ?? '-' }}
                                {{-- <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->kode_aset ?? 'N/A' }}</td> --}}
                                {{-- <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->nama ?? 'N/A' }}</td> --}}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if ($detail->status_fisik == 'tersedia') bg-green-100 text-green-800 @endif
                                @if ($detail->status_fisik == 'tidak ditemukan') bg-red-100 text-red-800 @endif
                                @if ($detail->status_fisik == 'rusak') bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($detail->status_fisik) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
