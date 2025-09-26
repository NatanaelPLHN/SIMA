@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    {{-- <div>
        <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Kode <span class="text-red-500">*</span></label>
        <input type="text" id="kode" name="kode"
            value="{{ old('kode', $asset->kode ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('kode') ? 'border-red-500' : '' }}">
        @error('kode')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div> --}}

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
        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori<span class="text-red-500">*</span></label>
        <input type="text" id="kategori" name="kategori"
            value="{{ old('kategori', $asset->kategori ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('kategori') ? 'border-red-500' : '' }}">
        @error('kategori')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="group_kategori" class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori<span class="text-red-500">*</span></label>
        <input type="text" id="group_kategori" name="group_kategori"
            value="{{ old('group_kategori', $asset->group_kategori ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('group_kategori') ? 'border-red-500' : '' }}">
        @error('group_kategori')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    {{-- <div>
        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
        <input type="number" id="jumlah" name="jumlah" min="1"
            value="{{ old('jumlah', $asset->jumlah ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('jumlah') ? 'border-red-500' : '' }}">
        @error('jumlah')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div> --}}

    <input type="hidden" name="jumlah" value="1">

    <div>
        <label for="nilai_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Nilai Pembelian<span class="text-red-500">*</span></label>
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
        <label for="tgl_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian<span class="text-red-500">*</span></label>
        <input type="date" id="tgl_pembelian" name="tgl_pembelian" max="<?php echo date('Y-m-d'); ?>"
            value="{{ old('tgl_pembelian', $asset->tgl_pembelian ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('tgl_pembelian') ? 'border-red-500' : '' }}">
        @error('tgl_pembelian')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label for="lokasi_terakhir" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir<span class="text-red-500">*</span></label>
    <input type="text" id="lokasi_terakhir" name="lokasi_terakhir"
        value="{{ old('lokasi_terakhir', $asset->lokasi_terakhir ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('lokasi_terakhir') ? 'border-red-500' : '' }}">
    @error('lokasi_terakhir')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
