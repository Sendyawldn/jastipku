@extends('layouts.homepage')

@section('title', 'Detail Pesanan: ' . $order->nama_barang)

@push('styles')
    {{-- Bootstrap sudah di-include dari layout, namun kita tambahkan style khusus di sini --}}
    <style>
        body {
            background-color: #f8fafc;
        }
        .order-detail-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }
        .image-gallery-item {
            cursor: pointer;
            overflow: hidden;
            border-radius: 0.5rem;
        }
        .image-gallery-item img {
            transition: transform 0.3s ease;
        }
        .image-gallery-item:hover img {
            transform: scale(1.1);
        }
        .sticky-sidebar {
            top: 8rem; /* Sesuaikan jarak dari atas */
        }
    </style>
@endpush

@section('content')
    <div class="container my-5 pt-5">
        <div class="order-detail-header text-white p-4 p-md-5 rounded-3 mb-4 text-center">
            <h1 class="display-5 fw-bold">{{ $order->nama_barang }}</h1>
            <p class="lead mb-0">ID Pesanan: JTP-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">

                @if ($order->foto_produk && count($order->foto_produk) > 0)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-images text-primary me-2"></i>Foto Referensi Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                @foreach ($order->foto_produk as $photo)
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <div class="image-gallery-item shadow-sm">
                                            <img src="{{ asset('storage/' . $photo) }}" class="img-fluid" alt="Foto Produk"
                                                 data-bs-toggle="modal" data-bs-target="#imageModal"
                                                 data-bs-image-src="{{ asset('storage/' . $photo) }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted mt-2 d-block">* Klik gambar untuk memperbesar.</small>
                        </div>
                    </div>
                @endif

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Informasi Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Deskripsi</dt>
                            <dd class="col-sm-8">{{ $order->deskripsi }}</dd>

                            <hr class="my-2">

                            <dt class="col-sm-4">Kategori</dt>
                            <dd class="col-sm-8"><span class="badge bg-info-subtle text-info-emphasis fs-6">{{ $order->getCategoryDisplayNameAttribute() }}</span></dd>

                            <hr class="my-2">

                            <dt class="col-sm-4">Tujuan Pengiriman</dt>
                            <dd class="col-sm-8"><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ ucfirst($order->destination) }}</dd>

                            <hr class="my-2">

                            <dt class="col-sm-4">Deadline</dt>
                            <dd class="col-sm-8"><i class="fas fa-calendar-alt text-warning me-1"></i> {{ $order->deadline->format('d F Y') }}</dd>

                            @if ($order->catatan_khusus)
                                <hr class="my-2">
                                <dt class="col-sm-4">Catatan Khusus</dt>
                                <dd class="col-sm-8">
                                    <div class="p-3 bg-light border-start border-4 border-warning rounded-end">
                                        {{ $order->catatan_khusus }}
                                    </div>
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top sticky-sidebar">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-hand-holding-usd text-primary me-2"></i>Aksi Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-5">Budget</span>
                            <strong class="fs-4 text-success">Rp {{ number_format($order->budget, 0, ',', '.') }}</strong>
                        </div>

                        <hr>

                        @if ($order->status == 'pending')
                            @auth
                                @if (Auth::user()->role === 'traveler' && Auth::user()->isTravelerVerified())
                                    <form action="{{ route('traveler.orders.accept', $order) }}" method="POST" class="d-grid">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-hand-paper me-2"></i>Ambil Pesanan
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-warning text-center small">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Hanya traveler terverifikasi yang dapat mengambil pesanan.
                                    </div>
                                @endif
                            @else
                                <div class="text-center">
                                    <p class="text-muted">Login sebagai traveler untuk mengambil pesanan ini.</p>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login untuk Ambil</a>
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Daftar sebagai Traveler</a>
                                    </div>
                                </div>
                            @endauth
                        @else
                             <div class="alert alert-danger text-center">
                                <i class="fas fa-times-circle me-1"></i>
                                Pesanan ini sudah tidak tersedia.
                             </div>
                        @endif
                    </div>
                    <div class="card-footer bg-light p-3">
                         <div class="d-flex align-items-center">
                            <img src="{{ $order->customer->profile_photo_path ? asset('storage/' . $order->customer->profile_photo_path) : 'https://via.placeholder.com/40x40/764ba2/white?text=' . substr($order->customer->name, 0, 1) }}"
                                alt="{{ $order->customer->name }}" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <small class="d-block text-muted">Dipesan oleh</small>
                                <div class="fw-bold fs-6">{{ $order->customer->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Foto Referensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid rounded" alt="Image Preview">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Script untuk menampilkan gambar di modal
    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const imageUrl = button.getAttribute('data-bs-image-src');
            const modalImage = imageModal.querySelector('#modalImage');
            modalImage.src = imageUrl;
        });
    }
</script>
@endpush
