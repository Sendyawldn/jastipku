@extends('layouts.app')

@section('title', 'Dashboard Customer')

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold text-dark mb-1">Dashboard Customer</h2>
                <p class="text-muted">Selamat datang, {{ Auth::user()->name }}!</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-clock text-primary fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['proses'] }}</h3>
                            <p class="text-muted mb-0">Sedang Diproses</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['selesai'] }}</h3>
                            <p class="text-muted mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-shipping-fast text-warning fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['pengiriman'] }}</h3>
                            <p class="text-muted mb-0">Dalam Pengiriman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt text-primary me-2"></i>
                            Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('customer.orders.create') }}" class="btn btn-primary w-100 py-3">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    Buat Pesanan Baru
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-primary w-100 py-3">
                                    <i class="fas fa-list me-2"></i>
                                    Lihat Semua Pesanan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        @if ($recentOrders->count() > 0)
            <div class="row">
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-history text-primary me-2"></i>
                                    Pesanan Terbaru
                                </h5>
                                <a href="{{ route('customer.orders.index') }}" class="btn btn-sm btn-outline-primary">
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Tujuan</th>
                                            <th>Budget</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentOrders as $order)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $order->nama_barang }}</div>
                                                    <small
                                                        class="text-muted">{{ Str::limit($order->deskripsi, 50) }}</small>
                                                </td>
                                                <td>
                                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                                    {{ ucfirst($order->destination) }}
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-success">Rp
                                                        {{ number_format($order->budget, 0, ',', '.') }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $statusClasses = [
                                                            'pending' => 'bg-warning text-dark',
                                                            'accepted' => 'bg-info text-white',
                                                            'in_progress' => 'bg-primary text-white',
                                                            'completed' => 'bg-success text-white',
                                                            'cancelled' => 'bg-danger text-white',
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary text-white' }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('customer.orders.show', $order) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-shopping-bag text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted mb-3">Belum Ada Pesanan</h5>
                            <p class="text-muted mb-4">Anda belum memiliki pesanan. Mulai buat pesanan pertama Anda!</p>
                            <a href="{{ route('customer.orders.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>
                                Buat Pesanan Pertama
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
