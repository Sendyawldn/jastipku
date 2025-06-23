{{-- filepath: c:\laragon\www\jastipku\resources\views\customer\edit_order.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Pesanan')

@push('styles')
    <style>
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .btn {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .alert-warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            border-radius: 8px;
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
                <li class="breadcrumb-item"><a href="{{ route('customer.orders.show', $order) }}"
                        class="text-decoration-none">Detail Pesanan</a></li>
                <li class="breadcrumb-item active">Edit Pesanan</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Edit Pesanan</h2>
                        <p class="text-muted mb-0">Perbarui detail pesanan Anda</p>
                    </div>
                    <div>
                        <span class="badge bg-warning text-dark px-3 py-2">Status: Pending</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Alert -->
        <div class="alert alert-warning mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian:</strong> Anda hanya dapat mengedit pesanan yang masih berstatus <strong>Pending</strong>.
            Setelah pesanan diterima oleh traveler, perubahan tidak dapat dilakukan.
        </div>

        <!-- Form -->
        <form action="{{ route('customer.orders.update', $order) }}" method="POST" enctype="multipart/form-data"
            id="editOrderForm">
            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col-lg-8">
                    <!-- Informasi Barang -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Edit Informasi Barang</h5>
                                <small class="text-muted">Perbarui detail barang yang ingin dibeli</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nama_barang" class="form-label fw-semibold">Nama Barang <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                    id="nama_barang" name="nama_barang"
                                    value="{{ old('nama_barang', $order->nama_barang) }}"
                                    placeholder="Contoh: Tas Korea Brand Terkenal, Skincare Set, dll" required>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kategori" class="form-label fw-semibold">Kategori <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                    name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="fashion"
                                        {{ old('kategori', $order->kategori) == 'fashion' ? 'selected' : '' }}>👗 Fashion &
                                        Pakaian</option>
                                    <option value="skincare"
                                        {{ old('kategori', $order->kategori) == 'skincare' ? 'selected' : '' }}>🧴 Skincare
                                        & Kosmetik</option>
                                    <option value="elektronik"
                                        {{ old('kategori', $order->kategori) == 'elektronik' ? 'selected' : '' }}>📱
                                        Elektronik</option>
                                    <option value="makanan"
                                        {{ old('kategori', $order->kategori) == 'makanan' ? 'selected' : '' }}>🍎 Makanan &
                                        Minuman</option>
                                    <option value="buku"
                                        {{ old('kategori', $order->kategori) == 'buku' ? 'selected' : '' }}>📚 Buku &
                                        Majalah</option>
                                    <option value="beauty"
                                        {{ old('kategori', $order->kategori) == 'beauty' ? 'selected' : '' }}>💄 Beauty &
                                        Health</option>
                                    <option value="accessories"
                                        {{ old('kategori', $order->kategori) == 'accessories' ? 'selected' : '' }}>👜
                                        Accessories</option>
                                    <option value="toys"
                                        {{ old('kategori', $order->kategori) == 'toys' ? 'selected' : '' }}>🧸 Mainan &
                                        Hobi</option>
                                    <option value="sports"
                                        {{ old('kategori', $order->kategori) == 'sports' ? 'selected' : '' }}>⚽ Olahraga
                                    </option>
                                    <option value="home"
                                        {{ old('kategori', $order->kategori) == 'home' ? 'selected' : '' }}>🏠 Rumah Tangga
                                    </option>
                                    <option value="lainnya"
                                        {{ old('kategori', $order->kategori) == 'lainnya' ? 'selected' : '' }}>📦 Lainnya
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
                                        id="budget" name="budget" value="{{ old('budget', $order->budget) }}"
                                        placeholder="2500000" min="50000" max="50000000" required>
                                </div>
                                @error('budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi Detail <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                                    placeholder="Deskripsikan barang yang ingin dibeli dengan detail..." required>{{ old('deskripsi', $order->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="link_produk" class="form-label fw-semibold">Link Produk (Opsional)</label>
                                <input type="url" class="form-control @error('link_produk') is-invalid @enderror"
                                    id="link_produk" name="link_produk"
                                    value="{{ old('link_produk', $order->link_produk) }}"
                                    placeholder="https://tokopedia.com/product/example">
                                @error('link_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="catatan_khusus" class="form-label fw-semibold">Catatan Khusus</label>
                                <textarea class="form-control @error('catatan_khusus') is-invalid @enderror" id="catatan_khusus"
                                    name="catatan_khusus" rows="3" placeholder="Catatan tambahan atau permintaan khusus...">{{ old('catatan_khusus', $order->catatan_khusus) }}</textarea>
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
                                <h5 class="mb-0">Edit Informasi Pengiriman</h5>
                                <small class="text-muted">Perbarui detail tujuan dan deadline</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="destination" class="form-label fw-semibold">Kota Tujuan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('destination') is-invalid @enderror" id="destination"
                                    name="destination" required>
                                    <option value="">Pilih Kota Tujuan</option>
                                    <option value="jakarta"
                                        {{ old('destination', $order->destination) == 'jakarta' ? 'selected' : '' }}>
                                        Jakarta</option>
                                    <option value="bandung"
                                        {{ old('destination', $order->destination) == 'bandung' ? 'selected' : '' }}>
                                        Bandung</option>
                                    <option value="surabaya"
                                        {{ old('destination', $order->destination) == 'surabaya' ? 'selected' : '' }}>
                                        Surabaya</option>
                                    <option value="yogyakarta"
                                        {{ old('destination', $order->destination) == 'yogyakarta' ? 'selected' : '' }}>
                                        Yogyakarta</option>
                                    <option value="semarang"
                                        {{ old('destination', $order->destination) == 'semarang' ? 'selected' : '' }}>
                                        Semarang</option>
                                    <option value="malang"
                                        {{ old('destination', $order->destination) == 'malang' ? 'selected' : '' }}>Malang
                                    </option>
                                    <option value="medan"
                                        {{ old('destination', $order->destination) == 'medan' ? 'selected' : '' }}>Medan
                                    </option>
                                    <option value="palembang"
                                        {{ old('destination', $order->destination) == 'palembang' ? 'selected' : '' }}>
                                        Palembang</option>
                                    <option value="makassar"
                                        {{ old('destination', $order->destination) == 'makassar' ? 'selected' : '' }}>
                                        Makassar</option>
                                    <option value="denpasar"
                                        {{ old('destination', $order->destination) == 'denpasar' ? 'selected' : '' }}>
                                        Denpasar</option>
                                </select>
                                @error('destination')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="deadline" class="form-label fw-semibold">Deadline <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                    id="deadline" name="deadline"
                                    value="{{ old('deadline', $order->deadline ? $order->deadline->format('Y-m-d') : '') }}"
                                    min="{{ date('Y-m-d', strtotime('+3 day')) }}"
                                    max="{{ date('Y-m-d', strtotime('+90 day')) }}" required>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="alamat_pengiriman" class="form-label fw-semibold">Alamat Pengiriman Lengkap
                                    <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat_pengiriman') is-invalid @enderror" id="alamat_pengiriman"
                                    name="alamat_pengiriman" rows="3" placeholder="Alamat lengkap dengan kode pos..." required>{{ old('alamat_pengiriman', $order->alamat_pengiriman) }}</textarea>
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
                                        id="no_telepon" name="no_telepon"
                                        value="{{ old('no_telepon', $order->no_telepon) }}" placeholder="81234567890"
                                        pattern="[0-9]{10,13}" required>
                                </div>
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Order Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Pesanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted">ID Pesanan:</small>
                                <div class="fw-bold">JTP-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Dibuat pada:</small>
                                <div>{{ $order->created_at->format('d F Y, H:i') }}</div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Status:</small>
                                <div><span class="badge bg-warning text-dark">Pending</span></div>
                            </div>
                            <div>
                                <small class="text-muted">Terakhir diubah:</small>
                                <div>{{ $order->updated_at->format('d F Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-cogs me-2"></i>
                                Aksi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning btn-lg" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Batal & Kembali
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-lightbulb me-2"></i>
                                Tips Edit Pesanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <small>Pastikan semua informasi sudah benar</small>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <small>Deadline minimal 3 hari dari sekarang</small>
                            </div>
                            <div>
                                <i class="fas fa-check text-success me-2"></i>
                                <small>Setelah diterima traveler, tidak bisa diedit</small>
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
            const form = document.getElementById('editOrderForm');
            const updateBtn = document.getElementById('updateBtn');

            // Form validation
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading state
                updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                updateBtn.disabled = true;

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
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';
                    updateBtn.disabled = false;
                    alert('Mohon lengkapi semua field yang wajib diisi');
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
                let value = e.target.value.replace(/\D/g, '');

                if (value.startsWith('0')) {
                    value = value.substring(1);
                }

                if (value.length > 13) {
                    value = value.substring(0, 13);
                }

                e.target.value = value;
            });

            // Deadline validation
            const deadlineInput = document.getElementById('deadline');
            deadlineInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                const diffTime = selectedDate - today;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays < 3) {
                    alert('Deadline minimal 3 hari dari sekarang');
                    this.value = '';
                }
            });
        });
    </script>
@endpush
