<div class="sidebar">
    <!-- Profile Info -->
    <div class="text-center p-4 border-bottom">
        <div class="d-flex justify-content-center mb-3">
            <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://via.placeholder.com/80x80/6366f1/white?text=' . substr(Auth::user()->name, 0, 1) }}"
                alt="Profile" class="rounded-circle border border-1 border-secondary shadow-sm" width="80"
                height="80" style="object-fit: cover;">
        </div>
        <h6 class="fw-semibold mb-1">{{ Auth::user()->name }}</h6>
        <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>

        <div class="mt-2">
            <span class="badge bg-primary">Customer</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('landing') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 text-success border-bottom border-light">
                    <i class="fas fa-external-link-alt me-3"></i>
                    <div>
                        <div class="fw-semibold">Halaman Utama</div>
                        <small class="text-muted">Lihat pesanan tersedia</small>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.dashboard') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('customer.dashboard') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-home me-3"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.orders.index') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('customer.orders.index') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-shopping-bag me-3"></i>
                    Pesanan Saya
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.orders.create') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('customer.orders.create') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-plus-circle me-3"></i>
                    Buat Pesanan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.history.index') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('customer.history.*') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-history me-3"></i>
                    Riwayat Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('profile.*') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-user-cog me-3"></i>
                    Profil
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout -->
    <div class="position-absolute bottom-0 w-100 p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">
                <i class="fas fa-sign-out-alt me-2"></i>
                Logout
            </button>
        </form>
    </div>
</div>

<!-- Mobile Toggle Button -->
<button class="btn btn-primary d-md-none position-fixed sidebar-toggle" style="top: 15px; left: 15px; z-index: 1001;"
    onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>
