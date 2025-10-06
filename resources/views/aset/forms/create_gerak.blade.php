@extends('layouts.app')

@section('title', 'Admin Dashboard')
@include('components.alert')

@section('content')
    <h1 class="text-lg font-semibold text-indigo-800">Tambah Aset Bergerak</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form id="asset-form" action="{{ routeForRole('assets', 'store') }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols gap-6">
            <!-- Form Groups -->
            @include('aset.forms._form', ['jenis_aset' => 'bergerak'])
            {{-- @include('aset.forms._form') --}}

            <!-- Hidden field: jenis_aset -->
            <input type="hidden" name="jenis_aset" value="bergerak">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="merk" class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                    <input type="text" id="merk" name="merk"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="tipe" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <input type="text" id="tipe" name="tipe"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nomor_serial" class="block text-sm font-medium text-gray-700 mb-1">Serial
                        Number<span class="text-red-500">*</span></label>
                    <input type="text" id="nomor_serial" name="nomor_serial"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">

                </div>

                <div>
                    <label for="tahun_produksi" class="block text-sm font-medium text-gray-700 mb-1">Tahun
                        Produksi</label>
                    <input type="number" id="tahun_produksi" name="tahun_produksi" value="{{ old('tahun_produksi') }}"
                        min="1900" max="{{ date('Y') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ routeForRole('assets', 'index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                    Simpan
                </button>
            </div>

        </form>

    </div>
@endsection

@push('scripts')
    {{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const assetForm = document.getElementById('asset-form');
        if (assetForm) {
            assetForm.addEventListener('submit', function(event) {
                const assetCode = document.getElementById('kode').value;
                if (assetCode) {
                    // We construct the URL manually because the route needs a parameter
                    // that isn't available when the page first loads.
                    const baseUrl = "{{ url('/verify/asset') }}";
                    const verificationUrl = baseUrl + "/" + encodeURIComponent(assetCode);
                    window.open(verificationUrl, '_blank');
                }
            });
        }
    });
</script> --}}
@endpush
