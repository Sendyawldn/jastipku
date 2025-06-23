@extends('layouts.homepage')

@section('title', 'Selamat Datang Penitip')

    {{-- PERBAIKAN FINAL: Semua CSS dimasukkan langsung di sini agar pasti termuat --}}
    <style>
        /* Variabel warna yang dibutuhkan oleh CSS di bawah */
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #10b981;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --gray-color: #6b7280;
            --light-gray: #e5e7eb;
        }

        /* Container Utama & Judul */
        .orders-showcase {
            padding: 60px 20px;
            background-color: #f8fafc;
        }

        .orders-showcase h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 50px;
            color: var(--dark-color);
            font-weight: 600;
        }

        /* Grid untuk menampung kartu pesanan */
        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Style untuk setiap kartu pesanan */
        .order-card-sm {
            background: #fff;
            border: 1px solid var(--light-gray);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .order-card-sm:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Bagian Gambar Produk */
        .order-card-sm .order-image {
            height: 180px;
            background-color: #f0f0f0;
        }

        .order-card-sm .order-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Konten di dalam Kartu */
        .order-card-sm .order-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .order-card-sm .order-title {
            font-size: 1.15em;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .order-card-sm .order-destination {
            font-size: 0.9em;
            color: var(--gray-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .order-card-sm .order-price {
            font-size: 1.2em;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        /* Tombol Aksi */
        .order-card-sm .order-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .order-card-sm .btn-action {
            flex: 1;
            padding: 12px;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
        }

        .order-card-sm .btn-secondary {
            background-color: #eef2ff;
            color: var(--primary-color);
        }
        .order-card-sm .btn-secondary:hover {
            background-color: #e0e7ff;
            transform: translateY(-2px);
        }
    </style>


@section('content')
<header class="hero" style="padding-top: 120px; text-align: center;">
    <div class="container">
        <div class="hero-content" style="max-width: 100%;">
            <h1>Selamat Datang, Penitip!</h1>
            <p>Siap untuk menitip barang impian Anda? Buat pesanan baru atau cek status pesanan Anda saat ini.</p>
            <div class="cta-buttons" style="justify-content: center;">
                <a href="{{ route('customer.orders.create') }}" class="btn-primary">Buat Pesanan Baru</a>
                <a href="{{ route('customer.orders.index') }}" class="btn-secondary">Lihat Pesanan Saya</a>
            </div>
        </div>
    </div>
</header>

<section class="orders-showcase">
    <div class="container">
        <h2>Pesanan Aktif Anda</h2>
        <div class="orders-grid">
            @forelse ($myActiveOrders as $order)
                <div class="order-card-sm">
                    <div class="order-image">
                        <img src="{{ $order->product_image_path ? asset('storage/' . $order->product_image_path) : asset('images/order-default.jpg') }}" alt="{{ $order->product_name }}">
                    </div>
                    <div class="order-content">
                        <h3 class="order-title">{{ $order->product_name }}</h3>
                        <p class="order-destination"><i class="fas fa-map-marker-alt"></i> {{ $order->destination }}</p>
                        <p class="order-price">Rp {{ number_format($order->estimated_price) }}</p>
                        <div class="order-actions">
                             <a href="{{ route('customer.orders.show', $order->order_code) }}" class="btn-action btn-secondary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <p style="text-align: center; grid-column: 1 / -1; color: var(--gray-color);">Anda belum memiliki pesanan aktif. Ayo buat pesanan pertama Anda!</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
