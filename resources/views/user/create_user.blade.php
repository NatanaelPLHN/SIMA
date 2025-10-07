@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-lg font-semibold text-indigo-800">Tambah User</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form action="{{ routeForRole('user', 'store') }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols gap-6">
            <!-- Form Groups -->
            @php $user_role = auth()->user()->role; @endphp
            <!-- Filter untuk Superadmin -->
            @if ($user_role === 'superadmin')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="institution-filter" class="block text-sm font-medium text-gray-700 mb-1">Pilih
                            Instansi</label>
                        <select id="institution-filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">-- Pilih Instansi --</option>
                            @foreach ($institutions as $institution)
                                <option value="{{ $institution->id }}">{{ $institution->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="department-filter" class="block text-sm font-medium text-gray-700 mb-1">Pilih
                            Bidang</label>
                        <select id="department-filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            disabled>
                            <option value="">-- Pilih Instansi Dulu --</option>
                        </select>
                    </div>
                </div>
            @endif

            <!-- Filter untuk Admin -->
            @if ($user_role === 'admin')
                <div class="mb-4">
                    <label for="department-filter" class="block text-sm font-medium text-gray-700 mb-1">Pilih Bidang</label>
                    <select id="department-filter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Bidang --</option>
                        @foreach ($departements as $department)
                            <option value="{{ $department->id }}">{{ $department->nama }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @include('user._user')

            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ routeForRole('user', 'index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userRole = '{{ auth()->user()->role }}';

            const institutionSelect = document.getElementById('institution-filter');
            const departmentSelect = document.getElementById('department-filter');
            const employeeSelect = document.getElementById('karyawan_id');

            // Fungsi untuk mengosongkan dan menonaktifkan select
            const resetSelect = (select, message) => {
                select.innerHTML = `<option value="">-- ${message} --</option>`;
                select.disabled = true;
            };

            // Fungsi untuk mengisi select dengan data dari API
            const populateSelect = (select, data, message) => {
                resetSelect(select, message);
                if (data.length > 0) {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.nama;
                        select.appendChild(option);
                    });
                    select.disabled = false;
                }
            };

            // Event listener untuk Superadmin
            if (userRole === 'superadmin') {
                institutionSelect.addEventListener('change', function() {
                    const institutionId = this.value;
                    resetSelect(employeeSelect, 'Pilih Bidang Dulu');

                    if (institutionId) {
                        fetch(`/api/departements/${institutionId}`)
                            .then(response => response.json())
                            .then(data => {
                                populateSelect(departmentSelect, data, 'Pilih Bidang');
                            });
                    } else {
                        resetSelect(departmentSelect, 'Pilih Instansi Dulu');
                    }
                });
            }

            // Event listener untuk Superadmin dan Admin
            if (userRole === 'superadmin' || userRole === 'admin') {
                departmentSelect.addEventListener('change', function() {
                    const departmentId = this.value;
                    if (departmentId) {
                        fetch(`/api/employees/${departmentId}`)
                            .then(response => response.json())
                            .then(data => {
                                populateSelect(employeeSelect, data, 'Pilih Karyawan');
                            });
                    } else {
                        resetSelect(employeeSelect, 'Pilih Bidang Dulu');
                    }
                });
            }
        });
    </script>
@endpush
