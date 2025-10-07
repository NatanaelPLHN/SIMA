@extends('layouts.app')

@section('title', 'Ubah Aset Tidak Bergerak')

@section('content')
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form id="asset-form" action="{{ routeForRole('assets', 'update', $asset->id) }}" method="POST"
            class="grid grid-cols-1 md:grid-cols gap-6">
            @csrf
            @method('PUT')

            @include('aset.forms._form')
            <div class="grid grid-cols-1 md:grid-cols gap-4">
                <div>
                    <label for="ukuran" class="block text-sm font-medium text-gray-700 mb-1">Ukuran</label>
                    <input type="text" id="ukuran" name="ukuran"
                        value="{{ old('ukuran', $asset->tidakBergerak->ukuran ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="bahan" class="block text-sm font-medium text-gray-700 mb-1">Bahan</label>
                    <input type="text" id="bahan" name="bahan"
                        value="{{ old('bahan', $asset->tidakBergerak->bahan ?? '') }}"
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
    {{-- </main> --}}

@endsection
