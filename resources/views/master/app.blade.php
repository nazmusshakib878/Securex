<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', config('app.name', 'Securex'))</title>

    <link href="{{ asset('favicon.ico') }}" rel="icon">
    <!-- Google Fonts for Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('site/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/css/style.css') }}" rel="stylesheet">

    <!-- Modern Global Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            color: #2b3445;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }
        .navbar {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.85) !important;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        .navbar-brand h2 {
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .navbar-nav .nav-link {
            font-weight: 500;
            color: #4b5563 !important;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            margin: 0 0.2rem;
        }
        .navbar-nav .nav-link:hover {
            color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.08);
        }
        .btn-modern {
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('sweetalert::alert')

    <nav class="navbar navbar-expand-lg sticky-top p-0 px-4 px-lg-5">
        <div class="container py-2">
            <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
                <h2 class="m-0">Securex</h2>
            </a>
            <button type="button" class="navbar-toggler border-0 shadow-none" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto align-items-center">
                    <a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
                    <a href="{{ route('about') }}" class="nav-item nav-link">About</a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="d-inline ms-lg-3">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-modern px-4">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-item nav-link me-lg-2">Login</a>
                        <a href="{{ route('viewSignup') }}" class="btn btn-primary btn-modern ms-lg-2 text-white">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
