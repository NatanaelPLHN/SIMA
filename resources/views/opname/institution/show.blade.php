@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')
    <div class="px-4 py-6">
        <div class="mb-6">
            <a href="{{ route('admin.opname.index') }}"
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
            <div class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 p-5">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <!-- Informasi Utama -->
                    <div id="detail_ini" class="space-y-1">
                        <h2 class="text-lg font-bold">{{ $opname->nama }}</h2>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-700 dark:text-gray-200">
                            <span>Tanggal Dijadwalkan:
                                {{ \Carbon\Carbon::parse($opname->tanggal_dijadwalkan)->translatedFormat('d F Y') }}</span>
                            @if ($opname->status === 'selesai')
                                <span>Tanggal Mulai:
                                    {{ \Carbon\Carbon::parse($opname->tanggal_dimulai)->translatedFormat('d F Y') }}</span>
                                <span>Tanggal Selesai:
                                    {{ \Carbon\Carbon::parse($opname->tanggal_selesai)->translatedFormat('d F Y') }}</span>
                            @endif
                            <span class="inline-flex items-center">
                                Status:
                                <span
                                    class="ml-1 px-2 py-0.5 text-xs font-medium rounded-full
                                @if ($opname->status === 'selesai') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                @elseif($opname->status === 'proses') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                @elseif($opname->status === 'dijadwalkan') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                @elseif($opname->status === 'draft') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @elseif($opname->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $opname->status)) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        @if ($opname->status == 'draft')
                            <form id="start-form" action="{{ routeForRole('opname', 'start', $opname->id) }}" method="POST"
                                class="flex flex-wrap items-center gap-2">
                                @csrf
                                <div class="w-full md:w-auto">
                                    <label for="catatan" class="sr-only">Catatan</label>
                                    <input type="text" id="catatan" name="catatan" placeholder="Catatan opsional..."
                                        class="w-full md:w-48 px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-600 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <button type="submit"
                                    class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    Jadwalkan
                                </button>
                            </form>
                        @endif

                        @if ($opname->status == 'draft' || $opname->status == 'dijadwalkan')
                            <form id="cancel-form" action="{{ routeForRole('opname', 'cancel', $opname->id) }}"
                                method="POST" class="inline-block">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Data Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

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
                            @if ($opname->status == 'selesai')
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Status Lama</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Status Baru</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Selisih</th>
                            @else
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Status</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($opname->details as $index => $detail)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-4 py-3 text-center text-sm text-gray-900 dark:text-gray-100">
                                    {{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-center text-sm font-mono text-gray-900 dark:text-gray-100">
                                    {{ $detail->asset->kode ?? '-' }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-900 dark:text-gray-100">
                                    {{ $detail->asset->nama_aset ?? '-' }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-900 dark:text-gray-100">
                                    {{ $detail->asset->category->nama ?? '-' }}</td>

                                @if ($opname->status == 'selesai')
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full
                                        @if (in_array($detail->status_lama, ['tersedia', 'dipakai'])) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                        @elseif($detail->status_lama == 'rusak')
                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                        @elseif(in_array($detail->status_lama, ['habis', 'hilang']))
                                            bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                        @else
                                            bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $detail->status_lama)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full
                                        @if (in_array($detail->status_fisik, ['tersedia', 'dipakai'])) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                        @elseif($detail->status_fisik == 'rusak')
                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                        @elseif(in_array($detail->status_fisik, ['habis', 'hilang']))
                                            bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                        @else
                                            bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $detail->status_fisik)) }}
                                        </span>
                                        @if ($detail->status_fisik === 'hilang')
                                            @if ($detail->surat_kehilangan_path)
                                            <a href="{{ Storage::url($detail->surat_kehilangan_path) }}" target="_blank" rel="noopener"
                                               class="inline-block mt-2 text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                                Lihat Surat
                                            </a>
                                            @else
                                                <div class="mt-1 text-[11px] text-yellow-600 dark:text-yellow-300">Belum ada
                                                    surat</div>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $detail->jumlah_fisik - $detail->jumlah_sistem }}
                                    </td>
                                @else
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full
                                        @if ($detail->status_lama == 'tersedia') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                        @elseif($detail->status_lama == 'tidak ditemukan')
                                            bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                        @elseif($detail->status_lama == 'rusak')
                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                        @else
                                            bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $detail->status_lama)) }}
                                        </span>
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
@endsection
