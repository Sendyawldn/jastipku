@extends('layouts.app')

@section('title', 'Dashboard Traveler')

@section('content')
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold text-dark mb-1">Dashboard Traveler</h2>
                <p class="text-muted">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <span
                        class="badge bg-{{ Auth::user()->travelerProfile && Auth::user()->travelerProfile->available_for_orders ? 'success' : 'secondary' }} fs-6 px-3 py-2">
                        <i
                            class="fas fa-{{ Auth::user()->travelerProfile && Auth::user()->travelerProfile->available_for_orders ? 'check' : 'times' }}-circle me-1"></i>
                        {{ Auth::user()->travelerProfile && Auth::user()->travelerProfile->available_for_orders ? 'Aktif Menerima Pesanan' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 bg-gradient bg-primary">
                    <div class="card-body text-white d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                            <i class="fas fa-shopping-bag fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['baru'] ?? 0 }}</h3>
                            <p class="mb-0 opacity-75">Pesanan Baru</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 bg-gradient bg-warning">
                    <div class="card-body text-white d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                            <i class="fas fa-tasks fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['proses'] ?? 0 }}</h3>
                            <p class="mb-0 opacity-75">Sedang Diproses</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 bg-gradient bg-success">
                    <div class="card-body text-white d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                            <i class="fas fa-check-circle fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['selesai'] ?? 0 }}</h3>
                            <p class="mb-0 opacity-75">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 bg-gradient bg-info">
                    <div class="card-body text-white d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                            <i class="fas fa-star fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ number_format(Auth::user()->rating ?? 5.0, 1) }}</h3>
                            <p class="mb-0 opacity-75">Rating Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('traveler.active_orders.index') }}" class="btn btn-primary w-100 py-3">
                                    <i class="fas fa-tasks me-2"></i>
                                    Pesanan Aktif
                                    @if (($stats['proses'] ?? 0) > 0)
                                        <span class="badge bg-white text-primary ms-2">{{ $stats['proses'] }}</span>
                                    @endif
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('traveler.earnings.index') }}"
                                    class="btn btn-outline-success w-100 py-3">
                                    <i class="fas fa-wallet me-2"></i>
                                    Cek Penghasilan
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-info w-100 py-3">
                                    <i class="fas fa-user-cog me-2"></i>
                                    Update Profil
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('traveler.history.index') }}"
                                    class="btn btn-outline-secondary w-100 py-3">
                                    <i class="fas fa-history me-2"></i>
                                    Riwayat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($availableOrders->count() > 0)
            <div class="row">
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-shopping-bag text-primary me-2"></i>
                                    Pesanan Tersedia
                                </h5>
                                <a href="/" class="btn btn-sm btn-outline-primary">
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($availableOrders as $order)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="card border h-100">
                                            <div class="card-header bg-light border-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Tersedia
                                                    </span>
                                                    <small
                                                        class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title">{{ $order->nama_barang }}</h6>

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                                            {{ ucfirst($order->destination) }}
                                                        </small>
                                                        @php
                                                            $categoryNames = [
                                                                'fashion' => '👗 Fashion',
                                                                'skincare' => '🧴 Skincare',
                                                                'elektronik' => '📱 Elektronik',
                                                                'makanan' => '🍎 Makanan',
                                                                'buku' => '📚 Buku',
                                                                'beauty' => '💄 Beauty',
                                                                'accessories' => '👜 Accessories',
                                                                'toys' => '🧸 Mainan',
                                                                'sports' => '⚽ Olahraga',
                                                                'home' => '🏠 Rumah Tangga',
                                                                'lainnya' => '📦 Lainnya',
                                                            ];
                                                            $displayCategory =
                                                                $categoryNames[$order->kategori] ??
                                                                ucfirst($order->kategori);
                                                        @endphp
                                                        <span
                                                            class="badge bg-info-subtle text-info">{{ $displayCategory }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar text-primary me-1"></i>
                                                            Deadline: {{ $order->deadline->format('d M Y') }}
                                                        </small>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">Budget</small>
                                                        <strong class="text-success">Rp
                                                            {{ number_format($order->budget, 0, ',', '.') }}</strong>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="{{ $order->customer->profile_photo_path ? asset('storage/' . $order->customer->profile_photo_path) : 'https://via.placeholder.com/30x30' }}"
                                                        alt="{{ $order->customer->name }}" class="rounded-circle me-2"
                                                        width="30" height="30">
                                                    <div>
                                                        <small class="fw-semibold">{{ $order->customer->name }}</small>
                                                        <div class="d-flex align-items-center">
                                                            <small class="text-muted">Customer sejak
                                                                {{ $order->customer->created_at->format('Y') }}</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="card-text text-muted small">
                                                    {{ Str::limit($order->deskripsi, 80) }}
                                                </p>

                                                <div class="d-flex gap-2 mt-auto">
                                                    <a href="{{ route('orders.show_public', $order) }}" class="btn btn-outline-secondary flex-fill">
                                                        <i class="fas fa-eye me-1"></i>
                                                        Detail
                                                    </a>
                                                    <form action="{{ route('traveler.orders.accept', $order) }}" method="POST" class="flex-fill">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="fas fa-hand-paper me-1"></i>
                                                            Ambil
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                            <i class="fas fa-search text-muted mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mb-3">Tidak Ada Pesanan Tersedia</h4>
                            <p class="text-muted mb-4">Saat ini tidak ada pesanan baru yang tersedia. Cek kembali nanti!
                            </p>
                            <a href="/" class="btn btn-primary">
                                <i class="fas fa-sync me-2"></i>
                                Refresh Halaman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
