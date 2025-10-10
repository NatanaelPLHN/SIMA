@csrf

<!-- NIP -->
<div>
    <label for="nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIP<span
            class="text-red-500">*</span></label>
    <input type="number" id="nip" name="nip" value="{{ old('nip', $employee->nip ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<!-- Nama -->
<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama <span
            class="text-red-500">*</span></label>
    <input type="text" id="nama" name="nama" value="{{ old('nama', $employee->nama ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<!-- Alamat -->
<div>
    <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
    <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $employee->alamat ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"">
</div>

<!-- Telepon -->
<div>
    <label for=" telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telepon</label>
    <input type="number" id="telepon" min="0" name="telepon" value="{{ old('telepon', $employee->telepon ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"">
</div>
@php
    $user = Auth::user();
    $isSuperAdmin = $user->hasRole('superadmin');
    $isAdmin = $user->hasRole('admin');
    $isSubAdmin = $user->hasRole('subadmin');
@endphp
<!-- Alpine.js Dependent Dropdown -->
<div x-data=" { selectedInstitution: '{{ old('institution_id', $employee->institution_id ?? '') }}' ,
        selectedDepartment: '{{ old('department_id', $employee->department_id ?? '') }}' , departments: {{ Js::from($departements) }}, get filteredDepartments() { if (!this.selectedInstitution) return []; return
        this.departments.filter(dept=> dept.instansi_id == this.selectedInstitution);
    }
    }" x-init="$watch('selectedInstitution', () => {
    // Opsional: reset department jika tidak valid
    if (this.selectedInstitution && !this.filteredDepartments.some(d => d.id == this.selectedDepartment)) {
    this.selectedDepartment = '';
    }
    });">

    @if ($isSuperAdmin)
        <!-- Tampilan untuk Superadmin -->
        <div>
            <label for="institution_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instansi</label>
            <select name="institution_id" id="institution_id" x-model="selectedInstitution" class="js-select2 mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3
                        bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400
                        focus:border-indigo-500 dark:focus:border-indigo-400">
                <option value="">Pilih Instansi</option>
                @foreach ($institutions as $institution)
                    <option value="{{ $institution->id }}" @selected(old('institution_id', $employee->institution_id ?? '') == $institution->id)>
                        {{ $institution->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- <div class="mt-4">
            <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bidang</label>
            <select name="department_id" id="department_id" x-model="selectedDepartment"
                :disabled="!selectedInstitution || {{ isset($isInstitutionHead) && $isInstitutionHead ? 'true' : 'false' }}"
                class=" mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3
                        bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400
                        focus:border-indigo-500 dark:focus:border-indigo-400
                        disabled:bg-gray-100 disabled:dark:bg-gray-700 disabled:opacity-100">
                <option value="">Pilih Bidang</option>
                <template x-for="department in filteredDepartments" :key="department.id">
                    <option :value="department.id" x-text="department.nama" :selected="department.id == selectedDepartment">
                    </option>
                </template>
            </select>
            @if (isset($isInstitutionHead) && $isInstitutionHead)
            <small class="mt-1 text-sm text-red-500 dark:text-red-400">Tidak dapat mengubah bidang karena karyawan ini
                adalah Kepala Instansi.</small>
            @endif
        </div> --}}

    @elseif ($isAdmin)
        {{-- <div class="grid grid-cols-1 sm:grid-cols-[140px_1fr] gap-3 items-start sm:items-center">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 pt-2">Instansi</label>
            <div
                class="p-3 bg-indigo-100 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-700 rounded-md min-h-[42px] flex items-center">
                <p class="font-semibold text-indigo-800 dark:text-indigo-200 break-words">
                    {{ $user->employee?->institution->nama }}
                </p>
            </div>
        </div> --}}

        <div class="mt-2">
            <label for="department_id"
                class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Bidang</label>
            <select name="department_id" id="department_id" class="js-select2 mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3
                        bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400
                        focus:border-indigo-500 dark:focus:border-indigo-400">
                <option value="">Pilih Bidang</option>
                @foreach ($departements as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id ?? '') == $department->id)>
                        {{ $department->nama }}
                    </option>
                @endforeach
            </select>
        </div>

    @elseif ($isSubAdmin)
        <div class="grid grid-cols-1 sm:grid-cols-[140px_1fr] gap-3 items-start sm:items-center">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 pt-2">Instansi</label>
            <div
                class="p-3 bg-indigo-100 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-700 rounded-md min-h-[42px] flex items-center">
                <p class="font-semibold text-indigo-800 dark:text-indigo-200 break-words">
                    {{ $user->employee?->institution?->nama ?? '–' }}
                </p>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-[140px_1fr] gap-3 items-start sm:items-center">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 pt-2">Bidang</label>
            <div
                class="p-3 bg-indigo-100 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-700 rounded-md min-h-[42px] flex items-center">
                <p class="font-semibold text-indigo-800 dark:text-indigo-200 break-words">
                    {{ $user->employee?->department?->nama ?? '–' }}
                </p>
            </div>
        </div>
    @endif

    @error('department_id')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>