@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form id="opname-form" action="{{ route('admin.opname.update', $opname->id) }}" method="POST"
            enctype="multipart/form-data" class="contents">
            {{-- <form id="opname-form" action="{{ route('admin.opname.update', $opname->id) }}" method="POST" ...> --}}
            @method('PUT')
            @csrf

            <!-- Stock Opname Header -->
            <div class="bg-indigo-800 text-white rounded-lg p-4 mb-6" id="penanda">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div id="detail_ini">
                        <div class="font-medium">{{ $opname->nama }}</div>
                        <div class="text-sm">Tanggal Buat: {{ $opname->tanggal_dijadwalkan }}</div>
                        <div class="text-sm">Status: {{ $opname->status }}</div>
                        <div class="text-sm">Catatan: {{ $opname->catatan }}</div>
                    </div>
                    <button id="scan-qr-button"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                        Scan QR
                    </button>
                </div>
            </div>
            <div class="my-4">
                <label for="search-opname" class="text-sm font-medium text-gray-700">Cari:</label>
                <input type="text" id="search-opname"
                    class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                    Selesai
                </button>
                {{-- ... (kode search input di sini) ... --}}
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-800">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama
                                Aset
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Sub
                                Kategori
                            </th>

                            @if (
                                $opname->details->first()?->asset->jenis_aset == 'bergerak' ||
                                    $opname->details->first()?->asset->jenis_aset == 'tidak_bergerak')
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Status
                                    Lama
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Status
                                    Baru
                                </th>
                            @else
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Jumlah Sistem
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Jumlah Fisik
                                </th>
                            @endif
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Selisih
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($opname->details as $index => $detail)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->kode ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->nama_aset ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->category->nama ?? '-' }}</td>
                                @if ($detail->asset->jenis_aset == 'bergerak' || $detail->asset->jenis_aset == 'tidak_bergerak')
                                    {{-- <td class="px-4 py-3 text-sm text-gray-900"> --}}

                                    {{-- harus dibuat agar jumlah fisik berdasarkan status  --}}
                                    {{-- <input type="hidden" name="jumlah_fisik[{{ $detail->id }}]" value="1"
                                        class="w-20 border border-gray-300 rounded-md px-2 py-1 text-sm" readonly> --}}
                                    {{-- </td> --}}
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->status_lama ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        <div>
                                            {{-- ID unik untuk setiap select, penting untuk label jika ada --}}
                                            <select id="status_fisik_{{ $detail->id }}"
                                                name="statuses[{{ $detail->id }}]"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                <option value="">Pilih Status</option>
                                                {{-- Menampilkan status yang sudah ada sebagai pilihan default --}}
                                                <option value="tersedia"
                                                    {{ $detail->status_fisik == 'tersedia' ? 'selected' : '' }}>Tersedia
                                                </option>
                                                <option value="dipakai"
                                                    {{ $detail->status_fisik == 'dipakai' ? 'selected' : '' }}>Dipakai
                                                </option>
                                                <option value="rusak"
                                                    {{ $detail->status_fisik == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                                <option value="hilang"
                                                    {{ $detail->status_fisik == 'hilang' ? 'selected' : '' }}>Hilang
                                                </option>
                                                {{-- <option value="habis"
                                                    {{ $detail->status_fisik == 'habis' ? 'selected' : '' }}>Habis</option> --}}
                                            </select>
                                        </div>
                                    </td>
                                @else
                                    {{-- Kolom untuk Aset Habis Pakai --}}
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->jumlah_sistem }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        <input type="number" name="jumlah_fisik[{{ $detail->id }}]"
                                            value="{{ $detail->jumlah_fisik ?? $detail->jumlah_sistem }}"
                                            class="w-20 border border-gray-300 rounded-md px-2 py-1 text-sm">
                                        {{-- Kirim nilai kosong untuk status, karena akan di-handle di controller --}}
                                        <input type="hidden" name="statuses[{{ $detail->id }}]" value="">
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{-- Selisih bisa dihitung di backend atau via JS --}}
                                        -
                                    </td>
                                @endif

                                <td class="px-4 py-3 text-sm text-gray-900">selisih</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

    </div>
    <!-- QR Scanner Modal -->
    <div id="qr-scanner-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75
flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Scan QR
                Code</h2>
            <div id="qr-reader" class="w-full"></div>
            <button id="close-modal-button"
                class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-medium transition-colors">
                Tutup
            </button>
        </div>
    </div>



@endsection
{{-- @push('scripts') --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scanButton = document.getElementById('scan-qr-button');
        const closeModalButton = document.getElementById('close-modal-button');
        const modal = document.getElementById('qr-scanner-modal');
        let html5QrCode;

        // Fungsi untuk memulai pemindaian
        function startScanning() {
            modal.classList.remove('hidden');
            html5QrCode = new Html5Qrcode("qr-reader");
            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                //   alert(QR Code terdeteksi: ${decodedText});
                alert('QR Code terdeteksi: ' + decodedText);
                stopScanning();
                // Anda bisa menambahkan logika lain di sini,
                // misalnya mengirim hasil scan ke server via fetch/axios
            };
            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            };

            // Meminta izin kamera dan memulai pemindaian
            html5QrCode.start({
                    facingMode: "environment"
                }, config, qrCodeSuccessCallback)
                .catch(err => {
                    console.error("Tidak dapat memulai pemindaian QR Code", err);
                    alert("Gagal memulai kamera. Pastikan Anda memberikan izin.");
                    stopScanning();
                });
        }

        // Fungsi untuk menghentikan pemindaian
        function stopScanning() {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    console.log("Pemindaian QR Code dihentikan.");
                }).catch(err => {
                    console.error("Gagal menghentikan pemindaian QR Code.", err);
                });
            }
            modal.classList.add('hidden');
        }

        // Event listener untuk tombol
        scanButton.addEventListener('click', startScanning);
        closeModalButton.addEventListener('click', stopScanning);

        // Juga tutup jika mengklik di luar modal
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                stopScanning();
            }
        });
    });
</script>
{{-- @endpush --}}
