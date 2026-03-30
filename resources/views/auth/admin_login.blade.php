@extends('layouts.app')

@section('title', 'Admin Portal - Garda JKN')

@section('content')


<div class="split-layout">
    <!-- Left Section -->
    <div class="brand-side">
        <div class="brand-title">Admin Console</div>
        <p class="brand-subtitle">Panel kendali sistem Garda JKN. Gunakan kredensial administratif Anda untuk mengelola infrastruktur keanggotaan nasional.</p>
        
        <div style="margin-top: 60px; display: flex; gap: 40px;">
            <div>
                <div style="font-size: 1.5rem; font-weight: 700;">Secure</div>
                <div style="font-size: 0.875rem; opacity: 0.7;">Infrastruktur</div>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700;">Audit</div>
                <div style="font-size: 0.875rem; opacity: 0.7;">Terpusat</div>
            </div>
        </div>
    </div>

    <!-- Right Section -->
    <div class="form-side">
        <div class="form-container">
            <div class="welcome-text">
                <h2>Admin Login</h2>
                <p>Otorisasi sistem diperlukan untuk akses admin.</p>
            </div>

            <form id="adminLoginForm">
                <div class="input-group">
                    <label class="label">Username Admin</label>
                    <input type="text" id="username" class="form-input" placeholder="Masukkan username" required autofocus>
                </div>
                
                <div class="input-group">
                    <label class="label">Kata Sandi</label>
                    <div class="input-group-password">
                        <input type="password" id="password" class="form-input" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; background: #001f4d; border-color: #001f4d;">
                    Login Administrator
                </button>

                <div style="margin-top: 24px; text-align: center;">
                    <a href="{{ route('login') }}" style="font-size: 0.875rem; color: #64748b; text-decoration: none;">Kembali ke Portal Publik</a>
                </div>
            </form>

            <div style="margin-top: 40px; text-align: center; font-size: 0.75rem; color: #94a3b8;">
                &copy; 2026 BPJS Kesehatan Garda JKN. Admin Portal v2.0
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/css/pages/auth_admin_login.css', 'resources/js/pages/auth_admin_login.js'])


@endpush

@push("scripts")
<script>
    window.sessionSuccess = "{{ session("success") }}";
    window.sessionError = "{{ session("error") }}";
</script>
@endpush
