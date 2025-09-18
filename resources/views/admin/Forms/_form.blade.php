@csrf

{{-- Notifikasi Error Validasi --}}
@if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan dalam pengisian form:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Notifikasi Error Session --}}
@if (session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Error</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Notifikasi Success --}}
@if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">Berhasil</h3>
                <div class="mt-2 text-sm text-green-700">
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Kode <span class="text-red-500">*</span></label>
        <input type="text" id="kode" name="kode"
            value="{{ old('kode', $asset->kode ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('kode') ? 'border-red-500' : '' }}">
        @error('kode')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-1">Nama Aset <span class="text-red-500">*</span></label>
        <input type="text" id="nama_aset" name="nama_aset"
            value="{{ old('nama_aset', $asset->nama_aset ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('nama_aset') ? 'border-red-500' : '' }}">
        @error('nama_aset')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
        <input type="text" id="kategori" name="kategori"
            value="{{ old('kategori', $asset->kategori ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('kategori') ? 'border-red-500' : '' }}">
        @error('kategori')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="group_kategori" class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori</label>
        <input type="text" id="group_kategori" name="group_kategori"
            value="{{ old('group_kategori', $asset->group_kategori ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('group_kategori') ? 'border-red-500' : '' }}">
        @error('group_kategori')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
        <input type="number" id="jumlah" name="jumlah" min="1"
            value="{{ old('jumlah', $asset->jumlah ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('jumlah') ? 'border-red-500' : '' }}">
        @error('jumlah')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="nilai_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Nilai Pembelian</label>
        <input type="number" id="nilai_pembelian" name="nilai_pembelian" min="0" step="0.01"
            value="{{ old('nilai_pembelian', $asset->nilai_pembelian ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('nilai_pembelian') ? 'border-red-500' : '' }}">
        @error('nilai_pembelian')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
        <select id="status" name="status"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('status') ? 'border-red-500' : '' }}">
            <option value="">Pilih Status</option>
            <option value="tersedia" {{ old('status', $asset->status ?? '') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="dipakai" {{ old('status', $asset->status ?? '') === 'dipakai' ? 'selected' : '' }}>Dipakai</option>
            <option value="rusak" {{ old('status', $asset->status ?? '') === 'rusak' ? 'selected' : '' }}>Rusak</option>
            <option value="hilang" {{ old('status', $asset->status ?? '') === 'hilang' ? 'selected' : '' }}>Hilang</option>
            <option value="habis" {{ old('status', $asset->status ?? '') === 'habis' ? 'selected' : '' }}>Habis</option>
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="tgl_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian</label>
        <input type="date" id="tgl_pembelian" name="tgl_pembelian" max="<?php echo date('Y-m-d'); ?>"
            value="{{ old('tgl_pembelian', $asset->tgl_pembelian ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('tgl_pembelian') ? 'border-red-500' : '' }}">
        @error('tgl_pembelian')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label for="lokasi_terakhir" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir</label>
    <input type="text" id="lokasi_terakhir" name="lokasi_terakhir"
        value="{{ old('lokasi_terakhir', $asset->lokasi_terakhir ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('lokasi_terakhir') ? 'border-red-500' : '' }}">
    @error('lokasi_terakhir')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>