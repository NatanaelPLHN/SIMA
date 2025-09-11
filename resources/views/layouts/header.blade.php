<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom px-3">
    <div class="container-fluid">
        {{-- <button class="btn btn-sm btn-outline-secondary" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </button> --}}

        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 fw-bold text-primary">
                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>
