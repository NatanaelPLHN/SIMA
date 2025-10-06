<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMA DISKOMINFO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0">
        <!-- Logo -->
        <div class="max-w-md w-full">
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-10">
                <img src="{{ asset('assets/img/logo.svg') }}" class="w-14 h-14" alt="Logo">
                <div>
                    <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-400">SIMA</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Sistem Manajemen Aset DISKOMINFO
                    </p>
                </div>
            </div>
        </div>


        <!-- Card -->
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Selamat Datang 👋
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Silakan masuk untuk melanjutkan
            </p>

            <!-- Form -->
            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg 
                               focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 
                               dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                               dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        placeholder="name@company.com" required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg 
                               focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 
                               dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                               dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" required>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 
                                   focus:ring-3 focus:ring-indigo-300 dark:focus:ring-indigo-600 
                                   dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="remember" class="font-medium text-gray-900 dark:text-white">Ingat saya</label>
                    </div>
                    <a href="#" class="ml-auto text-sm text-indigo-700 hover:underline dark:text-indigo-400">Lupa
                        Password?</a>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full px-5 py-3 text-base font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 sm:w-auto dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800">
                    LOGIN
                </button>

                <!-- Register Info -->
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Belum punya akun? <a href="#" class="text-indigo-600 hover:underline dark:text-indigo-400">Hubungi
                        Admin</a>
                </div>
            </form>
        </div>
    </div>

    {{-- SweetAlert jika login gagal --}}
    @if(session('loginError'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: '{{ session('loginError') }}',
                    confirmButtonColor: '#6366F1'
                });
            });
        </script>
    @endif
</body>

</html>