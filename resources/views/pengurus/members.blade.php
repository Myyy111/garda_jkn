@extends('layouts.app')

@section('title', 'Data Anggota Wilayah - Pengurus Garda JKN')



@section('content')

<div class="admin-layout">
    <aside class="sidebar">
        <div class="sb-brand">
            <div class="sb-brand-name">Garda JKN</div>
        </div>
        <div class="sb-user-card">
            <div class="sb-avatar" id="sb-avatar-wrap"><span id="sb-initials">A</span></div>
            <div class="sb-user-name" id="sb-user-name">Administrator</div>
        </div>
        <nav class="sb-menu">
            <div class="sb-section-label">Menu</div>
            <a href="/pengurus/dashboard" class="sb-link"><i data-lucide="layout-dashboard" style="width:16px;height:16px;"></i> Dashboard</a>
            <a href="/pengurus/members" class="sb-link active"><i data-lucide="users" style="width:16px;height:16px;"></i> Anggota Wilayah</a>
            <a href="/pengurus/informations" class="sb-link"><i data-lucide="megaphone" style="width:16px;height:16px;"></i> Informasi</a>
        </nav>
        <div class="sb-footer">
            <div class="sb-section-label" style="margin-top:0;margin-bottom:8px;">Pengaturan</div>
            <a href="/pengurus/settings" class="sb-link {{ request()->is('pengurus/settings') ? 'active' : '' }}"><i data-lucide="settings" style="width:16px;height:16px;"></i> Pengaturan Akun</a>
            <button class="sb-link" onclick="logout()" style="color:#fca5a5;margin-top:4px;border:none;background:none;width:100%;text-align:left;"><i data-lucide="log-out" style="width:16px;height:16px;color:#fca5a5;"></i> Keluar Sesi</button>
        </div>
    </aside>

    <main class="main-body">
        <header class="top-header">
            <div style="font-weight: 600; color: #1e293b; font-size: 1rem;">Administrasi Keanggotaan Wilayah</div>
            <div id="user-info-header" style="display: flex; align-items: center; gap: 12px;">
                <span id="date-now" style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;"></span>
                <div id="user-initials" style="width: 32px; height: 32px; background: #eff6ff; color: #004aad; border: 1px solid #dbeafe; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">...</div>
            </div>
        </header>

        <div class="view-container">
            <div class="table-card">
                <div class="table-header">
                    <div>
                        <h2>Daftar Anggota Terkelola</h2>
                        <p style="font-size: 0.8125rem; color: #64748b; margin-top: 2px;">Data anggota di wilayah koordinasi Anda.</p>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Informasi Anggota</th>
                            <th>Kontak Aktif</th>
                            <th>Domisili Wilayah</th>
                            <th>Klasifikasi</th>
                            <th style="text-align: right;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="memberTableBody">
                        <!-- Data loaded via JS -->
                    </tbody>
                </table>
                <div id="pagination" style="padding: 16px 32px; display: flex; justify-content: center; background: white; border-top: 1px solid #f1f5f9;"></div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
@vite(['resources/css/pages/pengurus_members.css', 'resources/js/pages/pengurus_members.js'])


@endpush

@push("scripts")
<script>
    window.sessionSuccess = "{{ session("success") }}";
    window.sessionError = "{{ session("error") }}";
</script>
@endpush
