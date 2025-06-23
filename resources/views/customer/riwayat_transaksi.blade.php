@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Riwayat Transaksi</li>
                    </ol>
                </nav>
                <h2 class="fw-bold text-dark mb-1">Riwayat Transaksi</h2>
                <p class="text-muted">Daftar lengkap pesanan yang telah selesai atau dibatalkan</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                                <i class="fas fa-check-circle fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ $stats['completed'] ?? 0 }}</h4>
                                <p class="mb-0 opacity-75">Pesanan Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                                <i class="fas fa-times-circle fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ $stats['cancelled'] ?? 0 }}</h4>
                                <p class="mb-0 opacity-75">Pesanan Dibatalkan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                                <i class="fas fa-wallet fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">Rp {{ number_format($stats['total_spent'] ?? 0, 0, ',', '.') }}
                                </h4>
                                <p class="mb-0 opacity-75">Total Pengeluaran</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                                <i class="fas fa-chart-line fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">Rp {{ number_format($stats['avg_spent'] ?? 0, 0, ',', '.') }}</h4>
                                <p class="mb-0 opacity-75">Rata-rata per Order</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('customer.history.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" placeholder="Cari nama barang..." id="searchInput"
                                name="search" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <select class="form-select" id="statusFilter" name="status">
                                <option value="">Semua Status</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select class="form-select" id="categoryFilter" name="category">
                                <option value="">Semua Kategori</option>
                                <option value="fashion" {{ request('category') == 'fashion' ? 'selected' : '' }}>👗 Fashion
                                    & Pakaian</option>
                                <option value="skincare" {{ request('category') == 'skincare' ? 'selected' : '' }}>🧴
                                    Skincare & Kosmetik</option>
                                <option value="elektronik" {{ request('category') == 'elektronik' ? 'selected' : '' }}>📱
                                    Elektronik</option>
                                <option value="makanan" {{ request('category') == 'makanan' ? 'selected' : '' }}>🍎 Makanan
                                    & Minuman</option>
                                <option value="buku" {{ request('category') == 'buku' ? 'selected' : '' }}>📚 Buku &
                                    Majalah</option>
                                <option value="beauty" {{ request('category') == 'beauty' ? 'selected' : '' }}>💄 Beauty &
                                    Health</option>
                                <option value="accessories" {{ request('category') == 'accessories' ? 'selected' : '' }}>👜
                                    Accessories</option>
                                <option value="toys" {{ request('category') == 'toys' ? 'selected' : '' }}>🧸 Mainan &
                                    Hobi</option>
                                <option value="sports" {{ request('category') == 'sports' ? 'selected' : '' }}>⚽ Olahraga
                                </option>
                                <option value="home" {{ request('category') == 'home' ? 'selected' : '' }}>🏠 Rumah
                                    Tangga</option>
                                <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>📦 Lainnya
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <input type="month" class="form-control" id="monthFilter" name="month"
                                value="{{ request('month') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <select class="form-select" id="sortFilter" name="sort">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Budget
                                    Tertinggi</option>
                                <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Budget Terendah
                                </option>
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <button type="button" class="btn btn-outline-primary w-100" onclick="resetFilters()">
                                <i class="fas fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- History List -->
        @if ($orders->count() > 0)
            <div class="row" id="historyContainer">
                @foreach ($orders as $order)
                    <div class="col-lg-6 mb-4 history-item" data-status="{{ $order->status }}"
                        data-category="{{ $order->kategori }}" data-name="{{ strtolower($order->nama_barang) }}"
                        data-date="{{ $order->completed_at ? $order->completed_at->format('Y-m') : $order->updated_at->format('Y-m') }}"
                        data-budget="{{ $order->budget }}">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    @php
                                        $statusClasses = [
                                            'completed' => 'bg-success text-white',
                                            'cancelled' => 'bg-danger text-white',
                                        ];
                                        $statusTexts = [
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary text-white' }}">
                                        {{ $statusTexts[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                    <div class="text-end">
                                        <small class="text-muted d-block">
                                            {{ $order->completed_at ? $order->completed_at->format('d M Y') : $order->updated_at->format('d M Y') }}
                                        </small>
                                        <small class="text-muted">
                                            {{ $order->completed_at ? $order->completed_at->format('H:i') : $order->updated_at->format('H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-2">{{ $order->nama_barang }}</h5>
                                        <span
                                            class="badge bg-info-subtle text-info">{{ ucfirst($order->kategori) }}</span>
                                    </div>
                                    @if ($order->status === 'completed' && $order->customer_rating)
                                        <div class="text-end">
                                            <div class="text-warning">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star{{ $i <= $order->customer_rating ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted">Rating Anda</small>
                                        </div>
                                    @endif
                                </div>

                                <!-- Order Summary -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="border rounded p-2 text-center">
                                            <small class="text-muted d-block">Tujuan</small>
                                            <span class="fw-semibold">{{ ucfirst($order->destination) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-2 text-center">
                                            <small class="text-muted d-block">Budget Awal</small>
                                            <span class="fw-semibold">Rp
                                                {{ number_format($order->budget, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    @if ($order->status === 'completed')
                                        <div class="col-6">
                                            <div class="border rounded p-2 text-center bg-success bg-opacity-10">
                                                <small class="text-muted d-block">Total Belanja</small>
                                                <span class="fw-semibold text-success">Rp
                                                    {{ number_format($order->total_belanja ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border rounded p-2 text-center bg-primary bg-opacity-10">
                                                <small class="text-muted d-block">Ongkos Jasa</small>
                                                <span class="fw-semibold text-primary">Rp
                                                    {{ number_format($order->ongkos_jasa ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Traveler Info -->
                                @if ($order->traveler)
                                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                        <img src="{{ $order->traveler->profile_photo_path ? asset('storage/' . $order->traveler->profile_photo_path) : 'https://via.placeholder.com/50x50' }}"
                                            alt="{{ $order->traveler->name }}" class="rounded-circle me-3"
                                            width="50" height="50">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $order->traveler->name }}</h6>
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="text-warning me-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="fas fa-star{{ $i <= $order->traveler->rating ? '' : '-o' }}"></i>
                                                    @endfor
                                                </div>
                                                <small
                                                    class="text-muted">({{ number_format($order->traveler->rating, 1) }})</small>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-check-circle text-success me-1"></i>
                                                {{ $order->traveler->completed_orders_count ?? 0 }} pesanan selesai
                                            </small>
                                        </div>
                                        @if ($order->status === 'completed')
                                            <div class="text-end">
                                                <span class="badge bg-success">Berhasil</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Description -->
                                <p class="card-text text-muted small mb-3">{{ Str::limit($order->deskripsi, 100) }}</p>

                                <!-- Progress Timeline -->
                                @if ($order->status === 'completed')
                                    <div class="mb-3">
                                        <small class="text-muted fw-semibold">Timeline:</small>
                                        <div class="mt-2">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="bg-success rounded-circle me-2"
                                                    style="width: 8px; height: 8px;"></div>
                                                <small class="text-muted">Dibuat:
                                                    {{ $order->created_at->format('d M Y, H:i') }}</small>
                                            </div>
                                            @if ($order->accepted_at)
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="bg-info rounded-circle me-2"
                                                        style="width: 8px; height: 8px;"></div>
                                                    <small class="text-muted">Diterima:
                                                        {{ $order->accepted_at->format('d M Y, H:i') }}</small>
                                                </div>
                                            @endif
                                            @if ($order->completed_at)
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success rounded-circle me-2"
                                                        style="width: 8px; height: 8px;"></div>
                                                    <small class="text-muted">Selesai:
                                                        {{ $order->completed_at->format('d M Y, H:i') }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $order->id }}">
                                        <i class="fas fa-eye me-1"></i>
                                        Detail Lengkap
                                    </button>

                                    <div class="d-flex gap-2">
                                        @if ($order->status === 'completed')
                                            @if (!$order->customer_rating)
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#ratingModal{{ $order->id }}">
                                                    <i class="fas fa-star me-1"></i>
                                                    Beri Rating
                                                </button>
                                            @endif
                                        @endif

                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('customer.orders.invoice', $order) }}"
                                                        class="dropdown-item" target="_blank">
                                                        <i class="fas fa-download"></i>
                                                        Download Invoice
                                                    </a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="shareOrder({{ $order->id }})">
                                                        <i class="fas fa-share me-2"></i>Bagikan
                                                    </a></li>
                                                @if ($order->status === 'completed' && $order->traveler)
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"
                                                            onclick="reportIssue({{ $order->id }})">
                                                            <i class="fas fa-flag me-2"></i>Laporkan Masalah
                                                        </a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Transaksi: {{ $order->nama_barang }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Order Status Badge -->
                                    <div class="text-center mb-4">
                                        <span
                                            class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary text-white' }} fs-6 px-3 py-2">
                                            {{ $statusTexts[$order->status] ?? ucfirst($order->status) }}
                                        </span>
                                    </div>

                                    <!-- Timeline -->
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-3">Timeline Pesanan</h6>
                                        <div class="timeline">
                                            <div class="timeline-item">
                                                <div class="timeline-icon bg-primary">
                                                    <i class="fas fa-plus"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <h6>Pesanan Dibuat</h6>
                                                    <small
                                                        class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                                </div>
                                            </div>

                                            @if ($order->accepted_at)
                                                <div class="timeline-item">
                                                    <div class="timeline-icon bg-info">
                                                        <i class="fas fa-handshake"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>Pesanan Diterima Traveler</h6>
                                                        <small
                                                            class="text-muted">{{ $order->accepted_at->format('d M Y, H:i') }}</small>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($order->completed_at)
                                                <div class="timeline-item">
                                                    <div class="timeline-icon bg-success">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>Pesanan Selesai</h6>
                                                        <small
                                                            class="text-muted">{{ $order->completed_at->format('d M Y, H:i') }}</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Order Details -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Detail Pesanan</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td class="fw-semibold text-muted">Nama Barang:</td>
                                                    <td>{{ $order->nama_barang }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">Kategori:</td>
                                                    <td><span class="badge bg-info">{{ ucfirst($order->kategori) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">Tujuan:</td>
                                                    <td>{{ ucfirst($order->destination) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-muted">Deadline:</td>
                                                    <td>{{ $order->deadline->format('d F Y') }}</td>
                                                </tr>
                                                @if ($order->link_produk)
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Link Produk:</td>
                                                        <td><a href="{{ $order->link_produk }}" target="_blank"
                                                                class="btn btn-sm btn-outline-primary">Lihat Produk</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Rincian Biaya</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td class="fw-semibold text-muted">Budget Awal:</td>
                                                    <td>Rp {{ number_format($order->budget, 0, ',', '.') }}</td>
                                                </tr>
                                                @if ($order->total_belanja)
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Total Belanja:</td>
                                                        <td>Rp {{ number_format($order->total_belanja, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endif
                                                @if ($order->ongkos_jasa)
                                                    <tr>
                                                        <td class="fw-semibold text-muted">Ongkos Jasa:</td>
                                                        <td>Rp {{ number_format($order->ongkos_jasa, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endif
                                                @if ($order->total_pembayaran)
                                                    <tr class="table-success">
                                                        <td class="fw-semibold">Total Pembayaran:</td>
                                                        <td class="fw-semibold">Rp
                                                            {{ number_format($order->total_pembayaran, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Delivery Info -->
                                    @if ($order->alamat_pengiriman)
                                        <div class="mb-4">
                                            <h6 class="text-primary">Informasi Pengiriman</h6>
                                            <div class="bg-light rounded p-3">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <strong>Alamat:</strong><br>
                                                        {{ $order->alamat_pengiriman }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>No. Telepon:</strong><br>
                                                        {{ $order->no_telepon }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-4">
                                        <h6 class="text-primary">Deskripsi Lengkap</h6>
                                        <p class="bg-light rounded p-3">{{ $order->deskripsi }}</p>
                                    </div>

                                    @if ($order->catatan_khusus)
                                        <div class="mb-4">
                                            <h6 class="text-primary">Catatan Khusus</h6>
                                            <div
                                                class="p-3 bg-warning bg-opacity-10 rounded border-start border-warning border-4">
                                                {{ $order->catatan_khusus }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Photos -->
                                    @if ($order->hasPhotos())
                                        <div class="mb-4">
                                            <h6 class="text-primary">Foto Produk</h6>
                                            <div class="row">
                                                @foreach ($order->photos as $photo)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset('storage/' . $photo) }}"
                                                            class="img-fluid rounded shadow-sm"
                                                            style="height: 100px; object-fit: cover; cursor: pointer;"
                                                            onclick="showImage('{{ asset('storage/' . $photo) }}')">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    @if ($order->status === 'completed' && !$order->customer_rating)
                                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal"
                                            data-bs-toggle="modal" data-bs-target="#ratingModal{{ $order->id }}">
                                            <i class="fas fa-star me-2"></i>
                                            Beri Rating
                                        </button>
                                    @endif
                                    <a href="{{ route('customer.orders.invoice', $order) }}" class="btn btn-outline"
                                        target="_blank">
                                        <i class="fas fa-download"></i>
                                        Download Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rating Modal -->
                    @if ($order->status === 'completed' && !$order->customer_rating)
                        <div class="modal fade" id="ratingModal{{ $order->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Beri Rating untuk
                                            {{ $order->traveler->name ?? 'Traveler' }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('customer.orders.rate', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                            <div class="text-center mb-4">
                                                @if ($order->traveler)
                                                    <img src="{{ $order->traveler->profile_photo_path ? asset('storage/' . $order->traveler->profile_photo_path) : 'https://via.placeholder.com/80x80' }}"
                                                        alt="{{ $order->traveler->name }}" class="rounded-circle mb-3"
                                                        width="80" height="80">
                                                    <h6>{{ $order->traveler->name }}</h6>
                                                @endif
                                                <p class="text-muted">Bagaimana pengalaman Anda dengan traveler ini?</p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Rating</label>
                                                <div class="rating-stars text-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star star-rating"
                                                            data-rating="{{ $i }}"
                                                            style="font-size: 2rem; color: #ddd; cursor: pointer;"></i>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="rating" id="rating{{ $order->id }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="review{{ $order->id }}"
                                                    class="form-label fw-semibold">Review (Opsional)</label>
                                                <textarea class="form-control" id="review{{ $order->id }}" name="review" rows="4"
                                                    placeholder="Ceritakan pengalaman Anda..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-star me-2"></i>
                                                Kirim Rating
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <div class="row">
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-history text-muted mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mb-3">Belum Ada Riwayat Transaksi</h4>
                            <p class="text-muted mb-4">Riwayat pesanan yang telah selesai atau dibatalkan akan muncul di
                                sini</p>
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

@push('styles')
    <style>
        .timeline {
            position: relative;
            padding: 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 60px;
            margin-bottom: 30px;
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 22px;
            top: 30px;
            width: 2px;
            height: calc(100% + 10px);
            background-color: #e9ecef;
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            z-index: 1;
        }

        .timeline-content h6 {
            margin-bottom: 5px;
            color: #333;
        }

        .star-rating:hover,
        .star-rating.active {
            color: #ffc107 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // PERBAIKAN: Hapus filterHistory function dan ganti dengan form submission
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;
            const monthFilter = document.getElementById('monthFilter').value;
            const sortFilter = document.getElementById('sortFilter').value;

            // Build URL with parameters
            const params = new URLSearchParams();
            if (searchTerm) params.append('search', searchTerm);
            if (statusFilter) params.append('status', statusFilter);
            if (categoryFilter) params.append('category', categoryFilter);
            if (monthFilter) params.append('month', monthFilter);
            if (sortFilter) params.append('sort', sortFilter);

            // Redirect with filters
            window.location.href = '{{ route('customer.history.index') }}?' + params.toString();
        }

        function resetFilters() {
            window.location.href = '{{ route('customer.history.index') }}';
        }

        // PERBAIKAN: Hapus filter yang lama dan ganti dengan form
        // Event listeners untuk auto-submit saat ada perubahan
        document.addEventListener('DOMContentLoaded', function() {
            let filterTimeout;

            function delayedFilter() {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(applyFilters, 500);
            }

            document.getElementById('searchInput').addEventListener('input', delayedFilter);
            document.getElementById('statusFilter').addEventListener('change', applyFilters);
            document.getElementById('categoryFilter').addEventListener('change', applyFilters);
            document.getElementById('monthFilter').addEventListener('change', applyFilters);
            document.getElementById('sortFilter').addEventListener('change', applyFilters);

            // Rating stars functionality tetap sama
            document.querySelectorAll('.rating-stars').forEach(container => {
                const stars = container.querySelectorAll('.star-rating');
                const orderId = container.closest('.modal').id.replace('ratingModal', '');
                const ratingInput = document.getElementById('rating' + orderId);

                stars.forEach((star, index) => {
                    star.addEventListener('mouseover', function() {
                        highlightStars(stars, index + 1);
                    });

                    star.addEventListener('click', function() {
                        const rating = index + 1;
                        ratingInput.value = rating;
                        highlightStars(stars, rating);

                        stars.forEach((s, i) => {
                            if (i < rating) {
                                s.classList.add('active');
                            } else {
                                s.classList.remove('active');
                            }
                        });
                    });
                });

                container.addEventListener('mouseleave', function() {
                    const currentRating = parseInt(ratingInput.value) || 0;
                    highlightStars(stars, currentRating);
                });
            });
        });

        function highlightStars(stars, count) {
            stars.forEach((star, index) => {
                if (index < count) {
                    star.style.color = '#ffc107';
                } else {
                    star.style.color = '#ddd';
                }
            });
        }

        // Action functions tetap sama
        function reorderItem(orderId) {
            if (confirm('Apakah Anda ingin membuat pesanan serupa?')) {
                window.location.href = `{{ route('customer.orders.reorder', '') }}/${orderId}`;
            }
        }

        function downloadInvoice(orderId) {
            window.open(`{{ route('customer.orders.invoice', '') }}/${orderId}`, '_blank');
        }

        function shareOrder(orderId) {
            if (navigator.share) {
                navigator.share({
                    title: 'Pesanan JastipKu',
                    text: 'Lihat pesanan saya di JastipKu',
                    url: window.location.origin + `/orders/${orderId}`
                });
            } else {
                const url = window.location.origin + `/orders/${orderId}`;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link berhasil disalin!');
                });
            }
        }

        function reportIssue(orderId) {
            if (confirm('Apakah Anda ingin melaporkan masalah dengan pesanan ini?')) {
                // Implement report functionality
                alert('Fitur laporan akan segera tersedia');
            }
        }

        function showImage(src) {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="${src}" class="img-fluid">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        `;
            document.body.appendChild(modal);
            new bootstrap.Modal(modal).show();

            modal.addEventListener('hidden.bs.modal', () => {
                document.body.removeChild(modal);
            });
        }
    </script>
@endpush
