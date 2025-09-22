@csrf
<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
    <input type="text" id="nama" name="nama" value="{{ old('nama', $bidang->nama ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<div>
    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $bidang->lokasi ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

{{-- buat drop down berdasarkan data instansi --}}
<div>
    <label for="instansi_id" class="block text-sm font-medium text-gray-700">Instansi <span class="text-red-500">*</span></label>
    <select name="instansi_id" id="instansi_id"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('instansi_id') ? 'border-red-500' : '' }}">
        <option value="">Pilih Instansi</option>
        @foreach ($instansis as $instansi)
            <option value="{{ $instansi->id }}" {{ old('instansi_id', $bidang->instansi_id ?? '') == $instansi->id ? 'selected' : '' }}>
                {{ $instansi->nama }}
            </option>
        @endforeach
    </select>
    @error('instansi_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
<div>
    <label for="kepala_bidang" class="block text-sm font-medium text-gray-700">Kepala Bidang</label>
    <select name="kepala_bidang" id="kepala_bidang"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('kepala_bidang') ? 'border-red-500' : '' }}">
        <option value="">Pilih Kepala Bidang</option>
        @forelse ($employees as $employee)
            <option value="{{ $employee->id }}" {{ old('kepala_bidang', $bidang->kepala_bidang ?? '') == $employee->id ? 'selected' : '' }}>
                {{ $employee->nama }} ({{ $employee->nip }})
            </option>
        @empty
            <option value="">Tidak ada pegawai di bidang ini</option>
        @endforelse
    </select>

    @if(isset($bidang) && $bidang->exists)
        <p class="mt-1 text-sm text-gray-500">Hanya menampilkan pegawai yang ada di bidang ini.</p>
    @else
        <p class="mt-1 text-sm text-gray-500">Kepala bidang dapat dipilih setelah bidang dibuat dan pegawai ditambahkan.</p>
    @endif

    @error('kepala_bidang')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
{{-- <div>
    <label for="kepala_bidang" class="block text-sm font-medium text-gray-700">Kepala Bidang</label>
    <select name="kepala_bidang" id="kepala_bidang"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('kepala_bidang') ? 'border-red-500' : '' }}">
        <option value="">Pilih Kepala Bidang</option>
        @foreach ($employees as $employee)
            <option value="{{ $employee->id }}" {{ old('kepala_bidang', $bidang->kepala_bidang ?? '') == $employee->id ? 'selected' : '' }}>
                {{ $employee->nama }} ({{ $employee->nip }})
            </option>
        @endforeach
    </select>
    @error('kepala_bidang')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div> --}}
{{-- <div>
    <label for="instansi" class="block text-sm font-medium text-gray-700 mb-1">Instansi</label>
    <select id="instansi"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ind=">
        <option value="">Pilih Instansi</option>
        <option value="tersedia">diskominfo</option>
        <option value="dipakai">diknas</option>
    </select>
</div> --}}
