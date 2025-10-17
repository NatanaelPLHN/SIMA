@extends('layouts.app')

@section('title', 'Tambah Akun')

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('superadmin.dashboard') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ routeForRole('user', 'index') }}"
                                    class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Daftar Akun</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2 dark:text-gray-500"
                                    aria-current="page">Tambah Akun</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Buat Akun Baru</h1>
            </div>
        </div>
    </div>

    <div class="p-4">
        <div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ routeForRole('user', 'store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div>
                            <label for="role"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Role <span
                                    class="text-red-500">*</span></label>
                            <select id="role" name="role"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                required>
                                <option value="" selected disabled>-- Pilih Role --</option>
                                @foreach ($roles as $key => $value)
                                    <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                    {{ $message }}</p>
                            @enderror
                        </div>

                        <div id="institution-wrapper" class="hidden">
                            <label for="institution_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Instansi <span
                                    class="text-red-500">*</span></label>
                            <select id="institution_id" name="institution_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Pilih Instansi --</option>
                            </select>
                            @error('institution_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="department-wrapper" class="hidden">
                            <label for="department_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departemen <span
                                    class="text-red-500">*</span></label>
                            <select id="department_id" name="department_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Pilih Departemen --</option>
                            </select>
                            @error('department_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="employee-wrapper" class="hidden">
                            <label for="karyawan_id"
                                class="block mb-2 text-sm font-medium
       text-gray-900 dark:text-white">Pegawai <span
                                    class="text-red-500">*</span></label>
                            <select id="karyawan_id" name="karyawan_id"
                                class="bg-gray-50 border
       border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500
       focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
       dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Pilih Pegawai --</option>
                            </select>
                            @error('karyawan_id')
                                <p class="mt-2 text-sm text-red-600
       dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900
       dark:text-white">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border
       border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600
       focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
       dark:placeholder-gray-400 dark:text-white"
                                placeholder="nama@email.com" required value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                    {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium
       text-gray-900 dark:text-white">Password <span
                                    class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password"
                                class="bg-gray-50
       border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600
       focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
       dark:placeholder-gray-400 dark:text-white"
                                placeholder="••••••••" required>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600
       dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation"
                                class="block mb-2 text-sm
       font-medium text-gray-900 dark:text-white">Konfirmasi
                                Password <span class="text-red-500">*</ span></label>
                            <input type="password" name="password_confirmation" id=
       "password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
       rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700
       dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 mt-6 flex justify-end space-x-3">
                    <a href="{{ routeForRole('user', 'index') }}"
                        class="px-4 py-2 bg-gray-500
       text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500
       focus:ring-offset-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-600
       dark:focus:ring-offset-gray-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md
       hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2
       dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-600
       dark:focus:ring-offset-gray-800 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const institutionWrapper = document.getElementById('institution-wrapper');
            const institutionSelect = document.getElementById('institution_id');
            const departmentWrapper = document.getElementById('department-wrapper');
            const departmentSelect = document.getElementById('department_id');
            const employeeWrapper = document.getElementById('employee-wrapper');
            const employeeSelect = document.getElementById('karyawan_id');

            // --- Event Listeners ---
            roleSelect.addEventListener('change', handleRoleChange);
            institutionSelect.addEventListener('change', handleInstitutionChange);
            departmentSelect.addEventListener('change', handleDepartmentChange);

            // --- Initial State ---
            if (roleSelect.value) {
                handleRoleChange();
            }

            // --- Handlers ---
            function handleRoleChange() {
                const role = roleSelect.value;
                resetAllSelects();

                if (!role) return;

                institutionWrapper.classList.remove('hidden');
                departmentWrapper.classList.toggle('hidden', role === 'admin');
                employeeWrapper.classList.remove('hidden');

                const institutionLabel = institutionWrapper.querySelector('label');
                const departmentLabel = departmentWrapper.querySelector('label');

                institutionLabel.innerHTML = `Instansi <span class="text-red-500">*</span>`;
                departmentLabel.innerHTML = `Departemen <span class="text-red-500">*</span>`;

                if (role === 'user') {
                    institutionLabel.innerHTML = 'Instansi (Filter Opsional)';
                    departmentLabel.innerHTML = 'Departemen (Filter Opsional)';
                }

                fetchInstitutions(role);
                fetchEmployees();
            }

            function handleInstitutionChange() {
                const role = roleSelect.value;
                const institutionId = institutionSelect.value;
                resetSelect(departmentSelect, '-- Pilih Departemen --');
                resetSelect(employeeSelect, '-- Pilih Pegawai --');

                if (role === 'admin' || role === 'user') {
                    fetchEmployees(institutionId);
                } else if (role === 'subadmin') {
                    fetchDepartments(institutionId);
                }
            }

            function handleDepartmentChange() {
                const institutionId = institutionSelect.value;
                const departmentId = departmentSelect.value;
                resetSelect(employeeSelect, '-- Pilih Pegawai --');
                fetchEmployees(institutionId, departmentId);
            }

            // --- Fetch Functions ---
            function fetchInstitutions(role) {
                fetch(`{{ route('users.ajax.get-institutions') }}?role=${role}`)
                    .then(response => response.json())
                    .then(data => {
                        populateSelect(institutionSelect, data, '-- Pilih Instansi --');
                    });
            }

            function fetchDepartments(institutionId) {
                const role = roleSelect.value;
                if (!institutionId) return;
                fetch(`{{ route('users.ajax.get-departments') }}?role=${role}&institution_id=
      ${institutionId}`)
                    .then(response => response.json())
                    .then(data => {
                        populateSelect(departmentSelect, data, '-- Pilih Departemen --');
                    });
            }

            function fetchEmployees(institutionId = '', departmentId = '') {
                let url = new URL('{{ route('users.ajax.get-employees') }}');
                if (institutionId) url.searchParams.append('institution_id', institutionId);
                if (departmentId) url.searchParams.append('department_id', departmentId);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        populateSelect(employeeSelect, data, '-- Pilih Pegawai --');
                    });
            }

            // --- Helper Functions ---
            function resetAllSelects() {
                institutionWrapper.classList.add('hidden');
                departmentWrapper.classList.add('hidden');
                employeeWrapper.classList.add('hidden');
                resetSelect(institutionSelect, '-- Pilih Instansi --');
                resetSelect(departmentSelect, '-- Pilih Departemen --');
                resetSelect(employeeSelect, '-- Pilih Pegawai --');
            }

            function resetSelect(selectElement, defaultText) {
                selectElement.innerHTML = `<option value="">${defaultText}</option>`;
            }

            function populateSelect(selectElement, data, defaultText) {
                resetSelect(selectElement, defaultText);
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.nama;
                    selectElement.appendChild(option);
                });
            }
        });
    </script>
@endpush
