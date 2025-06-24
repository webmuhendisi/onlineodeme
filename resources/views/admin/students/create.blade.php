@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Öğrenci Ekle</h2>
    <form method="POST" action="{{ route('admin.students.store') }}">
        @csrf
        <div class="mb-3">
            <label>Ad</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Şifre</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Öğrenci No</label>
            <input type="text" name="student_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Bölüm</label>
            <input type="text" name="department" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Sınıf</label>
            <input type="text" name="class" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Telefon</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>
</div>
@endsection
