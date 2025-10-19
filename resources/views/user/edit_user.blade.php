@extends('layouts.app')

@section('title', 'Ubah Akun')

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            @if (auth()->user()->role == 'superadmin')
                            <a href="{{ route('superadmin.dashboard') }}" @elseif (auth()->user()->role == 'admin') <a
                                href="{{ route('admin.dashboard') }}" @elseif (auth()->user()->role == 'subadmin') <a
                                    href="{{ route('subadmin.dashboard') }}" @endif
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
                                <a href="{{ routeForRole('user', 'index') }}"
                                    class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Daftar
                                    Akun</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2 dark:text-gray-500"
                                    aria-current="page">Ubah Akun</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Ubah Akun</h1>
            </div>
        </div>
    </div>

    <div class="p-4">
        <div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ routeForRole('user', 'update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- INFORMASI AKUN SAAT INI --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 border rounded-lg dark:border-gray-700">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                        <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Role</label>
                        <p class="font-semibold text-gray-800 dark:text-gray-200">{{ Str::ucfirst($user->role) }}</p>
                    </div>
                    @if ($user->employee)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Karyawan
                                Tertaut</label>
                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $user->employee->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Instansi</label>
                            <p class="font-semibold text-gray-800 dark:text-gray-200">
                                {{ $user->employee->institution->nama }}</p>
                        </div>
                        @if ($user->employee->department)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Departemen</label>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $user->employee->department->nama }}</p>
                            </div>
                        @endif
                    @endif
                </div>

                {{-- UBAH DATA AKUN --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 border-t pt-4 dark:border-gray-700">
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Ubah Data</h3>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                            <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password
                            Baru</label>
                        <input type="password" name="password" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Kosongkan jika tidak diubah">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password
                            Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="••••••••">
                    </div>
                </div>
                <div class="mt-6 border-t pt-4 dark:border-gray-700">
                    <button type="button" id="change-role-btn"
                        class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Ubah Role
                    </button>
                </div>

                {{-- TOMBOL UNTUK UBAH ROLE/KARYAWAN --}}
                <div id="change-role-section" class="hidden mt-4 pt-4 border-t dark:border-gray-600">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role
                                Baru</label>
                            <select id="role" name="role"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Jangan Ubah Role --</option>
                                @foreach ($roles as $key => $value)
                                    {{-- Hanya tampilkan role yang bisa di-assign oleh user saat ini --}}
                                    <option value="{{ $key }}"
                                        {{ old('role') == $key
                                            ? '
                                                                                                                                                                                                                        selected'
                                            : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 mt-6 flex justify-end space-x-3">
                    <a href="{{ routeForRole('user', 'index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-600 dark:focus:ring-offset-gray-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const changeBtn = document.getElementById('change-role-btn');
            const changeSection = document.getElementById('change-role-section');
            const roleSelect = document.getElementById('role');

            changeBtn.addEventListener('click', () => {
                changeSection.classList.toggle('hidden');
                // Jika disembunyikan, reset pilihan role agar tidak terkirim
                if (changeSection.classList.contains('hidden')) {
                    roleSelect.value = "";
                }
            });
        });
    </script>
@endpush
