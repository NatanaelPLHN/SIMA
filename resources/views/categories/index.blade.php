@extends('layouts.app')

@section('title', 'Daftar Kategori')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <!-- Breadcrumb -->
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#  "
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                    aria-current="page">Kategori</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar Kategori </h1>
            </div>

            <!-- Controls: Search, Add Button -->
            <div class="items-center justify-between block sm:flex">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form method="GET" action="{{ route('superadmin.categories.index') }}"
                        class="flex items-center space-x-2 sm:pl-4 mt-2 sm:mt-0">
                        <div class="relative w-48 sm:w-64">
                            <input type="text" name="search" id="Grup-kategori-search" value="{{ request('search') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Cari nama, Deskripsi, dll...">
                        </div>
                        @if (request('search'))
                            <a href="{{ route('superadmin.categories.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <button id="createCategoryButton"
                    class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800"
                    type="button" data-drawer-target="drawer-create-grup-category"
                    data-drawer-show="drawer-create-grup-category" aria-controls="drawer-create-grup-category"
                    data-drawer-placement="right">
                    Tambah Kategori
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                            No</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                            <a
                                href="{{ request()->fullUrlWithQuery(['sort' => 'alias', 'direction' => request('sort') === 'alias' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Alias
                                @if (request('sort') === 'alias')
                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                            <a
                                href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('sort') === 'nama' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Nama Kategori
                                @if (request('sort') === 'nama')
                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                            <a
                                href="{{ request()->fullUrlWithQuery(['sort' => 'group', 'direction' => request('sort') === 'group' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Group
                                @if (request('sort') === 'group')
                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                            <a
                                href="{{ request()->fullUrlWithQuery(['sort' => 'deskripsi', 'direction' => request('sort') === 'deskripsi' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Deskripsi
                                @if (request('sort') === 'deskripsi')
                                    <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th
                            class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                            Aksi
                        </th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse($categories as $index => $category)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                {{ $index + $categories->firstItem() }}
                            </td>
                            <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                {{ $category->alias }}
                            </td>
                            <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                {{ $category->nama }}
                            </td>
                            <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                {{ $category->categoryGroup->nama ?? '-' }}
                            </td>
                            <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                {{ $category->deskripsi }}
                            </td>
                            <td class="p-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-x-3">
                                    <button type="button" data-drawer-target="drawer-update-category"
                                        data-drawer-show="drawer-update-category" aria-controls="drawer-update-category"
                                        data-drawer-placement="right"
                                        class="updateCategoryButton inline-flex items-center justify-center w-9 h-9 rounded-lg
                                            bg-yellow-500 text-white/90 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300
                                            dark:bg-yellow-900/40 dark:text-yellow-300 dark:hover:bg-yellow-800/60 dark:focus:ring-yellow-800/50
                                            transition-all"
                                        data-id="{{ $category->id }}" data-nama="{{ $category->nama }}"
                                        data-alias="{{ $category->alias }}" data-deskripsi="{{ $category->deskripsi }}"
                                        data-category-group-id="{{ $category->category_group_id }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>

                                    </button>

                                    <form method="POST"
                                        action="{{ route('superadmin.categories.destroy', $category->id) }}"
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                                    bg-red-500 text-white/90 hover:bg-red-600 focus:ring-4 focus:ring-red-300
                                                    dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-800/60 dark:focus:ring-red-800/50
                                                    transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data
                                Kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if ($categories->hasPages())
            <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                    Menampilkan <span class="font-medium">{{ $categories->firstItem() }}</span> sampai
                    <span class="font-medium">{{ $categories->lastItem() }}</span> dari
                    <span class="font-medium">{{ $categories->total() }}</span> hasil
                </div>
                <div>
                    {{ $categories->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Drawer Create -->
    <div id="drawer-create-grup-category"
        class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-96 dark:bg-gray-800"
        tabindex="-1" aria-labelledby="drawer-label">
        <h5 id="drawer-label"
            class="inline-flex items-center mb-6 text-base font-semibold text-gray-500 dark:text-gray-400">
            Tambah Kategori Baru
        </h5>
        <button type="button" data-drawer-hide="drawer-create-grup-category" aria-controls="drawer-create-grup-category"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        {{-- NOTE: keep form id createForm WITHOUT action attribute so IS handled by AJAX.
             If you want a non-AJAX fallback, you could add action/method attributes, but
             ensure JS prevents default submit when AJAX available. --}}
        <form id="createForm" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="mb-4">
                <label for="create-nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                    Kategori<span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="create-nama" pattern="[A-Z a-z0-9,.]{0,30}"
                    placeholder="Masukkan nama kategori..." minlength="4" maxlength="20"
                    title="Only letters, numbers, and spaces allowed"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="create-alias" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alias<span
                        class="text-red-500">*</span></label>
                <input type="text" name="alias" id="create-alias" pattern="[A-Za-z0-9,-.]{0,30}"
                    placeholder="Masukkan alias..." minlength="3" maxlength="30"
                    title="Only letters, numbers, and - allowed"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="create-group" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Group<span
                        class="text-red-500">*</span></label>
                <select name="category_group_id" id="create-group"
                    class="js-select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="">Pilih Group</option>
                    @foreach ($groupCategories as $group)
                        <option value="{{ $group->id }}">{{ $group->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label for="create-deskripsi"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <textarea name="deskripsi" id="create-deskripsi" rows="3" placeholder="Deskripsi kategori..."
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>
            </div>
            <button type="submit" id="createSubmitBtn"
                class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                Simpan
            </button>
        </form>
    </div>

    <!-- Drawer Update -->
    <div id="drawer-update-group-category"
        class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-96 dark:bg-gray-800"
        tabindex="-1" aria-labelledby="drawer-label">
        <h5 id="drawer-label"
            class="inline-flex items-center mb-6 text-base font-semibold text-gray-500 dark:text-gray-400">
            Edit Kategori
        </h5>
        <button type="button" data-drawer-hide="drawer-update-group-category"
            aria-controls="drawer-update-group-category"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <form id="updateForm" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" id="update-id" name="id">
            <div class="mb-4">
                <label for="update-nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                    Kategori<span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="update-nama"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="update-alias" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alias<span
                        class="text-red-500">*</span></label>
                <input type="text" name="alias" id="update-alias"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    readonly>
            </div>
            <div class="mb-6">
                <label for="update-deskripsi"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <textarea name="deskripsi" id="update-deskripsi" rows="3"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>
            </div>
            <button type="submit" id="updateSubmitBtn"
                class="text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full dark:bg-yellow-500 dark:hover:bg-yellow-600 focus:outline-none dark:focus:ring-yellow-800">
                Perbarui
            </button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createDrawer = document.getElementById('drawer-create-grup-category');
            const updateDrawer = document.getElementById('drawer-update-group-category');

            const createForm = document.getElementById('createForm');
            const updateForm = document.getElementById('updateForm');

            const createSubmitBtn = document.getElementById('createSubmitBtn');
            const updateSubmitBtn = document.getElementById('updateSubmitBtn');

            // Helper to open/close drawers
            function openDrawer(drawer) {
                if (createDrawer) createDrawer.classList.add('translate-x-full');
                if (updateDrawer) updateDrawer.classList.add('translate-x-full');
                if (drawer) drawer.classList.remove('translate-x-full');
            }

            // CREATE - open drawer and reset
            document.getElementById('createCategoryButton').addEventListener('click', function() {
                createForm.reset();
                openDrawer(createDrawer);
            });

            // CREATE submit (AJAX)
            createForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (createSubmitBtn.disabled) return;

                const originalBtnText = createSubmitBtn.innerHTML;
                createSubmitBtn.disabled = true;
                createSubmitBtn.innerHTML = 'Menyimpan...';

                const formData = new FormData(this);

                fetch("{{ route('superadmin.categories.store') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json().then(data => ({
                        ok: response.ok,
                        data
                    })))
                    .then(({
                        ok,
                        data
                    }) => {
                        if (!ok) {
                            let errorMessage = data.message || 'Terjadi kesalahan.';
                            if (data.errors) {
                                errorMessage += '<br><br>' + Object.values(data.errors).flat().join(
                                    '<br>');
                            }
                            Swal.fire({
                                title: 'Gagal!',
                                html: errorMessage,
                                icon: 'error'
                            });
                            return;
                        }

                        Swal.fire('Berhasil!', 'Data kategori berhasil ditambahkan!', 'success').then(
                            () => location.reload());
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        Swal.fire('Error!', 'Gagal menyimpan data. Cek koneksi atau coba lagi.',
                            'error');
                    })
                    .finally(() => {
                        createSubmitBtn.disabled = false;
                        createSubmitBtn.innerHTML = originalBtnText;
                    });
            });

            // UPDATE - open drawer and fill form
            document.querySelectorAll('.updateCategoryGroupButton').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;
                    const alias = this.dataset.alias;
                    const deskripsi = this.dataset.deskripsi;
                    const groupId = this.dataset.categoryGroupId;

                    updateForm.querySelector('#update-id').value = id;
                    updateForm.querySelector('#update-nama').value = nama;
                    updateForm.querySelector('#update-alias').value = alias;
                    updateForm.querySelector('#update-deskripsi').value = deskripsi;
                    updateForm.querySelector('#update-group').value = groupId;

                    openDrawer(updateDrawer);
                });
            });

            // UPDATE submit (AJAX)
            updateForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (updateSubmitBtn.disabled) return;

                const originalBtnText = updateSubmitBtn.innerHTML;
                updateSubmitBtn.disabled = true;
                updateSubmitBtn.innerHTML = 'Memperbarui...';

                const id = document.getElementById('update-id').value;
                const formData = new FormData(this);
                formData.append('_method', 'PUT');

                fetch("{{ url('superadmin/categories') }}/" + id, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json().then(data => ({
                        ok: response.ok,
                        data
                    })))
                    .then(({
                        ok,
                        data
                    }) => {
                        if (!ok) {
                            let errorMessage = data.message || 'Terjadi kesalahan.';
                            if (data.errors) {
                                errorMessage += '<br><br>' + Object.values(data.errors).flat().join(
                                    '<br>');
                            }
                            Swal.fire({
                                title: 'Gagal!',
                                html: errorMessage,
                                icon: 'error'
                            });
                            return;
                        }

                        Swal.fire('Berhasil!', data.message || 'Data berhasil diperbarui.', 'success')
                            .then(() => location.reload());
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        Swal.fire('Error!', 'Gagal memperbarui data.', 'error');
                    })
                    .finally(() => {
                        updateSubmitBtn.disabled = false;
                        updateSubmitBtn.innerHTML = originalBtnText;
                    });
            });

            // Close drawers on button click
            document.querySelectorAll('[data-drawer-hide]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const target = document.getElementById(this.getAttribute('data-drawer-hide'));
                    if (target) {
                        target.classList.add('translate-x-full');
                    }
                });
            });
        });
    </script>
@endpush
