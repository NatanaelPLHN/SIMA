@extends('layouts.app')
@section('title', 'Manajemen Aset')
@include('components.alert')
@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('content')
<div class="container">
    <h1>Detail Penggunaan Aset</h1>

    {{-- Bagian 1: Detail Penggunaan (Informasi Umum) --}}
    <div class="card mb-4">
        <div class="card-header">
            Informasi Penggunaan
        </div>
        <div class="card-body">
            <p><strong>Pengguna:</strong> {{ $assetUsage->user->nama ?? 'N/A' }}</p>
            <p><strong>Departemen:</strong> {{ $assetUsage->department->nama ?? 'N/A' }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ $assetUsage->start_date->format('d F Y') }}</p>
            <p><strong>Status:</strong> {{ Str::title(str_replace('_', ' ', $assetUsage->status)) }}</p>
            <p><strong>Tujuan Penggunaan:</strong> {{ $assetUsage->tujuan_penggunaan ?? '-' }}</p>
            <p><strong>Keterangan:</strong> {{ $assetUsage->keterangan ?? '-' }}</p>
        </div>
    </div>

    {{-- Bagian 2: Detail Aset (Informasi Spesifik) --}}
    <div class="card">
        <div class="card-header">
            Informasi Aset yang Digunakan
        </div>
        <div class="card-body">
            {{-- Simpan data aset dalam variabel agar mudah diakses --}}
            @php
                $asset = $assetUsage->asset;
            @endphp

            {{-- Tampilkan detail umum aset --}}
            <p><strong>Nama Aset:</strong> {{ $asset->nama_aset }}</p>
            <p><strong>Kode Aset:</strong> {{ $asset->kode }}</p>
            <p><strong>Jenis Aset:</strong> {{ Str::title(str_replace('_', ' ', $asset->jenis_aset)) }}</p>

            <hr>

            {{-- Logika Kondisional untuk Menampilkan Detail Spesifik --}}
            @if ($asset->jenis_aset === 'bergerak' && $asset->bergerak)
                @include('aset.details.bergerak', ['aset' => $asset, 'bergerak' => $asset->bergerak])

            @elseif ($asset->jenis_aset === 'tidak_bergerak' && $asset->tidakBergerak)
                @include('aset.details.tidak_bergerak', ['aset' => $asset, 'tidakBergerak' => $asset->tidakBergerak])

            @elseif ($asset->jenis_aset === 'habis_pakai' && $asset->habisPakai)
                @include('aset.details.habis_pakai', ['aset' => $asset, 'habisPakai' => $asset->habisPakai])

            @else
                <p class="text-muted">Detail spesifik untuk jenis aset ini tidak tersedia.</p>
            @endif
        </div>
    </div>

    {{-- Bagian 3: Tombol Aksi --}}
    <div class="mt-4">
        {{-- Tombol Kembali --}}
        <a href="{{ routeForRole('asset-usage', 'index') }}" class="btn btn-secondary">Kembali</a>

        {{-- Tombol Return Asset (hanya untuk subadmin) --}}
        @can('return', $assetUsage)
            @if ($assetUsage->status === 'in_use')
                <form action="{{ routeForRole('asset-usage.return', $assetUsage->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin mengembalikan aset ini?')">Kembalikan Aset</button>
                </form>
            @endif
        @endcan
    </div>
</div>
@endsection
