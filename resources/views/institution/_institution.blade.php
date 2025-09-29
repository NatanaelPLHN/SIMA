@csrf
<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
    <input type="text" id="nama" name="nama"
    value="{{ old('nama', $institution->nama ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="alias" class="block text-sm font-medium text-gray-700 mb-1">Alias</label>
    <input type="text" id="alias" name="alias" value="{{ old('alias', $institution->alias ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ isset($institution) && $institution->exists ? 'bg-gray-100' : '' }}"
        {{ isset($institution) && $institution->exists ? 'disabled' : '' }} required>
</div>
<div>
    <label for="pemerintah" class="block text-sm font-medium text-gray-700 mb-1">Pemerintah <span class="text-red-500">*</span></label>
    <input type="text" id="pemerintah" name="pemerintah"
    value="{{ old('pemerintah', $institution->pemerintah ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
    <input type="number" id="telepon" min="0" name="telepon"
    value="{{ old('telepon', $institution->telepon ?? '') }}"
    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div class="form-group">
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
    <input type="email" name="email" id="email" value="{{ old('email', $institution->email ?? '') }}"  placeholder="Email" required
        autofocus class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" @error('email') is-invalid @enderror">
    @error('email')
        <div style="color: red; font-size: 12px;">{{ $message }}</div>
    @enderror
</div>
<div>
    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
    <input type="text" id="alamat" name="alamat"
    value="{{ old('alamat', $institution->alamat ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
