@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Kode</label>
        <input type="text" id="kode" name="kode"
            value="{{ old('kode', $asset->kode ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <div>
        <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-1">Nama Aset</label>
        <input type="text" id="nama_aset" name="nama_aset"
            value="{{ old('nama_aset', $asset->nama_aset ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
        <input type="text" id="kategori" name="kategori"
            value="{{ old('kategori', $asset->kategori ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <div>
        <label for="group_kategori" class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori</label>
        <input type="text" id="group_kategori" name="group_kategori"
            value="{{ old('group_kategori', $asset->group_kategori ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
        <input type="number" id="jumlah" name="jumlah" min="0"
            value="{{ old('jumlah', $asset->jumlah ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <div>
        <label for="nilai_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Nilai Pembelian</label>
        <input type="number" id="nilai_pembelian" name="nilai_pembelian" min="0"
            value="{{ old('nilai_pembelian', $asset->nilai_pembelian ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select id="status" name="status"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Pilih Status</option>
            <option value="tersedia" {{ old('status', $asset->status ?? '') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="dipakai" {{ old('status', $asset->status ?? '') === 'dipakai' ? 'selected' : '' }}>Dipakai</option>
            <option value="rusak" {{ old('status', $asset->status ?? '') === 'rusak' ? 'selected' : '' }}>Rusak</option>
            <option value="hilang" {{ old('status', $asset->status ?? '') === 'hilang' ? 'selected' : '' }}>Hilang</option>
            <option value="habis" {{ old('status', $asset->status ?? '') === 'habis' ? 'selected' : '' }}>Habis</option>
        </select>
    </div>

    <div>
        <label for="tgl_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian</label>
        <input type="date" id="tgl_pembelian" name="tgl_pembelian" max="<?php echo date('Y-m-d'); ?>"
            value="{{ old('tgl_pembelian', $asset->tgl_pembelian ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>

<div>
    <label for="lokasi_terakhir" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir</label>
    <input type="text" id="lokasi_terakhir" name="lokasi_terakhir"
        value="{{ old('lokasi_terakhir', $asset->lokasi_terakhir ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
