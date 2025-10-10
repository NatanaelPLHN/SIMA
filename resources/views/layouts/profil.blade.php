@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Profile Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <!-- Header dengan gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-user text-indigo-600 text-4xl"></i>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-white">
                    {{ $user->employee->nama ?? '-' }}
                </h3>
                <p class="text-indigo-200 text-sm">{{ ucfirst($user->role) ?? 'User' }}</p>
            </div>

            <!-- Detail -->
            <div class="p-6 space-y-4">
                <div class="flex items-center text-gray-700 dark:text-gray-300">
                    <i class="fas fa-envelope w-6 text-indigo-500"></i>
                    <span class="ml-2">{{ $user->email }}</span>
                </div>
                <div class="flex items-center text-gray-700 dark:text-gray-300">
                    <i class="fas fa-building w-6 text-indigo-500"></i>
                    <span class="ml-2">{{ $user->employee->institution->nama ?? '-' }}</span>
                </div>
                <div class="flex items-center text-gray-700 dark:text-gray-300">
                    <i class="fas fa-sitemap w-6 text-indigo-500"></i>
                    <span class="ml-2">{{ $user->employee->department->nama ?? '-' }}</span>
                </div>
                <div class="flex items-center text-gray-700 dark:text-gray-300">
                    <i class="fas fa-user-shield w-6 text-indigo-500"></i>
                    <span class="ml-2">
                        @php
                            $role = $user->role;
                            $department = $user->employee?->department?->nama ?? '';
                            $institution = $user->employee?->institution?->nama ?? '';
                        @endphp

                        @if($user->role === 'admin' && $institution)
                            Admin {{ $institution }}
                        @elseif($user->role === 'subadmin' && $department)
                            Admin {{ $department }}
                        @elseif($user->role === 'superadmin')
                            Super Admin SIMA
                        @else
                            User SIMA
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-indigo-800 dark:text-indigo-300 mb-6">Ganti Password</h3>
            <form action="{{ routeForRole('profile', 'update', $user) }}" method="POST"
            class="space-y-5">
            @csrf
            @method('PUT')
            {{-- <form class="space-y-5"> --}}
                <!-- Old Password -->
                <div>
                    <label for="old-password" class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                        Password lama
                    </label>
                    <div class="relative">
                        <input type="password" id="old-password" name="old-password"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <button type="button" onclick="togglePassword('old-password', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <!-- New Password -->
                <div>
                    <label for="new-password" class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                        Password baru
                    </label>
                    <div class="relative">
                        <input type="password" id="new-password" name="new-password"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <button type="button" onclick="togglePassword('new-password', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm-password" class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                        Konfirmasi password baru
                    </label>
                    <div class="relative">
                        <input type="password" id="confirm-password" name="new-password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <button type="button" onclick="togglePassword('confirm-password', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg shadow hover:from-green-600 hover:to-emerald-700 transition-colors">
                        Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk toggle password -->
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>
@endsection
