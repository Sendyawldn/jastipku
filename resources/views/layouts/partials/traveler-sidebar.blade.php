<div class="sidebar">
    <div class="text-center p-4 border-bottom">
        <div class="d-flex justify-content-center mb-3">
            <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://via.placeholder.com/80x80/6366f1/white?text=' . substr(Auth::user()->name, 0, 1) }}"
                alt="Profile" class="rounded-circle border border-1 border-secondary shadow-sm" width="80"
                height="80" style="object-fit: cover;">
        </div>
        <h6 class="fw-semibold mb-1">{{ Auth::user()->name }}</h6>
        <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>

        {{-- Badge Khusus untuk Traveler --}}
        <div class="mt-2 d-flex justify-content-center align-items-center gap-2">
            <span class="badge bg-success">Traveler</span>
            @if (Auth::user()->isTraveler())
                <span class="badge bg-warning text-dark">
                    <i class="fas fa-star"></i> {{ number_format(Auth::user()->rating_display ?? 5.0, 1) }}
                </span>
            @endif
        </div>
    </div>

    <nav class="mt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('landing') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 text-success border-bottom border-light">
                    <i class="fas fa-external-link-alt me-3"></i>
                    <div>
                        <div class="fw-semibold">Halaman Utama</div>
                        <small class="text-muted">Cari pesanan baru</small>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('traveler.dashboard') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('traveler.dashboard') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-home me-3"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('traveler.active_orders.index') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('traveler.active_orders.*') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-tasks me-3"></i>
                    Pesanan Aktif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('traveler.history.index') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('traveler.history.*') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-history me-3"></i>
                    Riwayat Pesanan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('traveler.earnings.index') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('traveler.earnings.index') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-wallet me-3"></i>
                    Penghasilan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('traveler.earnings.history') }}"
                    class="nav-link d-flex align-items-center py-3 px-4 {{ request()->routeIs('traveler.earnings.history') ? 'active bg-light text-primary' : 'text-dark' }}">
                    <i class="fas fa-receipt me-3"></i>
                    Riwayat Penarikan
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

<button class="btn btn-primary d-md-none position-fixed sidebar-toggle" style="top: 15px; left: 15px; z-index: 1001;"
    onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>
