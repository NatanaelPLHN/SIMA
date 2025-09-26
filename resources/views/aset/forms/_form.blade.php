@csrf
@php
    $categories = $categories ?? collect();
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    {{-- Nama Aset --}}
    <div>
        <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-1">
            Nama Aset <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nama_aset" name="nama_aset" value="{{ old('nama_aset', $asset->nama_aset ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md
            focus:outline-none focus:ring-2 focus:ring-indigo-500
            {{ $errors->has('nama_aset') ? 'border-red-500' : '' }}">
        @error('nama_aset')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="nilai_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Nilai Pembelian<span
                class="text-red-500">*</span></label>
        <input type="number" id="nilai_pembelian" name="nilai_pembelian" min="0" step="0.01"
            value="{{ old('nilai_pembelian', $asset->nilai_pembelian ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('nilai_pembelian') ? 'border-red-500' : '' }}">
        @error('nilai_pembelian')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Grup Kategori & Kategori --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    {{-- Grup Kategori --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Grup Kategori</label>
        @if(Route::is('admin.assets.edit'))
            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                {{ $asset->category->CategoryGroup->nama ?? '-' }}
            </div>
            <input type="hidden" name="category_group_id" value="{{ $asset->category->category_group_id }}">
        @else
            <select id="category_group_id" name="category_group_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Pilih Grup --</option>
            @foreach($groupCategories as $group)
            <option value="{{ $group->id }}">{{ $group->nama }}</option>
            @endforeach
</select>

        @endif
    </div>

    {{-- Kategori --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
        @if(Route::is('admin.assets.edit'))
            <div class="px-3 py-2 bg-gray-100 rounded-md border border-gray-200">
                {{ $asset->category->nama ?? '-' }}
            </div>
            <input type="hidden" name="category_id" value="{{ $asset->category_id }}">
        @else
            <select id="category_id" name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $asset->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nama }}
                    </option>
                @endforeach
            </select>
        @endif

    </div>
</div>
<input type="hidden" name="jumlah" value="1">

{{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

</div> --}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span
                class="text-red-500">*</span></label>
        <select id="status" name="status"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('status') ? 'border-red-500' : '' }}">
            <option value="">Pilih Status</option>
            <option value="tersedia" {{ old('status', $asset->status ?? '') === 'tersedia' ? 'selected' : '' }}>Tersedia
            </option>
            <option value="dipakai" {{ old('status', $asset->status ?? '') === 'dipakai' ? 'selected' : '' }}>Dipakai
            </option>
            <option value="rusak" {{ old('status', $asset->status ?? '') === 'rusak' ? 'selected' : '' }}>Rusak</option>
            <option value="hilang" {{ old('status', $asset->status ?? '') === 'hilang' ? 'selected' : '' }}>Hilang
            </option>
            <option value="habis" {{ old('status', $asset->status ?? '') === 'habis' ? 'selected' : '' }}>Habis</option>
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="tgl_pembelian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian<span
                class="text-red-500">*</span></label>
        <input type="date" id="tgl_pembelian" name="tgl_pembelian" max="<?php echo date('Y-m-d'); ?>"
            value="{{ old('tgl_pembelian', $asset->tgl_pembelian ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('tgl_pembelian') ? 'border-red-500' : '' }}">
        @error('tgl_pembelian')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label for="lokasi_terakhir" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terakhir<span
            class="text-red-500">*</span></label>
    <input type="text" id="lokasi_terakhir" name="lokasi_terakhir"
        value="{{ old('lokasi_terakhir', $asset->lokasi_terakhir ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('lokasi_terakhir') ? 'border-red-500' : '' }}">
    @error('lokasi_terakhir')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Script untuk filter kategori berdasarkan grup --}}
<script>
    document.getElementById('category_group_id').addEventListener('change', function () {
        let groupId = this.value;
        let categorySelect = document.getElementById('category_id');
        categorySelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';

        if (groupId) {
            fetch("{{ route('categories.by-group') }}?group_id=" + groupId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(cat => {
                        let option = document.createElement('option');
                        option.value = cat.id;
                        option.textContent = cat.nama;
                        categorySelect.appendChild(option);
                    });
                });
        }
    });
</script>
