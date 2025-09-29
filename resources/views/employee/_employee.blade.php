@csrf
<div>
    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP<span class="text-red-500">*</span></label>
    <input type="number" id="nip" min="0" name="nip"
    value="{{ old('nip', $employee->nip ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama<span class="text-red-500">*</span></label>
    <input type="text" id="nama" name="nama"
    value="{{ old('nama', $employee->nama ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
    <input type="text" id="alamat" name="alamat"
    value="{{ old('alamat', $employee->alamat ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
    <input type="number" id="telepon" min="0" name="telepon"
    value="{{ old('telepon', $employee->telepon ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<!-- Alpine.js Dependent Dropdown -->
<div x-data="{
    selectedInstitution: '{{ old('institution_id', $employee->department->instansi_id ?? '') }}',
    selectedDepartment: '{{ old('department_id', $employee->department_id ?? '') }}',
    departments: {{ Js::from($departements) }},
    get filteredDepartments() {
        if (!this.selectedInstitution) {
            return [];
        }
        return this.departments.filter(dept => dept.instansi_id == this.selectedInstitution);
    }
}" x-init="
    $watch('selectedInstitution', (value) => {
        // When institution changes, check if the selected department is still valid. If not, reset it.
        if (!filteredDepartments.some(d => d.id == selectedDepartment)) {
            selectedDepartment = '';
        }
    });
">
    <!-- Institution Dropdown -->
    <div>
        <label for="institution_id" class="block text-sm font-medium text-gray-700">Instansi</label>
        <select name="institution_id" id="institution_id" x-model="selectedInstitution"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Pilih Instansi</option>
            @foreach($institutions as $institution)
                <option value="{{ $institution->id }}" {{ (old('institution_id', $employee->department->instansi_id ?? '') == $institution->id) ? 'selected' : '' }}>
                    {{ $institution->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Department Dropdown -->
    <div class="mt-4">
        <label for="department_id" class="block text-sm font-medium text-gray-700">Bidang</label>
        <select name="department_id" id="department_id" x-model="selectedDepartment"
            :disabled="!selectedInstitution || filteredDepartments.length === 0"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-100">
            <option value="">Pilih Bidang</option>
            <template x-for="department in filteredDepartments" :key="department.id">
                <option :value="department.id" x-text="department.nama" :selected="department.id == selectedDepartment"></option>
            </template>
        </select>
        @error('department_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>


