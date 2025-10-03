@extends('layouts.app')

  @section('title', 'Stock Opname')

  @section('content')
      <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
      <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
          <form id="opname-form" action="{{ route('admin.opname.update', $opname->id) }}" method="POST"
              enctype="multipart/form-data" class="contents">
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
                      @if ($opname->status != 'selesai')
                          <button type="submit"
                              class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                              Selesai
                          </button>
                      @endif
                  </div>
              </div>
              <div class="my-4">
                  <label for="search-opname" class="text-sm font-medium text-gray-700">Cari:</label>
                  <input type="text" id="search-opname"
                      class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                  <button type="button" id="scan-qr-button"
                      class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                      Scan QR
                  </button>
              </div>

              <!-- Data Table -->
              <div class="bg-white rounded-lg shadow-md overflow-hidden">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-indigo-800">
                          <tr>
                              <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                              <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode</th>
                              <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Aset</th>
                              <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Sub Kategori</th>
                              @if ($opname->details->first()?->asset->jenis_aset == 'bergerak' || $opname->details->first()?->asset->jenis_aset =='tidak_bergerak')
                                  <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status Lama</th>
                                  <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status Baru</th>
                              @else
                                  <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jumlah Sistem</th>
                                  <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jumlah Fisik</th>
                              @endif
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @foreach ($opname->details as $index => $detail)
                              {{-- PERUBAHAN 1: Menambahkan atribut data-asset-code pada <tr> --}}
                              <tr data-asset-code="{{ $detail->asset->kode ?? '' }}">
                                  <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                                  <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->kode ?? '-' }}</td>
                                  <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->nama_aset ?? '-' }}</td>
                                  <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->asset->category->nama ?? '-' }}</td>
                                  @if ($detail->asset->jenis_aset == 'bergerak' || $detail->asset->jenis_aset == 'tidak_bergerak')
                                      <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->status_lama ?? '-' }}</td>
                                      <td class="px-4 py-3 text-sm text-gray-900">
                                          <div>
                                              <select id="status_fisik_{{ $detail->id }}" name="statuses[{{ $detail->id }}]"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2
  focus:ring-indigo-500"
                                                  {{ $opname->status == 'selesai' ? 'disabled' : '' }}>
                                                  <option value="">Pilih Status</option>
                                                  <option value="tersedia" {{ $detail->status_fisik == 'tersedia' ? 'selected' : ''
  }}>Tersedia</option>
                                                  <option value="dipakai" {{ $detail->status_fisik == 'dipakai' ? 'selected' : '' }}>Dipakai</option>
                                                  <option value="rusak" {{ $detail->status_fisik == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                                  <option value="hilang" {{ $detail->status_fisik == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                              </select>
                                          </div>
                                      </td>
                                  @else
                                      <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->jumlah_sistem }}</td>
                                      <td class="px-4 py-3 text-sm text-gray-900">
                                          <input type="number" name="jumlah_fisik[{{ $detail->id }}]"
                                              value="{{ $detail->jumlah_fisik ?? $detail->jumlah_sistem }}"
                                              class="w-20 border border-gray-300 rounded-md px-2 py-1 text-sm"
                                              {{ $opname->status == 'selesai' ? 'disabled' : '' }}>
                                          <input type="hidden" name="statuses[{{ $detail->id }}]" value="">
                                      </td>
                                  @endif
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </form>
      </div>

      <!-- QR Scanner Modal -->
      <div id="qr-scanner-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
          <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Scan QR Code</h2>
              <div id="qr-reader" class="w-full"></div>
              <button id="close-modal-button" class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-medium
  transition-colors">
                  Tutup
              </button>
          </div>
      </div>

      {{-- PERUBAHAN 2: Menambahkan HTML untuk Modal Update Aset --}}
      <div id="update-asset-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
          <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
              <h2 id="modal-title" class="text-xl font-semibold text-gray-800 mb-2">Update Aset</h2>
              <p id="modal-asset-info" class="text-sm text-gray-600 mb-4"></p>

              <div id="modal-dynamic-content">
                  <!-- Konten dinamis (select atau input) akan dimasukkan di sini oleh JS -->
              </div>

              <div class="mt-6 flex justify-end gap-4">
                  <button id="modal-cancel-button" type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium
  transition-colors">
                      Batal
                  </button>
                  <button id="modal-save-button" type="button" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium
  transition-colors">
                      Simpan
                  </button>
              </div>
          </div>
      </div>
  @endsection

  @push('scripts')
      <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

      {{-- PERUBAHAN 3: Mengganti seluruh logika JavaScript --}}
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              // Elemen-elemen Modal Pemindai QR
              const scanButton = document.getElementById('scan-qr-button');
              const qrScannerModal = document.getElementById('qr-scanner-modal');
              const closeQrModalButton = document.getElementById('close-modal-button');
              let html5QrCode;

              // Elemen-elemen Modal Update Aset
              const updateAssetModal = document.getElementById('update-asset-modal');
              const modalTitle = document.getElementById('modal-title');
              const modalAssetInfo = document.getElementById('modal-asset-info');
              const modalDynamicContent = document.getElementById('modal-dynamic-content');
              const modalSaveButton = document.getElementById('modal-save-button');
              const modalCancelButton = document.getElementById('modal-cancel-button');

              // --- LOGIKA PEMINDAI QR ---

              function startScanning() {
                  qrScannerModal.classList.remove('hidden');
                  html5QrCode = new Html5Qrcode("qr-reader");
                  const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                  html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback)
                      .catch(err => {
                          alert("Gagal memulai kamera. Pastikan Anda memberikan izin.");
                          stopScanning();
                      });
              }

              function stopScanning() {
                  if (html5QrCode && html5QrCode.isScanning) {
                      html5QrCode.stop().catch(err => console.error("Gagal menghentikan pemindaian.", err));
                  }
                  qrScannerModal.classList.add('hidden');
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

              scanButton.addEventListener('click', startScanning);
              closeQrModalButton.addEventListener('click', stopScanning);

              // --- LOGIKA MODAL UPDATE ASET ---

              async function fetchAssetData(assetCode) {
                  // Cek dulu apakah aset ada di tabel opname
                  const targetRow = document.querySelector(tr[data-asset-code="${assetCode}"]);
                  if (!targetRow) {
                      alert(Aset dengan kode ${assetCode} tidak termasuk dalam daftar opname ini.);
                      return;
                  }

                  try {
                      const response = await fetch(/api/asset/${assetCode});
                      if (!response.ok) {
                          const errorData = await response.json();
                          throw new Error(errorData.message || 'Gagal mengambil data aset.');
                      }
                      const asset = await response.json();
                      showUpdateModal(asset, targetRow);
                  } catch (error) {
                      alert(error.message);
                  }
              }

              function showUpdateModal(asset, targetRow) {
                  modalAssetInfo.textContent = ${asset.kode} - ${asset.nama_aset};
                  modalDynamicContent.innerHTML = ''; // Kosongkan konten sebelumnya

                  if (asset.jenis_aset === 'bergerak' || asset.jenis_aset === 'tidak_bergerak') {
                      const currentStatus = targetRow.querySelector('select[name^="statuses"]').value;
                      const selectHTML = `
                          <label for="modal-status" class="block text-sm font-medium text-gray-700">Status Fisik</label>
                          <select id="modal-status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none
  focus:ring-2 focus:ring-indigo-500">
                              <option value="tersedia" ${currentStatus === 'tersedia' ? 'selected' : ''}>Tersedia</option>
                              <option value="dipakai" ${currentStatus === 'dipakai' ? 'selected' : ''}>Dipakai</option>
                              <option value="rusak" ${currentStatus === 'rusak' ? 'selected' : ''}>Rusak</option>
                              <option value="hilang" ${currentStatus === 'hilang' ? 'selected' : ''}>Hilang</option>
                          </select>`;
                      modalDynamicContent.innerHTML = selectHTML;
                  } else if (asset.jenis_aset === 'habis_pakai') {
                      const currentJumlah = targetRow.querySelector('input[name^="jumlah_fisik"]').value;
                      const inputHTML = `
                          <label for="modal-jumlah" class="block text-sm font-medium text-gray-700">Jumlah Fisik</label>
                          <input type="number" id="modal-jumlah" value="${currentJumlah}" class="mt-1 w-full border border-gray-300 rounded-md px-2
  py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">`;
                      modalDynamicContent.innerHTML = inputHTML;
                  }

                  // Simpan assetCode di tombol simpan untuk referensi
                  modalSaveButton.dataset.assetCode = asset.kode;
                  updateAssetModal.classList.remove('hidden');
              }

              function hideUpdateModal() {
                  updateAssetModal.classList.add('hidden');
              }

              modalCancelButton.addEventListener('click', hideUpdateModal);

              modalSaveButton.addEventListener('click', function() {
                  const assetCode = this.dataset.assetCode;
                  const targetRow = document.querySelector(tr[data-asset-code="${assetCode}"]);

                  const modalInput = modalDynamicContent.querySelector('select, input');
                  const newValue = modalInput.value;

                  if (modalInput.id === 'modal-status') {
                      const targetSelect = targetRow.querySelector('select[name^="statuses"]');
                      targetSelect.value = newValue;
                  } else if (modalInput.id === 'modal-jumlah') {
                      const targetInput = targetRow.querySelector('input[name^="jumlah_fisik"]');
                      targetInput.value = newValue;
                  }

                  // Beri highlight singkat untuk menandakan baris telah diubah
                  targetRow.classList.add('bg-yellow-200', 'transition-colors', 'duration-1000');
                  setTimeout(() => {
                      targetRow.classList.remove('bg-yellow-200');
                  }, 1000);

                  hideUpdateModal();
              });
          });
      </script>
  @endpush