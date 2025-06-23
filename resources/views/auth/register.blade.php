<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - JastipKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #10b981;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 10px;
            padding: 0.75rem;
        }

        .btn-success {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            border-radius: 10px;
            padding: 0.75rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .role-card {
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .role-card:hover {
            border-color: var(--primary-color);
            background-color: rgba(79, 70, 229, 0.05);
        }

        .role-card.active {
            border-color: var(--primary-color);
            background-color: rgba(79, 70, 229, 0.1);
        }

        .role-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .traveler-fields {
            display: none;
        }

        .traveler-fields.show {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-user-plus mb-3" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold mb-2">Bergabung dengan JastipKu</h2>
                        <p class="mb-0">Mulai perjalanan jastip Anda bersama kami</p>
                    </div>

                    <div class="p-4">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <h5 class="text-center mb-3">Pilih Peran Anda</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="role-card text-center" onclick="selectRole('penitip')">
                                            <div class="role-icon">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                            <h6 class="fw-semibold">Penitip</h6>
                                            <p class="text-muted small mb-0">Saya ingin meminta orang lain untuk
                                                membelikan barang</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="role-card text-center" onclick="selectRole('traveler')">
                                            <div class="role-icon">
                                                <i class="fas fa-plane"></i>
                                            </div>
                                            <h6 class="fw-semibold">Traveler</h6>
                                            <p class="text-muted small mb-0">Saya ingin membantu orang lain dengan
                                                berbelanja</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="role" name="role" value="{{ old('role') }}"
                                    required>
                                @error('role')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-semibold">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Masukkan nama lengkap" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Masukkan email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-semibold">No. Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="08123456789" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label fw-semibold">Alamat <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                        placeholder="Masukkan alamat lengkap" required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-semibold">Password <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" placeholder="Minimal 8 karakter" required>
                                        <button type="button" class="input-group-text"
                                            onclick="togglePassword('password')">
                                            <i class="fas fa-eye" id="togglePassword"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi
                                        Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" name="password_confirmation"
                                            placeholder="Ulangi password" required>
                                        <button type="button" class="input-group-text"
                                            onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye" id="togglePasswordConfirmation"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="traveler-fields" id="travelerFields">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Sebagai traveler, Anda perlu melengkapi informasi tambahan untuk verifikasi.
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nik" class="form-label fw-semibold">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" placeholder="Contoh: 3201012345678901" pattern="\d{16}" title="NIK harus terdiri dari 16 digit angka">
                                        <small class="text-muted">Masukkan 16 digit NIK Anda.</small>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="id_card" class="form-label fw-semibold">Foto KTP/Identitas</label>
                                        <input type="file"
                                            class="form-control @error('id_card') is-invalid @enderror" id="id_card"
                                            name="id_card" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                        @error('id_card')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                    id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya setuju dengan <a href="#" class="text-primary">Syarat & Ketentuan</a>
                                    dan <a href="#" class="text-primary">Kebijakan Privasi</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Daftar Sekarang
                                </button>

                                <div class="text-center">
                                    <p class="text-muted">
                                        Sudah punya akun?
                                        <a href="{{ route('login') }}"
                                            class="text-primary text-decoration-none fw-semibold">
                                            Masuk di sini
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="/" class="position-fixed top-0 start-0 m-4 btn btn-light btn-sm">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali ke Beranda
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function selectRole(role) {
            // Remove active class from all cards
            document.querySelectorAll('.role-card').forEach(card => {
                card.classList.remove('active');
            });

            // Add active class to selected card
            event.currentTarget.classList.add('active');

            // Set hidden input value
            document.getElementById('role').value = role;

            // Show/hide traveler fields
            const travelerFields = document.getElementById('travelerFields');
            const nikInput = document.getElementById('nik');
            if (role === 'traveler') {
                travelerFields.classList.add('show');
                nikInput.required = true;
            } else {
                travelerFields.classList.remove('show');
                nikInput.required = false;
            }
        }

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('toggle' + fieldId.charAt(0).toUpperCase() + fieldId.slice(1));

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Set initial role if old value exists
        @if (old('role'))
            selectRole('{{ old('role') }}');
            document.querySelector('.role-card:nth-child({{ old('role') === 'penitip' ? 1 : 2 }})').click();
        @endif
    </script>
</body>

</html>
