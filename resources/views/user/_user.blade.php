@csrf
<!-- Role Info -->


{{-- Email --}}
<div>
    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email<span
            class="text-red-500">*</span></label>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror">

    @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Password --}}
<div>
    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password
        {{ isset($user) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</label>
    <input type="password" id="password" name="password"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror">

    @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Confirm Password --}}
<div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Konfirmasi Password
    </label>
    <input type="password" name="password_confirmation" id="password_confirmation"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

{{-- Role --}}
{{-- <div class="mb-4">
    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
        Role <span class="text-red-500">*</span>
    </label>
    <select name="role" id="role" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('role') border-red-500 @enderror">
        <option value="">Pilih Role</option>
        <option value="superadmin" {{ old('role', $user->role ?? '') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
        <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>User</option>
    </select>

    @error('role')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div> --}}

{{-- nda tau ini apa --}}
{{-- <div>
    <label for="karyawan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Karyawan
    </label>
    <select
        name="karyawan_id"
        id="karyawan_id"
        class="js-select2 mt-1 block w-full border border-gray-300 dark:border-gray-600
               bg-white dark:bg-gray-800 text-gray-900 dark:text-white
               rounded-md shadow-sm py-2 px-3
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
               dark:focus:ring-indigo-600 dark:focus:border-indigo-500
               @error('karyawan_id') border-red-500 dark:border-red-500 @enderror"
    >
        <option value="">Tidak ada</option>
        @foreach ($employees as $employee)
        <option value="{{ $employee->id }}" {{ old('karyawan_id', $user->karyawan_id ?? '') == $employee->id ? 'selected' : '' }}>
            @if ($login->role == 'superadmin')
            {{ $employee->nama }} ( {{ $employee->institution->nama ?? $user->employee->institution->nama }} )
            @elseif ($login->role == 'admin')
            {{ $employee->nama }} ( {{ $employee->department->nama ?? $user->employee->department->nama ?? ''}})
            @elseif ($login->role == 'subadmin')
            {{ $employee->nama }}
            @endif
        </option>
        @endforeach
    </select>

    @error('karyawan_id')
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div> --}}

{{-- Department --}}
<div class="mb-4">
    <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Departemen
    </label>
    <select id="department_id" name="department_id" class="js-select2 w-full border-gray-300 rounded-md">
        <option value="">-- Pilih Departemen --</option>
        @foreach ($departments as $dept)
            <option value="{{ $dept->id }}">{{ $dept->nama }}</option>
        @endforeach
    </select>
</div>

{{-- Role --}}
<div class="mt-4">
    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Role <span class="text-red-500">*</span>
    </label>
    <select id="role" name="role"
        class="js-select2 mt-1 block w-full border border-gray-300 dark:border-gray-600
               bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md
               shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="">Pilih Role</option>
        {{-- Roles will be dynamically set based on logged-in user --}}
        @if ($login->isSuperAdmin())
            <option value="admin">Admin</option>
            <option value="subadmin">Subadmin</option>
            <option value="user">User</option>
        @elseif ($login->isAdmin())
            <option value="subadmin">Subadmin</option>
            <option value="user">User</option>
        @elseif ($login->isSubAdmin())
            <option value="user">User</option>
        @endif
    </select>
</div>

{{-- Karyawan --}}
<div class="mb-4">
    <label for="karyawan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Karyawan
    </label>
    <select id="karyawan_id" name="karyawan_id" class="js-select2 w-full border-gray-300 rounded-md">
        <option value="">-- Pilih Karyawan --</option>
    </select>
</div>


{{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const deptSelect = document.getElementById('department_id');
        const empSelect = document.getElementById('karyawan_id');

        deptSelect.addEventListener('change', async function() {
            const departmentId = this.value;
            empSelect.innerHTML = '<option value="">Memuat...</option>';

            if (!departmentId) {
                empSelect.innerHTML = '<option value="">Pilih Karyawan</option>';
                return;
            }

            try {
                const response = await fetch(`/departments/${departmentId}/employees`);
                const employees = await response.json();

                empSelect.innerHTML = '<option value="">Pilih Karyawan</option>';
                employees.forEach(emp => {
                    const opt = document.createElement('option');
                    opt.value = emp.id;
                    opt.textContent = emp.nama;
                    empSelect.appendChild(opt);
                });
            } catch (err) {
                console.error(err);
                empSelect.innerHTML = '<option value="">Gagal memuat data</option>';
            }
        });
    });
</script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Select2
        $('#department_id').select2();
        $('#karyawan_id').select2();

        // Saat departemen berubah
        $('#department_id').on('change', function() {
            let departmentId = $(this).val();
            let karyawanSelect = $('#karyawan_id');

            // Reset pilihan karyawan
            karyawanSelect.empty().append('<option value="">-- Pilih Karyawan --</option>').trigger(
                'change');

            if (departmentId) {
                $.get("{{ route('departments.employees', ':id') }}".replace(':id', departmentId))
                    .done(function(data) {
                        // Kosongkan kembali untuk memastikan tidak duplikat
                        karyawanSelect.empty().append(
                            '<option value="">-- Pilih Karyawan --</option>');

                        // Tambahkan opsi baru
                        $.each(data, function(index, emp) {
                            let option = new Option(emp.nama, emp.id, false, false);
                            karyawanSelect.append(option);
                        });

                        // Render ulang Select2
                        karyawanSelect.trigger('change');
                    })
                    .fail(function() {
                        console.error('Gagal memuat data karyawan');
                        // Opsional: tampilkan alert/Swal error
                    });
            }
        });
    });
</script>
