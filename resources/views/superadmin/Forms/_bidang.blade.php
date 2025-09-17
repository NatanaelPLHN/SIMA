@csrf
<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
    <input type="text" id="nama"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="kepalaBidang" class="block text-sm font-medium text-gray-700 mb-1">Kepala Bidang</label>
    <input type="text" id="kepalaBidang"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
    <input type="text" id="lokasi"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

{{-- buat drop down berdasarkan data instansi --}}
{{-- <div>
    <label for="instansi" class="block text-sm font-medium text-gray-700 mb-1">Instansi</label>
    <input type="text" id="instansi"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div> --}}

<div>
    <label for="instansi" class="block text-sm font-medium text-gray-700 mb-1">Instansi</label>
    <select id="instansi"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ind=">
        <option value="">Pilih Instansi</option>
        <option value="tersedia">diskominfo</option>
        <option value="dipakai">diknas</option>
    </select>
</div>