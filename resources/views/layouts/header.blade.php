<nav class="fixed z-30 w-full bg-white border-b-2 border-gray-300 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
                    class="p-2 text-gray-600 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100
           dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700
           dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ">

                    <!-- Hamburger -->
                    <svg id="sidebarIconOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg id="sidebarIconClose" class="hidden w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg> <!-- Close -->


                </button>

                <a href="#" class="flex ml-2 md:mr-24">
                    <div class="flex items-center justify-center w-10 h-10 bg-white rounded-full">
                        <img src="{{ asset('assets/img/logo.svg') }}" class="h-9" alt="Disko Logo" />
                    </div>
                    <span class="self-center ml-2 text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
                        SIM ASET
                    </span>
                </a>
            </div>

            <div class="flex items-center">
                <button type="button"
                    class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                </button>


                <!-- Notifications -->
                <button type="button" data-dropdown-toggle="notification-dropdown"
                    class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                    <span class="sr-only">View notifications</span>
                    <!-- Bell icon -->
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                        </path>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div class="z-20 z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:divide-gray-600 dark:bg-gray-700"
                    id="notification-dropdown">
                    <div
                        class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        Notifications
                    </div>
                    <div>
                        @if (isset($notifications) && $notifications->count() > 0)
                            @foreach ($notifications as $notification)
                                <a href="{{ routeForRole('opname', 'index') }}"
                                    class="flex px-4 py-3 border-b-2 hover:bg-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <!-- Icon bisa disesuaikan -->
                                        <div
                                            class="absolute flex items-center justify-center w-5 h-5 ml-6
                                   -mt-5 bg-blue-500 border border-white rounded-full">
                                            <svg class="w-3 h-3 text-white" aria-hidden="true"
                                                xmlns=
                                   "http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10
                                   0Zm3.932 13.885-2.014-2.014a1 1 0 0 0-1.414 0l-2.014 2.014a1 1 0 0 1-1.414-1.414l2.014-2.014a1 1
                                   0 0 0 0-1.414L6.07 7.028a1 1 0 1 1 1.414-1.414l2.014 2.014a1 1 0 0 0 1.414 0l2.014-2.014a1 1 0 1
                                   1 1.414 1.414L12.914 8.97a1 1 0 0 0 0 1.414l2.014 2.014a1 1 0 0 1-1.414 1.414Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="w-full pl-3">
                                        <div
                                            class="text-gray-500 font-normal text-sm mb-1.5
                                   dark:text-gray-400">
                                            Opname baru dijadwalkan untuk <span
                                                class="font-semibold
                                   text-gray-900 dark:text-white">{{ $notification->departement->nama ?? 'Departemen' }}</span>.
                                        </div>
                                        <div
                                            class="text-xs font-medium text-primary-700
                                   dark:text-primary-400">
                                            {{ $notification->tanggal_dijadwalkan->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada notifikasi baru.
                            </div>
                        @endif

                    </div>
                    <a href="#"
                        class="block py-2 text-base font-normal text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline">
                        <div class="inline-flex items-center ">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd"
                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            View all
                        </div>
                    </a>
                </div>
                
                <div x-data="{
                    darkMode: localStorage.getItem('color-theme') ?
                        localStorage.getItem('color-theme') === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches,

                    toggle() {
                        this.darkMode = !this.darkMode;
                        document.documentElement.classList.toggle('dark', this.darkMode);
                        localStorage.setItem('color-theme', this.darkMode ? 'dark' : 'light');
                    }
                }" x-init="document.documentElement.classList.toggle('dark', darkMode)">
                    <button @click="toggle" class="p-2 rounded-lg  border-gray-300 dark:border-gray-600">
                        <template x-if="darkMode">
                            <i class="fas fa-sun text-yellow-400"></i>
                        </template>

                        <template x-if="!darkMode">
                            <i class="fas fa-moon text-gray-700"></i>
                        </template>
                    </button>
                </div>



                <div id="tooltip-toggle" role="tooltip"
                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                    Toggle darak mode
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <!-- Profile -->
                <!-- WRAPPER RELATIF -->
<div class="relative flex items-center ml-3">
    <!-- Tombol Trigger -->
    <button type="button"
        id="user-menu-button-2"
        aria-expanded="false"
        data-dropdown-toggle="dropdown-2"
        class="flex items-center justify-center w-10 h-10 text-sm
               bg-gray-200 text-gray-800 hover:bg-gray-300
               dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700
               rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition-colors">
        <span class="sr-only">Open user menu</span>
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
        </svg>
    </button>

    <!-- Dropdown Menu (sekarang di dalam relative container) -->
    <div class="z-50 hidden my-2 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 absolute right-0 top-12 min-w-[200px]"
        id="dropdown-2">
        
        <!-- Header: Foto, Nama, Email, Role -->
        <div class="px-4 py-3 flex flex-col items-center text-center" role="none">
            <img class="h-12 w-12 rounded-full object-cover mb-2"
                src="{{ Auth::user()->Employee->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->Employee->nama ?? 'User') . '&background=0D8ABC&color=fff' }}"
                alt="{{ Auth::user()->Employee->nama ?? 'User' }}">
            <p class="text-sm font-medium text-gray-900 dark:text-white">
                {{ Auth::user()->Employee->nama ?? '-' }}
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[180px]">
                {{ Auth::user()->email }}
            </p>
            <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 mt-1">
                {{ ucfirst(Auth::user()->role) }}
            </p>
        </div>

        <!-- Menu Items -->
        <ul class="py-1" role="none">
            <li>
                <a href="{{ routeForRole('profile', 'index') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">
                    Ubah Password
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-600 dark:hover:text-white">
                    Sign out
                </a>
            </li>
        </ul>
    </div>
</div> <!-- Penutup .relative -->

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>
            </div>
        </div>
    </div>
</nav>
