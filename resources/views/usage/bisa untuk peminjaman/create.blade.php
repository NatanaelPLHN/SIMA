@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-lg font-semibold text-indigo-800">Tambah Penggunaan Asset</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form action="{{ routeForRole('asset-usage','store') }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols gap-6">
            <!-- Form Groups -->
            @csrf

            <div>
                <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-1">Asset <span
                        class="text-red-500">*</span></label>
                <select name="asset_id" id="asset_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('asset_id') ? 'border-red-500' : '' }}">
                    <option value="">Pilih Asset</option>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                            {{ $asset->kode }} - {{ $asset->nama_aset }} ({{ $asset->status }})
                        </option>
                    @endforeach
                </select>
                @error('asset_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="used_by" class="block text-sm font-medium text-gray-700 mb-1">Digunakan Oleh <span
                        class="text-red-500">*</span></label>
                <select name="used_by" id="used_by"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('used_by') ? 'border-red-500' : '' }}">
                    <option value="">Pilih Employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('used_by') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->nip }} - {{ $employee->nama }}
                        </option>
                    @endforeach
                </select>
                @error('used_by')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Departemen <span
                        class="text-red-500">*</span></label>
                <select name="department_id" id="department_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('department_id') ? 'border-red-500' : '' }}">
                    <option value="">Pilih Departemen</option>
                    @foreach ($departements as $departement)
                        <option value="{{ $departement->id }}" {{ old('department_id') == $departement->id ? 'selected' : '' }}>
                            {{ $departement->nama }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span
                        class="text-red-500">*</span></label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('start_date') ? 'border-red-500' : '' }}">
                @error('start_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tujuan_penggunaan" class="block text-sm font-medium text-gray-700 mb-1">Tujuan Penggunaan <span
                        class="text-red-500">*</span></label>
                <input type="text" id="tujuan_penggunaan" name="tujuan_penggunaan" value="{{ old('tujuan_penggunaan') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('tujuan_penggunaan') ? 'border-red-500' : '' }}">
                @error('tujuan_penggunaan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('keterangan') ? 'border-red-500' : '' }}">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ routeForRole('asset-usage','index') }}"
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