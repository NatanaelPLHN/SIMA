@csrf
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#dc2626'
        })
    </script>
@endif

{{-- Jika ada error session --}}
@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc2626'
        })
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#16a34a'
        })
    </script>
@endif