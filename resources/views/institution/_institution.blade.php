@csrf
<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama instansi<span
            class="text-red-500">*</span></label>
            <input type="text" id="nama" name="nama"
            pattern="[A-Za-z0-9 ]+"
            placeholder="Masukkan nama instansi..."
            title="Hanya huruf, angka, dan spasi yang diizinkan"
            value="{{ old('nama', $institution->nama ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            required autofocus>

</div>
<div>
    <label for="alias" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alias <span
            class="text-red-500">*</span></label>
    <input type="text" id="alias" name="alias" pattern="[A-Za-z0-9,-.]{0,30}"
        placeholder="Masukkan alias instansi..." minlength="3" maxlength="30"
        title="Only letters, numbers, and - allowed" value="{{ old('alias', $institution->alias ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
        {{ isset($institution) && $institution->exists ? 'bg-gray-100' : '' }}"
        {{ isset($institution) && $institution->exists ? 'disabled' : '' }} required>
</div>
<div>
    <label for="pemerintah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pemerintah <span
            class="text-red-500">*</span></label>
    <input type="text" id="pemerintah" name="pemerintah" pattern="[A-Z a-z0-9,.]{0,30}"
        placeholder="Masukkan nama pemerintah..." minlength="6"
        title="Only letters, numbers, and spaces allowed"
        value="{{ old('pemerintah', $institution->pemerintah ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
        required>
</div>
<div>
    <label for="telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telepon</label>
    <input type="tel" id="telepon" name="telepon" pattern="[0-9]{0,15}"
        placeholder="Masukkan nomor telepon instansi..." minlength="10" maxlength="15" title="Contoh: 08xxxxxxxx"
        value="{{ old('telepon', $institution->telepon ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div class="form-group">
    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email <span
            class="text-red-500">*</span></label>
    <input type="email" name="email" id="email" value="{{ old('email', $institution->email ?? '') }}"
        placeholder="Masukkan alamat email instansi..." required
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
        @error('email') is-invalid @enderror">
    @error('email')
        <div style="color: red; font-size: 12px;">{{ $message }}</div>
    @enderror
</div>
<div>
    <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
    <input type="text" id="alamat" name="alamat" pattern="[A-Z a-z0-9,.]{0,30}"
        placeholder="Masukkan alamat instansi..." minlength="6"
        title="Only letters, numbers, and spaces allowed" value="{{ old('alamat', $institution->alamat ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<div>
    <label for="kepala_instansi_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Kepala instansi
    </label>

    @if ($employees->isNotEmpty())
        <!-- Tampilkan Select2 hanya jika ada pegawai -->
        <select name="kepala_instansi_id" id="kepala_instansi_id"
            class="js-select2 mt-1 block w-full border {{ $errors->has('kepala_instansi_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-md shadow-sm py-2 px-3
                   bg-white dark:bg-gray-800
                   text-gray-900 dark:text-gray-200
                   focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                   dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
            <option value="">Pilih Kepala Instansi</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}"
                    {{ old('kepala_instansi_id', $institution->kepala_instansi_id ?? '') == $employee->id ? 'selected' : '' }}>
                    {{ $employee->nama }} ({{ $employee->nip }})
                </option>
            @endforeach
        </select>
    @else
        <!-- Tampilkan pesan statis jika tidak ada pegawai -->
        <div
            class="mt-1 block w-full py-2 px-3
                    text-gray-500 dark:text-gray-400
                    bg-gray-50 dark:bg-gray-700
                    border border-gray-300 dark:border-gray-600
                    rounded-md">
            Belum ada pegawai
        </div>
        <!-- Hidden input agar field tetap dikirim -->
        <input type="hidden" name="kepala_instansi_id" value="">
    @endif

    @if (isset($institution) && $institution->exists)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Hanya menampilkan pegawai yang ada di instansi ini.
        </p>
    @else
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Kepala instansi dapat dipilih setelah instansi dibuat dan pegawai ditambahkan.
        </p>
    @endif

    @error('kepala_instansi_id')
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>
