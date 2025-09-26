@extends('layouts.app')

@section('title', 'Manajemen Group Kategori')
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
                <button id="addGroupBtn"
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
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        No</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Nama</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Deskripsi</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Alias</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($categoryGroups as $index => $categoryGroup)
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">{{ $categoryGroup->nama }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">{{ $categoryGroup->deskripsi }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-center whitespace-normal break-words">{{ $categoryGroup->alias }}</td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex items-center justify-center gap-x-3">
                            {{-- Edit button dengan data attributes --}}
                            <button class="fas fa-edit text-yellow-600 hover:text-yellow-800 edit-btn"
                                data-id="{{ $categoryGroup->id }}" data-nama="{{ $categoryGroup->nama }}"
                                data-alias="{{ $categoryGroup->alias }}"
                                data-deskripsi="{{ $categoryGroup->deskripsi }}">
                            </button>
                            <form method="POST"
                                action="{{ route('superadmin.category-groups.destroy', $categoryGroup) }}"
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
        {{ $categoryGroups->links() }}
    </div>
</div>

<!-- Modal Form -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addGroupBtn = document.getElementById('addGroupBtn');

        // Add event listener to the add button
        addGroupBtn.addEventListener('click', function () {
            showCategoryGroupModal('Tambah Group Kategori', {});
        });

        // Add event listeners to edit buttons
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const categoryGroup = {
                    id: this.dataset.id,
                    nama: this.dataset.nama,
                    alias: this.dataset.alias,
                    deskripsi: this.dataset.deskripsi
                };
                showCategoryGroupModal('Edit Group Kategori', categoryGroup);
            });
        });

        // Function to show modal
        function showCategoryGroupModal(title, categoryGroup = {}) {
            const isEdit = categoryGroup.id ? true : false;

            Swal.fire({
                title: title,
                html: `
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Group <span class="text-red-500">*</span></label>
                                <input type="text" id="nama" name="nama" value="${categoryGroup.nama || ''}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="Contoh: Elektronik, Kendaraan">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alias <span class="text-red-500">*</span></label>
                                ${isEdit
                                ? `<input type="text" id="alias" value="${categoryGroup.alias || ''}" class="w-full px-3 py-2 border rounded-md bg-gray-100" readonly>`
                                : `<input type="text" id="alias" value="" class="w-full px-3 py-2 border rounded-md">`}

                                </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea id="deskripsi" rows="3" name="deskripsi"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="Deskripsi singkat tentang group kategori ini...">${categoryGroup.deskripsi || ''}</textarea>
                            </div>
                            ${isEdit ? `<input type="hidden" id="categoryId" value="${categoryGroup.id}">` : ''}
                        </div>
                    `,
                showCancelButton: true,
                confirmButtonText: isEdit ? 'Update Data' : 'Simpan Data',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-lg',
                    header: 'bg-indigo-800 text-white',
                    confirmButton: 'bg-green-500 hover:bg-green-600 text-white',
                    cancelButton: 'bg-gray-500 hover:bg-gray-600 text-white'
                },
                preConfirm: () => {
                    const nama = document.getElementById('nama').value.trim();
                    const alias = document.getElementById('alias').value.trim();

                    if (!nama || !alias) {
                        Swal.showValidationMessage('Nama dan Alias wajib diisi!');
                        return false;
                    }

                    return {
                        nama: nama,
                        alias: alias,
                        deskripsi: document.getElementById('deskripsi').value,
                        id: isEdit ? document.getElementById('categoryId')?.value : null
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (isEdit) {
                        // Update existing category group
                        updateCategoryGroup(result.value);
                    } else {
                        // Create new category group
                        createCategoryGroup(result.value);
                    }
                }
            });
        }

        // Function to create category group
        function createCategoryGroup(data) {
            fetch("{{ route('superadmin.category-groups.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nama: data.nama,
                    alias: data.alias,
                    deskripsi: data.deskripsi
                })
            })

                .then(handleResponse)
                .then(showSuccessMessage)
                .catch(showErrorMessage);
        }

        // Function to update category group
        function updateCategoryGroup(data) {
            fetch("{{ url('superadmin/category-groups') }}/" + data.id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nama: data.nama,
                    alias: data.alias,
                    deskripsi: data.deskripsi
                })
            })
                .then(handleResponse)
                .then(showSuccessMessage)
                .catch(showErrorMessage);
        }

        // Function to handle response
        function handleResponse(response) {
            console.log('Response status:', response.status);
            console.log('Response headers:', [...response.headers.entries()]);

            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                return response.text().then(text => {
                    console.log('Response text:', text);
                    if (response.status === 200 || response.status === 201 || response.status === 204) {
                        return { success: true, message: 'Operasi berhasil.' };
                    }
                    throw new Error('Invalid response format');
                });
            }
        }

        // Function to show success message
        function showSuccessMessage(data) {
            if (data.success) {
                location.reload(); // reload saja, jangan munculkan swal di JS
            }
        }

        function showErrorMessage(error) {
            console.error('Error:', error);
            location.reload(); // reload juga
        }

        // Function to show error message
        // function showErrorMessage(error) {
        //     console.error('Error:', error);
        //     Swal.fire({
        //         icon: 'success',
        //         title: 'Bessssssssssssssssssssssssssssssssrhasil!',
        //         text: 'Operasi berhasil.',
        //         customClass: {
        //             popup: 'rounded-lg',
        //             confirmButton: 'bg-green-500 hover:bg-green-600 text-white'
        //         }
        //     }).then(() => {
        //         location.reload();
        //     });
        // }
    });
</script>
@endsection