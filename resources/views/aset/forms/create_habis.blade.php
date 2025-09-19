@extends('layouts.app')
@include('components.alert')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-lg font-semibold text-indigo-800">Tambah Aset Habis Pakai</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols gap-6">

            @include('aset.forms._form')

            <!-- Hidden field: jenis_aset -->
            <input type="hidden" name="jenis_aset" value="habis_pakai">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="register" class="block text-sm font-medium text-gray-700 mb-1">Register</label>
                    <input type="text" id="register" name="register"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <input type="text" id="satuan" name="satuan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <!-- Generate Code Section -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-gray-700">Generate Code?</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="radio" id="yes" name="generateCode" value="yes"
                                class="text-indigo-600 focus:ring-indigo-500">
                            <label for="yes" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="no" name="generateCode" value="no"
                                class="text-indigo-600 focus:ring-indigo-500">
                            <label for="no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.assets.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                    Simpan
                </button>
            </div>

        </form>

        < </div>
            {{-- </main> --}}

        @endsection
