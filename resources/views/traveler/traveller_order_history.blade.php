@extends('layouts.app')

@section('title', 'Riwayat Pesanan Traveler')

@section('content')
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('traveler.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Riwayat Pesanan</li>
                    </ol>
                </nav>
                <h2 class="fw-bold text-dark mb-1">Riwayat Pesanan</h2>
                <p class="text-muted">Daftar pesanan yang telah Anda selesaikan atau batalkan</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                                <i class="fas fa-check-circle fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ $orders->where('status', 'completed')->count() }}</h4>
                                <p class="mb-0 opacity-75">Pesanan Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                                <i class="fas fa-times-circle fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ $orders->where('status', 'cancelled')->count() }}</h4>
                                <p class="mb-0 opacity-75">Dibatalkan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                                <i class="fas fa-wallet fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">Rp
                                    {{ number_format($orders->where('status', 'completed')->sum('ongkos_jasa'), 0, ',', '.') }}
                                </h4>
                                <p class="mb-0 opacity-75">Total Penghasilan</p>
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
                                <i class="fas fa-star fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ number_format(Auth::user()->rating ?? 5.0, 1) }}</h4>
                                <p class="mb-0 opacity-75">Rating Rata-rata</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('traveler.history.index') }}" id="filterForm">
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
                                </option>
                                <option value="skincare" {{ request('category') == 'skincare' ? 'selected' : '' }}>🧴
                                    Skincare</option>
                                <option value="elektronik" {{ request('category') == 'elektronik' ? 'selected' : '' }}>📱
                                    Elektronik</option>
                                <option value="makanan" {{ request('category') == 'makanan' ? 'selected' : '' }}>🍎 Makanan
                                </option>
                                <option value="buku" {{ request('category') == 'buku' ? 'selected' : '' }}>📚 Buku
                                </option>
                                <option value="beauty" {{ request('category') == 'beauty' ? 'selected' : '' }}>💄 Beauty
                                </option>
                                <option value="accessories" {{ request('category') == 'accessories' ? 'selected' : '' }}>👜
                                    Accessories</option>
                                <option value="toys" {{ request('category') == 'toys' ? 'selected' : '' }}>🧸 Mainan
                                </option>
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
                                <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Penghasilan
                                    Tertinggi</option>
                                <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Penghasilan
                                    Terendah</option>
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

        @if ($orders->count() > 0)
            <div class="row" id="historyContainer">
                @foreach ($orders as $order)
                    <div class="col-lg-6 col-md-12 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light border-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $order->nama_barang }}</h6>
                                        <small class="text-muted">Order #{{ $order->id }}</small>
                                    </div>
                                    <div class="text-end">
                                        @if ($order->status === 'completed')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>
                                                Dibatalkan
                                            </span>
                                        @endif
                                        <div class="mt-1">
                                            <small class="text-muted">{{ $order->updated_at->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="border rounded p-2 text-center bg-primary bg-opacity-10">
                                            <small class="text-muted d-block">Budget</small>
                                            <span class="fw-semibold text-primary">Rp
                                                {{ number_format($order->budget, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    @if ($order->status === 'completed' && $order->ongkos_jasa)
                                        <div class="col-6">
                                            <div class="border rounded p-2 text-center bg-success bg-opacity-10">
                                                <small class="text-muted d-block">Penghasilan</small>
                                                <span class="fw-semibold text-success">Rp
                                                    {{ number_format($order->ongkos_jasa, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                                    <img src="{{ $order->customer->profile_photo_path ? asset('storage/' . $order->customer->profile_photo_path) : 'https://via.placeholder.com/40x40' }}"
                                        alt="{{ $order->customer->name }}" class="rounded-circle me-3" width="40"
                                        height="40">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $order->customer->name }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ ucfirst($order->destination) }}
                                        </small>
                                    </div>
                                    @if ($order->status === 'completed')
                                        <div class="text-end">
                                            <span class="badge bg-success">Sukses</span>
                                        </div>
                                    @endif
                                </div>

                                <p class="card-text text-muted small mb-3">{{ Str::limit($order->deskripsi, 100) }}</p>

                                @if ($order->status === 'completed')
                                    <div class="mb-3">
                                        <small class="text-muted fw-semibold">Timeline:</small>
                                        <div class="mt-2">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="bg-success rounded-circle me-2"
                                                    style="width: 8px; height: 8px;"></div>
                                                <small class="text-muted">Dibuat:
                                                    {{ $order->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                            @if ($order->accepted_at)
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="bg-primary rounded-circle me-2"
                                                        style="width: 8px; height: 8px;"></div>
                                                    <small class="text-muted">Diterima:
                                                        {{ $order->accepted_at->format('d M Y H:i') }}</small>
                                                </div>
                                            @endif
                                            @if ($order->completed_at)
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success rounded-circle me-2"
                                                        style="width: 8px; height: 8px;"></div>
                                                    <small class="text-muted">Selesai:
                                                        {{ $order->completed_at->format('d M Y H:i') }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary btn-sm flex-fill" data-bs-toggle="modal"
                                        data-bs-target="#orderModal{{ $order->id }}">
                                        <i class="fas fa-eye me-1"></i>
                                        Detail
                                    </button>
                                    @if ($order->status === 'completed')
                                        {{-- Tombol diubah menjadi link ke rute invoice --}}
                                        <a href="{{ route('traveler.history.invoice', $order) }}" class="btn btn-outline-success btn-sm" target="_blank">
                                            <i class="fas fa-download me-1"></i>
                                            Invoice
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Pesanan #{{ $order->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Informasi Pesanan</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td class="fw-semibold">Nama Barang:</td>
                                                    <td>{{ $order->nama_barang }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Kategori:</td>
                                                    <td>
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
                                                        <span class="badge bg-info">{{ $displayCategory }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Budget:</td>
                                                    <td class="text-primary fw-semibold">Rp
                                                        {{ number_format($order->budget, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Deadline:</td>
                                                    <td>{{ $order->deadline->format('d F Y') }}</td>
                                                </tr>
                                                @if ($order->total_belanja)
                                                    <tr>
                                                        <td class="fw-semibold">Total Belanja:</td>
                                                        <td>Rp {{ number_format($order->total_belanja, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endif
                                                @if ($order->ongkos_jasa)
                                                    <tr>
                                                        <td class="fw-semibold">Ongkos Jasa:</td>
                                                        <td class="text-success fw-semibold">Rp
                                                            {{ number_format($order->ongkos_jasa, 0, ',', '.') }}</td>
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
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Informasi Customer</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td class="fw-semibold">Nama:</td>
                                                    <td>{{ $order->customer->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Email:</td>
                                                    <td>{{ $order->customer->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Telepon:</td>
                                                    <td>{{ $order->no_telepon ?? $order->customer->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Alamat:</td>
                                                    <td>{{ $order->alamat_pengiriman }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Tujuan:</td>
                                                    <td>{{ ucfirst($order->destination) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <h6 class="text-primary mt-3">Deskripsi</h6>
                                    <p>{{ $order->deskripsi }}</p>

                                    @if ($order->catatan_khusus)
                                        <h6 class="text-primary">Catatan Khusus</h6>
                                        <div class="p-3 bg-warning bg-opacity-10 rounded">
                                            {{ $order->catatan_khusus }}
                                        </div>
                                    @endif

                                    @if ($order->hasPhotos())
                                        <h6 class="text-primary mt-3">Foto Referensi</h6>
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
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    @if ($order->status === 'completed')
                                        <a href="{{ route('traveler.history.invoice', $order) }}" class="btn btn-success" target="_blank">
                                            <i class="fas fa-download me-2"></i>
                                            Download Invoice
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @else
            <div class="row">
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-history text-muted mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mb-3">Belum Ada Riwayat Pesanan</h4>
                            <p class="text-muted mb-4">Riwayat pesanan yang telah selesai atau dibatalkan akan muncul di
                                sini</p>
                            <a href="{{ route('traveler.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                                Cari Pesanan Baru
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
        // Filter functions
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;
            const monthFilter = document.getElementById('monthFilter').value;
            const sortFilter = document.getElementById('sortFilter').value;

            const params = new URLSearchParams();
            if (searchTerm) params.append('search', searchTerm);
            if (statusFilter) params.append('status', statusFilter);
            if (categoryFilter) params.append('category', categoryFilter);
            if (monthFilter) params.append('month', monthFilter);
            if (sortFilter) params.append('sort', sortFilter);

            window.location.href = '{{ route('traveler.history.index') }}?' + params.toString();
        }

        function resetFilters() {
            window.location.href = '{{ route('traveler.history.index') }}';
        }

        // Auto-submit on change
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
        });

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
