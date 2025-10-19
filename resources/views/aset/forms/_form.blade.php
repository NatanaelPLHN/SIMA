@csrf
@php
    $categories = $categories ?? collect();
    // Menentukan jenis aset saat ini, baik dari mode edit ($asset) atau mode create ($jenis_aset)
    $current_jenis_aset = $asset->jenis_aset ?? ($jenis_aset ?? '');
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    {{-- Nama Aset --}}
    <div>
        <label for="nama_aset" class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">
            Nama Aset <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nama_aset" name="nama_aset" pattern="[A-Z a-z0-9,.]{0,30}"
            placeholder="Masukkan nama aset..." minlength="4" maxlength="20"
            title="Only letters, numbers, and spaces allowed" value="{{ old('nama_aset', $asset->nama_aset ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            required>
        @error('nama_aset')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">
            Nilai Pembelian <span class="text-red-500">*</span>
        </label>

        @if (Route::is('subadmin.assets.edit'))
            {{-- Mode Edit: Tampilkan sebagai teks + hidden input --}}
            <div
                class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                {{ number_format($asset->nilai_pembelian ?? 0, 2, ',', '.') }}
            </div>
            <input type="hidden" name="nilai_pembelian" value="{{ $asset->nilai_pembelian }}">
        @else
            {{-- Mode Create: Input normal --}}
            <input type="number" id="nilai_pembelian" name="nilai_pembelian" min="0" step="1"
                placeholder="Masukkan nilai pembelian..." title="Only numbers allowed"
                value="{{ old('nilai_pembelian') }}"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('nilai_pembelian') ? 'border-red-500' : '' }}"
                required>
            @error('nilai_pembelian')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        @endif
    </div>
</div>

{{-- Grup Kategori & Kategori --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    {{-- Grup Kategori --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Grup Kategori <span
                class="text-red-500">*</span></label>
        @if (Route::is('subadmin.assets.edit'))
            <div
                class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                {{ $asset->category->CategoryGroup->nama ?? '-' }}
            </div>
            <input type="hidden" name="category_group_id" value="{{ $asset->category->category_group_id }}">
        @else
            <select id="category_group_id" name="category_group_id"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                class="js-select2">
                <option value="">-- Pilih Grup --</option>
                @foreach ($groupCategories as $group)
                    <option value="{{ $group->id }}">{{ $group->nama }}</option>
                @endforeach
            </select>

        @endif
    </div>

    {{-- Kategori --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Kategori <span
                class="text-red-500">*</span></label>
        @if (Route::is('subadmin.assets.edit'))
            <div
                class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                {{ $asset->category->nama ?? '-' }}
            </div>
            <input type="hidden" name="category_id" value="{{ $asset->category_id }}">
        @else
            <select id="category_id" name="category_id"
                class="js-select2 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $asset->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nama }}
                    </option>
                @endforeach
            </select>
        @endif

    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @if (in_array($current_jenis_aset, ['bergerak', 'tidak_bergerak']))
        {{-- <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Status <span
                    class="text-red-500">*</span></label>
            <select id="status" name="status" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Status</option>
                <option value="tersedia" {{ old('status', $asset->status ?? '') == 'tersedia' ? 'selected' : '' }}>
                    Tersedia</option>
                <option value="dipakai" {{ old('status', $asset->status ?? '') == 'dipakai' ? 'selected' : '' }}>
                    Dipakai</option>
                <option value="rusak" {{ old('status', $asset->status ?? '') == 'rusak' ? 'selected' : '' }}>Rusak
                </option>
                <option value="hilang" {{ old('status', $asset->status ?? '') == 'hilang' ? 'selected' : '' }}>Hilang
                </option>
            </select>
        </div> --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">
                Status <span class="text-red-500">*</span>
            </label>

            @if (Route::is('subadmin.assets.edit'))
                {{-- Mode Edit: Tampilkan sebagai teks + hidden input --}}
                <div
                    class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                    {{ match ($asset->status ?? '') {
                        'tersedia' => 'Tersedia',
                        'dipakai' => 'Dipakai',
                        'rusak' => 'Rusak',
                        'hilang' => 'Hilang',
                        default => '–',
                    } }}
                </div>
                <input type="hidden" name="status" value="{{ $asset->status }}">
            @else
                {{-- Mode Create: Tampilkan select --}}
                <select id="status" name="status" required
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Pilih Status</option>
                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipakai" {{ old('status') == 'dipakai' ? 'selected' : '' }}>Dipakai</option>
                    <option value="rusak" {{ old('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="hilang" {{ old('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
            @endif
        </div>
    @elseif($current_jenis_aset === 'habis_pakai')
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">
                Jumlah <span class="text-red-500">*</span>
            </label>

            @if (Route::is('subadmin.assets.edit'))
                {{-- Mode Edit: Tampilkan sebagai teks + hidden input --}}
                <div
                    class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white">
                    {{ $asset->jumlah ?? '1' }}
                </div>
                <input type="hidden" name="jumlah" value="{{ $asset->jumlah ?? 1 }}">
            @else
                {{-- Mode Create: Input normal --}}
                <input type="number" id="jumlah" name="jumlah" min="0" placeholder="Masukkan jumlah aset..."
                    title="Only numbers allowed" value="{{ old('jumlah', '1') }}" required
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('jumlah')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            @endif
        </div>
    @endif

    <div>
        <label for="tgl_pembelian" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">
            Tanggal Pembelian<span class="text-red-500">*</span>
        </label>
        <input type="text" id="tgl_pembelian" name="tgl_pembelian" data-datepicker
            data-max-date="{{ date('Y-m-d') }}" value="{{ old('tgl_pembelian', $asset->tgl_pembelian ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white {{ $errors->has('tgl_pembelian') ? 'border-red-500' : '' }}"
            placeholder="Pilih tanggal..." required>
        @error('tgl_pembelian')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

</div>

<div>
    <label for="lokasi_terakhir" class="block text-sm font-medium text-gray-700 dark:text-gray-100 mb-1">Lokasi
        Terakhir<span class="text-red-500">*</span></label>
    <input type="text" id="lokasi_terakhir" name="lokasi_terakhir" pattern="[A-Z a-z0-9,.]{0,30}"
        placeholder="Masukkan lokasi terakhir aset..." minlength="4" maxlength="30"
        title="Only letters, numbers, and spaces allowed"
        value="{{ old('lokasi_terakhir', $asset->lokasi_terakhir ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('lokasi_terakhir') ? 'border-red-500' : '' }}">
    @error('lokasi_terakhir')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Script untuk filter kategori berdasarkan grup --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Select2 (jika belum otomatis)
        $('#category_group_id').select2();
        $('#category_id').select2();

        // Event saat grup kategori berubah
        $('#category_group_id').on('change', function() {
            let groupId = $(this).val();
            let categorySelect = $('#category_id');

            // Reset pilihan kategori
            categorySelect.empty().append('<option value="">-- Pilih Kategori --</option>').trigger(
                'change');

            if (groupId) {
                $.get("{{ route('categories.by-group') }}", {
                        group_id: groupId
                    })
                    .done(function(data) {
                        // Kosongkan lagi (untuk menghindari duplikasi jika ada delay)
                        categorySelect.empty().append(
                            '<option value="">-- Pilih Kategori --</option>');

                        // Tambahkan opsi baru
                        $.each(data, function(index, cat) {
                            let option = new Option(cat.nama, cat.id, false, false);
                            categorySelect.append(option);
                        });

                        // Trigger change agar Select2 merender ulang
                        categorySelect.trigger('change');
                    })
                    .fail(function() {
                        console.error('Gagal memuat kategori');
                        // Opsional: tampilkan notifikasi error
                    });
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#tgl_pembelian", {
            dateFormat: "Y-m-d",
            maxDate: "{{ date('Y-m-d') }}", // batas maksimal hari ini
            allowInput: true,
            // Opsional: aktifkan dark mode jika sistem/dark class aktif
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        });
    });
</script>
