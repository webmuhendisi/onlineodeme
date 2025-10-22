@extends('layout')

@section('content')
<div class="container">
    <h2>Öğrenci Düzenle</h2>
    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Ad</label>
            <input type="text" name="name" value="{{ $student->user->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $student->user->email }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Öğrenci No</label>
            <input type="text" name="student_number" value="{{ $student->student_number }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Bölüm</label>
            <input type="text" name="department" value="{{ $student->department }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Sınıf</label>
            <input type="text" name="class" value="{{ $student->class }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Telefon</label>
            <input type="text" name="phone" value="{{ $student->phone }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
</div>
@endsection
