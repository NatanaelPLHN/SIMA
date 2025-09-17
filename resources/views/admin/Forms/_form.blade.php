@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Kode</label>
        <input type="text" id="kode" name="kode"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <div>
        <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-1">Nama Aset</label>
        <input type="text" id="nama_aset" name="nama_aset"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
        <input type="text" id="kategori" name="kategori"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <div>
        <label for="group_kategori" class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori</label>
        <input type="text" id="group_kategori" name="group_kategori"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
        <input type="number" id="jumlah" name="jumlah"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <div>
        <label for="nilai_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Nilai Pembelian</label>
        <input type="number" id="nilai_pembelian" name="nilai_pembelian"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ind=">
            <option value="">Pilih Status</option>
            <option value="tersedia">Tersedia</option>
            <option value="dipakai">Dipakai</option>
            <option value="rusak">Rusak</option>
            <option value="hilang">Hilang</option>
            <option value="habis">Habis</option>
        </select>
    </div>

    <div>
        <label for="tgl_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian</label>
        <input type="date" id="tgl_pembelian" name="tgl_pembelian"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>

<div>
    <label for="lokasi_terakhir" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir</label>
    <input type="text" id="lokasi_terakhir" name="lokasi_terakhir"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
