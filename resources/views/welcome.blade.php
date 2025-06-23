<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JastipKu - Platform Jastip Terpercaya</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #10b981;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-content {
            color: white;
        }

        .search-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 2rem;
        }

        .order-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
        }

        .btn-success {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand text-primary" href="/">
                <i class="fas fa-shopping-bag me-2"></i>
                JastipKu
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#orders">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">Cara Kerja</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    @if (Auth::check())
                        @if (Auth::user()->role === 'penitip')
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                        @elseif(Auth::user()->role === 'traveler')
                            <a href="{{ route('traveler.dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="display-4 fw-bold mb-4">
                            Jastip Mudah, Aman, dan Terpercaya
                        </h1>
                        <p class="lead mb-4">
                            Hubungkan kebutuhan belanja Anda dengan traveler terpercaya.
                            Dapatkan barang impian dari mana saja dengan mudah!
                        </p>
                        <div class="d-flex gap-3 mb-4">
                            @guest
                                <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Mulai Sekarang
                                </a>
                                <a href="#orders" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-search me-2"></i>
                                    Lihat Pesanan
                                </a>
                            @endguest
                        </div>
                        <div class="d-flex gap-4 text-center">
                            <div>
                                <h3 class="fw-bold">1000+</h3>
                                <small>Pesanan Selesai</small>
                            </div>
                            <div>
                                <h3 class="fw-bold">500+</h3>
                                <small>Traveler Aktif</small>
                            </div>
                            <div>
                                <h3 class="fw-bold">50+</h3>
                                <small>Kota Tujuan</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="search-section">
                        <h3 class="text-dark mb-4">Cari Pesanan Jastip</h3>
                        <form id="searchForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Pulau</label>
                                    <select class="form-select" id="pulau" name="pulau">
                                        <option value="">Semua Pulau</option>
                                        <option value="jawa">Jawa</option>
                                        <option value="sumatera">Sumatera</option>
                                        <option value="kalimantan">Kalimantan</option>
                                        <option value="sulawesi">Sulawesi</option>
                                        <option value="bali_ntt">Bali & NTT</option>
                                        <option value="papua_maluku">Papua & Maluku</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kota Tujuan</label>
                                    <select class="form-select" id="destination" name="destination">
                                        <option value="">Pilih Kota</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori">
                                        <option value="">Semua Kategori</option>
                                        @if (isset($kategoriList))
                                            @foreach ($kategoriList as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-primary w-100" onclick="filterOrders()">
                                        <i class="fas fa-search me-2"></i>
                                        Cari Pesanan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="orders" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-3">Pesanan Tersedia</h2>
                    <p class="text-muted">Temukan pesanan jastip yang sesuai dengan rencana perjalanan Anda</p>
                </div>
            </div>

            <div class="row" id="ordersContainer">
                @if (isset($orders) && $orders->count() > 0)
                    @foreach ($orders as $order)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card order-card h-100 shadow-sm">
                                <div class="card-header bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-warning text-dark">Tersedia</span>
                                        <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-3">{{ $order->nama_barang }}</h5>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                                {{ ucfirst($order->destination) }}
                                            </small>
                                            <span
                                                class="badge bg-info-subtle text-info">{{ ucfirst($order->kategori) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar text-primary me-1"></i>
                                                {{ $order->deadline->format('d M Y') }}
                                            </small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Budget</small>
                                            <strong class="text-success">Rp
                                                {{ number_format($order->budget, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $order->customer->profile_photo_path ? asset('storage/' . $order->customer->profile_photo_path) : 'https://via.placeholder.com/30x30' }}"
                                            alt="{{ $order->customer->name }}" class="rounded-circle me-2"
                                            width="30" height="30">
                                        <div>
                                            <small class="fw-semibold">{{ $order->customer->name }}</small>
                                        </div>
                                    </div>

                                    <p class="card-text text-muted small">{{ Str::limit($order->deskripsi, 80) }}</p>

                                    <div class="d-flex gap-2 mt-auto pt-3">
                                        <a href="{{ route('orders.show_public', $order) }}" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        @auth
                                            @if (Auth::user()->role === 'traveler' && Auth::user()->isTravelerVerified())
                                                <form action="{{ route('traveler.orders.accept', $order) }}" method="POST" class="w-100">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="fas fa-hand-paper"></i> Ambil
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                                <i class="fas fa-sign-in-alt"></i> Ambil
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-search text-muted mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mb-3">Tidak Ada Pesanan</h4>
                            <p class="text-muted">Belum ada pesanan yang tersedia saat ini</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-center mt-4">
                <button id="loadMoreBtn" class="btn btn-outline-primary btn-lg" onclick="loadMoreOrders()">
                    <i class="fas fa-plus me-2"></i>
                    Muat Lebih Banyak
                </button>
            </div>
        </div>
    </section>

    <section id="features" class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-3">Mengapa Memilih JastipKu?</h2>
                    <p class="text-muted">Platform jastip terpercaya dengan berbagai keunggulan untuk memudahkan Anda
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Aman & Terpercaya</h4>
                        <p class="text-muted">Semua traveler telah terverifikasi dan pesanan dijamin aman</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Proses Cepat</h4>
                        <p class="text-muted">Pesanan Anda akan segera diproses oleh traveler berpengalaman</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h4>Jangkauan Luas</h4>
                        <p class="text-muted">Tersedia di berbagai kota di seluruh Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-3">Cara Kerja JastipKu</h2>
                    <p class="text-muted">Mudah dan sederhana, hanya dalam 4 langkah</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <div class="feature-icon bg-primary">
                            <span class="fw-bold fs-3">1</span>
                        </div>
                        <h5>Buat Pesanan</h5>
                        <p class="text-muted">Daftarkan barang yang ingin dibeli dengan detail lengkap</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <div class="feature-icon bg-info">
                            <span class="fw-bold fs-3">2</span>
                        </div>
                        <h5>Traveler Mengambil</h5>
                        <p class="text-muted">Traveler yang sesuai akan mengambil pesanan Anda</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <div class="feature-icon bg-warning">
                            <span class="fw-bold fs-3">3</span>
                        </div>
                        <h5>Proses Pembelian</h5>
                        <p class="text-muted">Traveler akan membelikan barang sesuai pesanan Anda</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <div class="feature-icon bg-success">
                            <span class="fw-bold fs-3">4</span>
                        </div>
                        <h5>Terima Barang</h5>
                        <p class="text-muted">Barang akan dikirim ke alamat yang Anda berikan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="navbar-brand fs-4">
                        <i class="fas fa-shopping-bag me-2"></i>JastipKu
                    </h5>
                    <p class="mb-3">Platform jasa titip online terpercaya yang menghubungkan penitip dengan traveler
                        untuk pengalaman belanja yang aman dan mudah.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5>Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#features">Fitur</a></li>
                        <li class="mb-2"><a href="#how-it-works">Cara Kerja</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}">Daftar</a></li>
                        <li class="mb-2"><a href="{{ route('login') }}">Masuk</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5>Bantuan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">FAQ</a></li>
                        <li class="mb-2"><a href="#">Pusat Bantuan</a></li>
                        <li class="mb-2"><a href="#">Hubungi Kami</a></li>
                        <li class="mb-2"><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h5>Kontak</h5>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>support@jastipku.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+62 812-3456-7890</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jakarta, Indonesia</span>
                    </div>
                </div>
            </div>

            <hr class="my-4 border-secondary">
            <div class="text-center">
                <p class="mb-0">&copy; 2024 JastipKu. Semua hak cipta dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Variabel global untuk status login & URL
        const IS_AUTHENTICATED = @json(Auth::check());
        const IS_TRAVELER_VERIFIED = @json(Auth::check() ? (Auth::user()->isTraveler() && Auth::user()->isTravelerVerified()) : false);
        const LOGIN_URL = "{{ route('login') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";

        let currentPage = 1;
        let isLoading = false;

        const kotaByPulau = @json($kotaByPulau ?? []);

        document.getElementById('pulau').addEventListener('change', function() {
            const pulau = this.value;
            const destinationSelect = document.getElementById('destination');
            destinationSelect.innerHTML = '<option value="">Pilih Kota</option>';
            if (pulau && kotaByPulau[pulau]) {
                kotaByPulau[pulau].forEach(kota => {
                    const option = document.createElement('option');
                    option.value = kota;
                    option.textContent = kota.charAt(0).toUpperCase() + kota.slice(1);
                    destinationSelect.appendChild(option);
                });
            }
        });

        function filterOrders() {
            const formData = new FormData(document.getElementById('searchForm'));
            const params = new URLSearchParams(formData);
            window.location.href = window.location.pathname + '?' + params.toString() + '#orders';
        }

        function loadMoreOrders() {
            if (isLoading) return;

            isLoading = true;
            currentPage++;

            const loadMoreBtn = document.getElementById('loadMoreBtn');
            loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat...';
            loadMoreBtn.disabled = true;

            const params = new URLSearchParams(new FormData(document.getElementById('searchForm')));
            params.append('page', currentPage);

            fetch('{{ route('orders.load-more') }}?' + params.toString())
                .then(response => response.json())
                .then(data => {
                    if (data.orders && data.orders.length > 0) {
                        data.orders.forEach(order => {
                            const orderCard = createOrderCard(order);
                            document.getElementById('ordersContainer').appendChild(orderCard);
                        });

                        if (!data.hasMore) {
                            loadMoreBtn.style.display = 'none';
                        }
                    } else {
                        loadMoreBtn.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadMoreBtn.innerHTML = 'Gagal Memuat';
                })
                .finally(() => {
                    isLoading = false;
                    if(loadMoreBtn.style.display !== 'none') {
                        loadMoreBtn.innerHTML = '<i class="fas fa-plus me-2"></i>Muat Lebih Banyak';
                        loadMoreBtn.disabled = false;
                    }
                });
        }

        function createOrderCard(order) {
            const div = document.createElement('div');
            div.className = 'col-lg-4 col-md-6 mb-4';

            let actionButton = '';
            if (IS_AUTHENTICATED) {
                if (IS_TRAVELER_VERIFIED) {
                    actionButton = `
                        <form action="${order.accept_url}" method="POST" class="w-100">
                            <input type="hidden" name="_token" value="${CSRF_TOKEN}">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-hand-paper"></i> Ambil
                            </button>
                        </form>
                    `;
                }
            } else {
                actionButton = `
                    <a href="${LOGIN_URL}" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt"></i> Ambil
                    </a>
                `;
            }

            div.innerHTML = `
                <div class="card order-card h-100 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-warning text-dark">Tersedia</span>
                            <small class="text-muted">${order.created_at_human}</small>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-3">${order.nama_barang}</h5>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                    ${order.destination}
                                </small>
                                <span class="badge bg-info-subtle text-info">${order.kategori}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Budget</small>
                                <strong class="text-success">${order.budget_formatted}</strong>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <img src="${order.customer_avatar}" alt="${order.customer_name}" class="rounded-circle me-2" width="30" height="30">
                            <div>
                                <small class="fw-semibold">${order.customer_name}</small>
                            </div>
                        </div>

                        <p class="card-text text-muted small">${order.deskripsi_short}</p>

                        <div class="d-flex gap-2 mt-auto pt-3">
                            <a href="${order.detail_url}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            ${actionButton}
                        </div>
                    </div>
                </div>
            `;
            return div;
        }
    </script>
</body>

</html>
