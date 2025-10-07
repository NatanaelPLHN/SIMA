@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-lg font-semibold text-indigo-800">Tambah Pegawai</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form action="{{ routeForRole('employee', 'store') }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols gap-6">
            <!-- Form Groups -->
            @include('employee._employee')
            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ routeForRole('employee', 'index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
    </div>
    </div>


@endsection