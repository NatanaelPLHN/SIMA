<div id="default-tab-content">

    <!-- Tab: Bergerak -->
    <div id="bergerak" class="table-content hidden p-4" role="tabpanel" aria-labelledby="tab-bergerak">
        <div class="items-center justify-between block sm:flex mb-4">
            <form method="GET" action="{{ routeForRole('assets', 'index') }}"
                class="flex items-center space-x-2 sm:pl-4">
                <input type="hidden" name="tab" value="bergerak">
                <div class="relative w-48 sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Cari nama, serial number, dll...">
                </div>
                @if (request('search'))
                    <a href="{{ routeForRole('assets', 'index', ['tab' => request('tab', 'bergerak')]) }}" 15
                        class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">Clear</a>
                    {{-- <a href="{{ routeForRole('assets', 'index') }}"
                        class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">Clear</a> --}}
                @endif
            </form>
            @if (auth()->user()->role == 'subadmin')
                <a href="{{ route('subadmin.assets.create_gerak') }}"
                    class="mt-2 sm:mt-0 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                    Tambah Aset B
                </a>
            @endif
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                No</th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('sort') === 'nama' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Nama Aset
                                    @if (request('sort') === 'nama')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'serialnumber', 'direction' => request('sort') === 'serialnumber' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Serial Number
                                    @if (request('sort') === 'serialnumber')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Status
                                    @if (request('sort') === 'status')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'merk', 'direction' => request('sort') === 'merk' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Merk/Type
                                    @if (request('sort') === 'merk')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'tahun_produksi', 'direction' => request('sort') === 'tahun_produksi' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Tahun Produksi
                                    @if (request('sort') === 'tahun_produksi')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>

                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                        @if ($assetsBergerak->isEmpty())
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                data aset bergerak.</td>
                        </tr>
                        @else

                        @foreach($assetsBergerak as $index => $asset)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                    {{ $index + $assetsBergerak->firstItem() }}
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $asset->nama_aset }}
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $asset->bergerak->nomor_serial ?? '-' }}
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    @switch(strtolower($asset->status))
                                        @case('tersedia')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Tersedia
                                            </span>
                                        @break

                                        @case('dipakai')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                Dipakai
                                            </span>
                                        @break

                                        @case('rusak')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Rusak
                                            </span>
                                        @break

                                        @case('hilang')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Hilang
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                {{ ucfirst($asset->status ?? 'Tidak Diketahui') }}
                                            </span>
                                    @endswitch
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $asset->bergerak->merk ?? '-' }}/{{ $asset->bergerak->tipe ?? '-' }}
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $asset->bergerak->tahun_produksi ?? '-' }}
                                </td>

                                <td class="p-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-x-3">
                                        <!-- View -->
                                        <a href="{{ routeForRole('assets', 'show', $asset->id) }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                        bg-blue-500 text-white/90 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300
                                        dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-800/60 dark:focus:ring-blue-800/50
                                        transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        @if (auth()->user()->role == 'subadmin')
                                            <!-- Edit -->
                                            <a href="{{ route('subadmin.assets.edit', $asset->id) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                        bg-yellow-500 text-white/90 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300
                                        dark:bg-yellow-900/40 dark:text-yellow-300 dark:hover:bg-yellow-800/60 dark:focus:ring-yellow-800/50
                                        transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <!-- Delete -->
                                            <form method="POST"
                                                action="{{ route('subadmin.assets.destroy', $asset->id) }}"
                                                class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                                bg-red-500 text-white/90 hover:bg-red-600 focus:ring-4 focus:ring-red-300
                                                dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-800/60 dark:focus:ring-red-800/50
                                                transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($assetsBergerak->hasPages())
                    <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                            Menampilkan <span class="font-medium">{{ $assetsBergerak->firstItem() }}</span> sampai
                            <span class="font-medium">{{ $assetsBergerak->lastItem() }}</span> dari
                            <span class="font-medium">{{ $assetsBergerak->total() }}</span> hasil
                        </div>
                        <div>{{ $assetsBergerak->links() }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Tab: Tidak Bergerak -->
    <div id="tidakbergerak" class="table-content hidden p-4" role="tabpanel" aria-labelledby="tab-tidak-bergerak">
        <div class="items-center justify-between block sm:flex mb-4">
            <form method="GET" action="{{ routeForRole('assets', 'index') }}"
                class="flex items-center space-x-2 sm:pl-4">
                <input type="hidden" name="tab" value="tidakbergerak">
                <div class="relative w-48 sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Cari nama, kode, dll...">
                </div>
                @if (request('search'))
                    {{-- <a href="" ...>Clear</a> --}}
                    <a href="{{ routeForRole('assets', 'index', ['tab' => 'tidakbergerak']) }}"
                        class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">Clear</a>
                @endif
            </form>
            @if (auth()->user()->role == 'subadmin')
                <a href="{{ route('subadmin.assets.create_tidak_bergerak') }}"
                    class="mt-2 sm:mt-0 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                    Tambah Aset T
                </a>
            @endif
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                No</th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'kode', 'direction' => request('sort') === 'kode' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Kode
                                    @if (request('sort') === 'kode')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('sort') === 'nama' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Nama Aset
                                    @if (request('sort') === 'nama')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'ukuran', 'direction' => request('sort') === 'ukuran' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Ukuran
                                    @if (request('sort') === 'ukuran')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'bahan', 'direction' => request('sort') === 'bahan' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Bahan
                                    @if (request('sort') === 'bahan')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    Status
                                    @if (request('sort') === 'status')
                                        <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </a>
                            </th>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($assetsTidakBergerak as $index => $asset)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                    {{ $index + $assetsTidakBergerak->firstItem() }}
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $asset->kode }}
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $asset->nama_aset }}
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $asset->tidakBergerak->ukuran ?? '-' }}
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    {{ $asset->tidakBergerak->bahan ?? '-' }}
                                </td>
                                <td
                                    class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                    @switch(strtolower($asset->status))
                                        @case('tersedia')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Tersedia
                                            </span>
                                        @break

                                        @case('dipakai')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                Dipakai
                                            </span>
                                        @break

                                        @case('rusak')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Rusak
                                            </span>
                                        @break

                                        @case('hilang')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Hilang
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                {{ ucfirst($asset->status ?? 'Tidak Diketahui') }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="p-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-x-3">
                                        <!-- View -->
                                        <a href="{{ routeForRole('assets', 'show', $asset->id) }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                        bg-blue-500 text-white/90 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300
                                        dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-800/60 dark:focus:ring-blue-800/50
                                        transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        @if (auth()->user()->role == 'subadmin')
                                            <!-- Edit -->
                                            <a href="{{ route('subadmin.assets.edit', $asset->id) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                        bg-yellow-500 text-white/90 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300
                                        dark:bg-yellow-900/40 dark:text-yellow-300 dark:hover:bg-yellow-800/60 dark:focus:ring-yellow-800/50
                                        transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <!-- Delete -->
                                            <form method="POST"
                                                action="{{ route('subadmin.assets.destroy', $asset->id) }}"
                                                class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                                bg-red-500 text-white/90 hover:bg-red-600 focus:ring-4 focus:ring-red-300
                                                dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-800/60 dark:focus:ring-red-800/50
                                                transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                        data aset tidak bergerak.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($assetsTidakBergerak->hasPages())
                    <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                            Menampilkan <span class="font-medium">{{ $assetsTidakBergerak->firstItem() }}</span> sampai
                            <span class="font-medium">{{ $assetsTidakBergerak->lastItem() }}</span> dari
                            <span class="font-medium">{{ $assetsTidakBergerak->total() }}</span> hasil
                        </div>
                        <div>{{ $assetsTidakBergerak->links() }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tab: Habis Pakai -->
        <div id="habispakai" class="table-content hidden p-4" role="tabpanel" aria-labelledby="tab-habis-pakai">
            <div class="items-center justify-between block sm:flex mb-4">
                <form method="GET" action="{{ routeForRole('assets', 'index') }}"
                    class="flex items-center space-x-2 sm:pl-4">

                    <input type="hidden" name="tab" value="habispakai">
                    <div class="relative w-48 sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Cari nama, kode, dll...">
                    </div>
                    @if (request('search'))
                        <a href="{{ routeForRole('assets', 'index', ['tab' => 'habispakai']) }}"
                            class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">Clear</a>
                    @endif
                </form>
                @if (auth()->user()->role == 'subadmin')
                    <a href="{{ route('subadmin.assets.create_habis') }}"
                        class="mt-2 sm:mt-0 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                        Tambah Aset H
                    </a>
                @endif
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    No</th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'kode', 'direction' => request('sort') === 'kode' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Kode
                                        @if (request('sort') === 'kode')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('sort') === 'nama' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Nama Aset
                                        @if (request('sort') === 'nama')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'register', 'direction' => request('sort') === 'register' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Register
                                        @if (request('sort') === 'register')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'satuan', 'direction' => request('sort') === 'satuan' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Satuan
                                        @if (request('sort') === 'satuan')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-white">
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Status
                                        @if (request('sort') === 'status')
                                            <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($assetsHabisPakai as $index => $asset)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">
                                        {{ $index + $assetsHabisPakai->firstItem() }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $asset->kode }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $asset->nama_aset }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $asset->habisPakai->register ?? '-' }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        {{ $asset->habisPakai->satuan ?? '-' }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 break-words text-center">
                                        @switch(strtolower($asset->status))
                                            @case('tersedia')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Tersedia
                                                </span>
                                            @break

                                            @case('dipakai')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Dipakai
                                                </span>
                                            @break

                                            @case('rusak')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    Rusak
                                                </span>
                                            @break

                                            @case('hilang')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    Hilang
                                                </span>
                                            @break

                                            @default
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                    {{ ucfirst($asset->status ?? 'Tidak Diketahui') }}
                                                </span>
                                        @endswitch
                                    </td>

                                    <td class="p-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-x-3">
                                            <!-- View -->
                                            <a href="{{ routeForRole('assets', 'show', $asset->id) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                        bg-blue-500 text-white/90 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300
                                        dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-800/60 dark:focus:ring-blue-800/50
                                        transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                            @if (auth()->user()->role == 'subadmin')
                                                <!-- Edit -->
                                                <a href="{{ route('subadmin.assets.edit', $asset->id) }}"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                        bg-yellow-500 text-white/90 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300
                                        dark:bg-yellow-900/40 dark:text-yellow-300 dark:hover:bg-yellow-800/60 dark:focus:ring-yellow-800/50
                                        transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </a>

                                                <!-- Delete -->
                                                <form method="POST"
                                                    action="{{ route('subadmin.assets.destroy', $asset->id) }}"
                                                    class="inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <input type="hidden" name="tab" value="{{ request('tab', 'habispakai') }}"> --}}
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                                bg-red-500 text-white/90 hover:bg-red-600 focus:ring-4 focus:ring-red-300
                                                dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-800/60 dark:focus:ring-red-800/50
                                                transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                            data aset habis pakai.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($assetsHabisPakai->hasPages())
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                Menampilkan <span class="font-medium">{{ $assetsHabisPakai->firstItem() }}</span> sampai
                                <span class="font-medium">{{ $assetsHabisPakai->lastItem() }}</span> dari
                                <span class="font-medium">{{ $assetsHabisPakai->total() }}</span> hasil
                            </div>
                            <div>{{ $assetsHabisPakai->links() }}</div>
                        </div>
                    @endif
                </div>
            </div>
            </div>
