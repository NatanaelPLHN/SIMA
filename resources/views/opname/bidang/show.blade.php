@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <div class="px-4 py-6">
        <div class="mb-6">
            <a href="{{ route('subadmin.opname.index') }}"
                class="inline-flex items-center text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Kembali ke Daftar Stock Opname
            </a>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
            <!-- Header Section -->
            <form id="opname-form" action="{{ routeForRole('opname', 'update', $opname->id) }}" method="POST"
                enctype="multipart/form-data" class="contents">
                @method('PUT')
                @csrf

                <div class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 p-5 " id="penanda">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <!-- Informasi Utama -->
                        <div id="detail_ini" class="space-y-1">
                            <h2 class="text-lg font-bold">{{ $opname->nama }}</h2>
                            <div
                                class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-700 dark:text-gray-200">
                                <span>Tanggal Buat:
                                    {{ \Carbon\Carbon::parse($opname->tanggal_dijadwalkan)->translatedFormat('d F Y') }}</span>
                                {{-- @if ($opname->status === 'selesai')
                                <span>Tan: {{ \Carbon\Carbon::parse($opname->tanggal_dimulai)->translatedFormat('d F Y')
                                    }}</span>
                                <span>Tanggal Selesai: {{
                                    \Carbon\Carbon::parse($opname->tanggal_selesai)->translatedFormat('d F Y') }}</span>
                                @endif --}}
                                <div class="text-sm">Catatan: {{ $opname->catatan }}</div>
                                <span class="inline-flex items-center">
                                    Status:
                                    <span class="ml-1 px-2 py-0.5 text-xs font-medium rounded-full
                                    @if($opname->status === 'selesai') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                    @elseif($opname->status === 'proses') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                    @elseif($opname->status === 'dijadwalkan') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                    @elseif($opname->status === 'draft') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @elseif($opname->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @endif">
                                        {{ ucfirst(str_replace('_', ' ', $opname->status)) }}
                                    </span>

                                </span>

                            </div>
                        </div>

                        <!-- Aksi -->
                        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                            @if ($opname->status == 'proses')
                                                <button type="submit" id="finish-opname-btn"
                                                    class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                                    Selesai
                                                </button>
                                </form>
                            @endif
        </div>
    </div>

    </div>
    <div class="my-5 ml-5">
        <label for="search-opname" class="text-sm font-medium text-gray-700 dark:text-gray-300"></label>
        <input type="text" id="search-opname" placeholder="Cari: Nama, Kategori dll.."
            class="border border-gray-300 dark:border-gray-600 rounded-md px-2 py-1 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
        @if ($opname->status == 'proses')
            <button type="button" id="scan-qr-button"
                class="bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                Scan QR
            </button>
        @endif
    </div>
    </div>
    <!-- Data Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                            No</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                            Kode</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                            Nama Aset</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                            Sub Kategori</th>
                        @if (
                            $opname->details->first()?->asset->jenis_aset == 'bergerak' ||
                                $opname->details->first()?->asset->jenis_aset == 'tidak_bergerak'
                            )
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Status Lama
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Status Baru
                                </th>
                            @else
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Jumlah Sistem
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Jumlah Fisik
                                </th>
                            @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($opname->details as $index => $detail)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                            data-asset-code="{{ $detail->asset->kode ?? '' }}"
                            data-update-url="{{ route('subadmin.opname.details.update', $detail->id) }}"
                            >
                            <td class="px-4 py-3 text-center text-sm text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-center text-sm font-mono text-gray-900 dark:text-gray-100">
                                {{ $detail->asset->kode ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-900 dark:text-gray-100">
                                {{ $detail->asset->nama_aset ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-900 dark:text-gray-100">
                                {{ $detail->asset->category->nama ?? '-' }}</td>
                            @if ($detail->asset->jenis_aset == 'bergerak' || $detail->asset->jenis_aset == 'tidak_bergerak')
                                <td class="px-4 py-3 text-center text-sm text-gray-900 dark:text-gray-100">
                                {{ $detail->status_lama ?? '-' }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-900 dark:text-gray-100">
                                    <div>
                                        <select id="status_fisik_{{ $detail->id }}"
                                            name="statuses[{{ $detail->id }}]"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                                            {{ $opname->status == 'selesai' ? 'disabled' : '' }}>
                                            <option value="">Pilih Status</option>
                                            <option value="tersedia" {{ $detail->status_fisik == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="dipakai" {{ $detail->status_fisik == 'dipakai' ? 'selected' : '' }}>Dipakai</option>
                                            <option value="rusak" {{ $detail->status_fisik == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                            <option value="hilang" {{ $detail->status_fisik == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                        </select>
                                    </div>
                                </td>
                            @else
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $detail->jumlah_sistem }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    <input type="number" 
                                        name="jumlah_fisik[{{ $detail->id }}]"
                                        value="{{ $detail->jumlah_fisik ?? $detail->jumlah_sistem }}"
                                        class="w-20 border border-gray-300 dark:border-gray-600 rounded-md px-2 py-1 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                                        {{ $opname->status == 'selesai' ? 'disabled' : '' }}>
                                    <input type="hidden" name="statuses[{{ $detail->id }}]" value="">
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $opname->status == 'selesai' ? 7 : 5 }}"
                                class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada data aset dalam sesi ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    
    <!-- QR Scanner Modal -->
    <div id="qr-scanner-modal" class="fixed inset-0 dark:bg-gray-900/80 bg-gray-300/80 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">Scan QR Code</h2>
            <div id="qr-reader" class="w-full"></div>
            <button id="close-modal-button"
                class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-medium
transition-colors">
                Tutup
            </button>
        </div>
    </div>

    {{-- PERUBAHAN 2: Menambahkan HTML untuk Modal Update Aset --}}
    <div id="update-asset-modal"
        class="fixed inset-0 dark:bg-gray-900/80 bg-gray-300/80 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md">
            <h2 id="modal-title" class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">Update Aset</h2>
            <p id="modal-asset-info" class="text-sm text-gray-600 dark:text-gray-400 mb-4"></p>

            <div id="modal-dynamic-content">
                <!-- Konten dinamis (select atau input) akan dimasukkan di sini oleh JS -->
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button id="modal-cancel-button" type="button"
                    class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-md font-medium transition-colors">
                    Batal
                </button>
                <button id="modal-save-button" type="button"
                    class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 text-white px-4 py-2 rounded-md font-medium transition-colors">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    {{-- Style untuk memperbaiki masalah video ganda pada QR Scanner --}}
    <style>
        #qr-reader {
            /* Atur tinggi container sesuai dengan ukuran qrbox di JS (250px) */
            height: 250px;
            /* Sembunyikan video kedua yang mungkin muncul di bawahnya */
            overflow: hidden;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        // Bungkus seluruh logic agar tidak terjadi redeclare variabel global
        (function () {
            document.addEventListener('DOMContentLoaded', function () {
                // --- DEKLARASI ELEMEN UTAMA (hanya sekali) ---
                const opnameForm = document.getElementById('opname-form');
                const finishButton = document.getElementById('finish-opname-btn');
                const scanButton = document.getElementById('scan-qr-button');
                const qrScannerModal = document.getElementById('qr-scanner-modal');
                const closeQrModalButton = document.getElementById('close-modal-button');
                let html5QrCode = null;

                const updateAssetModal = document.getElementById('update-asset-modal');
                const modalTitle = document.getElementById('modal-title');
                const modalAssetInfo = document.getElementById('modal-asset-info');
                const modalDynamicContent = document.getElementById('modal-dynamic-content');
                const modalSaveButton = document.getElementById('modal-save-button');
                const modalCancelButton = document.getElementById('modal-cancel-button');

                // --- LOGIKA AUTO-SAVE ---
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : null;

                const autoSaveStatus = document.createElement('div');
                autoSaveStatus.className =
                    'text-sm text-gray-500 fixed bottom-4 right-4 bg-gray-100 px-3 py-1 rounded-lg shadow-md';
                autoSaveStatus.style.display = 'none';
                document.body.appendChild(autoSaveStatus);

                let debounceTimerMap = {};

                function showAutoSave(text, persistent = false) {
                    autoSaveStatus.textContent = text;
                    autoSaveStatus.style.display = 'block';
                    if (!persistent) {
                        setTimeout(() => {
                            autoSaveStatus.style.display = 'none';
                        }, 1800);
                    }
                }

                async function sendPatch(url, payload, opts = { keepalive: false }) {
                    return await fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(payload),
                        credentials: 'same-origin',
                        keepalive: opts.keepalive === true
                    });
                }

                const localPrefix = 'opname_pending_';
                function savePending(detailId, url, payload) {
                    try {
                        localStorage.setItem(localPrefix + detailId, JSON.stringify({ url, payload, ts: Date.now() }));
                    } catch (e) {
                        console.warn('Gagal menyimpan ke localStorage', e);
                    }
                }

                function removePending(detailId) {
                    localStorage.removeItem(localPrefix + detailId);
                }

                async function flushPendingItem(detailId, useKeepalive = false) {
                    const raw = localStorage.getItem(localPrefix + detailId);
                    if (!raw) return false;
                    let parsed;
                    try { parsed = JSON.parse(raw); } catch (e) { removePending(detailId); return false; }
                    try {
                        const res = await sendPatch(parsed.url, parsed.payload, { keepalive: useKeepalive });
                        if (res.ok) {
                            removePending(detailId);
                            return true;
                        }
                        return false;
                    } catch (e) {
                        return false;
                    }
                }

                async function flushAllPending(useKeepalive = false) {
                    const keys = Object.keys(localStorage).filter(k => k.startsWith(localPrefix));
                    if (!keys.length) return;
                    showAutoSave('Menyinkronkan perubahan...', true);
                    for (const k of keys) {
                        const detailId = k.replace(localPrefix, '');
                        await flushPendingItem(detailId, useKeepalive);
                    }
                    showAutoSave('Sinkronisasi selesai.');
                }

                // Attach auto-save change handler
                function handleChangeEvent(e) {
                    const inputElement = e.target;
                    if (!inputElement.closest('#opname-form')) return; // safety
                    const row = inputElement.closest('tr');
                    if (!row) return;
                    const url = row.dataset.updateUrl;
                    if (!url) return;

                    const inputName = inputElement.name || '';
                    const detailIdMatch = inputName.match(/\d+/);
                    if (!detailIdMatch) return;
                    const detailId = detailIdMatch[0];

                    const payload = {};
                    if (inputName.includes('statuses')) {
                        payload.status_fisik = inputElement.value;
                    } else if (inputName.includes('jumlah_fisik')) {
                        payload.jumlah_fisik = Number(inputElement.value);
                    } else {
                        return;
                    }

                    // debounce per detail
                    if (debounceTimerMap[detailId]) clearTimeout(debounceTimerMap[detailId]);
                    debounceTimerMap[detailId] = setTimeout(async () => {
                        showAutoSave('Menyimpan...');
                        try {
                            const res = await sendPatch(url, payload);
                            if (!res.ok) {
                                const body = await res.json().catch(() => ({ message: res.statusText }));
                                console.warn('Server error autosave:', body);
                                savePending(detailId, url, payload);
                                showAutoSave('Gagal tersimpan — disimpan sementara');
                                return;
                            }
                            const data = await res.json().catch(() => ({}));
                            removePending(detailId);
                            showAutoSave(`Tersimpan (${data.timestamp || new Date().toLocaleTimeString()})`);
                        } catch (err) {
                            console.error('Autosave network error', err);
                            savePending(detailId, url, payload);
                            showAutoSave('Gagal tersimpan — disimpan sementara');
                        }
                    }, 800);
                }

                // Attach listeners to inputs/selects
                function attachAutoSaveListeners() {
                    document.querySelectorAll('select[name^="statuses"], input[name^="jumlah_fisik"]').forEach(el => {
                        // remove previous to avoid duplicate listeners
                        el.removeEventListener('change', handleChangeEvent);
                        el.addEventListener('change', handleChangeEvent);
                        if (el.tagName.toLowerCase() === 'input') {
                            el.removeEventListener('blur', handleChangeEvent);
                            el.addEventListener('blur', handleChangeEvent);
                        }
                    });
                }

                // flush pending on online
                window.addEventListener('online', () => {
                    flushAllPending(false);
                });

                // beforeunload try best-effort using keepalive
                window.addEventListener('beforeunload', () => {
                    // clear pending debounce timers to let immediate saves run if any
                    Object.values(debounceTimerMap).forEach(t => clearTimeout(t));
                    flushAllPending(true);
                });

                // initial attach
                attachAutoSaveListeners();
                // attempt flush any pending on load
                flushAllPending(false);

                                // --- LOGIKA PEMINDAI QR (REVISI FINAL DENGAN PEMBERSIHAN PAKSA) ---
                                function startScanning() {
                                    qrScannerModal.classList.remove('hidden');

                                    // Selalu buat instance baru untuk memastikan state bersih, seperti di file referensi
                                    html5QrCode = new Html5Qrcode("qr-reader");

                                    const config = {
                                        fps: 10,
                                        qrbox: { width: 250, height: 250 }
                                    };

                                    html5QrCode.start(
                                        { facingMode: "environment" },
                                        config,
                                        qrCodeSuccessCallback
                                    ).catch(err => {
                                        alert("Gagal memulai kamera. Pastikan Anda memberikan izin.");
                                        // Coba hentikan untuk membersihkan jika ada sisa elemen
                                        stopScanning();
                                    });
                                }
                function stopScanning() {
                    if (html5QrCode && html5QrCode.isScanning) {
                        // Biarkan library menangani penghentian dan pembersihan.
                        // Kita hanya perlu menangani hasilnya.
                        html5QrCode.stop()
                            .then(ignore => {
                                // Berhasil dihentikan oleh library
                                console.log("QR Code scanning stopped successfully.");
                            })
                            .catch(err => {
                                // Ini adalah tempat error 'removeChild' terjadi.
                                // Kita bisa mengabaikannya dengan aman karena tujuannya (menghentikan scan) tercapai.
                                console.warn("Scanner stop function failed, but this is often ignorable.", err);
                            })
                            .finally(() => {
                                // Apapun yang terjadi (berhasil atau gagal), pastikan modal selalu tersembunyi.
                                qrScannerModal.classList.add('hidden');
                            });
                    } else {
                        // Jika tidak sedang memindai, cukup sembunyikan modal.
                        qrScannerModal.classList.add('hidden');
                    }
                }

                const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                    stopScanning();
                    let assetCode;
                    try {
                        const url = new URL(decodedText);
                        const pathParts = url.pathname.split('/');
                        assetCode = pathParts[pathParts.length - 1];
                    } catch (e) {
                        assetCode = decodedText;
                    }
                    fetchAssetData(assetCode);
                };

                if (scanButton) scanButton.addEventListener('click', startScanning);
                if (closeQrModalButton) closeQrModalButton.addEventListener('click', stopScanning);

                // --- LOGIKA MODAL UPDATE ASET ---
                async function fetchAssetData(assetCode) {
                    const targetRow = document.querySelector(`tr[data-asset-code="${assetCode}"]`);
                    if (!targetRow) {
                        console.error(`[DEBUG] GAGAL: Baris tabel untuk aset ${assetCode} tidak ditemukan.`);
                        alert(`Aset dengan kode ${assetCode} tidak termasuk dalam daftar opname ini.`);
                        return;
                    }

                    try {
                        const response = await fetch(`/api/asset/${assetCode}`, { credentials: 'same-origin' });
                        console.log(`[DEBUG] 5. Respons API diterima. Status: ${response.status}`);
                        if (!response.ok) {
                            const errorData = await response.json().catch(() => ({ message: response.statusText }));
                            throw new Error(errorData.message || 'Gagal mengambil data aset.');
                        }
                        const asset = await response.json();
                        showUpdateModal(asset, targetRow);
                    } catch (error) {
                        alert(error.message);
                    }
                }

                function showUpdateModal(asset, targetRow) {
                    modalAssetInfo.textContent = `${asset.kode} - ${asset.nama_aset}`;
                    modalDynamicContent.innerHTML = ''; // Kosongkan konten sebelumnya

                    if (asset.jenis_aset === 'bergerak' || asset.jenis_aset === 'tidak_bergerak') {
                        const currentStatus = (targetRow.querySelector('select[name^="statuses"]') || {}).value || '';
                        const selectHTML = `
                        <label for="modal-status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Fisik</label>
                        <select id="modal-status" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                            <option value="tersedia" ${currentStatus === 'tersedia' ? 'selected' : ''}>Tersedia</option>
                            <option value="dipakai" ${currentStatus === 'dipakai' ? 'selected' : ''}>Dipakai</option>
                            <option value="rusak" ${currentStatus === 'rusak' ? 'selected' : ''}>Rusak</option>
                            <option value="hilang" ${currentStatus === 'hilang' ? 'selected' : ''}>Hilang</option>
                        </select>`;
                        modalDynamicContent.innerHTML = selectHTML;
                    } else if (asset.jenis_aset === 'habis_pakai') {
                        const currentJumlah = (targetRow.querySelector('input[name^="jumlah_fisik"]') || {}).value || '';
                        const inputHTML = `
                        <label for="modal-jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Fisik</label>
                        <input type="number" id="modal-jumlah" value="${currentJumlah}" class="mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md px-2 py-1 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">`;
                        modalDynamicContent.innerHTML = inputHTML;
                    }

                    modalSaveButton.dataset.assetCode = asset.kode;
                    updateAssetModal.classList.remove('hidden');
                }

                function hideUpdateModal() {
                    updateAssetModal.classList.add('hidden');
                }

                if (modalCancelButton) modalCancelButton.addEventListener('click', hideUpdateModal);

                if (modalSaveButton) modalSaveButton.addEventListener('click', function () {
                    const assetCode = this.dataset.assetCode;
                    const targetRow = document.querySelector(`tr[data-asset-code="${assetCode}"]`);

                    const modalInput = modalDynamicContent.querySelector('select, input');
                    if (!modalInput) return;
                    const newValue = modalInput.value;

                    if (modalInput.id === 'modal-status') {
                        const targetSelect = targetRow.querySelector('select[name^="statuses"]');
                        if (targetSelect) {
                            targetSelect.value = newValue;
                            // trigger change to fire autosave
                            targetSelect.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    } else if (modalInput.id === 'modal-jumlah') {
                        const targetInput = targetRow.querySelector('input[name^="jumlah_fisik"]');
                        if (targetInput) {
                            targetInput.value = newValue;
                            // trigger blur or change to fire autosave
                            targetInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }

                    targetRow.classList.add('bg-yellow-200', 'transition-colors', 'duration-1000');
                    setTimeout(() => {
                        targetRow.classList.remove('bg-yellow-200');
                    }, 1000);

                    hideUpdateModal();
                });

                // --- LOGIKA TOMBOL SELESAI (SWEETALERT) ---
                if (finishButton) {
                    finishButton.addEventListener('click', function (event) {
                        event.preventDefault();
                        Swal.fire({
                            title: 'Konfirmasi Penyelesaian',
                            text: 'Masukkan password Anda untuk menyelesaikan sesi stock opname ini.',
                            input: 'password',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Verifikasi & Selesaikan',
                            cancelButtonText: 'Batal',
                            showLoaderOnConfirm: true,
                            preConfirm: (password) => {
                                const csrf = csrfToken;
                                return fetch('{{ route('verifyPassword') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': csrf
                                        },
                                        credentials: 'same-origin',
                                        body: JSON.stringify({
                                            password: password
                                        })
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            return response.json().then(err => {
                                                throw new Error(err.message)
                                            });
                                        }
                                        return response.json();
                                    })
                                    .catch(error => {
                                        Swal.showValidationMessage(
                                            `Verifikasi gagal: ${error.message}`);
                                    });
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Terverifikasi!',
                                    text: 'Menyelesaikan sesi stock opname...',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    opnameForm.submit();
                                });
                            }
                        });
                    });
                }

                // If dynamic DOM changes could occur, reattach listeners:
                // You can call attachAutoSaveListeners() after rows update
            });
        })();
    </script>
@endpush