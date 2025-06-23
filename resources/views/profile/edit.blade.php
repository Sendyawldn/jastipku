@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a
                                href="{{ Auth::user()->role === 'penitip' ? route('customer.dashboard') : route('traveler.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Edit Profil</li>
                    </ol>
                </nav>
                <h2 class="fw-bold text-dark mb-1">Edit Profil</h2>
                <p class="text-muted">Kelola informasi profil dan keamanan akun Anda</p>
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

        <div class="row">
            <!-- Profile Information -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-edit text-primary me-2"></i>
                            Informasi Profil
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- Profile Photo -->
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://via.placeholder.com/120x120' }}"
                                        alt="Profile Photo" class="rounded-circle border border-3 border-primary"
                                        width="120" height="120" id="profilePreview">
                                    <label for="profile_photo"
                                        class="position-absolute bottom-0 end-0 btn btn-primary btn-sm rounded-circle">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" class="d-none @error('profile_photo') is-invalid @enderror"
                                        id="profile_photo" name="profile_photo" accept="image/*"
                                        onchange="previewImage(this)">
                                </div>
                                @error('profile_photo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <p class="text-muted mt-2 mb-0">Klik icon kamera untuk mengubah foto profil</p>
                            </div>

                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-semibold">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-semibold">No. Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                        required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label fw-semibold">Peran</label>
                                    <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->role) }}"
                                        readonly>
                                    <small class="text-muted">Peran tidak dapat diubah</small>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label fw-semibold">Alamat <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                        required>{{ old('address', Auth::user()->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="bio" class="form-label fw-semibold">Bio (Opsional)</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3"
                                        placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Traveler Specific Fields -->
                            @if (Auth::user()->role === 'traveler')
                                <hr class="my-4">
                                <div class="col-md-12 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="available_for_orders"
                                            name="available_for_orders" value="1"
                                            {{ old('available_for_orders', Auth::user()->travelerProfile->available_for_orders ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="available_for_orders">
                                            Tersedia untuk menerima pesanan
                                        </label>
                                        <small class="d-block text-muted">Aktifkan untuk menampilkan profil Anda kepada
                                            customer</small>
                                    </div>
                                </div>

                                <!-- Bank Information -->
                                <hr class="my-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-university me-2"></i>
                                    Informasi Rekening Bank
                                </h6>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="bank_name" class="form-label fw-semibold">Nama Bank</label>
                                        <select class="form-select @error('bank_name') is-invalid @enderror"
                                            id="bank_name" name="bank_name">
                                            <option value="">Pilih Bank</option>
                                            <option value="BCA"
                                                {{ old('bank_name', Auth::user()->travelerProfile->bank_name ?? '') == 'BCA' ? 'selected' : '' }}>
                                                Bank Central Asia (BCA)</option>
                                            <option value="BNI"
                                                {{ old('bank_name', Auth::user()->travelerProfile->bank_name ?? '') == 'BNI' ? 'selected' : '' }}>
                                                Bank Negara Indonesia (BNI)</option>
                                            <option value="BRI"
                                                {{ old('bank_name', Auth::user()->travelerProfile->bank_name ?? '') == 'BRI' ? 'selected' : '' }}>
                                                Bank Rakyat Indonesia (BRI)</option>
                                            <option value="Mandiri"
                                                {{ old('bank_name', Auth::user()->travelerProfile->bank_name ?? '') == 'Mandiri' ? 'selected' : '' }}>
                                                Bank Mandiri</option>
                                            <option value="CIMB"
                                                {{ old('bank_name', Auth::user()->travelerProfile->bank_name ?? '') == 'CIMB' ? 'selected' : '' }}>
                                                CIMB Niaga</option>
                                            <option value="Danamon"
                                                {{ old('bank_name', Auth::user()->travelerProfile->bank_name ?? '') == 'Danamon' ? 'selected' : '' }}>
                                                Bank Danamon</option>
                                            <option value="Permata"
                                                {{ old('bank_name', Auth::user()->travelerProfile->bank_name ?? '') == 'Permata' ? 'selected' : '' }}>
                                                Bank Permata</option>
                                            <option value="BTN"
                                                {{ old('bank_name', Auth::user()->travelerProfile->bank_name ?? '') == 'BTN' ? 'selected' : '' }}>
                                                Bank Tabungan Negara (BTN)</option>
                                        </select>
                                        @error('bank_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="bank_account_number" class="form-label fw-semibold">Nomor
                                            Rekening</label>
                                        <input type="text"
                                            class="form-control @error('bank_account_number') is-invalid @enderror"
                                            id="bank_account_number" name="bank_account_number"
                                            value="{{ old('bank_account_number', Auth::user()->travelerProfile->bank_account_number ?? '') }}"
                                            placeholder="1234567890">
                                        @error('bank_account_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="bank_account_name" class="form-label fw-semibold">Nama Pemilik
                                            Rekening</label>
                                        <input type="text"
                                            class="form-control @error('bank_account_name') is-invalid @enderror"
                                            id="bank_account_name" name="bank_account_name"
                                            value="{{ old('bank_account_name', Auth::user()->travelerProfile->bank_account_name ?? '') }}"
                                            placeholder="Nama sesuai rekening">
                                        @error('bank_account_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Stats & Security -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-bar text-primary me-2"></i>
                            Statistik Profil
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Rating hanya untuk traveler --}}
                        @if (Auth::user()->isTraveler())
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Rating</span>
                                <div class="d-flex align-items-center">
                                    <div class="text-warning me-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= (Auth::user()->rating ?? 5) ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="fw-semibold">{{ number_format(Auth::user()->rating ?? 5.0, 1) }}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Pesanan Selesai</span>
                                <span class="fw-semibold">{{ Auth::user()->completed_orders_count ?? 0 }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Total Review</span>
                                <span class="fw-semibold">{{ Auth::user()->total_reviews ?? 0 }}</span>
                            </div>
                        @else
                            {{-- Statistik untuk customer --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Total Pesanan</span>
                                <span class="fw-semibold">{{ Auth::user()->ordersAsCustomer()->count() }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Pesanan Selesai</span>
                                <span
                                    class="fw-semibold">{{ Auth::user()->ordersAsCustomer()->where('status', 'completed')->count() }}</span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Bergabung</span>
                            <span class="fw-semibold">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Security Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            Keamanan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1">Password</h6>
                                <small class="text-muted">Terakhir diubah
                                    {{ Auth::user()->updated_at->diffForHumans() }}</small>
                            </div>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                Ubah
                            </button>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Email</h6>
                                <small class="text-muted">
                                    @if (Auth::user()->email_verified_at)
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        Terverifikasi
                                    @else
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        Belum terverifikasi
                                    @endif
                                </small>
                            </div>
                            @if (!Auth::user()->email_verified_at)
                                <button class="btn btn-outline-warning btn-sm">
                                    Verifikasi
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="confirm_password"
                                name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
