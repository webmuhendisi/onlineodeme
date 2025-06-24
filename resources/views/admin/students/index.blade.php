@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Öğrenciler</h2>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary mb-3">Yeni Öğrenci</a>
    <ul>
    @foreach($students as $student)
        <li>
            <a href="{{ route('admin.students.show', $student) }}">{{ $student->user->name }}</a>
        </li>
    @endforeach
    </ul>
</div>
@endsection
