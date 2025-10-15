@extends('layouts.app')

@section('title', 'Daftar Instansi')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
        <!-- Breadcrumb -->
        <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('superadmin.dashboard') }}"
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
                            <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Instansi</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar Instansi</h1>
        </div>

        <!-- Controls: Search, Add Button -->
        <div class="items-center justify-between block sm:flex">
            <div class="flex items-center mb-4 sm:mb-0">
                <form method="GET" action="{{ route('superadmin.institution.index') }}" class="flex items-center space-x-2 sm:pl-4 mt-2 sm:mt-0">
                    <div class="relative w-48 sm:w-64">
                        <input
                            type="text"
                            name="search"
                            id="instansi-search"
                            value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Cari nama, Pemerintah, dll...">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('superadmin.institution.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">
                            Clear
                        </a>
                    @endif
                </form>
            </div>
            <a href="{{ routeForRole('institution', 'create') }}"
                class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                Tambah
            </a>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">No</th>
                    <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('sort') === 'nama' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Nama Instansi
                            @if(request('sort') === 'nama')
                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'pemerintah', 'direction' => request('sort') === 'pemerintah' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Pemerintah
                            @if(request('sort') === 'pemerintah')
                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'telepon', 'direction' => request('sort') === 'telepon' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Telepon
                            @if(request('sort') === 'telepon')
                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('sort') === 'email' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Email
                            @if(request('sort') === 'email')
                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'alamat', 'direction' => request('sort') === 'alamat' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Alamat
                            @if(request('sort') === 'alamat')
                                <span class="ml-1">{!! request('direction') === 'asc' ? '↑' : '↓' !!}</span>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider dark:text-white">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @forelse($institutions as $index => $institution)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center">{{ $index + $institutions->firstItem() }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center break-words">{{ $institution->nama }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center break-words">{{ $institution->pemerintah }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center break-words">{{ $institution->telepon ?? '-' }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center break-words">{{ $institution->email ?? '-' }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 dark:text-gray-400 text-center break-words">{{ $institution->alamat ?? '-' }}</td>
                        <td class="p-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-x-3">
                                <a href="{{ routeForRole('institution', 'edit', $institution->id) }}" 
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                            bg-yellow-500 text-white/90 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300
                                            dark:bg-yellow-900/40 dark:text-yellow-300 dark:hover:bg-yellow-800/60 dark:focus:ring-yellow-800/50
                                            transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                <form method="POST" action="{{ routeForRole('institution', 'destroy', $institution->id) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                                    bg-red-500 text-white/90 hover:bg-red-600 focus:ring-4 focus:ring-red-300
                                                    dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-800/60 dark:focus:ring-red-800/50
                                                    transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data instansi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if ($institutions->hasPages())
        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                Menampilkan <span class="font-medium">{{ $institutions->firstItem() }}</span> sampai
                <span class="font-medium">{{ $institutions->lastItem() }}</span> dari
                <span class="font-medium">{{ $institutions->total() }}</span> hasil
            </div>
            <div>
                {{ $institutions->links() }}
            </div>
        </div>
    @endif
</div>

@endsection