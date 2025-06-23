{{-- filepath: c:\laragon\www\jastipku\resources\views\customer\invoice.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - JastipKu</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .invoice-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            padding: 30px;
            border-bottom: 2px solid #f1f5f9;
        }

        .invoice-info div {
            flex: 1;
        }

        .invoice-info h3 {
            margin: 0 0 15px 0;
            color: #4f46e5;
            font-size: 1.2rem;
        }

        .invoice-info p {
            margin: 5px 0;
            line-height: 1.5;
        }

        .order-details {
            padding: 30px;
        }

        .detail-section {
            margin-bottom: 30px;
        }

        .detail-section h3 {
            color: #4f46e5;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
        }

        .detail-value {
            color: #111827;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .payment-summary {
            background: #f8fafc;
            border-radius: 10px;
            padding: 25px;
            margin-top: 30px;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
        }

        .payment-row.total {
            border-top: 2px solid #e5e7eb;
            margin-top: 15px;
            padding-top: 15px;
            font-weight: bold;
            font-size: 1.2rem;
            color: #4f46e5;
        }

        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer p {
            margin: 5px 0;
            color: #6b7280;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        @media print {
            body {
                background: white;
            }

            .invoice-container {
                box-shadow: none;
            }

            .no-print {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .invoice-info {
                flex-direction: column;
                gap: 20px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .payment-row {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <h1>JastipKu</h1>
            <p>Platform Jasa Titip Terpercaya</p>
            <p style="font-size: 0.9rem; margin-top: 15px;">
                INVOICE #JTP-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
            </p>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div>
                <h3>Informasi Pesanan</h3>
                <p><strong>Tanggal Pesanan:</strong><br>{{ $order->created_at->format('d F Y') }}</p>
                <p><strong>Status:</strong><br>
                    @php
                        $statusClasses = [
                            'pending' => 'status-pending',
                            'completed' => 'status-completed',
                            'cancelled' => 'status-cancelled',
                        ];
                        $statusTexts = [
                            'pending' => 'Menunggu',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                    @endphp
                    <span class="status-badge {{ $statusClasses[$order->status] ?? 'status-pending' }}">
                        {{ $statusTexts[$order->status] ?? ucfirst($order->status) }}
                    </span>
                </p>
                @if ($order->completed_at)
                    <p><strong>Tanggal Selesai:</strong><br>{{ $order->completed_at->format('d F Y') }}</p>
                @endif
            </div>
            <div>
                <h3>Informasi Customer</h3>
                <p><strong>Nama:</strong><br>{{ $order->customer->name }}</p>
                <p><strong>Email:</strong><br>{{ $order->customer->email }}</p>
                <p><strong>Telepon:</strong><br>+62{{ $order->no_telepon }}</p>
            </div>
            @if ($order->traveler)
                <div>
                    <h3>Informasi Traveler</h3>
                    <p><strong>Nama:</strong><br>{{ $order->traveler->name }}</p>
                    <p><strong>Email:</strong><br>{{ $order->traveler->email }}</p>
                    @if ($order->traveler->phone)
                        <p><strong>Telepon:</strong><br>+62{{ $order->traveler->phone }}</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Order Details -->
        <div class="order-details">
            <!-- Detail Barang -->
            <div class="detail-section">
                <h3>Detail Barang</h3>
                <div class="detail-grid">
                    <span class="detail-label">Nama Barang:</span>
                    <span class="detail-value">{{ $order->nama_barang }}</span>
                </div>
                <div class="detail-grid">
                    <span class="detail-label">Kategori:</span>
                    <span class="detail-value">{{ ucfirst($order->kategori) }}</span>
                </div>
                <div class="detail-grid">
                    <span class="detail-label">Deskripsi:</span>
                    <span class="detail-value">{{ $order->deskripsi }}</span>
                </div>
                @if ($order->catatan_khusus)
                    <div class="detail-grid">
                        <span class="detail-label">Catatan Khusus:</span>
                        <span class="detail-value">{{ $order->catatan_khusus }}</span>
                    </div>
                @endif
                @if ($order->link_produk)
                    <div class="detail-grid">
                        <span class="detail-label">Link Produk:</span>
                        <span class="detail-value">{{ $order->link_produk }}</span>
                    </div>
                @endif
            </div>

            <!-- Detail Pengiriman -->
            <div class="detail-section">
                <h3>Detail Pengiriman</h3>
                <div class="detail-grid">
                    <span class="detail-label">Tujuan:</span>
                    <span class="detail-value">{{ ucfirst($order->destination) }}</span>
                </div>
                <div class="detail-grid">
                    <span class="detail-label">Deadline:</span>
                    <span class="detail-value">{{ $order->deadline ? $order->deadline->format('d F Y') : '-' }}</span>
                </div>
                <div class="detail-grid">
                    <span class="detail-label">Alamat Pengiriman:</span>
                    <span class="detail-value">{{ $order->alamat_pengiriman }}</span>
                </div>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="payment-summary">
                <h3 style="margin-top: 0; color: #4f46e5;">Ringkasan Pembayaran</h3>

                <div class="payment-row">
                    <span>Budget Awal:</span>
                    <span>Rp {{ number_format($order->budget, 0, ',', '.') }}</span>
                </div>

                @if ($order->total_belanja)
                    <div class="payment-row">
                        <span>Total Belanja Aktual:</span>
                        <span>Rp {{ number_format($order->total_belanja, 0, ',', '.') }}</span>
                    </div>
                @endif

                @if ($order->ongkos_jasa)
                    <div class="payment-row">
                        <span>Ongkos Jasa:</span>
                        <span>Rp {{ number_format($order->ongkos_jasa, 0, ',', '.') }}</span>
                    </div>
                @endif

                @if ($order->total_pembayaran)
                    <div class="payment-row total">
                        <span>Total Pembayaran:</span>
                        <span>Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}</span>
                    </div>
                @else
                    <div class="payment-row total">
                        <span>Budget yang Dialokasikan:</span>
                        <span>Rp {{ number_format($order->budget, 0, ',', '.') }}</span>
                    </div>
                @endif

                @if ($order->status === 'completed' && $order->total_belanja && $order->budget > $order->total_belanja)
                    <div class="payment-row" style="color: #059669;">
                        <span>Sisa Budget (Dikembalikan):</span>
                        <span>Rp {{ number_format($order->budget - $order->total_belanja, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>

            <!-- QR Code for verification (optional) -->
            <div class="qr-code">
                <p style="margin-bottom: 10px; color: #6b7280;"><strong>Kode Verifikasi Pesanan</strong></p>
                <div style="background: #f3f4f6; padding: 15px; border-radius: 8px; display: inline-block;">
                    <strong
                        style="font-family: monospace; font-size: 1.2rem;">JTP-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>JastipKu - Platform Jasa Titip Terpercaya</strong></p>
            <p>Email: support@jastipku.com | WhatsApp: +62 812-3456-7890</p>
            <p>Website: www.jastipku.com</p>
            <p style="margin-top: 20px; font-size: 0.875rem;">
                Invoice ini dibuat secara otomatis pada {{ now()->format('d F Y, H:i') }} WIB
            </p>
        </div>
    </div>

    <!-- Print Button (hanya muncul di web) -->
    <div style="text-align: center; margin: 30px 0;" class="no-print">
        <button onclick="window.print()"
            style="background: #4f46e5; color: white; border: none; padding: 15px 30px; border-radius: 8px; font-size: 1rem; cursor: pointer; margin-right: 15px;">
            <i class="fas fa-print"></i> Cetak Invoice
        </button>
        <button onclick="window.close()"
            style="background: #6b7280; color: white; border: none; padding: 15px 30px; border-radius: 8px; font-size: 1rem; cursor: pointer;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <script>
        // Auto print when opened in new window
        if (window.opener) {
            window.onload = function() {
                setTimeout(() => {
                    window.print();
                }, 500);
            }
        }
    </script>
</body>

</html>
