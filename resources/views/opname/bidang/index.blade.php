@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    {{-- <h1 class="text-lg font-semibold text-gray-800">Stock Opname</h1> --}}
    <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('subadmin.dashboard') }}"
                            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Stock Opname</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar Jadwal Stock Opname</h1>
        </div>
    <div class=" dark:bg-gray-800 bg-gray-100  rounded-lg shadow-md p-6">
        
        <!-- Table Controls -->
        

        <!-- Data Table -->
        <div class="p-2 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">No</th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">Kode</th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">Tanggal Opname</th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">Tanggal Deadline</th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">Kategori</th>
                            {{-- <th class="px-4 py-3 text-left text-xs font-medium text-center text-white uppercase tracking-wider">Kategori</th> --}}
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">Keterangan</th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach($sessions as $index => $session)
                        @if (
                                $session->departement->id == $user->employee?->department?->id &&
                                !in_array($session->status, ['draft', 'cancelled']))
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                    {{ $index + $sessions->firstItem() }}
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $session->nama }}
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $session->tanggal_dijadwalkan }}
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $session->tanggal_deadline }}
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center whitespace-nowrap">
                                    @if ($session->details->first()?->asset->jenis_aset == 'bergerak')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Bergerak</span>
                                    @elseif ($session->details->first()?->asset->jenis_aset == 'tidak_bergerak')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Tidak Bergerak</span>
                                    @elseif ($session->details->first()?->asset->jenis_aset == 'habis_pakai')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Habis Pakai</span>
                                    @endif
                                </td>
                                
                                <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $session->catatan }}
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    @switch(strtolower($session->status))
                                        @case('selesai')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Selesai</span>
                                        @break
                                        @case('proses')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Proses</span>
                                        @break
                                        @case('dijadwalkan')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Dijadwalkan</span>
                                        @break
                                        @default
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">{{ ucfirst($session->status ?? 'Tidak Diketahui') }}</span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($session->status == 'dijadwalkan')
                                        <button type="button" class="start-opname-btn inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-500 text-white/90 hover:bg-green-600 focus:ring-4 focus:ring-green-300 dark:bg-green-900/40 dark:text-green-300 dark:hover:bg-green-800/60 dark:focus:ring-green-800/50 transition-all"
                                            data-start-url="{{ routeForRole('opname', 'startOpname', $session->id) }}"
                                            data-show-url="{{ routeForRole('opname', 'show', $session->id) }}"
                                            title="Mulai Opname">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                        </button>
                                    @else
                                        <a href="{{ routeForRole('opname', 'show', $session->id) }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-500 text-white/90 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-800/60 dark:focus:ring-blue-800/50 transition-all"
                                            title="Lihat Detail Opname">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            {{-- @empty --}}
                          
                    @endif
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if($sessions->hasPages())
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
    
@endsection
@push('scripts')
    {{-- PERUBAHAN 2: Menambahkan JavaScript untuk SweetAlert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startButtons = document.querySelectorAll('.start-opname-btn');

            startButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const startUrl = this.dataset.startUrl;
                    const showUrl = this.dataset.showUrl;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    Swal.fire({
                        title: 'Mulai Stock Opname?',
                        text: "Sesi ini akan ditandai sebagai 'proses' dan tidak dapat dibatalkan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Mulai!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(startUrl, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (response.ok) {
                                        // Jika berhasil, arahkan ke halaman show
                                        window.location.href = showUrl;
                                    } else {
                                        // Jika gagal, tampilkan pesan error
                                        response.json().then(data => {
                                            Swal.fire(
                                                'Gagal!',
                                                data.message ||
                                                'Terjadi kesalahan saat memulai sesi.',
                                                'error'
                                            );
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Fetch Error:', error);
                                    Swal.fire(
                                        'Error!',
                                        'Tidak dapat terhubung ke server.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush
