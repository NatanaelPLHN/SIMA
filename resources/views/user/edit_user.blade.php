@extends('layouts.app')

@section('title', 'Ubah Akun')

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            {{-- <h1 class="text-lg font-semibold text-indigo-800 dark:text-indigo-400">Ubah Akun</h1> --}}
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            @switch(auth()->user()->role)
                                @case('superadmin')
                                    <a href="{{ route('superadmin.dashboard') }}"
                                        class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                        <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        Dashboard
                                    </a>
                                @break

                                @case('admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                        <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        Dashboard
                                    </a>
                                @break

                                @case('subadmin')
                                    <a href="{{ route('subadmin.dashboard') }}"
                                        class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                        <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        Dashboard
                                    </a>
                                @break

                                @case('user')
                                    <a href="{{ route('user.dashboard') }}"
                                        class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                        <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        Dashboard
                                    </a>
                                @break
                            @endswitch
                        </li>
                        <li class="inline-flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ routeForRole('user', 'index') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                Daftar Akun
                            </a>
                            </svg>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">
                                    Ubah Akun</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Ubah Akun</h1>
            </div>
            <div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-lg p-6">
                <form action="{{ routeForRole('user', 'update', $user) }}" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Form Groups -->
                    @csrf
                    @method('PUT')

                    {{-- =================================================================== --}}
                    {{--                        INFORMASI AKUN SAAT INI                        --}}
                    {{-- =================================================================== --}}
                    <div
                        class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 p-4 border rounded-lg dark:border-gray-700">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Role</label>
                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ Str::ucfirst($user->role) }}</p>
                        </div>
                        @if ($user->employee)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Karyawan
                                    Tertaut</label>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $user->employee->nama }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Instansi</label>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $user->employee->institution->nama }}</p>
                            </div>
                            @if ($user->employee->department)
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-gray-400">Departemen</label>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $user->employee->department->nama }}</p>
                                </div>
                            @endif
                        @endif
                    </div>


                    {{-- =================================================================== --}}
                    {{--                           UBAH DATA AKUN                            --}}
                    {{-- =================================================================== --}}
                    <div class="md:col-span-2 mt-4">
                        <h3
                            class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-t pt-4 dark:border-gray-700">
                            Ubah Data</h3>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email<span
                                class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
                            placeholder="Kosongkan jika tidak diubah">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password
                            Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    {{-- Tombol untuk menampilkan/menyembunyikan form perubahan role/karyawan --}}
                    <div class="md:col-span-2">
                        <button type="button" id="change-role-employee-btn"
                            class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                            Ubah Role atau Karyawan Tertaut
                        </button>
                    </div>

                    {{-- =================================================================== --}}
                    {{--                  FORM DINAMIS UBAH ROLE & KARYAWAN                  --}}
                    {{-- =================================================================== --}}
                    <div id="change-role-employee-section"
                        class="hidden md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 border-t pt-4 dark:border-gray-700">

                        {{-- Role --}}
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Role Baru <span class="text-red-500">*</span>
                            </label>
                            <select id="role" name="role" class="w-full select2-class">
                                <option value="">-- Pilih Role Baru --</option>
                                @php
                                    $auth_user = auth()->user();
                                    $roles = [];
                                    if ($auth_user->isSuperAdmin()) {
                                        $roles = ['admin' => 'Admin', 'subadmin' => 'Sub Admin', 'user' => 'User'];
                                    } elseif ($auth_user->isAdmin()) {
                                        $roles = ['subadmin' => 'Sub Admin', 'user' => 'User'];
                                    } elseif ($auth_user->isSubAdmin()) {
                                        $roles = ['user' => 'User'];
                                    }
                                @endphp
                                @foreach ($roles as $key => $value)
                                    <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Placeholder to maintain grid layout --}}
                        <div></div>

                        {{-- Institution --}}
                        <div id="institution-wrapper" class="hidden">
                            <label for="institution_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Instansi <span id="institution-required" class="text-red-500 hidden">*</span>
                            </label>
                            <select id="institution_id" name="institution_id" class="w-full select2-class">
                                <option value="">-- Pilih Instansi --</option>
                            </select>
                            @error('institution_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Department --}}
                        <div id="department-wrapper" class="hidden">
                            <label for="department_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Departemen <span id="department-required" class="text-red-500 hidden">*</span>
                            </label>
                            <select id="department_id" name="department_id" class="w-full select2-class">
                                <option value="">-- Pilih Departemen --</option>
                            </select>
                            @error('department_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Employee --}}
                        <div id="employee-wrapper" class="hidden">
                            <label for="karyawan_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Karyawan <span class="text-red-500">*</span>
                            </label>
                            <select id="karyawan_id" name="karyawan_id" class="w-full select2-class">
                                <option value="">-- Pilih Karyawan --</option>
                            </select>
                            <small class="text-gray-500 dark:text-gray-400">Hanya menampilkan karyawan yang belum memiliki
                                akun.</small>
                            @error('karyawan_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <!-- Buttons -->
                    <div class="md:col-span-2 mt-6 flex justify-end space-x-3">
                        <a href="{{ routeForRole('user', 'index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-600 dark:focus:ring-offset-gray-800 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800 transition-colors">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2
            $('.select2-class').select2({
                width: '100%',
                theme: 'bootstrap-5' // Or any other theme you prefer
            });

            const changeBtn = document.getElementById('change-role-employee-btn');
            const changeSection = document.getElementById('change-role-employee-section');

            const roleSelect = $('#role');
            const institutionSelect = $('#institution_id');
            const departmentSelect = $('#department_id');
            const employeeSelect = $('#karyawan_id');

            const institutionWrapper = $('#institution-wrapper');
            const departmentWrapper = $('#department-wrapper');
            const employeeWrapper = $('#employee-wrapper');

            const institutionRequired = $('#institution-required');
            const departmentRequired = $('#department-required');

            // Toggle visibility of the change section
            changeBtn.addEventListener('click', () => {
                changeSection.classList.toggle('hidden');
                // Remove karyawan_id from the main form submission if section is hidden
                if (changeSection.classList.contains('hidden')) {
                    employeeSelect.prop('disabled', true);
                    roleSelect.val('').trigger('change'); // Reset role selection
                } else {
                    employeeSelect.prop('disabled', false);
                }
            });


            function resetAndHideAll() {
                institutionWrapper.addClass('hidden');
                departmentWrapper.addClass('hidden');
                employeeWrapper.addClass('hidden');
                institutionRequired.addClass('hidden');
                departmentRequired.addClass('hidden');

                institutionSelect.empty().append('<option value="">-- Pilih Instansi --</option>').trigger(
                    'change');
                departmentSelect.empty().append('<option value="">-- Pilih Departemen --</option>').trigger(
                    'change');
                employeeSelect.empty().append('<option value="">-- Pilih Karyawan --</option>').trigger('change');
            }

            roleSelect.on('change', function() {
                const role = $(this).val();
                resetAndHideAll();

                if (!role) return;

                employeeWrapper.removeClass('hidden');

                if (role === 'admin' || role === 'subadmin' || role === 'user') {
                    institutionWrapper.removeClass('hidden');
                    fetchInstitutions(role);
                }

                if (role === 'subadmin' || role === 'user') {
                    departmentWrapper.removeClass('hidden');
                }

                // Mark as required
                if (role === 'admin' || role === 'subadmin') {
                    institutionRequired.removeClass('hidden');
                }
                if (role === 'subadmin') {
                    departmentRequired.removeClass('hidden');
                }
            });

            institutionSelect.on('change', function() {
                const institutionId = $(this).val();
                const role = roleSelect.val();

                departmentSelect.empty().append('<option value="">-- Pilih Departemen --</option>').trigger(
                    'change');
                employeeSelect.empty().append('<option value="">-- Pilih Karyawan --</option>').trigger(
                    'change');

                if (institutionId && (role === 'subadmin' || role === 'user')) {
                    fetchDepartments(role, institutionId);
                }
                if (institutionId) {
                    fetchEmployees();
                }
            });

            departmentSelect.on('change', function() {
                employeeSelect.empty().append('<option value="">-- Pilih Karyawan --</option>').trigger(
                    'change');
                if ($(this).val()) {
                    fetchEmployees();
                }
            });

            function fetchInstitutions(role) {
                const targetUserId = {{ $user->id }};
                let url = new URL("{{ route('users.ajax.get-institutions') }}");
                url.searchParams.append('role', role);
                url.searchParams.append('user_id', targetUserId);
                
                $.getJSON(url.toString(), function(data) {
                    institutionSelect.empty().append('<option value="">-- Pilih Instansi --</option>');
                    $.each(data, function(key, value) {
                        institutionSelect.append(
                            `<option value="${value.id}">${value.nama}</option>`);
                    });
                    institutionSelect.trigger('change');
                });
            }

            function fetchDepartments(role, institutionId) {
                let url = new URL("{{ route('users.ajax.get-departments') }}");
                url.searchParams.append('role', role);
                url.searchParams.append('institution_id', institutionId);

                $.getJSON(url.toString(), function(data) {
                    departmentSelect.empty().append('<option value="">-- Pilih Departemen --</option>');
                    $.each(data, function(key, value) {
                        departmentSelect.append(
                            `<option value="${value.id}">${value.nama}</option>`);
                    });
                    departmentSelect.trigger('change');
                });
            }

            function fetchEmployees() {
                const institutionId = institutionSelect.val();
                const departmentId = departmentSelect.val();
                
                if (!institutionId && !departmentId) {
                    return; // Do not fetch if no filter is selected
                }

                let url = new URL("{{ route('users.ajax.get-employees') }}");
                if (departmentId) {
                    url.searchParams.append('department_id', departmentId);
                } else if (institutionId) {
                    url.searchParams.append('institution_id', institutionId);
                }

                $.getJSON(url.toString(), function(data) {
                    employeeSelect.empty().append('<option value="">-- Pilih Karyawan --</option>');
                    // IMPORTANT: Also add the currently selected employee to the list, in case we need to re-select them
                    const currentEmployeeId = {{ $user->karyawan_id ?? 'null' }};
                    const currentEmployeeName = '{{ $user->employee->nama ?? '' }}';
                    if (currentEmployeeId) {
                        employeeSelect.append(
                            `<option value="${currentEmployeeId}" selected>${currentEmployeeName} (Saat Ini)</option>`
                        );
                    }

                    $.each(data, function(key, value) {
                        // Avoid adding the current employee twice
                        if (value.id != currentEmployeeId) {
                            employeeSelect.append(
                                `<option value="${value.id}">${value.nama}</option>`);
                        }
                    });
                    employeeSelect.trigger('change');
                });
            }
        });
    </script>
@endpush
