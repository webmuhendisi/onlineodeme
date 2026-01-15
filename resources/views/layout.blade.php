<!DOCTYPE html>
<html>
<head>
    <title>Online Odeme</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Anasayfa</a>
        <a class="nav-link" href="{{ url('/admin') }}">Admin</a>
        @auth
            <span class="ms-2">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-link">Cikis</button>
            </form>
        @else
            <a class="nav-link" href="{{ route('login') }}">Giris</a>
        @endauth
    </div>
</nav>
<div class="py-4">
    @yield('content')
</div>
</body>
</html>
