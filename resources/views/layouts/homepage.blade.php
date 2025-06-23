{{-- filepath: resources/views/layouts/homepage.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - JastipKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    @vite(['resources/css/landing_page.css'])
    @stack('styles')
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: #f8f9fa;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 1rem 0;
        }
        .logo {
            font-weight: 700;
            font-size: 1.5rem;
            color: #764ba2;
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            align-items: center;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff !important;
            border-radius: 30px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: #fff !important;
        }
        .footer {
            background: #fff;
            color: #888;
            text-align: center;
            padding: 2rem 0 1rem 0;
            margin-top: 3rem;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a href="{{ url('/') }}" class="logo">JastipKu</a>
            <div class="nav-links ms-auto">
                @if(Auth::check())
                    <span style="color: var(--gray-color); margin-right: 25px;">Hello, {{ Auth::user()->name }}!</span>
                    <a href="{{ Auth::user()->role === 'penitip' ? route('customer.dashboard') : route('traveler.dashboard') }}" class="btn-register ms-2">Masuk ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                @endif
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} JastipKu. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
