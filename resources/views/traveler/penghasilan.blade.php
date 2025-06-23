@extends('layouts.app')

@section('title', 'Penghasilan')

@push('styles')
    <style>
        .earnings-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .earnings-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .earnings-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .withdrawal-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            color: white;
        }

        .bank-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .bank-card:hover {
            border-color: #6c63ff;
            transform: translateY(-2px);
        }

        .transaction-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
        }

        .customer-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .rating-stars {
            color: #ffc107;
            font-size: 0.85rem;
        }

        .earnings-amount {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .withdrawal-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .withdrawal-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            border: none;
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 5rem;
            color: #dee2e6;
            margin-bottom: 2rem;
        }

        .progress-ring {
            width: 120px;
            height: 120px;
            position: relative;
            margin: 0 auto 1rem;
        }

        .progress-ring circle {
            fill: none;
            stroke-width: 8;
            stroke-linecap: round;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .progress-ring .background {
            stroke: #e9ecef;
        }

        .progress-ring .progress {
            stroke: #28a745;
            stroke-dasharray: 283;
            stroke-dashoffset: 141.5;
            transition: stroke-dashoffset 0.5s ease-in-out;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('traveler.dashboard') }}" class="text-decoration-none">
                                <i class="fas fa-home me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Penghasilan</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="fw-bold text-dark mb-1 display-6">💰 Penghasilan Saya</h1>
                        <p class="text-muted fs-5">Pantau pendapatan dan kelola keuangan perjalanan Anda</p>
                    </div>
                    <div class="text-end">
                        <div class="bg-light rounded-pill px-3 py-2">
                            <small class="text-muted">Update terakhir:</small>
                            <span class="fw-semibold">{{ now()->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN BARU: Alert untuk notifikasi --}}
        <div class="row">
            <div class="col">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                 @error('amount')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror
            </div>
        </div>
        {{-- AKHIR BAGIAN BARU --}}

        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card earnings-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="earnings-icon mx-auto"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="stat-number text-primary">
                            Rp {{ number_format($stats['total'], 0, ',', '.') }}
                        </div>
                        <div class="stat-label text-muted">Total Penghasilan</div>
                        <div class="mt-3">
                            <small class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-chart-line me-1"></i>
                                All Time
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card earnings-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="earnings-icon mx-auto"
                            style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <div class="stat-number text-success">
                            Rp {{ number_format($stats['balance'], 0, ',', '.') }}
                        </div>
                        <div class="stat-label text-muted">Saldo Tersedia</div>
                        <div class="mt-3">
                            <small class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-circle me-1"></i>
                                Siap Tarik
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card earnings-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="earnings-icon mx-auto"
                            style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div class="stat-number text-info">{{ $stats['completed_count'] }}</div>
                        <div class="stat-label text-muted">Pesanan Selesai</div>
                        <div class="mt-3">
                            <small class="badge bg-info bg-opacity-10 text-info">
                                <i class="fas fa-trophy me-1"></i>
                                Achievement
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card earnings-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="earnings-icon mx-auto"
                            style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="stat-number text-warning">
                            Rp {{ number_format($stats['average'], 0, ',', '.') }}
                        </div>
                        <div class="stat-label text-muted">Rata-rata per Order</div>
                        <div class="mt-3">
                            <small class="badge bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-calculator me-1"></i>
                                Average
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-8 mb-4">
                <div class="card earnings-card">
                    <div class="card-body withdrawal-section p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-money-bill-wave fs-1 me-3"></i>
                                    <div>
                                        <h4 class="mb-1">Tarik Saldo Penghasilan</h4>
                                        <p class="mb-0 opacity-75">Nikmati hasil kerja keras Anda</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <h2 class="fw-bold mb-1">Rp {{ number_format($stats['balance'], 0, ',', '.') }}</h2>
                                        <small class="opacity-75">Saldo yang dapat ditarik</small>
                                    </div>
                                    <div class="col-6">
                                        <div class="progress-ring">
                                            <svg width="120" height="120">
                                                <circle class="background" cx="60" cy="60" r="45"></circle>
                                                <circle class="progress" cx="60" cy="60" r="45"></circle>
                                            </svg>
                                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                                <div class="fw-bold">{{ $stats['completed_count'] }}</div>
                                                <small>Orders</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-light bg-white bg-opacity-20 border-0 mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>Transfer akan diproses dalam 1-3 hari kerja ke rekening terdaftar</small>
                                </div>
                            </div>

                            <div class="col-md-4 text-center">
                                @if ($stats['balance'] >= 50000)
                                    <button class="btn withdrawal-btn btn-lg text-white" data-bs-toggle="modal"
                                        data-bs-target="#withdrawModal">
                                        <i class="fas fa-download me-2"></i>
                                        Tarik Sekarang
                                    </button>
                                @else
                                    <button class="btn btn-light btn-lg" disabled>
                                        <i class="fas fa-times me-2"></i>
                                        Saldo Kurang
                                    </button>
                                @endif

                                <div class="mt-3">
                                    <small class="text-white-50">
                                        Minimum penarikan: Rp 50.000
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card earnings-card h-100">
                    <div class="card-header border-0 bg-white">
                        <h5 class="card-title mb-0 d-flex align-items-center">
                            <i class="fas fa-university text-primary me-2"></i>
                            Rekening Bank
                        </h5>
                    </div>
                    <div class="card-body">
                        @if (Auth::user()->travelerProfile && Auth::user()->travelerProfile->bank_name)
                            <div class="bank-card p-3">
                                <div class="d-flex align-items-start">
                                    <div class="bg-primary bg-opacity-15 rounded-circle p-3 me-3">
                                        <i class="fas fa-university text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1">{{ Auth::user()->travelerProfile->bank_name }}</h6>
                                        <p class="text-muted mb-1 font-monospace">
                                            •••• •••• ••••
                                            {{ substr(Auth::user()->travelerProfile->bank_account_number, -4) }}
                                        </p>
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            {{ Auth::user()->travelerProfile->bank_account_name }}
                                        </small>
                                    </div>
                                    <span class="badge bg-success">Verified</span>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i>
                                    Edit Rekening
                                </a>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-exclamation-triangle text-warning fs-1 mb-3"></i>
                                <h6 class="text-muted mb-3">Rekening Belum Terdaftar</h6>
                                <p class="text-muted small mb-3">Daftarkan rekening bank untuk dapat menarik saldo</p>
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Daftar Rekening
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($recentTransactions->count() > 0)
            <div class="row">
                <div class="col">
                    <div class="card earnings-card">
                        <div class="card-header bg-white border-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0 d-flex align-items-center">
                                    <i class="fas fa-history text-primary me-2"></i>
                                    Transaksi Terbaru
                                </h5>
                               {{-- <a href="{{ route('traveler.earnings.history') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-external-link-alt me-1"></i>
            Lihat Semua
        </a> --}}
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 transaction-table">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Tanggal & Waktu</th>
                                            <th>Pesanan</th>
                                            <th>Customer</th>
                                            <th>Penghasilan</th>
                                            <th class="pe-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentTransactions as $transaction)
                                            <tr>
                                                <td class="ps-4">
                                                    <div>
                                                        <div class="fw-semibold text-dark">
                                                            {{ $transaction->completed_at ? $transaction->completed_at->format('d M Y') : '-' }}
                                                        </div>
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock me-1"></i>
                                                            {{ $transaction->completed_at ? $transaction->completed_at->format('H:i') : '-' }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div class="fw-semibold text-dark">
                                                            {{ Str::limit($transaction->nama_barang, 25) }}</div>
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt me-1"></i>
                                                            {{ ucfirst($transaction->destination) }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $transaction->customer->profile_photo_path ? asset('storage/' . $transaction->customer->profile_photo_path) : 'https://via.placeholder.com/45x45/6c63ff/white?text=' . substr($transaction->customer->name, 0, 1) }}"
                                                            alt="{{ $transaction->customer->name }}"
                                                            class="customer-avatar me-3">
                                                        <div>
                                                            <div class="fw-semibold text-dark">
                                                                {{ $transaction->customer->name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="earnings-amount text-success">
                                                        <i class="fas fa-plus-circle me-1"></i>
                                                        Rp {{ number_format($transaction->ongkos_jasa ?? 0, 0, ',', '.') }}
                                                    </span>
                                                </td>
                                                <td class="pe-4">
                                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Selesai
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col">
                    <div class="card earnings-card">
                        <div class="card-body">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h3 class="text-muted mb-3">Belum Ada Transaksi</h3>
                                <p class="text-muted fs-5 mb-4">
                                    Mulai petualangan Anda! Selesaikan pesanan pertama untuk mendapatkan penghasilan.
                                </p>
                                <a href="{{ route('traveler.dashboard') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-rocket me-2"></i>
                                    Mulai Cari Pesanan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="withdrawModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('traveler.earnings.withdraw') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            Konfirmasi Penarikan Saldo
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        @if (Auth::user()->travelerProfile && Auth::user()->travelerProfile->bank_name)
                            <div class="mb-4">
                                <label for="amount" class="form-label fw-semibold">Jumlah Penarikan (Rp)</label>
                                <input type="number" class="form-control form-control-lg @error('amount') is-invalid @enderror" id="amount" name="amount"
                                    placeholder="Contoh: 100000"
                                    required
                                    min="50000"
                                    max="{{ $stats['balance'] }}">
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Saldo tersedia: Rp {{ number_format($stats['balance'], 0, ',', '.') }}. Minimal penarikan Rp 50.000.</div>
                            </div>

                            <div class="border rounded-3 p-4 mb-4 bg-light">
                                <h6 class="mb-3 d-flex align-items-center">
                                    <i class="fas fa-university text-primary me-2"></i>
                                    Dana akan ditransfer ke rekening:
                                </h6>
                                <div class="bank-card p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-15 rounded-circle p-3 me-3">
                                            <i class="fas fa-university text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ Auth::user()->travelerProfile->bank_name }}</div>
                                            <div class="text-muted font-monospace">{{ Auth::user()->travelerProfile->bank_account_number }}</div>
                                            <small class="text-success">{{ Auth::user()->travelerProfile->bank_account_name }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning border-0">
                                <h6 class="alert-heading">Rekening Belum Terdaftar</h6>
                                <p class="mb-0">Daftarkan rekening bank Anda pada halaman profil terlebih dahulu.</p>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </button>
                        @if (Auth::user()->travelerProfile && Auth::user()->travelerProfile->bank_name)
                            <button type="submit" class="btn withdrawal-btn text-white">
                                <i class="fas fa-download me-2"></i>
                                Konfirmasi Penarikan
                            </button>
                        @else
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Rekening
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress ring
            const progressRing = document.querySelector('.progress-ring .progress');
            if (progressRing) {
                const completedCount = {{ $stats['completed_count'] }};
                const maxCount = Math.max(completedCount, 10); // Minimum 10 for visual effect
                const progress = (completedCount / maxCount) * 283;
                progressRing.style.strokeDashoffset = 283 - progress;
            }

            // Animate stat numbers on scroll
            const animateNumbers = () => {
                const statNumbers = document.querySelectorAll('.stat-number');

                statNumbers.forEach(stat => {
                    const finalValue = parseInt(stat.textContent.replace(/[^\d]/g, ''));
                    let currentValue = 0;
                    const increment = finalValue / 50;

                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            currentValue = finalValue;
                            clearInterval(timer);
                        }

                        const formattedValue = new Intl.NumberFormat('id-ID').format(Math.floor(
                            currentValue));
                        if (stat.textContent.includes('Rp')) {
                            stat.textContent = 'Rp ' + formattedValue;
                        } else {
                            stat.textContent = formattedValue;
                        }
                    }, 50);
                });
            };

            // Trigger animation when stats cards come into view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateNumbers();
                        observer.unobserve(entry.target);
                    }
                });
            });

            const statsContainer = document.querySelector('.row.mb-5');
            if (statsContainer) {
                observer.observe(statsContainer);
            }

            // Enhanced table row hover effects
            const tableRows = document.querySelectorAll('.transaction-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9ff';
                    this.style.transform = 'scale(1.01)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                    this.style.transform = '';
                });
            });
        });
    </script>
@endpush
