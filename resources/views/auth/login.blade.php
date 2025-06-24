@extends('layout')

@section('content')
<div class="container">
    <h2>Ogrenci Girisi</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">E-posta</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Sifre</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        @error('email')
            <div class="text-danger">{{ \$message }}</div>
        @enderror
        <button type="submit" class="btn btn-primary">Giris</button>
    </form>
</div>
@endsection
