@extends('layouts.app')

@section('title', 'Daftar instansi')

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                    aria-current="page">instansi</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar instansi</h1>
            </div>

            <!-- Controls: Entries, Search, Add Button -->
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
                                placeholder="Cari nama, pemerintah, dll..."
                            >
                        </div>
                        @if(request('search'))
                            <a href="{{ route('superadmin.institution.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-medium">
                                Clear
                            </a>
                        @endif
                        </form>
                </div>

                <div class="flex items-center space-x-2">
                    <label for="search" class="text-sm font-medium text-gray-700">Cari:</label>
                    <input type="text" id="search"
                        class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <a href="{{ routeForRole('institution', 'create') }}"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                        Tambah
                    </a>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-800">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            No</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Nama Instansi</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Pemerintah</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Telepon</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Email</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Alamat</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($institutions as $index => $institution)
                        <tr>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">
                                {{ $index + 1 }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">
                                {{ $institution->nama }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">
                                {{ $$institution->pemerintah }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">
                                {{ $institution->telepon ?? '-' }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">
                                {{ $institution->email ?? '-' }}</td>
                            <td class="text-center px-4 py-3 text-sm text-gray-900 whitespace-normal break-words">
                                {{ $institution->alamat ?? '-' }}</td>
                            <td class="text-center px-4 py-3 text-sm whitespace-normal break-words">
                                <div class="flex items-center justify-center gap-x-3">
                                    <a class="fas fa-edit text-yellow-600 hover:text-yellow-800"
                                        href="{{ routeForRole('institution', 'edit', $instansi->id) }}"></a>
                                    <form method="POST" action="{{ routeForRole('institution', 'destroy', $instansi->id) }}"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button class="fas fa-trash text-red-600 hover:text-red-800"
                                            type="submit"></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $institutions->links() }}
    </div>

    <!-- Pagination Footer -->
    @if ($institutions->hasPages())
        <div
            class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center mb-4 sm:mb-0">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Menampilkan <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $institutions->firstItem() }}–{{ $institutions->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $institutions->total() }}</span> data
                </span>
            </div>
            <div class="flex items-center space-x-3">
                {{ $institutions->links() }}
            </div>
        </div>
    @endif

@endsection
