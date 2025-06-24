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
    </div>
</nav>
<div class="py-4">
    @yield('content')
</div>
</body>
</html>
