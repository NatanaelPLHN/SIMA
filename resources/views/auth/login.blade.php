<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMA DISKOMINFO</title>

    <script>
        if (
            localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div class="flex min-h-screen">
        <!-- Form Login -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-white dark:bg-gray-800 px-8">
            <div class="max-w-md w-full">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-10">
                    <img src="{{ asset('assets/img/logo.svg') }}" class="w-14 h-14" alt="Logo">
                    <div>
                        <h1 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">SIMA</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sistem Manajemen Aset DISKOMINFO</p>
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Selamat Datang 👋</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-8">Silakan masuk untuk melanjutkan</p>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input id="email" name="email" type="email" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                        <input id="password" name="password" type="password" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-xl shadow-md transition">
                        LOGIN
                    </button>
                </form>

                <!-- Footer -->
                {{-- <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    Belum punya akun? <a href="#" class="text-indigo-600 hover:underline dark:text-indigo-400">Hubungi Admin</a>
                </p> --}}
            </div>
        </div>

        <!-- Bagian kanan (Gambar / Gradient) -->
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-r from-white via-indigo-300 to-indigo-500 dark:from-gray-800 dark:via-indigo-700 dark:to-indigo-900 items-center justify-center">
            <img src="{{ asset('assets/img/login.svg') }}" alt="Login Illustration"
                class="w-3/4 h-auto object-contain drop-shadow-lg dark:drop-shadow-none">
        </div>
    </div>

    {{-- Pop up SweetAlert jika login gagal --}}
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

    <!-- Optional: Tambahkan tombol toggle dark mode (opsional di halaman login) -->
    <!-- Jika ingin, tambahkan di footer atau pojok -->
    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
</body>

</html>