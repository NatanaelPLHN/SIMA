@extends('layouts.app')

@section('title', 'Ubah Aset Bergerak')

@section('content')
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.assets.update', $asset->id) }}" method="POST"
            class="grid grid-cols-1 md:grid-cols gap-6">
            @csrf
            @method('PUT')

            @include('aset.forms._form')
            <div class="grid grid-cols-1 md:grid-cols gap-4">
                <div>
                    <label for="register" class="block text-sm font-medium text-gray-700 mb-1">Register</label>
                    <input type="text" id="register" name="register"
                        value="{{ old('register', $asset->habisPakai->register ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <input type="text" id="satuan" name="satuan"
                        value="{{ old('satuan', $asset->habisPakai->satuan ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                @if (auth()->user()->role == 'superadmin')
                    <a href="{{ route('superadmin.assets.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                @endif

                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('admin.assets.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                @endif
                <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                    Simpan
                </button>
            </div>

        </form>

        </div>
            {{-- </main> --}}

        @endsection
