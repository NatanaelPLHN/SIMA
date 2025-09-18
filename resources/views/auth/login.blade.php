<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMA DISKOMINFO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="antialiased">
    <div class="flex min-h-screen">
        <!-- Form Login -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-white px-8">
            <div class="max-w-md w-full">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-10">
                    <img src="{{ asset('assets/img/logo.svg') }}" class="w-14 h-14" alt="Logo">
                    <div>
                        <h1 class="text-3xl font-bold text-indigo-700">SIMA</h1>
                        <p class="text-sm text-gray-500">Sistem Manajemen Aset DISKOMINFO</p>
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang 👋</h2>
                <p class="text-gray-500 text-sm mb-8">Silakan masuk untuk melanjutkan</p>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input id="email" name="email" type="email" required
                            class="w-full px-4 py-3 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input id="password" name="password" type="password" required
                            class="w-full px-4 py-3 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md transition">
                        LOGIN
                    </button>
                </form>

                <!-- Footer -->
                <p class="mt-6 text-center text-sm text-gray-600">
                    Belum punya akun? <a href="#" class="text-indigo-600 hover:underline">Hubungi Admin</a>
                </p>
            </div>
        </div>

        <!-- Bagian kanan (Gambar / Gradient) -->
        <div
            class="hidden md:flex md:w-1/2 bg-gradient-to-r from-white via-indigo-300 to-indigo-500 items-center justify-center">
            <img src="{{ asset('assets/img/login.svg') }}" alt="Login Illustration"
                class="w-3/4 h-auto object-contain drop-shadow-lg">
        </div>
    </div>

    {{-- Pop up SweetAlert jika login gagal --}}
    @if(session('loginError'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ session('loginError') }}',
                confirmButtonColor: '#6366F1'
            });
        </script>
    @endif
</body>

</html>
