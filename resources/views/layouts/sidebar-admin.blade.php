<!-- Sidebar -->
<div class="w-64 bg-indigo-800 text-white flex flex-col min-h-screen">
    <!-- Logo and Title -->
    <div class="p-4 border-b border-indigo-700">
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                <i class="fas fa-key text-white"></i>
            </div>
            <span class="text-xl font-bold">SIM ASET</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4">
        <ul class="space-y-2">
            <li class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-indigo-700">
                <i class="fas fa-home mr-2"></i>
                DASHBOARD
            </li>
            <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                <i class="fas fa-cube mr-2"></i>
                Aset
            </li>
            <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                Penggunaan Aset
            </li>
            <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                Peminjaman Aset
            </li>
            <li class="flex items-center px-3 py-2 text-sm font-medium hover:bg-indigo-700 cursor-pointer">
                Mutasi Aset
            </li>
        </ul>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-indigo-700">

        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button
            class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-indigo-200 hover:text-white transition-colors">
            Log Out
            <i class="fas fa-sign-out-alt ml-1"></i>
        </button>
        </form>
    </div>
</div>
