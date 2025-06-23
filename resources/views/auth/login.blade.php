<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JastipKu</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
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
            display: flex;
            align-items: center;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 10px;
            padding: 0.75rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="login-card">
                    <div class="row g-0">
                        <!-- Left Side - Header -->
                        <div class="col-lg-6">
                            <div class="login-header h-100 d-flex flex-column justify-content-center">
                                <div>
                                    <i class="fas fa-shopping-bag mb-4" style="font-size: 4rem;"></i>
                                    <h2 class="fw-bold mb-3">Selamat Datang di JastipKu</h2>
                                    <p class="mb-4">Platform jastip terpercaya untuk kebutuhan belanja Anda</p>
                                    <div class="d-flex justify-content-center gap-4">
                                        <div class="text-center">
                                            <i class="fas fa-shield-alt mb-2" style="font-size: 2rem;"></i>
                                            <div>Aman</div>
                                        </div>
                                        <div class="text-center">
                                            <i class="fas fa-bolt mb-2" style="font-size: 2rem;"></i>
                                            <div>Cepat</div>
                                        </div>
                                        <div class="text-center">
                                            <i class="fas fa-heart mb-2" style="font-size: 2rem;"></i>
                                            <div>Terpercaya</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Form -->
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold text-dark">Masuk ke Akun Anda</h3>
                                    <p class="text-muted">Silakan masuk untuk melanjutkan</p>
                                </div>

                                <!-- Session Status -->
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <!-- Email Address -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-envelope text-muted"></i>
                                            </span>
                                            <input type="email"
                                                class="form-control border-start-0 @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email') }}"
                                                placeholder="Masukkan email Anda" required autofocus>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                            <input type="password"
                                                class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                                id="password" name="password" placeholder="Masukkan password Anda"
                                                required>
                                            <button type="button" class="input-group-text bg-light border-start-0"
                                                onclick="togglePassword()">
                                                <i class="fas fa-eye text-muted" id="toggleIcon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="remember_me"
                                            name="remember">
                                        <label class="form-check-label" for="remember_me">
                                            Ingat saya
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary w-100 fw-semibold mb-3">
                                        <i class="fas fa-sign-in-alt me-2"></i>
                                        Masuk
                                    </button>

                                    <!-- Forgot Password -->
                                    <div class="text-center mb-4">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-decoration-none">
                                                Lupa password?
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Register Link -->
                                    <div class="text-center mt-4">
                                        <p class="text-muted">
                                            Belum punya akun?
                                            <a href="{{ route('register') }}"
                                                class="text-primary text-decoration-none fw-semibold">
                                                Daftar sekarang
                                            </a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Home -->
    <a href="/" class="position-fixed top-0 start-0 m-4 btn btn-light btn-sm">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali ke Beranda
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (password.type === 'password') {
                password.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
