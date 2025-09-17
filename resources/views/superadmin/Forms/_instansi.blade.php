<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
    <input type="text" id="nama"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="pemerintah" class="block text-sm font-medium text-gray-700 mb-1">Pemerintah</label>
    <input type="text" id="pemerintah"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
    <input type="number" id="telepon" min="0"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div class="form-group">
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" required
        autofocus class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" @error('email') is-invalid @enderror">
    @error('email')
        <div style="color: red; font-size: 12px;">{{ $message }}</div>
    @enderror
</div>
<div>
    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
    <input type="text" id="alamat"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
