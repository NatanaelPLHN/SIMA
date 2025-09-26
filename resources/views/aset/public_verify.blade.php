@extends('layouts.app')

@section('title', 'Verifikasi Aset')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-indigo-600 text-white text-lg font-semibold px-6 py-4">
            Detail Verifikasi Aset
        </div>

        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $asset->nama_aset }}</h2>
            <p class="text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded-md inline-block">
                Kode: <strong>{{ $asset->kode }}</strong>
            </p>

            <div class="mt-6 border-t border-gray-200 pt-4">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Jenis Aset</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ ucwords(str_replace('_', ' ', $asset->jenis_aset)) }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-lg text-gray-900">
                            <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full 
                                @switch($asset->status)
                                    @case('tersedia') bg-green-100 text-green-800 @break
                                    @case('dipakai') bg-blue-100 text-blue-800 @break
                                    @case('rusak') bg-yellow-100 text-yellow-800 @break
                                    @case('hilang') bg-red-100 text-red-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                {{ ucfirst($asset->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tanggal Pembelian</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ \Carbon\Carbon::parse($asset->tgl_pembelian)->isoFormat('LL') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Lokasi Terakhir</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $asset->lokasi_terakhir }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
