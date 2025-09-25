@csrf
<div>
    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP<span class="text-red-500">*</span></label>
    <input type="number" id="nip" min="0" name="nip"
    value="{{ old('nip', $employee->nip ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama<span class="text-red-500">*</span></label>
    <input type="text" id="nama" name="nama"
    value="{{ old('nama', $employee->nama ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
    <input type="text" id="alamat" name="alamat"
    value="{{ old('alamat', $employee->alamat ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
    <input type="number" id="telepon" min="0" name="telepon"
    value="{{ old('telepon', $employee->telepon ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="department_id" class="block text-sm font-medium text-gray-700">Bidang</label>
    <select name="department_id" id="department_id"
    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">Pilih Bidang</option>
        @foreach($bidangs as $bidang)
            <option value="{{ $bidang->id }}" {{ (old('department_id') ?? $employee->department_id ?? '') == $bidang->id ? 'selected' : '' }}>
                {{ $bidang->nama }}
            </option>
        @endforeach
    </select>
    @error('department_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

