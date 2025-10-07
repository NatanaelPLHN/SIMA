@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-lg font-semibold text-indigo-800">Ubah User</h1>
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form action="{{ routeForRole('user', 'update', $user) }}" method="POST"
            class="grid grid-cols-1 md:grid-cols gap-6">
            @csrf
            @method('PUT')

            <!-- Form Groups -->
            @include('user._user')

            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ routeForRole('user', 'index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
