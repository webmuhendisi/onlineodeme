@extends('admin.layout')

@section('content')
<h1 class="mb-4">Yönetim Paneli</h1>
<div class="list-group">
    <a href="{{ route('admin.students.index') }}" class="list-group-item list-group-item-action">Öğrenci Yönetimi</a>
    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action disabled">Raporlar (yakında)</a>
    <a href="{{ route('admin.settings.edit') }}" class="list-group-item list-group-item-action">Sistem Ayarları</a>
</div>
@endsection
