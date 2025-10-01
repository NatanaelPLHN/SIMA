<!-- Sidebar -->
<div class="w-64 bg-indigo-800 text-white flex flex-col h-full  "
     x-data="{ masterOpen: false, monitoringOpen: false, reportOpen: false }">
    <!-- Logo and Title -->
    <div class="p-4 border-b border-indigo-700">
        <div class="flex items-center space-x-2">
            <div
                class="w-12 h-12 bg-white rounded-full flex items-center justify-center border-2 border-indigo-700 shadow">
                <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo SIM ASET" class="w-9 h-9 object-contain">
            </div>
            <span class="text-xl font-bold">SIM ASET</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">

            {{-- Khusus ADMIN --}}
            @if(auth()->user()->role == 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-indigo-700">
                        <i class="fas fa-home mr-2"></i>
                        DASHBOARD
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.assets.index') }}"
                        class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-indigo-700">
                        <i class="fas fa-cube mr-2"></i>
                        Aset
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.borrowing.index') }}"
                        class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-indigo-700">
                        {{-- icon --}}
                        {{-- <i class="fas fa-clipboard-list mr-2"></i> --}}
                        Penggunaan Aset
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.opname.index') }}"
                        class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-indigo-700">
                        {{-- icon --}}
                        {{-- <i class="fas fa-clipboard-list mr-2"></i> --}}
                        Stock Opname
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-indigo-700">
                        {{-- <i class="fas fa-handshake mr-2"></i> --}}
                        Peminjaman Aset
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-indigo-700">
                        {{-- <i class="fas fa-random mr-2"></i> --}}
                        Mutasi Aset
                    </a>
                </li>
            @endif

            {{-- Khusus USER --}}
            @if(auth()->user()->role == 'user')
                <li>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-indigo-700">
                        <i class="fas fa-home mr-2"></i>
                        DASHBOARD
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-indigo-700">
                        <i class="fas fa-cube mr-2"></i>
                        Peminjaman Aset
                    </a>
                </li>
            @endif

            {{-- Khusus SUPERADMIN --}}
            @if(auth()->user()->role == 'superadmin')
                <li>
                    <a href="{{ route('superadmin.dashboard') }}"
                        class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-indigo-700">
                        <i class="fas fa-home mr-2"></i>
                        DASHBOARD
                    </a>
                </li>
                <li>
                    <button @click="masterOpen = !masterOpen"
                        class="flex items-center justify-between w-full px-3 py-2 hover:bg-indigo-700 rounded-md">
                        <span class="flex items-center"><i class="fas fa-database mr-2"></i> Master Data</span>
                        <i :class="masterOpen ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                    </button>
                    <ul x-show="masterOpen" x-transition class="ml-6 mt-1 space-y-1">
                        <li><a href="{{ route('superadmin.institution.index') }}"
                                class="block px-2 py-1 hover:text-indigo-200">Instansi</a></li>
                        <li><a href="{{ route('superadmin.departement.index') }}" class="block px-2 py-1 hover:text-indigo-200">Bidang</a>
                        </li>
                        <li><a href="{{ route('superadmin.employee.index') }}"
                                class="block px-2 py-1 hover:text-indigo-200">Pegawai</a></li>
                        <li><a href="{{route('superadmin.user.index')}}" class="block px-2 py-1 hover:text-indigo-200">Akun</a></li>
                        <li><a href="{{ route('superadmin.categories.index') }}" class="block px-2 py-1 hover:text-indigo-200">Kategori</a></li>
                        <li><a href="{{ route('superadmin.category-groups.index') }}" class="block px-2 py-1 hover:text-indigo-200">Grup Kategori</a></li>
                        <li><a href="{{ route('superadmin.assets.index') }}" class="block px-2 py-1 hover:text-indigo-200">Aset</a></li>
                    </ul>
                </li>

                <!-- Drawer Monitoring -->
                <li>
                    <button @click="monitoringOpen = !monitoringOpen"
                        class="flex items-center justify-between w-full px-3 py-2 hover:bg-indigo-700 rounded-md">
                        <span class="flex items-center"><i class="fas fa-desktop mr-2"></i> Monitoring Aset</span>
                        <i :class="monitoringOpen ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                    </button>
                    <ul x-show="monitoringOpen" x-transition class="ml-6 mt-1 space-y-1">
                        <li><a href="#" class="block px-2 py-1 hover:text-indigo-200">Data Peminjaman</a></li>
                        <li><a href="#" class="block px-2 py-1 hover:text-indigo-200">Mutasi Aset</a></li>
                        <li><a href="{{ route('superadmin.opname.index') }}" class="block px-2 py-1 hover:text-indigo-200">Stock Opname</a></li>
                    </ul>
                </li>

                <!-- Drawer Report -->
                <li>
                    <button @click="reportOpen = !reportOpen"
                        class="flex items-center justify-between w-full px-3 py-2 hover:bg-indigo-700 rounded-md">
                        <span class="flex items-center"><i class="fas fa-chart-bar mr-2"></i> Report</span>
                        <i :class="reportOpen ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                    </button>
                    <ul x-show="reportOpen" x-transition class="ml-6 mt-1 space-y-1">
                        <li><a href="{{ route('superadmin.qr') }}" class="block px-2 py-1 hover:text-indigo-200">Label
                                Barcode</a></li>
                        <li><a href="#" class="block px-2 py-1 hover:text-indigo-200">Kartu Inventaris</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-indigo-700 mt-auto">

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
