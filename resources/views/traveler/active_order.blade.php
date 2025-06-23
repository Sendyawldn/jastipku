@extends('layouts.app')

@section('title', 'Pesanan Aktif')

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('traveler.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pesanan Aktif</li>
                    </ol>
                </nav>
                <h2 class="fw-bold text-dark mb-1">Pesanan Aktif</h2>
                <p class="text-muted">Kelola pesanan yang sedang Anda kerjakan</p>
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

        <!-- Active Orders -->
        @if ($activeOrders->count() > 0)
            <div class="row">
                @foreach ($activeOrders as $order)
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    @php
                                        $statusClasses = [
                                            'accepted' => 'bg-info text-white',
                                            'in_progress' => 'bg-primary text-white',
                                        ];
                                        $statusTexts = [
                                            'accepted' => 'Diterima',
                                            'in_progress' => 'Dalam Proses',
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

                                <!-- Customer Info -->
                                <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                    <img src="{{ $order->customer->profile_photo_path ? asset('storage/' . $order->customer->profile_photo_path) : 'https://via.placeholder.com/40x40' }}"
                                        alt="{{ $order->customer->name }}" class="rounded-circle me-3" width="40"
                                        height="40">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $order->customer->name }}</h6>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">Customer</small>
                                    </div>
                                </div>

                                <!-- Order Details -->
                                <div class="mb-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">Tujuan</small>
                                                    <span class="fw-semibold">{{ ucfirst($order->destination) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar text-primary me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">Deadline</small>
                                                    <span
                                                        class="fw-semibold">{{ $order->deadline->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-tag text-primary me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">Kategori</small>
                                                    <span
                                                        class="badge bg-info-subtle text-info">{{ ucfirst($order->kategori) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-wallet text-primary me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">Budget</small>
                                                    <span class="fw-semibold text-success">Rp
                                                        {{ number_format($order->budget, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <small class="text-muted">Deskripsi:</small>
                                    <p class="text-dark mt-1">{{ Str::limit($order->deskripsi, 150) }}</p>
                                </div>

                                <!-- Special Notes -->
                                @if ($order->catatan_khusus)
                                    <div class="mb-3 p-2 bg-warning bg-opacity-10 rounded">
                                        <small class="text-muted"><i class="fas fa-sticky-note me-1"></i> Catatan
                                            Khusus:</small>
                                        <p class="mb-0 small">{{ $order->catatan_khusus }}</p>
                                    </div>
                                @endif

                                <!-- Product Link -->
                                @if ($order->link_produk)
                                    <div class="mb-3">
                                        <a href="{{ $order->link_produk }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>
                                            Lihat Produk
                                        </a>
                                    </div>
                                @endif

                                <!-- Status Update Form -->
                                <div class="border-top pt-3">
                                    @if ($order->status === 'accepted')
                                        <form action="{{ route('traveler.orders.start', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-play me-2"></i>
                                                Mulai Proses
                                            </button>
                                        </form>
                                    @elseif($order->status === 'in_progress')
                                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal"
                                            data-bs-target="#completeModal{{ $order->id }}">
                                            <i class="fas fa-check me-2"></i>
                                            Selesaikan Pesanan
                                        </button>
                                    @endif

                                    <div class="d-flex gap-2 mt-2">
                                        <button type="button" class="btn btn-outline-info flex-fill" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $order->id }}">
                                            <i class="fas fa-eye me-1"></i>
                                            Detail
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#cancelModal{{ $order->id }}">
                                            <i class="fas fa-times me-1"></i>
                                            Batal
                                        </button>
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
                                    <h5 class="modal-title">Detail Pesanan: {{ $order->nama_barang }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Informasi Barang</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td class="fw-semibold">Nama Barang:</td>
                                                    <td>{{ $order->nama_barang }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Kategori:</td>
                                                    <td><span class="badge bg-info">{{ ucfirst($order->kategori) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Budget:</td>
                                                    <td class="text-success fw-semibold">Rp
                                                        {{ number_format($order->budget, 0, ',', '.') }}</td>
                                                </tr>
                                                @if ($order->ongkos_jasa_otomatis)
<tr>
    <td class="fw-semibold">Ongkos Jasa Estimasi:</td>
    <td>Rp {{ number_format($order->ongkos_jasa_otomatis, 0, ',', '.') }}</td>
</tr>
@endif
                                                <tr>
                                                    <td class="fw-semibold">Metode Pembayaran:</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-success">{{ ucfirst($order->metode_pembayaran) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Deadline:</td>
                                                    <td>{{ $order->deadline->format('d F Y') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Informasi Pengiriman</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td class="fw-semibold">Tujuan:</td>
                                                    <td>{{ ucfirst($order->destination) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Alamat:</td>
                                                    <td>{{ $order->alamat_pengiriman ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">No. Telepon:</td>
                                                    <td>{{ $order->no_telepon ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <h6 class="text-primary mt-3">Deskripsi Lengkap</h6>
                                    <p>{{ $order->deskripsi }}</p>

                                    @if ($order->catatan_khusus)
                                        <h6 class="text-primary">Catatan Khusus</h6>
                                        <div class="p-3 bg-warning bg-opacity-10 rounded">
                                            {{ $order->catatan_khusus }}
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    @if ($order->link_produk)
                                        <a href="{{ $order->link_produk }}" target="_blank" class="btn btn-primary">
                                            <i class="fas fa-external-link-alt me-2"></i>
                                            Buka Link Produk
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- filepath: c:\laragon\www\jastipku\resources\views\traveler\active_order.blade.php --}}

                    {{-- Tambahkan setelah Detail Modal --}}


                    <!-- Complete Order Modal -->
                    @if ($order->status === 'in_progress')
    <div class="modal fade" id="completeModal{{ $order->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>
                        Selesaikan Pesanan
                    </h5>
                    <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('traveler.orders.complete', $order) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>{{ $order->nama_barang }}</strong> - Budget: Rp
                            {{ number_format($order->budget, 0, ',', '.') }}
                        </div>

                        <div class="mb-3">
                            <label for="total_belanja{{ $order->id }}" class="form-label">
                                <i class="fas fa-shopping-cart me-1"></i>
                                Total Belanja <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control"
                                id="total_belanja{{ $order->id }}" name="total_belanja" required
                                min="0" step="0.01" placeholder="Masukkan total belanja">
                            <small class="text-muted">Total yang dikeluarkan untuk membeli
                                barang</small>
                        </div>

                        <div class="mb-3">
                            <label for="ongkos_jasa{{ $order->id }}" class="form-label">
                                <i class="fas fa-wallet me-1"></i>
                                Ongkos Jasa <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control"
                                id="ongkos_jasa{{ $order->id }}" name="ongkos_jasa" required
                                min="0" step="0.01"
                                value="{{ $order->ongkos_jasa_otomatis ?? 0 }}" {{-- BARIS INI DITAMBAHKAN/DIMODIFIKASI --}}
                                placeholder="Masukkan ongkos jasa Anda">
                            <small class="text-muted">Fee yang Anda terima untuk jasa ini</small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Setelah pesanan diselesaikan, status tidak dapat
                            diubah kembali.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-2"></i>
                            Selesaikan Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

                    <!-- Cancel Order Modal -->
                    <div class="modal fade" id="cancelModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">
                                        <i class="fas fa-times-circle me-2"></i>
                                        Batalkan Pesanan
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('traveler.orders.cancel', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Anda yakin ingin membatalkan pesanan
                                            <strong>{{ $order->nama_barang }}</strong>?
                                        </div>

                                        <div class="mb-3">
                                            <label for="cancel_reason{{ $order->id }}" class="form-label">
                                                Alasan Pembatalan <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="cancel_reason{{ $order->id }}" name="cancel_reason" rows="3" required
                                                placeholder="Jelaskan alasan pembatalan..."></textarea>
                                        </div>

                                        <div class="alert alert-danger">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Konsekuensi:</strong> Pesanan akan dikembalikan ke status "pending" dan
                                            dapat diambil oleh traveler lain.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-arrow-left me-2"></i>
                                            Kembali
                                        </button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times me-2"></i>
                                            Ya, Batalkan
                                        </button>
                                    </div>
                                </form>
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
                            <i class="fas fa-tasks text-muted mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mb-3">Tidak Ada Pesanan Aktif</h4>
                            <p class="text-muted mb-4">Anda belum memiliki pesanan yang sedang dikerjakan. Cari pesanan
                                baru di dashboard!</p>
                            <a href="{{ route('traveler.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                                Cari Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
{{-- Tambahkan di bagian bawah file active_order.blade.php --}}

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto calculate total untuk setiap modal
            @foreach ($activeOrders as $order)
                @if ($order->status === 'in_progress')
                    const totalBelanjaInput{{ $order->id }} = document.getElementById(
                        'total_belanja{{ $order->id }}');
                    const ongkosJasaInput{{ $order->id }} = document.getElementById(
                        'ongkos_jasa{{ $order->id }}');

                    function updateTotal{{ $order->id }}() {
                        const totalBelanja = parseFloat(totalBelanjaInput{{ $order->id }}.value) || 0;
                        const ongkosJasa = parseFloat(ongkosJasaInput{{ $order->id }}.value) || 0; // Mengambil nilai dari input yang sudah terisi otomatis
                        const total = totalBelanja + ongkosJasa;
                        const budget = {{ $order->budget }};

                        // Hapus alert lama jika ada
                        const existingAlert = document.querySelector(
                            '#completeModal{{ $order->id }} .alert-total');
                        if (existingAlert) existingAlert.remove();

                        // Cek apakah total melebihi budget dan tampilkan peringatan
                        if (total > budget) {
                            document.querySelector('#completeModal{{ $order->id }} .modal-body')
                                .insertAdjacentHTML('afterbegin',
                                    '<div class="alert alert-warning alert-total">⚠️ Total (Rp ' + total
                                    .toLocaleString('id-ID') + ') melebihi budget (Rp ' + budget.toLocaleString(
                                        'id-ID') + ')</div>'
                                );
                        }
                    }

                    if (totalBelanjaInput{{ $order->id }} && ongkosJasaInput{{ $order->id }}) {
                        totalBelanjaInput{{ $order->id }}.addEventListener('input',
                            updateTotal{{ $order->id }});
                        ongkosJasaInput{{ $order->id }}.addEventListener('input', // Tambahkan listener untuk ongkos jasa juga
                            updateTotal{{ $order->id }});
                        // Panggil sekali saat modal dimuat untuk memastikan estimasi awal benar
                        // Anda bisa memicu ini saat modal ditampilkan, atau biarkan seperti ini jika tidak terlalu kritis
                         updateTotal{{ $order->id }}();
                    }
                @endif
            @endforeach
        });
    </script>
@endpush
