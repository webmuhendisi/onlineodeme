@extends('admin.layout')

@section('content')
<h1 class="mb-4">Sistem Ayarları</h1>
@if(session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif
<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    <div class="card mb-4">
        <div class="card-header">Active Directory</div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Host</label>
                <input type="text" name="AD_HOST" class="form-control" value="{{ $settings['AD_HOST'] ?? '' }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Base DN</label>
                <input type="text" name="AD_BASE_DN" class="form-control" value="{{ $settings['AD_BASE_DN'] ?? '' }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Kullanıcı</label>
                <input type="text" name="AD_USERNAME" class="form-control" value="{{ $settings['AD_USERNAME'] ?? '' }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Şifre</label>
                <input type="password" name="AD_PASSWORD" class="form-control" value="{{ $settings['AD_PASSWORD'] ?? '' }}">
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Logo Muhasebe</div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">API URL</label>
                <input type="text" name="LOGO_API_URL" class="form-control" value="{{ $settings['LOGO_API_URL'] ?? '' }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Client ID</label>
                <input type="text" name="LOGO_CLIENT_ID" class="form-control" value="{{ $settings['LOGO_CLIENT_ID'] ?? '' }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Client Secret</label>
                <input type="text" name="LOGO_CLIENT_SECRET" class="form-control" value="{{ $settings['LOGO_CLIENT_SECRET'] ?? '' }}">
            </div>
        </div>
    </div>
    <button class="btn btn-primary">Kaydet</button>
</form>
<form method="POST" action="{{ route('admin.settings.sync') }}" class="mt-3">
    @csrf
    <button class="btn btn-secondary">Logo Senkronizasyonu Yap</button>
</form>
@endsection
