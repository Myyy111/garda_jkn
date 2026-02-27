@extends('layouts.app')

@section('title', 'Admin Portal - Garda JKN')

@section('content')
<style>
    .split-layout {
        display: flex;
        min-height: 100vh;
        background: white;
    }

    /* Left Side: Brand/Visual */
    .brand-side {
        flex: 1;
        background: linear-gradient(135deg, #001f4d 0%, #004aad 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 80px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .brand-side::before {
        content: '';
        position: absolute;
        top: -10%; right: -10%;
        width: 400px; height: 400px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%;
    }

    .brand-title { font-size: 2.5rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 16px; }
    .brand-subtitle { font-size: 1.125rem; opacity: 0.8; line-height: 1.6; max-width: 480px; }

    /* Right Side: Form */
    .form-side {
        width: 520px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 80px;
        background: #fdfdfd;
    }

    .form-container { width: 100%; max-width: 360px; margin: 0 auto; }

    .welcome-text { margin-bottom: 32px; }
    .welcome-text h2 { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
    .welcome-text p { color: #64748b; font-size: 0.875rem; }

    .input-group { margin-bottom: 20px; }
    .label { display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 8px; color: #0f172a; }

    @media (max-width: 1024px) {
        .brand-side { display: none; }
        .form-side { width: 100%; padding: 40px; }
    }
</style>

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
<script>
    document.getElementById('adminLoginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const payload = { 
            username: document.getElementById('username').value,
            password: document.getElementById('password').value 
        };

        try {
            const res = await axios.post('/admin/login', payload);
            if(res.data.success) {
                showToast('Otorisasi admin berhasil!', 'success');
                localStorage.setItem('auth_token', res.data.data.token);
                localStorage.setItem('user_role', 'admin');
                localStorage.setItem('user_name', 'Administrator');
                
                setTimeout(() => {
                    window.location.href = '/admin/dashboard';
                }, 1000);
            }
        } catch (error) {
            let errorMsg = 'Kredensial admin tidak valid.';
            if (error.response?.data?.message) {
                errorMsg = error.response.data.message;
            }
            showToast(errorMsg, 'error');
        }
    });
</script>
@endpush
