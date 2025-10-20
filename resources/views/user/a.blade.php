
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loggedInUserRole = '{{ auth()->user()->role }}';
            const roleSelect = document.getElementById('role');
            const employeeWrapper = document.getElementById('employee-wrapper');
            const employeeSelect = document.getElementById('karyawan_id');

            // --- Helper Functions ---
            function resetSelect(selectElement, defaultText) {
                selectElement.innerHTML = `<option value="">${defaultText}</option>`;
            }

            function populateSelect(selectElement, data, defaultText) {
                resetSelect(selectElement, defaultText);

                // PERBAIKAN: Cek apakah data adalah array. Jika tidak, coba ubah dari objek.
                let dataArray = Array.isArray(data) ? data : Object.values(data);

                if (dataArray) {
                    dataArray.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.nama;
                        if (item.department_id) {
                            option.dataset.departmentId = item.department_id;
                        }
                        selectElement.appendChild(option);
                    });
                }
            }

            // =================================================================
            // LOGIKA UNTUK SUPERADMIN
            // =================================================================
            if (loggedInUserRole === 'superadmin') {
                const institutionWrapper = document.getElementById('institution-wrapper');
                const institutionSelect = document.getElementById('institution_id');
                const departmentWrapper = document.getElementById('department-wrapper');
                const departmentSelect = document.getElementById('department_id');

                roleSelect.addEventListener('change', handleRoleChangeSuperAdmin);
                institutionSelect.addEventListener('change', handleInstitutionChangeSuperAdmin);
                departmentSelect.addEventListener('change', handleDepartmentChangeSuperAdmin);

                function handleRoleChangeSuperAdmin() {
                    const role = roleSelect.value;
                    institutionWrapper.classList.add('hidden');
                    departmentWrapper.classList.add('hidden');
                    employeeWrapper.classList.add('hidden');
                    resetSelect(institutionSelect, '-- Pilih Instansi --');
                    resetSelect(departmentSelect, '-- Pilih Departemen --');
                    resetSelect(employeeSelect, '-- Pilih Pegawai --');

                    if (!role) return;

                    institutionWrapper.classList.remove('hidden');
                    employeeWrapper.classList.remove('hidden');
                    if (role === 'subadmin' || role === 'user') {
                        departmentWrapper.classList.remove('hidden');
                    }
                    fetchInstitutions(role);
                }

                function handleInstitutionChangeSuperAdmin() {
                    const role = roleSelect.value;
                    const institutionId = institutionSelect.value;
                    resetSelect(departmentSelect, '-- Pilih Departemen --');
                    resetSelect(employeeSelect, '-- Pilih Pegawai --');

                    if (!institutionId) return;

                    if (role === 'subadmin' || role === 'user') {
                        fetchDepartments(institutionId, role);
                    }
                    fetchEmployees(institutionId, '');
                }

                function handleDepartmentChangeSuperAdmin() {
                    const institutionId = institutionSelect.value;
                    const departmentId = departmentSelect.value;
                    resetSelect(employeeSelect, '-- Pilih Pegawai --');
                    if (institutionId && departmentId) {
                        fetchEmployees(institutionId, departmentId);
                    }
                }

                function fetchInstitutions(role) {
                    fetch(`{{ route('users.ajax.get-institutions') }}?role=${role}`)
                        .then(response => response.json())
                        .then(data => populateSelect(institutionSelect, data, '-- Pilih Instansi --'));
                }

                function fetchDepartments(institutionId, role) {
                    fetch(`{{ route('users.ajax.get-departments') }}?role=${role}&institution_id=${institutionId}`)
                        .then(response => response.json())
                        .then(data => populateSelect(departmentSelect, data, '-- Pilih Departemen --'));
                }

                function fetchEmployees(institutionId, departmentId) {
                    let url = new URL('{{ route('users.ajax.get-employees') }}');
                    if (institutionId) url.searchParams.append('institution_id', institutionId);
                    if (departmentId) url.searchParams.append('department_id', departmentId);
                    fetch(url)
                        .then(response => response.json())
                        .then(data => populateSelect(employeeSelect, data, '-- Pilih Pegawai --'));
                }

                // Initial call if role is pre-selected
                if (roleSelect.value) handleRoleChangeSuperAdmin();
            }

            if (loggedInUserRole === 'admin') {
                console.log("--- SCRIPT ADMIN DIMUAT ---");

                const departmentWrapper = document.getElementById('department-wrapper-admin');
                const departmentSelect = document.getElementById('department_id_admin');

                // Data dari Controller
                const allEmployees = @json($employees ?? []);
                const departmentsForSubadmin = @json($departmentsForSubadmin ?? []);
                const allDepartments = @json($allDepartments ?? []);

                // --- LANGKAH DEBUG 1: Periksa data awal ---
                console.log("Data dari Controller:", {
                    departmentsForSubadmin: departmentsForSubadmin,
                    allDepartments: allDepartments,
                    allEmployees: allEmployees
                });

                roleSelect.addEventListener('change', handleRoleChangeAdmin);
                departmentSelect.addEventListener('change', handleDepartmentChangeAdmin);

                function handleRoleChangeAdmin() {
                    const role = roleSelect.value;

                    // --- LANGKAH DEBUG 2: Periksa role yang dipilih ---
                    console.log(`handleRoleChangeAdmin dipanggil. Role dipilih: "${role}"`);

                    // 1. Reset
                    departmentWrapper.classList.add('hidden');
                    employeeWrapper.classList.add('hidden');
                    resetSelect(departmentSelect, '-- Pilih Departemen --');
                    resetSelect(employeeSelect, '-- Pilih Pegawai --');

                    if (!role) return;

                    // 2. Tentukan data
                    let departmentsToShow = [];
                    let departmentDefaultText = '-- Pilih Departemen --';

                    if (role === 'subadmin') {
                        departmentsToShow = departmentsForSubadmin;
                        console.log("Menggunakan data 'departmentsForSubadmin'. Jumlah item:",
                            departmentsForSubadmin.length);
                    } else if (role === 'user') {
                        departmentsToShow = allDepartments;
                        departmentDefaultText = '-- Pilih Departemen (Opsional) --';
                        console.log("Menggunakan data 'allDepartments'. Jumlah item:", allDepartments.length);
                    }

                    // 3. Tampilkan dan isi dropdown
                    departmentWrapper.classList.remove('hidden');

                    // --- LANGKAH DEBUG 3: Tepat sebelum mengisi dropdown ---
                    console.log("Akan memanggil populateSelect untuk departemen dengan data:", departmentsToShow);
                    populateSelect(departmentSelect, departmentsToShow, departmentDefaultText);

                    // 4. Tampilkan wrapper karyawan
                    employeeWrapper.classList.remove('hidden');

                    if (role === 'user') {
                        populateSelect(employeeSelect, allEmployees, '-- Pilih Pegawai --');
                    }
                }

                function handleDepartmentChangeAdmin() {
                    const selectedDepartmentId = departmentSelect.value;
                    console.log(`handleDepartmentChangeAdmin dipanggil. Department ID: "${selectedDepartmentId}"`);

                    const filteredEmployees = allEmployees.filter(emp => {
                        if (!selectedDepartmentId) return true;
                        return emp.department_id == selectedDepartmentId;
                    });

                    console.log(`Menyaring karyawan. Ditemukan ${filteredEmployees.length} karyawan.`);
                    populateSelect(employeeSelect, filteredEmployees, '-- Pilih Pegawai --');
                }

                // Panggil saat halaman dimuat
                if (roleSelect.value) {
                    console.log(
                        "Memanggil handleRoleChangeAdmin saat halaman dimuat karena ada role yang sudah terpilih."
                    );
                    handleRoleChangeAdmin();
                }
            }
        });
    </script>
@endpush
