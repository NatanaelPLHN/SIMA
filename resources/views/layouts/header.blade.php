<header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center">
    </div>
    {{-- <div class="container-fluid"> --}}
        <div class="flex items-center space-x-3">
            <div class="flex items-center">
                {{-- <span> --}}
                {{-- <i class="fas fa-user text-indigo-600 mr-2"></i> --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.profil') }}"><i class="fas fa-user-circle"></i></a>
                @elseif(auth()->user()->role === 'superadmin')
                    <a href="{{ route('superadmin.profil') }}"><i class="fas fa-user-circle"></i></a>
                @elseif(auth()->user()->role === 'user')
                    <a href="{{ route('user.profil') }}"><i class="fas fa-user-circle"></i></a>
                @endif

                {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
            {{-- </span> --}}

            </div>
        </div>
</header>
