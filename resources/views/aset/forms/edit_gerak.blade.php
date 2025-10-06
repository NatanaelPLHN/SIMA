@extends('layouts.app')

@section('title', 'Ubah Aset Bergerak')

@section('content')
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form id="asset-form" action="{{ routeForRole('assets', 'update', $asset->id) }}" method="POST"
            class="grid grid-cols-1 md:grid-cols gap-6">
            @csrf
            @method('PUT')

            @include('aset.forms._form')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="merk" class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                    <input type="text" id="merk" name="merk"
                        value="{{ old('merk', $asset->bergerak->merk ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="tipe" class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <input type="text" id="tipe" name="tipe"
                        value="{{ old('tipe', $asset->bergerak->tipe ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nomor_serial" class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
                    <input type="text" id="nomor_serial" name="nomor_serial"
                        value="{{ old('nomor_serial', $asset->bergerak->nomor_serial ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="tahun_produksi" class="block text-sm font-medium text-gray-700 mb-1">Tahun Produksi</label>
                    <input type="text" id="tahun_produksi" name="tahun_produksi"
                        value="{{ old('tahun_produksi', $asset->bergerak->tahun_produksi ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ routeForRole('assets', 'index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
