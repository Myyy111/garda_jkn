@extends('layouts.app')

@section('title', 'Data Anggota Wilayah - Pengurus Garda JKN')

@push('styles')
<style>
    .admin-layout { display: flex; min-height: 100vh; background: #f8fafc; }
    .sidebar { 
        width: 260px; background: #004aad; color: white; display: flex; flex-direction: column; 
        position: fixed; height: 100vh; z-index: 100;
    }
    .sb-brand { padding: 24px 32px; font-size: 1.1rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .sb-menu { padding: 20px 12px; flex: 1; }
    .sb-link { 
        display: flex; align-items: center; padding: 10px 16px; 
        color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 6px; 
        font-weight: 500; font-size: 0.875rem; margin-bottom: 4px; transition: 0.15s; gap: 12px;
    }
    .sb-link:hover, .sb-link.active { background: rgba(255,255,255,0.1); color: white; }
    
    .main-body { margin-left: 260px; flex: 1; }
    .top-header { height: 64px; background: white; border-bottom: 1px solid #e2e8f0; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; }
    .view-container { padding: 32px; max-width: 1400px; }

    /* Professional Table Styles */
    .table-card { border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .table-header { padding: 16px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
    .table-header h2 { font-size: 1rem; font-weight: 700; color: #1e293b; }
    
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 10px 16px; text-align: left; font-size: 0.65rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; }
    .data-table td { padding: 12px 16px; font-size: 0.875rem; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .data-table tr:hover { background: #f8fafc; }

    .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.65rem; font-weight: 600; text-transform: uppercase; }
    .badge-blue { background: #eff6ff; color: #1e40af; border: 1px solid #dbeafe; }
</style>
@endpush

@section('content')
<div class="admin-layout">
    <aside class="sidebar">
        <div class="sb-brand">Garda JKN</div>
        <nav class="sb-menu">
            <a href="/pengurus/dashboard" class="sb-link"><i data-lucide="layout-dashboard" style="width: 16px; height: 16px;"></i> Dashboard</a>
            <a href="/pengurus/members" class="sb-link active"><i data-lucide="users" style="width: 16px; height: 16px;"></i> Anggota Wilayah</a>
            <a href="/pengurus/informations" class="sb-link"><i data-lucide="megaphone" style="width: 16px; height: 16px;"></i> Informasi</a>
            <div style="margin-top: auto; padding-top: 20px;">
                <div style="height: 1px; background: rgba(255,255,255,0.1); margin-bottom: 20px;"></div>
                <a href="/settings" class="sb-link"><i data-lucide="settings" style="width: 16px; height: 16px;"></i> Pengaturan Akun</a>
                <a href="#" class="sb-link" onclick="logout()"><i data-lucide="log-out" style="width: 16px; height: 16px;"></i> Logout</a>
            </div>
        </nav>
    </aside>

    <main class="main-body">
        <header class="top-header">
            <div style="font-weight: 600; color: #1e293b; font-size: 1rem;">Administrasi Keanggotaan Wilayah</div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <span id="date-now" style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;"></span>
                <div style="width: 32px; height: 32px; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">PR</div>
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
<script>
    const token = localStorage.getItem('auth_token');
    const role = localStorage.getItem('user_role');
    if (!token || (role !== 'pengurus' && role !== 'admin')) window.location.href = '/login';

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('date-now').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        lucide.createIcons();
        fetchMembers();
    });

    async function fetchMembers(page = 1) {
        try {
            // Kita gunakan endpoint admin/members sementara
            const res = await axios.get(`admin/members?page=${page}`);
            const data = res.data.data;
            renderTable(data.data);
            renderPagination(data);
        } catch (e) {
            showToast('Gagal memuat data anggota', 'error');
        }
    }

    function renderTable(members) {
        const body = document.getElementById('memberTableBody');
        body.innerHTML = '';
        members.forEach(m => {
            body.innerHTML += `
                <tr>
                    <td>
                        <div style="font-weight: 700;">${m.name}</div>
                        <div style="font-size: 0.75rem; color: #64748b;">NIK: ${m.nik}</div>
                    </td>
                    <td style="font-weight: 500;">${m.phone}</td>
                    <td>
                        <div style="font-weight: 600;">${m.city?.name || '-'}</div>
                        <div style="font-size: 0.7rem; color: #94a3b8;">${m.province?.name || '-'}</div>
                    </td>
                    <td><span class="badge badge-blue">${m.occupation || 'UMUM'}</span></td>
                    <td style="text-align: right;"><span style="color: #10b981; font-weight: 700;">AKTIF</span></td>
                </tr>
            `;
        });
    }

    function renderPagination(meta) {
        const p = document.getElementById('pagination');
        p.innerHTML = '';
        for(let i=1; i<=meta.last_page; i++) {
            p.innerHTML += `<button onclick="fetchMembers(${i})" style="margin: 0 4px; padding: 4px 10px; border: 1px solid #e2e8f0; background: ${meta.current_page === i ? '#004aad' : 'white'}; color: ${meta.current_page === i ? 'white' : '#334155'}; border-radius: 4px; cursor: pointer;">${i}</button>`;
        }
    }

    function logout() { localStorage.clear(); window.location.href = '/login'; }
</script>
@endpush
