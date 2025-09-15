@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Profile Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center mb-6">
                <div
                    class="w-24 h-24 bg-indigo-800 rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-user text-white text-3xl"></i>
                </div>
            </div>

            <div class="border-t border-indigo-200 pt-6">
                <h3 class="text-lg font-medium text-indigo-800 mb-4">John Doe</h3>
                <p class="text-sm text-indigo-800 font-medium">Admin SIM Aset</p>
                <p class="text-sm text-gray-600 mt-1">Email: jhon@gmail.com</p>
            </div>
        </div>

        <!-- Update Profile Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-medium text-indigo-800 mb-4">Ubah Profil</h3>
            <form class="space-y-4">
                <div>
                    <label for="name"
                        class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" id="name" value="John Doe"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" value="jhon@gmail.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="role"
                        class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <input type="text" id="role" value="Admin"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="bidang"
                        class="block text-sm font-medium text-gray-700 mb-1">Bidang</label>
                    <input type="text" id="bidang"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-medium text-indigo-800 mb-4">Ganti Password</h3>
            <form class="space-y-4">
                <div>
                    <label for="old-password"
                        class="block text-sm font-medium text-gray-700 mb-1">Password lama</label>
                    <div class="relative">
                        <input type="password" id="old-password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="new-password"
                        class="block text-sm font-medium text-gray-700 mb-1">Password baru</label>
                    <div class="relative">
                        <input type="password" id="new-password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="confirm-password"
                        class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi password
                        baru</label>
                    <div class="relative">
                        <input type="password" id="confirm-password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                        Ganti Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
