@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <div x-data="{ openDrawer: false }">
        <div class="px-4 py-6">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Stock Opname</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex items-center">
                    <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Stock Opname</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $overview['total'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Dijadwalkan -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex items-center">
                    <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dijadwalkan</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $overview['dijadwalkan'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Sedang Berlangsung -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex items-center">
                    <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sedang Berlangsung</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $overview['proses'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Selesai -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex items-center">
                    <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Selesai</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $overview['selesai'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <!-- Card Placeholder (menggantikan form) -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 mb-6 transition-colors">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Daftar Stock Opname</h2>
                    <!-- Tombol untuk membuka drawer -->
                    <button @click="openDrawer = true"
                        class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white font-medium rounded-lg px-4 py-2 text-sm transition-colors shadow-sm">
                        Tambah Stock Opname
                    </button>
                </div>
            </div>

            <!-- Filter Section (search + select jenis aset + select status) -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Search -->
                    {{-- <div>
                        <label for="search"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari</label>
                        <input type="text" id="search"
                            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                            placeholder="Cari kode, bidang, dll...">
                    </div> --}}

                    {{-- <div>
                    <label for="filter_jenis_aset" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Aset</label>
                    <select id="filter_jenis_aset"
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                        <option value="">Semua Jenis</option>
                        <option value="bergerak">Bergerak</option>
                        <option value="tidak_bergerak">Tidak Bergerak</option>
                        <option value="habis_pakai">Habis Pakai</option>
                    </select>
                </div>

                <div>
                    <label for="filter_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select id="filter_status"
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                        <option value="">Semua Status</option>
                        <option value="dijadwalkan">Dijadwalkan</option>
                        <option value="draft">Draft</option>
                        <option value="proses">Proses</option>
                        <option value="selesai">Selesai</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div> --}}
                    <!-- Filter Jenis Aset -->
                    <div>
                        <label for="filter_jenis_aset"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Aset</label>
                        <select id="filter_jenis_aset" name="jenis_aset"
                            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-3
 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                            <option value="">Semua Jenis</option>
                            <option value="bergerak" {{ request('jenis_aset') == 'bergerak' ? 'selected' : '' }}>Bergerak
                            </option>
                            <option value="tidak_bergerak"
                                {{ request('jenis_aset') == 'tidak_bergerak' ? 'selected' : '' }}>Tidak Bergerak</option>
                            <option value="habis_pakai" {{ request('jenis_aset') == 'habis_pakai' ? 'selected' : '' }}>Habis
                                Pakai</option>
                        </select>
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label for="filter_status"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="filter_status" name="status"
                            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-3
          py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                            <option value="">Semua Status</option>
                            <option value="dijadwalkan" {{ request('status') == 'dijadwalkan' ? 'selected' : '' }}>
                                Dijadwalkan</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    No</th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">Kode
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    Tanggal</th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    Bidang</th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    Jenis Aset</th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    Status</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($sessions as $index => $session)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                        {{ $index + $sessions->firstItem() }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $session->nama }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $session->tanggal_dijadwalkan }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $session->departement->nama }}
                                    </td>
                                    @php
                                        $jenis = $session->details->first()?->asset->jenis_aset;
                                    @endphp
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        @if ($jenis == 'bergerak')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Bergerak</span>
                                        @elseif ($jenis == 'tidak_bergerak')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Tidak
                                                Bergerak</span>
                                        @elseif ($jenis == 'habis_pakai')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Habis
                                                Pakai</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">-</span>
                                        @endif
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        @switch(strtolower($session->status))
                                            @case('selesai')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Selesai</span>
                                            @break

                                            @case('draft')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Draft</span>
                                            @break

                                            @case('proses')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Proses</span>
                                            @break

                                            @case('cancelled')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Cancelled</span>
                                            @break

                                            @case('dijadwalkan')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Dijadwalkan</span>
                                            @break

                                            @default
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">{{ ucfirst($session->status ?? 'Tidak Diketahui') }}</span>
                                        @endswitch
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-x-3">
                                            <a href="{{ routeForRole('opname', 'show', $session->id) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-500 text-white/90 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-800/60 dark:focus:ring-blue-800/50 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                            data stock opname.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($sessions->hasPages())
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                Menampilkan <span class="font-medium">{{ $sessions->firstItem() }}</span> sampai
                                <span class="font-medium">{{ $sessions->lastItem() }}</span> dari
                                <span class="font-medium">{{ $sessions->total() }}</span> hasil
                            </div>
                            <div>{{ $sessions->links() }}</div>
                        </div>
                    @endif
                </div>
            </div>

    <!-- Drawer (Form Tambah Stock Opname) -->
    <div x-show="openDrawer" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 dark:bg-gray-900/80 bg-gray-300/80" @click="openDrawer = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div x-show="openDrawer" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                
                <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tambah Stock Opname</h3>
                        <button @click="openDrawer = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                        <form id="opname-form" action="{{ routeForRole('opname', 'store') }}" method="POST"
                            enctype="multipart/form-data" class="p-5">
                            @csrf
                            <input type="hidden" name="status" value="dijadwalkan">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- Tanggal Dijadwalkan -->
                                <div>
                                    <label for="tanggal_dijadwalkan"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Tanggal Dijadwalkan
                                    </label>
                                    <input type="date" id="tanggal_dijadwalkan" name="tanggal_dijadwalkan"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                                </div>


                                <!-- Tanggal Deadline -->
                                <div>
                                    <label for="tanggal_deadline"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Tanggal Deadline
                                    </label>
                                    <input type="date" id="tanggal_deadline" name="tanggal_deadline"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                                </div>

                                <!-- Bidang -->
                                <div>
                                    <label for="department_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Bidang
                                    </label>
                                    <select id="department_id" name="department_id"
                                        class="js-select2 w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                                        <option value="">Pilih Bidang</option>
                                        @foreach ($departements as $bidang)
                                            <option value="{{ $bidang->id }}">{{ $bidang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Jenis Aset -->
                                <div>
                                    <label for="jenis_aset"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Jenis Aset
                                    </label>
                                    <select id="jenis_aset" name="jenis_aset"
                                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                                        <option value="">Pilih Jenis Aset</option>
                                        <option value="bergerak">Bergerak</option>
                                        <option value="tidak_bergerak">Tidak Bergerak</option>
                                        <option value="habis_pakai">Habis Pakai</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" @click="openDrawer = false"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg dark:bg-green-700 dark:hover:bg-green-600">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            // Validasi deadline >= tanggal dijadwalkan
            document.addEventListener('DOMContentLoaded', function() {
                const deadlineInput = document.getElementById('tanggal_deadline');
                const jadwalInput = document.getElementById('tanggal_dijadwalkan');

                if (deadlineInput && jadwalInput) {
                    deadlineInput.addEventListener('change', function() {
                        const tglJadwal = jadwalInput.value;
                        const tglDeadline = this.value;
                        if (tglJadwal && tglDeadline && tglDeadline < tglJadwal) {
                            alert('Tanggal deadline tidak boleh sebelum tanggal dijadwalkan.');
                            this.value = '';
                        }
                    });
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                const filterJenisAset = document.getElementById('filter_jenis_aset');
                const filterStatus = document.getElementById('filter_status');

                function applyFilters() {
                    const jenisAset = filterJenisAset.value;
                    const status = filterStatus.value;

                    // Membuat URL baru dengan parameter filter
                    const url = new URL(window.location.href.split('?')[0]);

                    if (jenisAset) {
                        url.searchParams.set('jenis_aset', jenisAset);
                    }
                    if (status) {
                        url.searchParams.set('status', status);
                    }

                    // Mengarahkan browser ke URL baru
                    window.location.href = url.toString();
                }

                // Terapkan filter setiap kali pilihan berubah
                filterJenisAset.addEventListener('change', applyFilters);
                filterStatus.addEventListener('change', applyFilters);
            });
        </script>
    @endpush

    @push('styles')
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    @endpush
