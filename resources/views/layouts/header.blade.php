<header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center">
        {{-- <button class="text-gray-600 hover:text-gray-800 mr-4">
            <i class="fas fa-bars text-xl"></i>
        </button> --}}
        {{-- <h1 class="text-lg font-semibold text-gray-800">Tambah Aset Bergerak</h1> --}}
    </div>
    {{-- <div class="container-fluid"> --}}
        <div class="flex items-center space-x-3">
            <div class="flex items-center">
                {{-- <i class="fas fa-user text-indigo-600 mr-2"></i> --}}
                <span class="me-3 fw-bold text-primary">
                    <a href="{{ route('profil') }}"><i class="fas fa-user-circle"></i></a>

                    {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                </span>

            </div>
        </div>
</header>
