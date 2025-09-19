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