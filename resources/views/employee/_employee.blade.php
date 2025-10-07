@csrf

<!-- NIP -->
<div>
    <label for="nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIP<span class="text-red-500">*</span></label>
    <input type="number" id="nip" min="0" name="nip" value="{{ old('nip', $employee->nip ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<!-- Nama -->
<div>
    <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama<span class="text-red-500">*</span></label>
    <input type="text" id="nama" name="nama" value="{{ old('nama', $employee->nama ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<!-- Alamat -->
<div>
    <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
    <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $employee->alamat ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<!-- Telepon -->
<div>
    <label for="telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telepon</label>
    <input type="number" id="telepon" min="0" name="telepon" value="{{ old('telepon', $employee->telepon ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<!-- Instansi & Bidang (Sejajar) -->
<div class="md:col-span-2">
    <div 
        x-data="{
            selectedInstitution: '{{ old('institution_id', $employee->department->instansi_id ?? '') }}',
            selectedDepartment: '{{ old('department_id', $employee->department_id ?? '') }}',
            departments: {{ Js::from($departements) }},
            get filteredDepartments() {
                if (!this.selectedInstitution) return [];
                return this.departments.filter(d => d.instansi_id == this.selectedInstitution);
            }
        }"
        x-init="
            $watch('filteredDepartments', () => {
                setTimeout(() => {
                    $('#department_id').select2();
                }, 50);
            });

            $watch('selectedDepartment', value => {
                $('#department_id').val(value).trigger('change');
            });

            $('#institution_id').on('change', function() {
                selectedInstitution = this.value;
            });
            $('#department_id').on('change', function() {
                selectedDepartment = this.value;
            });

            $('#institution_id').select2();
            $('#department_id').select2();
        "
        class="grid grid-cols-1 md:grid-cols-2 gap-6"
    >
        <!-- Instansi (Kiri) -->
        <div>
            <label for="institution_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Instansi<span class="text-red-500">*</span>
            </label>
            <select name="institution_id" id="institution_id" 
                x-model="selectedInstitution"
                class="js-select2 w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md">
                <option value="">Pilih Instansi</option>
                @foreach($institutions as $institution)
                    <option value="{{ $institution->id }}" 
                        {{ (old('institution_id', $employee->department->instansi_id ?? '') == $institution->id) ? 'selected' : '' }}>
                        {{ $institution->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Bidang (Kanan) -->
        <div>
            <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Bidang<span class="text-red-500">*</span>
            </label>
            <select name="department_id" id="department_id" 
                x-model="selectedDepartment"
                class="js-select2 w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md"
                :disabled="!selectedInstitution || filteredDepartments.length === 0">
                <option value="">Pilih Bidang</option>
                <template x-for="dept in filteredDepartments" :key="dept.id">
                    <option :value="dept.id" x-text="dept.nama"></option>
                </template>
            </select>
            @error('department_id')
                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>