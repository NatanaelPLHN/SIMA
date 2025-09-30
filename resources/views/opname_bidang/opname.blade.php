@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Stock Opname Header -->
        <div class="bg-indigo-800 text-white rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div id="detail_ini">
                    <div class="font-medium">09-2023 | Elektronik</div>
                    <div class="text-sm">Tanggal Buat: 29-09-2023 23:59:59</div>
                    <div class="text-sm">Status: Proses</div>
                </div>

                {{-- <div class="w-full md:w-1/3">
                    <label for="keterangan" class="text-sm font-medium text-white">Keterangan</label>
                    <input type="text" id="keterangan" class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div> --}}

                <button id="scan-qr-button"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                    Scan QR
                </button>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Aset
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Sub Kategori
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">10</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Audrey Mckinney</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">1</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Savannah Howard</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">2</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Morris Cooper</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">2</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Victoria Lane</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">9</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Stella Warren</td>
                    </tr>
                </tbody>
            </table>
        </div>
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
      document.addEventListener('DOMContentLoaded', function () {
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
              const config = { fps: 10, qrbox: { width: 250, height: 250 } };

              // Meminta izin kamera dan memulai pemindaian
              html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback)
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