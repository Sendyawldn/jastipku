@extends('layouts.app')

@section('title', 'Buat Pesanan Baru')

@push('styles')
    <style>
        .category-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .upload-area {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: #4f46e5;
            background-color: #f8fafc;
        }

        .upload-area.dragover {
            border-color: #4f46e5;
            background-color: #eff6ff;
        }

        .image-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .preview-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(220, 38, 38, 0.9);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
        }

        .form-section {
            background: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .estimated-budget {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .payment-methods {
            display: grid;
            gap: 1rem;
        }

        .payment-option {
            position: relative;
        }

        .payment-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .payment-label {
            display: block;
            cursor: pointer;
            margin: 0;
        }

        .payment-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            transition: all 0.3s ease;
            position: relative;
        }

        .payment-card:hover {
            border-color: #4f46e5;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        }

        .payment-option input[type="radio"]:checked+.payment-label .payment-card {
            border-color: #4f46e5;
            background: #f8faff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
        }

        .payment-option input[type="radio"]:checked+.payment-label .payment-card::after {
            content: '✓';
            position: absolute;
            top: 10px;
            right: 15px;
            background: #4f46e5;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .payment-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: white;
            font-size: 1.2rem;
        }

        .payment-info {
            flex: 1;
        }

        .payment-info h6 {
            margin: 0;
            font-weight: 600;
            color: #1f2937;
        }

        .payment-badge {
            margin-left: auto;
        }

        .payment-info-box {
            margin-top: 1rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .payment-card {
                padding: 0.75rem;
            }

            .payment-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .payment-info h6 {
                font-size: 0.9rem;
            }

            .payment-info small {
                font-size: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"
                                class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Buat Pesanan</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Buat Pesanan Baru</h2>
                        <p class="text-muted mb-0">Isi form di bawah untuk membuat pesanan jastip</p>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">Estimasi pengerjaan: 3-7 hari</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle me-2"></i>
            Pastikan semua informasi yang diberikan akurat untuk memudahkan traveler dalam memenuhi pesanan Anda.
        </div>
        <!-- Form -->
        <form action="{{ route('customer.orders.store') }}" method="POST" enctype="multipart/form-data" id="orderForm">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <!-- Informasi Barang -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Informasi Barang</h5>
                                <small class="text-muted">Detail barang yang ingin dibeli</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nama_barang" class="form-label fw-semibold">Nama Barang <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                    id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}"
                                    placeholder="Contoh: Tas Korea Brand Terkenal, Skincare Set, dll" required>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Berikan nama yang spesifik agar traveler mudah mencari</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kategori" class="form-label fw-semibold">Kategori <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                    name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="fashion" {{ old('kategori') == 'fashion' ? 'selected' : '' }}>
                                        👗 Fashion & Pakaian
                                    </option>
                                    <option value="skincare" {{ old('kategori') == 'skincare' ? 'selected' : '' }}>
                                        🧴 Skincare & Kosmetik
                                    </option>
                                    <option value="elektronik" {{ old('kategori') == 'elektronik' ? 'selected' : '' }}>
                                        📱 Elektronik
                                    </option>
                                    <option value="makanan" {{ old('kategori') == 'makanan' ? 'selected' : '' }}>
                                        🍎 Makanan & Minuman
                                    </option>
                                    <option value="buku" {{ old('kategori') == 'buku' ? 'selected' : '' }}>
                                        📚 Buku & Majalah
                                    </option>
                                    <option value="beauty" {{ old('kategori') == 'beauty' ? 'selected' : '' }}>
                                        💄 Beauty & Health
                                    </option>
                                    <option value="accessories" {{ old('kategori') == 'accessories' ? 'selected' : '' }}>
                                        👜 Accessories
                                    </option>
                                    <option value="toys" {{ old('kategori') == 'toys' ? 'selected' : '' }}>
                                        🧸 Mainan & Hobi
                                    </option>
                                    <option value="sports" {{ old('kategori') == 'sports' ? 'selected' : '' }}>
                                        ⚽ Olahraga
                                    </option>
                                    <option value="home" {{ old('kategori') == 'home' ? 'selected' : '' }}>
                                        🏠 Rumah Tangga
                                    </option>
                                    <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>
                                        📦 Lainnya
                                    </option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="budget" class="form-label fw-semibold">Budget (Rp) <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('budget') is-invalid @enderror"
                                        id="budget" name="budget" value="{{ old('budget') }}" placeholder="2500000"
                                        min="50000" max="50000000" required>
                                </div>
                                @error('budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Budget termasuk harga barang + ongkos jasa (biasanya 10-20%)</div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi Detail <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                                    placeholder="Deskripsikan barang yang ingin dibeli dengan detail:&#10;- Merek/brand&#10;- Warna dan ukuran&#10;- Model atau tipe&#10;- Tempat/toko yang direkomendasikan&#10;- Spesifikasi khusus lainnya"
                                    required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Semakin detail deskripsi, semakin mudah traveler membantu Anda</div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="catatan_khusus" class="form-label fw-semibold">Catatan Khusus</label>
                                <textarea class="form-control @error('catatan_khusus') is-invalid @enderror" id="catatan_khusus" name="catatan_khusus"
                                    rows="3"
                                    placeholder="Contoh:&#10;- Warna hitam/putih saja&#10;- Ukuran M atau L&#10;- Jika tidak ada, boleh diganti dengan yang serupa&#10;- Harus original/authentic">{{ old('catatan_khusus') }}</textarea>
                                @error('catatan_khusus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pengiriman -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Informasi Pengiriman</h5>
                                <small class="text-muted">Detail tujuan dan deadline</small>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Pilih Pulau -->
                            <div class="col-md-6 mb-3">
                                <label for="pulau" class="form-label fw-semibold">Pilih Pulau <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('pulau') is-invalid @enderror" id="pulau"
                                    name="pulau" required>
                                    <option value="">Pilih Pulau</option>
                                    <option value="jawa" {{ old('pulau') == 'jawa' ? 'selected' : '' }}>🏝️ Pulau Jawa
                                    </option>
                                    <option value="sumatera" {{ old('pulau') == 'sumatera' ? 'selected' : '' }}>🏝️ Pulau
                                        Sumatera</option>
                                    <option value="kalimantan" {{ old('pulau') == 'kalimantan' ? 'selected' : '' }}>🏝️
                                        Pulau Kalimantan</option>
                                    <option value="sulawesi" {{ old('pulau') == 'sulawesi' ? 'selected' : '' }}>🏝️ Pulau
                                        Sulawesi</option>
                                    <option value="bali_nusa" {{ old('pulau') == 'bali_nusa' ? 'selected' : '' }}>🏝️ Bali
                                        & Nusa Tenggara</option>
                                    <option value="maluku_papua" {{ old('pulau') == 'maluku_papua' ? 'selected' : '' }}>
                                        🏝️ Maluku & Papua</option>
                                </select>
                                @error('pulau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kota Tujuan -->
                            <div class="col-md-6 mb-3">
                                <label for="destination" class="form-label fw-semibold">Kota Tujuan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('destination') is-invalid @enderror" id="destination"
                                    name="destination" required disabled>
                                    <option value="">Pilih pulau terlebih dahulu</option>
                                </select>
                                @error('destination')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Pilih pulau terlebih dahulu untuk melihat daftar kota</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="deadline" class="form-label fw-semibold">Deadline <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                    id="deadline" name="deadline" value="{{ old('deadline') }}"
                                    min="{{ date('Y-m-d', strtotime('+3 day')) }}"
                                    max="{{ date('Y-m-d', strtotime('+90 day')) }}" required>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Minimal 3 hari dari sekarang untuk memungkinkan traveler memproses
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estimasi_sampai" class="form-label fw-semibold">Estimasi Sampai Tujuan</label>
                                <input type="text" class="form-control" id="estimasi_sampai" readonly
                                    placeholder="Pilih kota tujuan untuk melihat estimasi">
                                <div class="form-text">Estimasi waktu pengiriman ke kota tujuan</div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="alamat_pengiriman" class="form-label fw-semibold">Alamat Pengiriman Lengkap
                                    <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat_pengiriman') is-invalid @enderror" id="alamat_pengiriman"
                                    name="alamat_pengiriman" rows="3"
                                    placeholder="Contoh:&#10;Jl. Sudirman No. 123, RT 01 RW 02&#10;Kelurahan Senayan, Kecamatan Kebayoran Baru&#10;Jakarta Selatan 12190&#10;Patokan: Dekat Mall Senayan City"
                                    required>{{ old('alamat_pengiriman') }}</textarea>
                                @error('alamat_pengiriman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="no_telepon" class="form-label fw-semibold">No. Telepon (WhatsApp) <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="tel" class="form-control @error('no_telepon') is-invalid @enderror"
                                        id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                                        placeholder="81234567890" pattern="[0-9]{10,13}" required>
                                </div>
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nomor WhatsApp aktif untuk komunikasi dengan traveler</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Metode Pembayaran</h5>
                                <small class="text-muted">Pilih cara pembayaran yang diinginkan</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Pilih Metode Pembayaran <span
                                        class="text-danger">*</span></label>

                                <div class="payment-methods">
                                    <!-- Bank Transfer -->
                                    <div class="payment-option">
                                        <input type="radio"
                                            class="form-check-input @error('metode_pembayaran') is-invalid @enderror"
                                            id="bank_transfer" name="metode_pembayaran" value="bank_transfer"
                                            {{ old('metode_pembayaran') == 'bank_transfer' ? 'checked' : '' }} required>
                                        <label for="bank_transfer" class="payment-label">
                                            <div class="payment-card">
                                                <div class="payment-icon bg-primary">
                                                    <i class="fas fa-university"></i>
                                                </div>
                                                <div class="payment-info">
                                                    <h6 class="mb-1">Transfer Bank</h6>
                                                    <small class="text-muted">BCA, Mandiri, BNI, BRI</small>
                                                </div>
                                                <div class="payment-badge">
                                                    <span class="badge bg-success">Populer</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- E-Wallet -->
                                    <div class="payment-option">
                                        <input type="radio" class="form-check-input" id="ewallet"
                                            name="metode_pembayaran" value="ewallet"
                                            {{ old('metode_pembayaran') == 'ewallet' ? 'checked' : '' }}>
                                        <label for="ewallet" class="payment-label">
                                            <div class="payment-card">
                                                <div class="payment-icon bg-success">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </div>
                                                <div class="payment-info">
                                                    <h6 class="mb-1">E-Wallet</h6>
                                                    <small class="text-muted">OVO, GoPay, DANA, ShopeePay</small>
                                                </div>
                                                <div class="payment-badge">
                                                    <span class="badge bg-info">Cepat</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Virtual Account -->
                                    <div class="payment-option">
                                        <input type="radio" class="form-check-input" id="virtual_account"
                                            name="metode_pembayaran" value="virtual_account"
                                            {{ old('metode_pembayaran') == 'virtual_account' ? 'checked' : '' }}>
                                        <label for="virtual_account" class="payment-label">
                                            <div class="payment-card">
                                                <div class="payment-icon bg-warning">
                                                    <i class="fas fa-credit-card"></i>
                                                </div>
                                                <div class="payment-info">
                                                    <h6 class="mb-1">Virtual Account</h6>
                                                    <small class="text-muted">VA BCA, Mandiri, BNI, BRI</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- QRIS -->
                                    <div class="payment-option">
                                        <input type="radio" class="form-check-input" id="qris"
                                            name="metode_pembayaran" value="qris"
                                            {{ old('metode_pembayaran') == 'qris' ? 'checked' : '' }}>
                                        <label for="qris" class="payment-label">
                                            <div class="payment-card">
                                                <div class="payment-icon bg-info">
                                                    <i class="fas fa-qrcode"></i>
                                                </div>
                                                <div class="payment-info">
                                                    <h6 class="mb-1">QRIS</h6>
                                                    <small class="text-muted">Scan QR untuk pembayaran</small>
                                                </div>
                                                <div class="payment-badge">
                                                    <span class="badge bg-primary">Praktis</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Cash on Delivery -->
                                    <div class="payment-option">
                                        <input type="radio" class="form-check-input" id="cash_on_delivery"
                                            name="metode_pembayaran" value="cash_on_delivery"
                                            {{ old('metode_pembayaran') == 'cash_on_delivery' ? 'checked' : '' }}>
                                        <label for="cash_on_delivery" class="payment-label">
                                            <div class="payment-card">
                                                <div class="payment-icon bg-secondary">
                                                    <i class="fas fa-money-bill"></i>
                                                </div>
                                                <div class="payment-info">
                                                    <h6 class="mb-1">Bayar di Tempat (COD)</h6>
                                                    <small class="text-muted">Bayar saat barang diterima</small>
                                                </div>
                                                <div class="payment-badge">
                                                    <span class="badge bg-warning">Aman</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                @error('metode_pembayaran')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <!-- Payment Info -->
                                <div class="payment-info-box mt-3" id="paymentInfo" style="display: none;">
                                    <div class="alert alert-info mb-0">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-info-circle me-2 mt-1"></i>
                                            <div>
                                                <strong class="payment-method-name">Informasi Pembayaran</strong>
                                                <p class="mb-0 mt-1 payment-method-desc">Pilih metode pembayaran untuk
                                                    melihat informasi detail</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Foto Produk -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-images"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Foto Referensi (Opsional)</h5>
                                <small class="text-muted">Upload foto untuk membantu traveler memahami barang yang
                                    diinginkan</small>
                            </div>
                        </div>

                        <div class="upload-area text-center p-4" id="uploadArea">
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt text-primary mb-3" style="font-size: 3rem;"></i>
                                <h6 class="mb-2">Drag & Drop foto di sini atau klik untuk pilih</h6>
                                <p class="text-muted mb-3">Maksimal 5 foto, ukuran maksimal 2MB per foto</p>
                                <p class="text-muted small">Format yang didukung: JPG, PNG, JPEG</p>
                                <input type="file"
                                    class="form-control d-none @error('foto_produk.*') is-invalid @enderror"
                                    id="foto_produk" name="foto_produk[]" multiple
                                    accept="image/jpeg,image/jpg,image/png" maxlength="5">
                                <button type="button" class="btn btn-outline-primary mt-2"
                                    onclick="document.getElementById('foto_produk').click()">
                                    <i class="fas fa-plus me-2"></i>Pilih Foto
                                </button>
                            </div>
                            @error('foto_produk.*')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="imagePreview" class="image-preview"></div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card border-0 shadow-sm sticky-top" style="top: 2rem;">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-receipt me-2"></i>
                                Ringkasan Pesanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Budget Maksimal:</span>
                                    <span class="fw-bold text-primary" id="displayBudget">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Estimasi Ongkos Jasa:</span>
                                    <span class="fw-semibold text-success" id="estimatedFee">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Budget untuk Barang:</span>
                                    <span class="fw-semibold" id="itemBudget">Rp 0</span>
                                </div>
                                <!-- Payment method summary akan ditambahkan di sini via JavaScript -->
                            </div>

                            <div class="estimated-budget">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <span class="fw-semibold">Estimasi Biaya</span>
                                </div>
                                <small>Ongkos jasa biasanya 10-20% dari budget, sudah termasuk biaya belanja dan
                                    pengiriman</small>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Perlindungan Pembelian
                                </h6>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <small>100% uang kembali jika pesanan dibatalkan</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <small>Garansi keaslian barang</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <small>Customer service 24/7</small>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Buat Pesanan
                                </button>
                                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const budgetInput = document.getElementById('budget');
            const displayBudget = document.getElementById('displayBudget');
            const estimatedFee = document.getElementById('estimatedFee');
            const itemBudget = document.getElementById('itemBudget');
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('foto_produk');
            const imagePreview = document.getElementById('imagePreview');
            const pulauSelect = document.getElementById('pulau');
            const destinationSelect = document.getElementById('destination');
            const estimasiSampai = document.getElementById('estimasi_sampai');
            const paymentMethods = document.querySelectorAll('input[name="metode_pembayaran"]');
            const paymentInfo = document.getElementById('paymentInfo');
            const paymentMethodName = document.querySelector('.payment-method-name');
            const paymentMethodDesc = document.querySelector('.payment-method-desc');
            const paymentDescriptions = {
                'bank_transfer': {
                    name: 'Transfer Bank',
                    desc: 'Pembayaran akan dilakukan melalui transfer bank. Anda akan mendapatkan nomor rekening setelah pesanan dikonfirmasi.'
                },
                'ewallet': {
                    name: 'E-Wallet',
                    desc: 'Pembayaran menggunakan aplikasi e-wallet seperti OVO, GoPay, DANA, atau ShopeePay. Proses pembayaran instan.'
                },
                'virtual_account': {
                    name: 'Virtual Account',
                    desc: 'Anda akan mendapatkan nomor Virtual Account untuk pembayaran melalui ATM, mobile banking, atau internet banking.'
                },
                'qris': {
                    name: 'QRIS',
                    desc: 'Scan kode QR menggunakan aplikasi pembayaran yang mendukung QRIS. Pembayaran langsung terverifikasi.'
                },
                'cash_on_delivery': {
                    name: 'Bayar di Tempat (COD)',
                    desc: 'Pembayaran dilakukan saat barang diterima. Pastikan menyiapkan uang pas sesuai total pembayaran.'
                }
            };
            let selectedFiles = [];

            // Data kota berdasarkan pulau
            const cityData = {
                'jawa': {
                    cities: [{
                            value: 'jakarta',
                            name: 'DKI Jakarta',
                            estimasi: '1-2 hari'
                        },
                        {
                            value: 'bandung',
                            name: 'Bandung',
                            estimasi: '2-3 hari'
                        },
                        {
                            value: 'surabaya',
                            name: 'Surabaya',
                            estimasi: '2-3 hari'
                        },
                        {
                            value: 'yogyakarta',
                            name: 'Yogyakarta',
                            estimasi: '2-3 hari'
                        },
                        {
                            value: 'semarang',
                            name: 'Semarang',
                            estimasi: '2-3 hari'
                        },
                        {
                            value: 'malang',
                            name: 'Malang',
                            estimasi: '3-4 hari'
                        },
                        {
                            value: 'solo',
                            name: 'Solo (Surakarta)',
                            estimasi: '2-3 hari'
                        },
                        {
                            value: 'bogor',
                            name: 'Bogor',
                            estimasi: '1-2 hari'
                        },
                        {
                            value: 'depok',
                            name: 'Depok',
                            estimasi: '1-2 hari'
                        },
                        {
                            value: 'bekasi',
                            name: 'Bekasi',
                            estimasi: '1-2 hari'
                        },
                        {
                            value: 'tangerang',
                            name: 'Tangerang',
                            estimasi: '1-2 hari'
                        },
                        {
                            value: 'cirebon',
                            name: 'Cirebon',
                            estimasi: '2-3 hari'
                        },
                        {
                            value: 'purwokerto',
                            name: 'Purwokerto',
                            estimasi: '3-4 hari'
                        },
                        {
                            value: 'tegal',
                            name: 'Tegal',
                            estimasi: '3-4 hari'
                        }
                    ]
                },
                'sumatera': {
                    cities: [{
                            value: 'medan',
                            name: 'Medan',
                            estimasi: '3-5 hari'
                        },
                        {
                            value: 'palembang',
                            name: 'Palembang',
                            estimasi: '3-4 hari'
                        },
                        {
                            value: 'pekanbaru',
                            name: 'Pekanbaru',
                            estimasi: '3-4 hari'
                        },
                        {
                            value: 'padang',
                            name: 'Padang',
                            estimasi: '4-5 hari'
                        },
                        {
                            value: 'bandar_lampung',
                            name: 'Bandar Lampung',
                            estimasi: '2-3 hari'
                        },
                        {
                            value: 'batam',
                            name: 'Batam',
                            estimasi: '3-4 hari'
                        },
                        {
                            value: 'jambi',
                            name: 'Jambi',
                            estimasi: '3-4 hari'
                        },
                        {
                            value: 'bengkulu',
                            name: 'Bengkulu',
                            estimasi: '4-5 hari'
                        },
                        {
                            value: 'banda_aceh',
                            name: 'Banda Aceh',
                            estimasi: '4-6 hari'
                        },
                        {
                            value: 'dumai',
                            name: 'Dumai',
                            estimasi: '4-5 hari'
                        }
                    ]
                },
                'kalimantan': {
                    cities: [{
                            value: 'banjarmasin',
                            name: 'Banjarmasin',
                            estimasi: '3-5 hari'
                        },
                        {
                            value: 'balikpapan',
                            name: 'Balikpapan',
                            estimasi: '4-5 hari'
                        },
                        {
                            value: 'samarinda',
                            name: 'Samarinda',
                            estimasi: '4-5 hari'
                        },
                        {
                            value: 'pontianak',
                            name: 'Pontianak',
                            estimasi: '4-5 hari'
                        },
                        {
                            value: 'palangkaraya',
                            name: 'Palangkaraya',
                            estimasi: '4-6 hari'
                        },
                        {
                            value: 'tarakan',
                            name: 'Tarakan',
                            estimasi: '5-6 hari'
                        },
                        {
                            value: 'singkawang',
                            name: 'Singkawang',
                            estimasi: '4-5 hari'
                        },
                        {
                            value: 'bontang',
                            name: 'Bontang',
                            estimasi: '4-5 hari'
                        }
                    ]
                },
                'sulawesi': {
                    cities: [{
                            value: 'makassar',
                            name: 'Makassar',
                            estimasi: '3-5 hari'
                        },
                        {
                            value: 'manado',
                            name: 'Manado',
                            estimasi: '4-6 hari'
                        },
                        {
                            value: 'palu',
                            name: 'Palu',
                            estimasi: '4-6 hari'
                        },
                        {
                            value: 'kendari',
                            name: 'Kendari',
                            estimasi: '4-6 hari'
                        },
                        {
                            value: 'gorontalo',
                            name: 'Gorontalo',
                            estimasi: '5-6 hari'
                        },
                        {
                            value: 'pare_pare',
                            name: 'Pare-Pare',
                            estimasi: '4-5 hari'
                        },
                        {
                            value: 'palopo',
                            name: 'Palopo',
                            estimasi: '4-5 hari'
                        },
                        {
                            value: 'bitung',
                            name: 'Bitung',
                            estimasi: '4-6 hari'
                        }
                    ]
                },
                'bali_nusa': {
                    cities: [{
                            value: 'denpasar',
                            name: 'Denpasar (Bali)',
                            estimasi: '2-4 hari'
                        },
                        {
                            value: 'mataram',
                            name: 'Mataram (Lombok)',
                            estimasi: '3-5 hari'
                        },
                        {
                            value: 'kupang',
                            name: 'Kupang (NTT)',
                            estimasi: '4-6 hari'
                        },
                        {
                            value: 'sumbawa',
                            name: 'Sumbawa Besar',
                            estimasi: '4-6 hari'
                        },
                        {
                            value: 'ende',
                            name: 'Ende',
                            estimasi: '5-7 hari'
                        },
                        {
                            value: 'maumere',
                            name: 'Maumere',
                            estimasi: '5-7 hari'
                        },
                        {
                            value: 'ubud',
                            name: 'Ubud',
                            estimasi: '4-6 hari'
                        },
                        {
                            value: 'sanur',
                            name: 'Sanur',
                            estimasi: '4-6 hari'
                        },
                        {
                            value: 'kuta',
                            name: 'Kuta',
                            estimasi: '4-6 hari'
                        },

                        {
                            value: 'labuan_bajo',
                            name: 'Labuan Bajo',
                            estimasi: '4-6 hari'
                        }
                    ]
                },
                'maluku_papua': {
                    cities: [{
                            value: 'ambon',
                            name: 'Ambon',
                            estimasi: '5-7 hari'
                        },
                        {
                            value: 'jayapura',
                            name: 'Jayapura',
                            estimasi: '6-8 hari'
                        },
                        {
                            value: 'sorong',
                            name: 'Sorong',
                            estimasi: '6-8 hari'
                        },
                        {
                            value: 'merauke',
                            name: 'Merauke',
                            estimasi: '7-9 hari'
                        },
                        {
                            value: 'ternate',
                            name: 'Ternate',
                            estimasi: '5-7 hari'
                        },
                        {
                            value: 'manokwari',
                            name: 'Manokwari',
                            estimasi: '6-8 hari'
                        },
                        {
                            value: 'timika',
                            name: 'Timika',
                            estimasi: '7-9 hari'
                        }
                    ]
                }
            };

            // Handle pulau selection
            pulauSelect.addEventListener('change', function() {
                const selectedPulau = this.value;

                // Reset destination select
                destinationSelect.innerHTML = '<option value="">Pilih Kota Tujuan</option>';
                destinationSelect.disabled = !selectedPulau;
                estimasiSampai.value = '';

                if (selectedPulau && cityData[selectedPulau]) {
                    const cities = cityData[selectedPulau].cities;

                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.value;
                        option.textContent = city.name;

                        // Set selected if this was the old value
                        if (city.value === '{{ old('destination') }}') {
                            option.selected = true;
                        }

                        destinationSelect.appendChild(option);
                    });

                    // Update placeholder
                    destinationSelect.querySelector('option').textContent = 'Pilih Kota Tujuan';
                }
            });

            // Handle destination selection
            destinationSelect.addEventListener('change', function() {
                const selectedCity = this.value;
                const selectedPulau = pulauSelect.value;

                if (selectedCity && selectedPulau && cityData[selectedPulau]) {
                    const city = cityData[selectedPulau].cities.find(c => c.value === selectedCity);
                    if (city) {
                        estimasiSampai.value = city.estimasi;

                        // Update budget info based on destination
                        updateShippingCost(selectedPulau);
                    }
                } else {
                    estimasiSampai.value = '';
                }
            });

            // Update shipping cost estimation
            function updateShippingCost(pulau) {
                const shippingMultiplier = {
                    'jawa': 1.0,
                    'sumatera': 1.2,
                    'kalimantan': 1.3,
                    'sulawesi': 1.3,
                    'bali_nusa': 1.4,
                    'maluku_papua': 1.6
                };

                const budget = parseFloat(budgetInput.value) || 0;
                const baseFee = budget * 0.15;
                const shippingFee = baseFee * (shippingMultiplier[pulau] || 1.0);
                const itemCost = budget - shippingFee;

                estimatedFee.textContent = formatRupiah(shippingFee);
                itemBudget.textContent = formatRupiah(itemCost);

                // Add shipping info
                const existingInfo = document.getElementById('shipping-info');
                if (existingInfo) existingInfo.remove();

        //         const shippingInfo = document.createElement('div');
        //         shippingInfo.id = 'shipping-info';
        //         shippingInfo.className = 'mt-2 p-2 bg-info bg-opacity-10 rounded';
        //         shippingInfo.innerHTML = `
        //     <small class="text-info">
        //         <i class="fas fa-info-circle me-1"></i>
        //         Ongkos jasa disesuaikan dengan jarak tujuan
        //     </small>
        // `;

                estimatedFee.parentElement.appendChild(shippingInfo);
            }

            // Initialize if there's old value
            if ('{{ old('pulau') }}') {
                pulauSelect.dispatchEvent(new Event('change'));

                setTimeout(() => {
                    if ('{{ old('destination') }}') {
                        destinationSelect.value = '{{ old('destination') }}';
                        destinationSelect.dispatchEvent(new Event('change'));
                    }
                }, 100);
            }

            // Budget calculation
            function updateBudgetDisplay() {
                const budget = parseFloat(budgetInput.value) || 0;
                let fee = budget * 0.15; // 15% base fee

                // Adjust fee based on selected destination
                const selectedPulau = pulauSelect.value;
                if (selectedPulau) {
                    const shippingMultiplier = {
                        'jawa': 1.0,
                        'sumatera': 1.2,
                        'kalimantan': 1.3,
                        'sulawesi': 1.3,
                        'bali_nusa': 1.4,
                        'maluku_papua': 1.6
                    };
                    fee *= (shippingMultiplier[selectedPulau] || 1.0);
                }

                const itemCost = budget - fee;

                displayBudget.textContent = formatRupiah(budget);
                estimatedFee.textContent = formatRupiah(fee);
                itemBudget.textContent = formatRupiah(itemCost);
            }

            function formatRupiah(number) {
                return 'Rp ' + number.toLocaleString('id-ID');
            }

            budgetInput.addEventListener('input', updateBudgetDisplay);

            // File upload handling
            uploadArea.addEventListener('click', () => fileInput.click());

            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                handleFiles(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', (e) => {
                handleFiles(e.target.files);
            });

            function handleFiles(files) {
                const maxFiles = 5;
                const maxSize = 2 * 1024 * 1024; // 2MB
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                Array.from(files).forEach(file => {
                    if (selectedFiles.length >= maxFiles) {
                        alert(`Maksimal ${maxFiles} foto yang dapat diupload`);
                        return;
                    }

                    if (!allowedTypes.includes(file.type)) {
                        alert(`File ${file.name} bukan format gambar yang didukung`);
                        return;
                    }

                    if (file.size > maxSize) {
                        alert(`File ${file.name} terlalu besar. Maksimal 2MB`);
                        return;
                    }

                    selectedFiles.push(file);
                });

                updateFileInput();
                displayImages();
            }

            function updateFileInput() {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            }

            function displayImages() {
                imagePreview.innerHTML = '';

                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'preview-item';
                        previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}">
                    <button type="button" class="remove-image" onclick="removeImage(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-75 text-white px-2 py-1 small">
                        ${index + 1}
                    </div>
                `;
                        imagePreview.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Make removeImage function global
            window.removeImage = function(index) {
                selectedFiles.splice(index, 1);
                updateFileInput();
                displayImages();
            }

            // Form validation
            const form = document.getElementById('orderForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuat Pesanan...';
                submitBtn.disabled = true;

                // Validate required fields
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Buat Pesanan';
                    submitBtn.disabled = false;
                    alert('Mohon lengkapi semua field yang wajib diisi');
                    return;
                }

                // Validate budget
                const budget = parseFloat(budgetInput.value);
                if (budget < 50000) {
                    alert('Budget minimal Rp 50.000');
                    budgetInput.focus();
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Buat Pesanan';
                    submitBtn.disabled = false;
                    return;
                }

                // Submit form
                setTimeout(() => {
                    form.submit();
                }, 1000);
            });

            // Phone number formatting
            const phoneInput = document.getElementById('no_telepon');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove non-digits

                // Remove leading 0 if present
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }

                // Limit to 13 digits
                if (value.length > 13) {
                    value = value.substring(0, 13);
                }

                e.target.value = value;
            });

            // Auto-update estimated delivery date
            const deadlineInput = document.getElementById('deadline');
            deadlineInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                const diffTime = selectedDate - today;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays < 3) {
                    alert(
                        'Deadline minimal 3 hari dari sekarang untuk memberikan waktu traveler memproses pesanan'
                    );
                    this.value = '';
                }
            });

            // Initialize budget display
            updateBudgetDisplay();

            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    if (this.checked) {
                        const selectedMethod = this.value;
                        const methodInfo = paymentDescriptions[selectedMethod];

                        if (methodInfo) {
                            paymentMethodName.textContent = methodInfo.name;
                            paymentMethodDesc.textContent = methodInfo.desc;
                            paymentInfo.style.display = 'block';

                            // Update summary in sidebar
                            updatePaymentSummary(selectedMethod);
                        }
                    }
                });
            });

            // Check if there's a selected payment method on load
            const selectedPayment = document.querySelector('input[name="metode_pembayaran"]:checked');
            if (selectedPayment) {
                selectedPayment.dispatchEvent(new Event('change'));
            }

            function updatePaymentSummary(method) {
                const methodNames = {
                    'bank_transfer': 'Transfer Bank',
                    'ewallet': 'E-Wallet',
                    'virtual_account': 'Virtual Account',
                    'qris': 'QRIS',
                    'cash_on_delivery': 'COD'
                };

                // Update payment method in sidebar summary
                let paymentSummaryElement = document.getElementById('paymentMethodSummary');
                if (!paymentSummaryElement) {
                    // Create payment method summary element in sidebar
                    const summaryContainer = document.querySelector('.card-body .mb-3:last-child');
                    if (summaryContainer) {
                        const paymentElement = document.createElement('div');
                        paymentElement.className = 'd-flex justify-content-between align-items-center mb-2';
                        paymentElement.id = 'paymentMethodSummary';
                        paymentElement.innerHTML = `
                        <span class="text-muted">Metode Pembayaran:</span>
                        <span class="fw-semibold text-info" id="selectedPaymentMethod">${methodNames[method] || method}</span>
                    `;
                        summaryContainer.appendChild(paymentElement);
                    }
                } else {
                    document.getElementById('selectedPaymentMethod').textContent = methodNames[method] || method;
                }
            }
        });
    </script>
@endpush
