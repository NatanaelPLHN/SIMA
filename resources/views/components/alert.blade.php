@csrf
@vite(['resources/css/app.css', 'resources/js/app.js'])
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#dc2626'
            });
        });
    </script>
@endif

{{-- Jika ada error session --}}
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626'
            });
        });
    </script>
@endif

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#16a34a'
            });
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // hentikan submit default

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // kalau user klik hapus, baru submit form
                    }
                });
            });
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form'); 
    if (!form) return;

    // simpan nilai awal
    const initialData = {};
    form.querySelectorAll('input, select, textarea').forEach(el => {
        initialData[el.name] = el.value;
    });

    form.addEventListener('submit', function(e) {
        let changed = false;

        form.querySelectorAll('input, select, textarea').forEach(el => {
            if (initialData[el.name] !== el.value) {
                changed = true;
            }
        });

        if (!changed) {
            e.preventDefault();
            Swal.fire({
                icon: 'info',
                title: 'Tidak ada perubahan',
                text: 'Silakan ubah data terlebih dahulu sebelum menyimpan.',
                confirmButtonColor: '#3b82f6'
            });
        }
    });
});
</script>

@if (session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'info',
                title: 'Tidak ada perubahan',
                text: '{{ session('info') }}',
                confirmButtonColor: '#3b82f6'
            });
        });
    </script>
@endif

