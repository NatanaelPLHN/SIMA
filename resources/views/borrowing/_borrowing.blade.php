@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    {{-- Nama Aset --}}
    <div>
        <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-1">
            Nama Aset <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nama_aset" name="nama_aset"
            class="w-full px-3 py-2 border border-gray-300 rounded-md
            focus:outline-none focus:ring-2 focus:ring-indigo-500">

    </div>
    <div>
        <label for="pic" class="block text-sm font-medium text-gray-700 mb-1">
            PIC <span class="text-red-500">*</span>
        </label>
        <input type="text" id="pic" name="pic"
            class="w-full px-3 py-2 border border-gray-300 rounded-md
            focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="Bidang" class="block text-sm font-medium text-gray-700 mb-1">
            Bidang <span class="text-red-500">*</span>
        </label>
        <input type="text" id="Bidang" name="Bidang"
            class="w-full px-3 py-2 border border-gray-300 rounded-md
            focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label for="tgl_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Peminjaman<span
                class="text-red-500">*</span></label>
        <input type="date" id="tgl_mulai" name="tgl_mulai" max="<?php echo date('Y-m-d'); ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('tgl_mulai') ? 'border-red-500' : '' }}">
        @error('tgl_mulai')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label for="tgl_pengembalian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengembalian<span
                class="text-red-500">*</span></label>
        <input type="date" id="tgl_pengembalian" name="tgl_pengembalian" max="<?php echo date('Y-m-d'); ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('tgl_pengembalian') ? 'border-red-500' : '' }}">
        @error('tgl_pengembalian')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-1">
            Tujuan Penggunaan <span class="text-red-500">*</span>
        </label>
        <input type="text" id="tujuan" name="tujuan"
            class="w-full px-3 py-2 border border-gray-300 rounded-md
            focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>
<div>
    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan<span
            class="text-red-500">*</span></label>
    <input type="text" id="keterangan" name="keterangan"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('keterangan') ? 'border-red-500' : '' }}">
    @error('keterangan')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
