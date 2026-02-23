<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Foodpanda App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #d70f64 0%, #ff2b85 50%, #ff6f9c 100%); min-height: 100vh; }
        .navbar { background: rgba(215, 15, 100, 0.95) !important; backdrop-filter: blur(10px); }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; }
        .card { border: none; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.1); }
        .btn-foodpanda { background: #d70f64; color: white; border: none; border-radius: 12px; padding: 12px 24px; font-weight: 600; }
        .btn-foodpanda:hover { background: #b80d55; color: white; transform: translateY(-2px); transition: all 0.3s; }
        .form-control { border-radius: 10px; padding: 12px 16px; border: 2px solid #e0e0e0; }
        .form-control:focus { border-color: #d70f64; box-shadow: 0 0 0 0.2rem rgba(215, 15, 100, 0.15); }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-utensils me-2"></i>Foodpanda</a>
            <div class="navbar-nav ms-auto">
                @auth
                    <span class="nav-link text-white"><i class="fas fa-user me-1"></i>{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm ms-2">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link text-white">Login</a>
                    <a href="{{ route('register') }}" class="nav-link text-white">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
