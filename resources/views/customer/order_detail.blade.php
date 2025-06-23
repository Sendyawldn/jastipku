@extends('layouts.app')

@section('title', 'Detail Pesanan')

@push('styles')
    <style>
        .order-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-accepted {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-in_progress {
            background: #e0e7ff;
            color: #4338ca;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .detail-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .detail-card-header {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
        }

        .detail-card-body {
            padding: 1.5rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1rem;
            align-items: start;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .detail-value {
            color: #111827;
            margin: 0;
        }

        .traveler-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .traveler-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .traveler-info h6 {
            margin: 0 0 0.25rem 0;
            color: #111827;
        }

        .traveler-rating {
            color: #fbbf24;
            font-size: 0.875rem;
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .image-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .image-item:hover {
            transform: scale(1.05);
        }

        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-icon {
            position: absolute;
            left: -2rem;
            top: 0.25rem;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            color: white;
            z-index: 1;
        }

        .timeline-content {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
        }

        .timeline-content h6 {
            margin: 0 0 0.5rem 0;
            color: #111827;
        }

        .timeline-content p {
            margin: 0;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            color: white;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            color: white;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            color: white;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #d1d5db;
            color: #374151;
        }

        .btn-outline:hover {
            background: #f9fafb;
            color: #374151;
        }

        @media (max-width: 768px) {
            .detail-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .order-header {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"
                        class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}" class="text-decoration-none">Pesanan
                        Saya</a></li>
                <li class="breadcrumb-item active">Detail Pesanan</li>
            </ol>
        </nav>

        <!-- Order Header -->
        <div class="order-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">{{ $order->nama_barang }}</h2>
                    <p class="mb-0 opacity-75">ID Pesanan:
                        <strong>{{ $order->id ?? 'JTP-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    @php
                        $statusClasses = [
                            'pending' => 'status-pending',
                            'accepted' => 'status-accepted',
                            'in_progress' => 'status-in_progress',
                            'completed' => 'status-completed',
                            'cancelled' => 'status-cancelled',
                        ];
                        $statusTexts = [
                            'pending' => 'Menunggu',
                            'accepted' => 'Diterima',
                            'in_progress' => 'Sedang Diproses',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                    @endphp
                    <span class="status-badge {{ $statusClasses[$order->status] ?? 'status-pending' }}">
                        {{ $statusTexts[$order->status] ?? ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Informasi Pesanan -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Pesanan
                    </div>
                    <div class="detail-card-body">
                        <div class="detail-grid">
                            <span class="detail-label">Nama Barang:</span>
                            <p class="detail-value">{{ $order->nama_barang }}</p>

                            <span class="detail-label">Kategori:</span>
                            <p class="detail-value">
                                <span class="badge bg-info">{{ ucfirst($order->kategori) }}</span>
                            </p>

                            <span class="detail-label">Tanggal Pesanan:</span>
                            <p class="detail-value">{{ $order->created_at->format('d F Y, H:i') }}</p>

                            <span class="detail-label">Deadline:</span>
                            <p class="detail-value">
                                {{ $order->deadline ? $order->deadline->format('d F Y') : '-' }}
                                @if ($order->deadline)
                                    <br><small class="text-muted">
                                        {{ $order->deadline->diffForHumans() }}
                                    </small>
                                @endif
                            </p>

                            <span class="detail-label">Tujuan:</span>
                            <p class="detail-value">{{ ucfirst($order->destination) }}</p>

                            <span class="detail-label">Budget:</span>
                            <p class="detail-value">
                                <strong class="text-primary">Rp {{ number_format($order->budget, 0, ',', '.') }}</strong>
                            </p>

                            <span class="detail-label">Metode Pembayaran:</span>
                            <p class="detail-value">
                                <span class="badge bg-success">{{ ucfirst($order->metode_pembayaran) }}</span>
                            </p>

                            @if ($order->link_produk)
                                <span class="detail-label">Link Produk:</span>
                                <p class="detail-value">
                                    <a href="{{ $order->link_produk }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i>
                                        Lihat Produk
                                    </a>
                                </p>
                            @endif

                            <span class="detail-label">Deskripsi:</span>
                            <p class="detail-value">{{ $order->deskripsi }}</p>

                            @if ($order->catatan_khusus)
                                <span class="detail-label">Catatan Khusus:</span>
                                <p class="detail-value">
                                <div class="p-3 bg-warning bg-opacity-10 rounded border-start border-warning border-4">
                                    {{ $order->catatan_khusus }}
                                </div>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informasi Pengiriman -->
                @if ($order->alamat_pengiriman || $order->no_telepon)
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fas fa-shipping-fast me-2 text-success"></i>
                            Informasi Pengiriman
                        </div>
                        <div class="detail-card-body">
                            <div class="detail-grid">
                                @if ($order->alamat_pengiriman)
                                    <span class="detail-label">Alamat Lengkap:</span>
                                    <p class="detail-value">{{ $order->alamat_pengiriman }}</p>
                                @endif

                                @if ($order->no_telepon)
                                    <span class="detail-label">No. Telepon:</span>
                                    <p class="detail-value">
                                        <a href="https://wa.me/62{{ $order->no_telepon }}" target="_blank"
                                            class="text-decoration-none">
                                            <i class="fab fa-whatsapp text-success me-1"></i>
                                            +62{{ $order->no_telepon }}
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Informasi Traveler -->
                @if ($order->traveler)
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fas fa-user-tie me-2 text-info"></i>
                            Traveler
                        </div>
                        <div class="detail-card-body">
                            <div class="traveler-card">
                                <img src="{{ $order->traveler->profile_photo_path ? asset('storage/' . $order->traveler->profile_photo_path) : 'https://via.placeholder.com/50x50' }}"
                                    alt="{{ $order->traveler->name }}" class="traveler-avatar">
                                <div class="traveler-info">
                                    <h6>{{ $order->traveler->name }}</h6>
                                    @if ($order->traveler && $order->traveler->role === 'traveler')
                                        <div class="traveler-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star{{ $i <= ($order->traveler->rating ?? 5) ? '' : '-o' }}"></i>
                                            @endfor
                                            <span
                                                class="ms-1">({{ number_format($order->traveler->rating ?? 5, 1) }})</span>
                                        </div>
                                    @endif
                                    <small class="text-muted">
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        {{ $order->traveler->completed_orders_count ?? 0 }} pesanan selesai
                                    </small>
                                </div>
                                <div class="ms-auto">
                                    @if ($order->traveler->phone)
                                        <a href="https://wa.me/62{{ $order->traveler->phone }}" target="_blank"
                                            class="btn btn-sm btn-success">
                                            <i class="fab fa-whatsapp me-1"></i>
                                            Chat
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fas fa-user-clock me-2 text-warning"></i>
                            Status Traveler
                        </div>
                        <div class="detail-card-body">
                            <div class="text-center py-3">
                                <i class="fas fa-search text-muted mb-3" style="font-size: 2rem;"></i>
                                <h6 class="text-muted">Menunggu Traveler</h6>
                                <p class="text-muted small mb-0">Pesanan Anda sedang menunggu traveler untuk mengambil dan
                                    memproses</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Foto Produk -->
                @if ($order->photos && count($order->photos) > 0)
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fas fa-images me-2 text-primary"></i>
                            Foto Referensi Produk
                        </div>
                        <div class="detail-card-body">
                            <div class="image-gallery">
                                @foreach ($order->photos as $photo)
                                    <div class="image-item" onclick="showImageModal('{{ asset('storage/' . $photo) }}')">
                                        <img src="{{ asset('storage/' . $photo) }}" alt="Foto Produk">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Timeline -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <i class="fas fa-history me-2 text-secondary"></i>
                        Timeline Pesanan
                    </div>
                    <div class="detail-card-body">
                        <div class="timeline">
                            <!-- Pesanan dibuat -->
                            <div class="timeline-item">
                                <div class="timeline-icon bg-primary">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Pesanan Dibuat</h6>
                                    <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            <!-- Jika sudah diterima traveler -->
                            @if ($order->traveler && $order->accepted_at)
                                <div class="timeline-item">
                                    <div class="timeline-icon bg-info">
                                        <i class="fas fa-handshake"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Diterima oleh {{ $order->traveler->name }}</h6>
                                        <p>{{ $order->accepted_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Jika sedang diproses -->
                            @if ($order->status === 'in_progress' && $order->started_at)
                                <div class="timeline-item">
                                    <div class="timeline-icon bg-warning">
                                        <i class="fas fa-cog fa-spin"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Sedang Diproses</h6>
                                        <p>{{ $order->started_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Jika selesai -->
                            @if ($order->status === 'completed' && $order->completed_at)
                                <div class="timeline-item">
                                    <div class="timeline-icon bg-success">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Pesanan Selesai</h6>
                                        <p>{{ $order->completed_at->format('d M Y, H:i') }}</p>
                                        @if ($order->total_belanja)
                                            <p><strong>Total Belanja: Rp
                                                    {{ number_format($order->total_belanja, 0, ',', '.') }}</strong></p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Jika dibatalkan -->
                            @if ($order->status === 'cancelled' && $order->cancelled_at)
                                <div class="timeline-item">
                                    <div class="timeline-icon bg-danger">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Pesanan Dibatalkan</h6>
                                        <p>{{ $order->cancelled_at->format('d M Y, H:i') }}</p>
                                        @if ($order->cancel_reason)
                                            <p class="text-danger">Alasan: {{ $order->cancel_reason }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Ringkasan Pembayaran -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <i class="fas fa-receipt me-2 text-primary"></i>
                        Ringkasan Pembayaran
                    </div>
                    <div class="detail-card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Budget Awal:</span>
                            <span>Rp {{ number_format($order->budget, 0, ',', '.') }}</span>
                        </div>
                        @if (!$order->ongkos_jasa && $order->ongkos_jasa_otomatis)
    <div class="d-flex justify-content-between mb-2">
        <span>Ongkos Jasa Estimasi:</span>
        <span>Rp {{ number_format($order->ongkos_jasa_otomatis, 0, ',', '.') }}</span>
    </div>
@endif

                        @if ($order->total_belanja)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Belanja:</span>
                                <span>Rp {{ number_format($order->total_belanja, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        @if ($order->ongkos_jasa)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkos Jasa:</span>
                                <span>Rp {{ number_format($order->ongkos_jasa, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        @if ($order->total_pembayaran)
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total Pembayaran:</strong>
                                <strong class="text-primary">Rp
                                    {{ number_format($order->total_pembayaran, 0, ',', '.') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <i class="fas fa-cogs me-2 text-secondary"></i>
                        Aksi
                    </div>
                    <div class="detail-card-body">
                        <div class="action-buttons">
                            @if ($order->status === 'pending')
                                <a href="{{ route('customer.orders.edit', $order) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                    Edit Pesanan
                                </a>
                                <button class="btn btn-danger" onclick="cancelOrder({{ $order->id }})">
                                    <i class="fas fa-times"></i>
                                    Batalkan
                                </button>
                            @endif

                            @if ($order->status === 'completed' && !$order->customer_rating)
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                    <i class="fas fa-star"></i>
                                    Beri Rating
                                </button>
                            @endif

                            @if ($order->status === 'completed')
                                <a href="{{ route('customer.orders.reorder', $order) }}" class="btn btn-primary">
                                    <i class="fas fa-redo"></i>
                                    Pesan Lagi
                                </a>
                            @endif

                            <a href="{{ route('customer.orders.invoice', $order) }}" class="btn btn-outline"
                                target="_blank">
                                <i class="fas fa-download"></i>
                                Download Invoice
                            </a>

                            <a href="{{ route('customer.orders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Support -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <i class="fas fa-life-ring me-2 text-info"></i>
                        Butuh Bantuan?
                    </div>
                    <div class="detail-card-body">
                        <p class="small text-muted mb-3">Jika ada masalah dengan pesanan ini, hubungi customer service kami
                        </p>
                        <div class="action-buttons">
                            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success">
                                <i class="fab fa-whatsapp"></i>
                                Chat CS
                            </a>
                            <a href="mailto:support@jastipku.com" class="btn btn-outline">
                                <i class="fas fa-envelope"></i>
                                Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Foto Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Foto Produk">
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Modal -->
    @if ($order->status === 'completed' && !$order->customer_rating && $order->traveler)
        <div class="modal fade" id="ratingModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Beri Rating untuk {{ $order->traveler->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('customer.orders.rate', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <img src="{{ $order->traveler->profile_photo_path ? asset('storage/' . $order->traveler->profile_photo_path) : 'https://via.placeholder.com/80x80' }}"
                                    alt="{{ $order->traveler->name }}" class="rounded-circle mb-3" width="80"
                                    height="80">
                                <h6>{{ $order->traveler->name }}</h6>
                                <p class="text-muted">Bagaimana pengalaman Anda dengan traveler ini?</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rating</label>
                                <div class="rating-stars text-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star star-rating" data-rating="{{ $i }}"
                                            style="font-size: 2rem; color: #ddd; cursor: pointer;"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" required>
                            </div>

                            <div class="mb-3">
                                <label for="review" class="form-label fw-semibold">Review (Opsional)</label>
                                <textarea class="form-control" id="review" name="review" rows="4"
                                    placeholder="Ceritakan pengalaman Anda..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
@endsection

@push('scripts')
    <script>
        // Image modal
        function showImageModal(src) {
            document.getElementById('modalImage').src = src;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }

        // Rating stars
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating');
            const ratingInput = document.getElementById('rating');

            stars.forEach((star, index) => {
                star.addEventListener('mouseover', function() {
                    highlightStars(index + 1);
                });

                star.addEventListener('click', function() {
                    const rating = index + 1;
                    ratingInput.value = rating;
                    highlightStars(rating);

                    // Make stars active
                    stars.forEach((s, i) => {
                        if (i < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });

            function highlightStars(count) {
                stars.forEach((star, index) => {
                    if (index < count) {
                        star.style.color = '#ffc107';
                    } else {
                        star.style.color = '#ddd';
                    }
                });
            }
        });

        // Cancel order
        function cancelOrder(orderId) {
            if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/customer/orders/${orderId}/cancel`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush
