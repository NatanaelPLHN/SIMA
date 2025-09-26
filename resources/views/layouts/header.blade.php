<header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
    <!-- Tombol menu hanya tampil di mobile -->
    <button @click="sidebarOpen = true" class="md:hidden p-2 text-indigo-800">
        <i class="fa-solid fa-bars text-2xl"></i>
    </button>

    <!-- Judul halaman -->
    <div class="flex items-center">
        <h1 class="text-lg font-semibold text-indigo-800">
            @yield('title', 'Dashboard')
        </h1>
    </div>

    <!-- Profil user -->
    <div class="flex items-center space-x-3">
        <div class="flex items-center">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.profil') }}"><i class="fas fa-user-circle mr-1.5"></i></a>
            @elseif(auth()->user()->role === 'superadmin')
                <a href="{{ route('superadmin.profil') }}"><i class="fas fa-user-circle mr-1.5"></i></a>
            @elseif(auth()->user()->role === 'user')
                <a href="{{ route('user.profil') }}"><i class="fas fa-user-circle mr-1.5"></i></a>
            @endif
            {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
        </div>
    </div>
</header>
