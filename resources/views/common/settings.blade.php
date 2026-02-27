@extends('layouts.app')

@section('title', 'Pengaturan Akun - Garda JKN')

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
    .view-container { padding: 32px; max-width: 800px; }

    .settings-card { background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .settings-header { padding: 24px 32px; border-bottom: 1px solid #f1f5f9; }
    .settings-body { padding: 32px; }

    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: #1e293b; margin-bottom: 8px; }
    .form-input { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem; transition: 0.15s; }
    .form-input:focus { outline: none; border-color: #004aad; box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.1); }

    .btn-save { background: #004aad; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.15s; }
    .btn-save:hover { background: #003a8a; }
    .btn-save:disabled { opacity: 0.6; cursor: not-allowed; }
</style>
@endpush

@section('content')
<div class="admin-layout">
    <aside class="sidebar" id="dynamic-sidebar">
        <div class="sb-brand">Garda JKN</div>
        <nav class="sb-menu" id="sidebar-nav">
            <!-- Sidebar links will be injected by JS based on role -->
        </nav>
    </aside>

    <main class="main-body">
        <header class="top-header">
            <div style="font-weight: 600; color: #1e293b; font-size: 1rem;">Pengaturan Akun</div>
            <div id="user-info-header" style="display: flex; align-items: center; gap: 12px;">
                <span id="date-now" style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;"></span>
                <div id="user-initials" style="width: 32px; height: 32px; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">...</div>
            </div>
        </header>

        <div class="view-container">
            <div class="settings-card">
                <div class="settings-header">
                    <h2 style="font-size: 1.125rem; font-weight: 700; color: #1e293b; margin: 0;">Keamanan & Password</h2>
                    <p style="font-size: 0.8125rem; color: #64748b; margin-top: 4px;">Perbarui kata sandi Anda untuk menjaga keamanan akun.</p>
                </div>
                <div class="settings-body">
                    <form id="passwordForm">
                        <div class="form-group">
                            <label class="form-label">Kata Sandi Saat Ini</label>
                            <input type="password" id="current_password" class="form-input" placeholder="Masukkan password sekarang" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kata Sandi Baru</label>
                            <input type="password" id="new_password" class="form-input" placeholder="Minimal 8 karakter" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="new_password_confirmation" class="form-input" placeholder="Ulangi password baru" required>
                        </div>
                        <div style="display: flex; justify-content: flex-end; margin-top: 32px;">
                            <button type="submit" class="btn-save" id="btnSubmit">Update Kata Sandi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Success Animation Modal -->
<div id="successModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.8); z-index:9999; align-items:center; justify-content:center; backdrop-filter: blur(8px);">
    <div style="background: white; width:400px; padding:40px; border-radius: 20px; text-align:center; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); transform: scale(0.9); transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);" id="successCard">
        <div style="width: 80px; height: 80px; background: #ecfdf5; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; animation: checkPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;">
            <i data-lucide="check" style="width: 48px; height: 48px; stroke-width: 3;"></i>
        </div>
        <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin-bottom: 8px;">Berhasil Diperbarui!</h3>
        <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 24px;">Kata sandi Anda telah berhasil diubah secara aman.</p>
        <button onclick="closeSuccessModal()" style="width: 100%; padding: 12px; background: #1e293b; color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer;">Selesai</button>
    </div>
</div>

<style>
    @keyframes checkPop {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    #successCard.show { transform: scale(1); }
</style>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('auth_token');
    const role = localStorage.getItem('user_role');
    
    if (!token) window.location.href = '/login';

    document.addEventListener('DOMContentLoaded', () => {
        setupSidebar();
        document.getElementById('date-now').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        const name = localStorage.getItem('user_name') || 'User';
        document.getElementById('user-initials').innerText = name.substring(0, 2).toUpperCase();
        
        lucide.createIcons();
    });

    function setupSidebar() {
        const nav = document.getElementById('sidebar-nav');
        let links = '';

        if (role === 'admin') {
            links = `
                <a href="/admin/dashboard" class="sb-link"><i data-lucide="layout-dashboard" style="width: 16px; height: 16px;"></i> Dashboard</a>
                <a href="/admin/members" class="sb-link"><i data-lucide="users" style="width: 16px; height: 16px;"></i> Manajemen Anggota</a>
                <a href="/admin/approvals/pengurus" class="sb-link"><i data-lucide="user-check" style="width: 16px; height: 16px;"></i> Persetujuan Pengurus</a>
                <a href="/admin/informations" class="sb-link"><i data-lucide="megaphone" style="width: 16px; height: 16px;"></i> Informasi</a>
                <a href="/admin/audit-logs" class="sb-link"><i data-lucide="file-clock" style="width: 16px; height: 16px;"></i> Log Audit</a>
            `;
        } else if (role === 'pengurus') {
            links = `
                <a href="/pengurus/dashboard" class="sb-link"><i data-lucide="layout-dashboard" style="width: 16px; height: 16px;"></i> Dashboard</a>
                <a href="/pengurus/members" class="sb-link"><i data-lucide="users" style="width: 16px; height: 16px;"></i> Anggota Wilayah</a>
                <a href="/pengurus/informations" class="sb-link"><i data-lucide="megaphone" style="width: 16px; height: 16px;"></i> Informasi</a>
            `;
        } else {
            // For member, hide sidebar
            document.getElementById('dynamic-sidebar').style.display = 'none';
            document.querySelector('.main-body').style.marginLeft = '0';
        }

        nav.innerHTML = links + `
            <div style="margin-top: auto; padding-top: 20px;">
                <div style="height: 1px; background: rgba(255,255,255,0.1); margin-bottom: 20px;"></div>
                <a href="/settings" class="sb-link active"><i data-lucide="settings" style="width: 16px; height: 16px;"></i> Pengaturan Akun</a>
                <a href="#" class="sb-link" onclick="logout()"><i data-lucide="log-out" style="width: 16px; height: 16px;"></i> Logout</a>
            </div>
        `;
    }

    document.getElementById('passwordForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('btnSubmit');
        const originalText = btn.innerText;

        const payload = {
            current_password: document.getElementById('current_password').value,
            new_password: document.getElementById('new_password').value,
            new_password_confirmation: document.getElementById('new_password_confirmation').value
        };

        btn.disabled = true;
        btn.innerText = 'Memproses...';

        try {
            await axios.post('settings/change-password', payload);
            openSuccessModal();
            document.getElementById('passwordForm').reset();
        } catch (error) {
            let msg = 'Gagal mengubah kata sandi.';
            if (error.response?.data?.errors) {
                msg = Object.values(error.response.data.errors).flat().join(' ');
            } else if (error.response?.data?.message) {
                msg = error.response.data.message;
            }
            showToast(msg, 'error');
        } finally {
            btn.disabled = false;
            btn.innerText = originalText;
        }
    });

    function openSuccessModal() {
        const modal = document.getElementById('successModal');
        const card = document.getElementById('successCard');
        modal.style.display = 'flex';
        setTimeout(() => { card.classList.add('show'); }, 10);
        lucide.createIcons();
    }

    function closeSuccessModal() {
        const modal = document.getElementById('successModal');
        const card = document.getElementById('successCard');
        card.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 300);
    }

    function logout() { localStorage.clear(); window.location.href = '/login'; }
</script>
@endpush
