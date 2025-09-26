@extends('layouts.app')

@section('title', 'Manajemen Kategori')
@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Table Controls -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-2">
                <label for="entries" class="text-sm font-medium text-gray-700">Tampilkan</label>
                <select id="entries"
                    class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <span class="text-sm text-gray-700">entri</span>
            </div>

            <div class="flex items-center space-x-2">
                <label for="search" class="text-sm font-medium text-gray-700">Cari:</label>
                <input type="text" id="search"
                    class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button id="addcategoryBtn"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                    Tambah
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-800">
                <tr>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">No</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Deskripsi
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Group</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Alias</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($categories as $index => $category)
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-center">{{ $category->nama }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">{{ $category->deskripsi }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">{{ $category->categoryGroup->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">{{ $category->alias }}</td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex items-center justify-center gap-x-3">
                            {{-- Edit button --}}
                            <button class="fas fa-edit text-yellow-600 hover:text-yellow-800 edit-btn"
                                data-id="{{ $category->id }}" data-nama="{{ $category->nama }}"
                                data-alias="{{ $category->alias }}" data-deskripsi="{{ $category->deskripsi }}"
                                data-grupcategory="{{ $category->groupCategory->nama ?? '-' }}">
                            </button>
                            <form method="POST" action="{{ route('superadmin.categories.destroy', $category->id) }}"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button class="fas fa-trash text-red-600 hover:text-red-800" type="submit"></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addcategoryBtn = document.getElementById('addcategoryBtn');

        // Tambah kategori
        addcategoryBtn.addEventListener('click', function () {
            showCategoryModal('Tambah Kategori', {});
        });

        // Edit kategori
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const category = {
                    id: this.dataset.id,
                    nama: this.dataset.nama,
                    alias: this.dataset.alias,
                    deskripsi: this.dataset.deskripsi,
                    grupcategory: this.dataset.grupcategory
                };
                showCategoryModal('Edit Kategori', category);
            });
        });

        // Modal form
        function showCategoryModal(title, category = {}) {
            const isEdit = category.id ? true : false;

            Swal.fire({
                title: title,
                html: `
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" id="nama" value="${category.nama || ''}" class="w-full px-3 py-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alias <span class="text-red-500">*</span></label>
                        ${isEdit
                        ? `<input type="text" id="alias" value="${category.alias || ''}" class="w-full px-3 py-2 border rounded-md bg-gray-100" readonly>`
                        : `<input type="text" id="alias" value="" class="w-full px-3 py-2 border rounded-md">`
                    }
                        </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea id="deskripsi" rows="3" class="w-full px-3 py-2 border rounded-md">${category.deskripsi || ''}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Group Category <span class="text-red-500">*</span></label>
                        <select id="groupCategoryId" class="w-full px-3 py-2 border rounded-md">
                            @foreach($groupCategories as $gc)
                                <option value="{{ $gc->id }}">{{ $gc->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    ${isEdit ? `<input type="hidden" id="categoryId" value="${category.id}">` : ''}
                </div>
            `,
                showCancelButton: true,
                confirmButtonText: isEdit ? 'Update Data' : 'Simpan Data',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const nama = document.getElementById('nama').value.trim();
                    const alias = document.getElementById('alias').value.trim();
                    const categoryGroupId = document.getElementById('groupCategoryId').value;

                    if (!nama || !alias) {
                        Swal.showValidationMessage('Nama dan Alias wajib diisi!');
                        return false;
                    }

                    return {
                        nama,
                        alias,
                        deskripsi: document.getElementById('deskripsi').value,
                        category_group_id: categoryGroupId,
                        id: isEdit ? document.getElementById('categoryId').value : null
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (isEdit) {
                        updateCategory(result.value);
                    } else {
                        createCategory(result.value);
                    }
                }
            });
        }

        // Create
        function createCategory(data) {
            fetch("{{ route('superadmin.categories.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
                .then(handleResponse)
                .then(() => location.reload()) // reload supaya alert dari session muncul
                .catch(() => location.reload());
        }

        // Update
        function updateCategory(data) {
            fetch("{{ url('superadmin/categories') }}/" + data.id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
                .then(handleResponse)
                .then(() => location.reload())
                .catch(() => location.reload());
        }

        // Response handler
        function handleResponse(response) {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        }
    });
</script>
@endsection