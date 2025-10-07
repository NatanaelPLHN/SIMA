@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Stock Opname Header -->
        <div class="bg-indigo-800 text-white rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div id="detail_ini">
                    <div class="font-medium">{{ $opname->nama }}</div>

                    <div class="text-sm">Tanggal Buat: {{ $opname->tanggal_dijadwalkan }}</div>
                    @if ($opname->status == 'selesai')
                    <div class="text-sm">Tanggal Mulai: {{ $opname->tanggal_dimulai }}</div>
                    <div class="text-sm">Tanggal Selesai: {{ $opname->tanggal_selesai }}</div>
                    @endif
                    <div class="text-sm">Status: {{ $opname->status }}</div>
                </div>
                @if ($opname->status == 'draft')
                    <form id="start-form" action="{{ route('superadmin.opname.start', $opname->id) }}" method="POST"
                        enctype="multipart/form-data" class="contents">
                        @csrf
                        <div class="w-full md:w-1/3">
                            <label for="catatan" class="text-sm font-medium text-white">Catatan</label>
                            <input type="text" id="catatan" name="catatan"
                                class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                            Jadwalkan
                        </button>
                    </form>
                    @endif
                    @if ($opname->status == 'draft' || $opname->status == 'dijadwalkan' )
                    <form id="cancel-form" action="{{ route('superadmin.opname.cancel', $opname->id) }}" method="POST"
                        enctype="multipart/form-data" class="contents">
                        @csrf
                        <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                            Batalkan
                        </button>
                    </form>
                    @endif


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
                        @if ($opname->status == 'selesai')
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status
                                Lama</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status
                                Baru</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Selisih
                            </th>
                        @else
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status
                            </th>
                        @endif

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($opname->details as $index => $detail)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->kode ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->nama_aset ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->category->nama ?? '-' }}
                            </td>

                            @if ($opname->status == 'selesai')
                                {{-- @foreach ($stockOpnameSession->details as $index => $detail) --}}
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($detail->status_lama == 'tersedia') bg-green-100 text-green-800 @endif
                                        @if ($detail->status_lama == 'dipakai') bg-green-100 text-green-800 @endif
                                        @if ($detail->status_lama == 'rusak') bg-yellow-100 text-yellow-800 @endif
                                        @if ($detail->status_lama == 'habis') bg-red-100 text-red-800 @endif
                                        @if ($detail->status_lama == 'hilang') bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($detail->status_lama) }}
                                    </span>

                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if ($detail->status_fisik == 'tersedia') bg-green-100 text-green-800 @endif
                                @if ($detail->status_fisik == 'dipakai') bg-green-100 text-green-800 @endif
                                @if ($detail->status_fisik == 'rusak') bg-yellow-100 text-yellow-800 @endif
                                @if ($detail->status_fisik == 'habis') bg-red-100 text-red-800 @endif
                                @if ($detail->status_fisik == 'hilang') bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($detail->status_fisik) }}
                                    </span>

                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $detail->jumlah_fisik - $detail->jumlah_sistem }}
                                </td>
                            @else
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if ($detail->status_lama == 'tersedia') bg-green-100 text-green-800 @endif
                                @if ($detail->status_lama == 'tidak ditemukan') bg-red-100 text-red-800 @endif
                                @if ($detail->status_lama == 'rusak') bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($detail->status_lama) }}
                                    </span>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
