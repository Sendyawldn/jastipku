@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pesanan Saya</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Pesanan Saya</h2>
                        <p class="text-muted">Kelola dan pantau status pesanan Anda</p>
                    </div>
                    <a href="{{ route('customer.orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Buat Pesanan Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter and Search -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="text" class="form-control" placeholder="Cari nama barang..." id="searchInput">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="accepted">Diterima</option>
                            <option value="in_progress">Dalam Proses</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select class="form-select" id="categoryFilter">
                            <option value="">Semua Kategori</option>
                            <option value="fashion">Fashion</option>
                            <option value="skincare">Skincare</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="makanan">Makanan</option>
                            <option value="buku">Buku</option>
                            <option value="beauty">Beauty</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button class="btn btn-outline-primary w-100" onclick="resetFilters()">
                            <i class="fas fa-refresh me-2"></i>
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        @if ($orders->count() > 0)
            <div class="row" id="ordersContainer">
                @foreach ($orders as $order)
                    <div class="col-lg-6 mb-4 order-item" data-status="{{ $order->status }}"
                        data-category="{{ $order->kategori }}" data-name="{{ strtolower($order->nama_barang) }}">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-warning text-dark',
                                            'accepted' => 'bg-info text-white',
                                            'in_progress' => 'bg-primary text-white',
                                            'completed' => 'bg-success text-white',
                                            'cancelled' => 'bg-danger text-white',
                                        ];
                                        $statusTexts = [
                                            'pending' => 'Menunggu',
                                            'accepted' => 'Diterima',
                                            'in_progress' => 'Dalam Proses',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary text-white' }}">
                                        {{ $statusTexts[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                    <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-3">{{ $order->nama_barang }}</h5>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                            Tujuan: {{ ucfirst($order->destination) }}
                                        </small>
                                        <span class="badge bg-info-subtle text-info">{{ ucfirst($order->kategori) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar text-primary me-1"></i>
                                            Deadline: {{ $order->deadline->format('d M Y') }}
                                        </small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-wallet text-primary me-1"></i>
                                            Budget
                                        </small>
                                        <strong class="text-success">Rp
                                            {{ number_format($order->budget, 0, ',', '.') }}</strong>
                                    </div>
                                </div>
                                @if ($order->display_ongkos_jasa)
<div class="d-flex justify-content-between align-items-center">
    <small class="text-muted">
        <i class="fas fa-hand-holding-usd text-info me-1"></i>
        Ongkos Jasa Estimasi
    </small>
    <strong class="text-info">Rp
        {{ number_format($order->display_ongkos_jasa, 0, ',', '.') }}</strong>
</div>
@endif

                                @if ($order->traveler)
                                    <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                                        <img src="{{ $order->traveler->profile_photo_path ? asset('storage/' . $order->traveler->profile_photo_path) : 'https://via.placeholder.com/30x30' }}"
                                            alt="{{ $order->traveler->name }}" class="rounded-circle me-2" width="30"
                                            height="30">
                                        <div>
                                            <small class="fw-semibold">{{ $order->traveler->name }}</small>
                                            <div class="d-flex align-items-center">
                                                <div class="text-warning me-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="fas fa-star{{ $i <= $order->traveler->rating ? '' : '-o' }}"></i>
                                                    @endfor
                                                </div>
                                                <small
                                                    class="text-muted">({{ number_format($order->traveler->rating, 1) }})</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <p class="card-text text-muted small">{{ Str::limit($order->deskripsi, 100) }}</p>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('customer.orders.show', $order) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>
                                        Detail
                                    </a>

                                    @if ($order->status === 'pending')
                                        <form action="{{ route('customer.orders.destroy', $order) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                <i class="fas fa-times me-1"></i>
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-shopping-bag text-muted mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mb-3">Belum Ada Pesanan Aktif</h4>
                            <p class="text-muted mb-4">Anda belum memiliki pesanan yang sedang diproses. Mulai buat pesanan
                                baru!</p>
                            <a href="{{ route('customer.orders.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>
                                Buat Pesanan Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Filter functionality
        function filterOrders() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;
            const orderItems = document.querySelectorAll('.order-item');

            orderItems.forEach(item => {
                const itemName = item.getAttribute('data-name');
                const itemStatus = item.getAttribute('data-status');
                const itemCategory = item.getAttribute('data-category');

                const matchesSearch = !searchTerm || itemName.includes(searchTerm);
                const matchesStatus = !statusFilter || itemStatus === statusFilter;
                const matchesCategory = !categoryFilter || itemCategory === categoryFilter;

                if (matchesSearch && matchesStatus && matchesCategory) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('categoryFilter').value = '';
            filterOrders();
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', filterOrders);
        document.getElementById('statusFilter').addEventListener('change', filterOrders);
        document.getElementById('categoryFilter').addEventListener('change', filterOrders);
    </script>
@endpush
