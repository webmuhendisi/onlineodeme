<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Online Odeme</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/admin') }}">Admin Panel</a>
        <a class="nav-link text-white" href="{{ url('/') }}">Siteye Dön</a>
    </div>
</nav>
<div class="container py-4">
    @yield('content')
</div>
</body>
</html>
