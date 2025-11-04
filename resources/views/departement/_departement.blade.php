@csrf
<!-- Nama -->
<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Bidang<span
        class="text-red-500">*</span>
    </label>
    <input type="text" id="nama" name="nama"
        pattern="[A-Za-z0-9,. -]+"
        placeholder="Masukkan nama bidang..."
        title="Hanya huruf, angka, spasi, koma, titik, dan tanda hubung yang diizinkan"
        value="{{ old('nama', $departement->nama ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
        required>
</div>

<!-- Alamat -->
<div>
    <label for="lokasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi</label>
    <input type="text" id="lokasi" name="lokasi" pattern="[A-Z a-z0-9,.]{0,30}" minlength="4"
        placeholder="Masukkan lokasi bidang..." title="Only letters, numbers, and spaces allowed"
        value="{{ old('lokasi', $departement->lokasi ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<div>
    <label for="alias" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alias<span
            class="text-red-500">*</span></label>
    <input type="text" id="alias" name="alias" pattern="[A-Za-z0-9,-.]{0,30}"
        placeholder="Masukkan alias bidang..." minlength="3" maxlength="30"
        title="Only letters, numbers, and - allowed" value="{{ old('alias', $departement->alias ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ isset($departement) && $departement->exists ? 'bg-gray-100' : '' }}"
        {{ isset($departement) && $departement->exists ? 'disabled' : '' }} required>
</div>

@if (isset($departement) && $departement->exists)
    {{-- Tampilan untuk form EDIT --}}
    <div>
        <label for="instansi_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Instansi
        </label>
        <input type="text" id="instansi_nama" name="instansi_nama"
            value="{{ $departement->institution->nama ?? 'Tidak Ditemukan' }}"
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-800 dark:text-white"
            disabled>
        <input type="hidden" name="instansi_id" value="{{ $departement->institution->id ?? '' }}">
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Instansi tidak dapat diubah.
        </p>
    </div>
@else
    {{-- Tampilan untuk form CREATE --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Instansi
        </label>
        <div
            class="mt-1 p-3 bg-indigo-100 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-700 rounded-md">
            <p class="font-semibold text-indigo-800 dark:text-indigo-200">
                {{ Auth::user()->employee?->institution?->nama }}
            </p>
            <p class="text-sm text-indigo-600 dark:text-indigo-300">
                Departemen baru akan otomatis terdaftar di bawah instansi ini.
            </p>
        </div>
    </div>
@endif

<div>
    <label for="kepala_bidang_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Kepala Bidang
    </label>
    <select name="kepala_bidang_id" id="kepala_bidang_id"
        class="js-select2 mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3
               bg-white dark:bg-gray-800 text-gray-900 dark:text-white
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
               {{ $errors->has('kepala_bidang_id') ? 'border-red-500 dark:border-red-500' : '' }}">
        <option value="">Pilih Kepala Bidang</option>
        @forelse ($employees as $employee)
            <option value="{{ $employee->id }}"
                {{ old('kepala_bidang_id', $departement->kepala_bidang_id ?? '') == $employee->id ? 'selected' : '' }}>
                {{ $employee->nama }} ({{ $employee->nip }})
            </option>
        @empty
            <option value="">Tidak ada pegawai di bidang ini</option>
        @endforelse
    </select>

    @if (isset($departement) && $departement->exists)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Hanya menampilkan pegawai yang ada di bidang ini.
        </p>
    @else
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Kepala bidang dapat dipilih setelah bidang dibuat dan pegawai ditambahkan.
        </p>
    @endif

    @error('kepala_bidang')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
