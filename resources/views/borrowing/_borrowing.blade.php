@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    {{-- Nama Aset --}}
    {{-- <div>
        <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-1">
            Nama Aset <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nama_aset" name="nama_aset"
            class="w-full px-3 py-2 border border-gray-300 rounded-md
            focus:outline-none focus:ring-2 focus:ring-indigo-500">

    </div> --}}

    <div>
        <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-1">Nama Aset <span class="text-red-500">*</span></label>
        <select name="asset_id" id="asset_id"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('nama_aset') ? 'border-red-500' : '' }}">
        <option value="">Pilih aset</option>
        @foreach ($assets as $asset)
            <option value="{{ $asset->id }}" {{ old('asset_id', $borrowing->asset_id ?? '') == $asset->id ? 'selected' : '' }}>
                {{ $asset->nama_aset }}
            </option>
        @endforeach
    </select>

    </div>

    <div>
        <label for="borrowed_by" class="block text-sm font-medium text-gray-700 mb-1">
            PIC <span class="text-red-500">*</span>
        </label>
        <select name="borrowed_by" id="borrowed_by"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('nama_aset') ? 'border-red-500' : '' }}">
        <option value="">Pilih aset</option>
        @foreach ($employees as $employee)
            <option value="{{ $employee->id }}" {{ old('borrowed_by', $borrowing->borrowed_by ?? '') == $employee->id ? 'selected' : '' }}>
                {{ $employee->nama }}
            </option>
        @endforeach
    </select>

    </div>
    {{-- <div>
        <label for="pic" class="block text-sm font-medium text-gray-700 mb-1">
            PIC <span class="text-red-500">*</span>
        </label>
        <input type="text" id="pic" name="pic"
            class="w-full px-3 py-2 border border-gray-300 rounded-md
            focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div> --}}
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
        <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Peminjaman<span
                class="text-red-500">*</span></label>
        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" max="<?php echo date('Y-m-d'); ?>"
        value="{{ old('tanggal_pinjam', $borrowing->tanggal_pinjam ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('tanggal_pinjam') ? 'border-red-500' : '' }}">
        @error('tanggal_pinjam')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengembalian<span
                class="text-red-500">*</span></label>
        <input type="date" id="tanggal_kembali" name="tanggal_kembali" max="<?php echo date('Y-m-d'); ?>"
        value="{{ old('tanggal_kembali', $borrowing->tanggal_kembali ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('tanggal_kembali') ? 'border-red-500' : '' }}">
        @error('tanggal_kembali')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="tujuan_penggunaan" class="block text-sm font-medium text-gray-700 mb-1">
            Tujuan Penggunaan <span class="text-red-500">*</span>
        </label>
        <input type="text" id="tujuan_penggunaan" name="tujuan_penggunaan"
            class="w-full px-3 py-2 border border-gray-300 rounded-md
            focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>
<div>
    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan<span
            class="text-red-500">*</span></label>
    <input type="text" id="keterangan" name="keterangan"
    value="{{ old('keterangan', $borrowing->keterangan ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('keterangan') ? 'border-red-500' : '' }}">
    @error('keterangan')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
