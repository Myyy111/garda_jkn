@extends('layouts.app')

@section('title', 'Persetujuan Pengurus - Admin Panel')

@push('styles')
<style>
    .admin-layout { display: flex; min-height: 100vh; background: #f8fafc; }
    
    /* Elegant Brand Sidebar */
    .sidebar { 
        width: 260px; 
        background: #004aad; 
        color: white;
        display: flex; flex-direction: column;
        position: fixed; height: 100vh;
        z-index: 100;
    }
    .sb-brand { padding: 24px 32px; font-size: 1.1rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .sb-menu { padding: 20px 12px; flex: 1; }
    .sb-link { 
        display: flex; align-items: center; padding: 10px 16px; 
        color: rgba(255,255,255,0.7); text-decoration: none;
        border-radius: 6px; font-weight: 500; font-size: 0.875rem;
        margin-bottom: 4px; transition: 0.15s;
        gap: 12px;
    }
    .sb-link:hover, .sb-link.active { background: rgba(255,255,255,0.1); color: white; }
    
    /* Main Area */
    .main-body { margin-left: 260px; flex: 1; }
    .top-header { height: 64px; background: white; border-bottom: 1px solid #e2e8f0; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; }
    .view-container { padding: 32px; max-width: 1400px; }

    /* Premium Table Design */
    .card-table { background: white; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 2px rgba(0,0,0,0.05); overflow: hidden; }
    .table-header { padding: 16px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
    .table-header h2 { font-size: 1rem; font-weight: 700; color: #1e293b; }

    .app-table { width: 100%; border-collapse: collapse; }
    .app-table th { background: #f8fafc; padding: 10px 16px; text-align: left; font-size: 0.65rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; }
    .app-table td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .app-table tr:hover { background: #f8fafc; }

    .name-cell { display: flex; flex-direction: column; gap: 4px; }
    .name-main { font-weight: 700; color: #0f172a; font-size: 0.95rem; }
    .nik-sub { font-size: 0.75rem; color: #94a3b8; font-weight: 500; }

    .status-badge { padding: 4px 12px; border-radius: 99px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; }
    .badge-exp { background: #eff6ff; color: #1d4ed8; }
    .badge-no-exp { background: #f1f5f9; color: #64748b; }

    .action-group { display: flex; gap: 8px; }
    .btn-action { 
        padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 0.8rem; border: none; cursor: pointer; transition: 0.2s;
    }
    .btn-approve { background: #10b981; color: white; }
    .btn-approve:hover { background: #059669; }
    .btn-reject { background: white; color: #ef4444; border: 1px solid #fee2e2; }
    .btn-reject:hover { background: #fef2f2; }

    .empty-state { padding: 100px 40px; text-align: center; }
    .empty-icon { width: 64px; height: 64px; background: #f1f5f9; color: #cbd5e1; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
</style>
@endpush

@section('content')
<div class="admin-layout">
    <aside class="sidebar">
        <div class="sb-brand">Garda JKN</div>
        <nav class="sb-menu">
            <a href="/admin/dashboard" class="sb-link"><i data-lucide="layout-dashboard" style="width: 16px; height: 16px;"></i> Dashboard</a>
            <a href="/admin/members" class="sb-link"><i data-lucide="users" style="width: 16px; height: 16px;"></i> Manajemen Anggota</a>
            <a href="{{ route('admin.approvals.pengurus.index') }}" class="sb-link active"><i data-lucide="user-check" style="width: 16px; height: 16px;"></i> Persetujuan Pengurus</a>
            <a href="/admin/informations" class="sb-link"><i data-lucide="megaphone" style="width: 16px; height: 16px;"></i> Informasi</a>
            <a href="/admin/audit-logs" class="sb-link"><i data-lucide="file-clock" style="width: 16px; height: 16px;"></i> Log Audit</a>
            <div style="margin-top: auto; padding-top: 20px;">
                <div style="height: 1px; background: rgba(255,255,255,0.1); margin-bottom: 20px;"></div>
                <a href="/settings" class="sb-link"><i data-lucide="settings" style="width: 16px; height: 16px;"></i> Pengaturan Akun</a>
                <a href="#" class="sb-link" onclick="logout()"><i data-lucide="log-out" style="width: 16px; height: 16px;"></i> Logout</a>
            </div>
        </nav>
    </aside>

    <main class="main-body">
        <header class="top-header">
            <div style="font-weight: 600; color: #1e293b; font-size: 1rem;">Antrian Persetujuan Pengurus</div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 32px; height: 32px; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">AD</div>
            </div>
        </header>

        <div class="view-container">
            <div class="card-table">
                <div class="table-header">
                    <div>
                        <h2>Data Permohonan Masuk</h2>
                        <p style="font-size: 0.85rem; color: #64748b; margin-top: 4px;">Daftar anggota yang mengajukan upgrade menjadi pengurus operasional.</p>
                    </div>
                    <div style="background: #3b82f6; color: white; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.8rem;">
                        {{ count($applicants) }} Permohonan Pending
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="app-table">
                        <thead>
                            <tr>
                                <th>Biodata Calon</th>
                                <th>Kualifikasi Org.</th>
                                <th>Portfolio & Sertifikat</th>
                                <th>Keputusan Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applicants as $app)
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <span class="name-main">{{ $app->name }}</span>
                                            <span class="nik-sub">NIK: {{ $app->nik }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($app->has_org_experience)
                                            <span class="status-badge badge-exp">Berpengalaman</span>
                                            <div style="margin-top: 8px;">
                                                <div style="font-size: 0.85rem; font-weight: 700; color: #334155;">{{ $app->org_name }}</div>
                                                <div style="font-size: 0.75rem; color: #64748b;">{{ $app->org_position }} • {{ $app->org_duration_months }} Bulan</div>
                                            </div>
                                        @else
                                            <span class="status-badge badge-no-exp">Entry Level</span>
                                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 6px;">Tanpa pengalaman sebelumnya</div>
                                        @endif
                                    </td>
                                    <td style="max-width: 320px;">
                                        @if($app->has_org_experience)
                                            <p style="font-size: 0.8rem; color: #64748b; line-height: 1.5; font-style: italic;">
                                                "{{ Str::limit($app->org_description, 120) }}"
                                            </p>
                                            @if($app->org_certificate_path)
                                                <a href="{{ asset('storage/' . $app->org_certificate_path) }}" target="_blank" style="margin-top: 12px; display: inline-flex; align-items: center; gap: 6px; color: #3b82f6; font-size: 0.7rem; font-weight: 800; text-decoration: none; background: #eff6ff; padding: 4px 10px; border-radius: 6px;">
                                                    <i data-lucide="external-link" style="width: 12px; height: 12px;"></i> VALIDASI DOKUMEN
                                                </a>
                                            @endif
                                        @else
                                            <span style="color: #cbd5e1;">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <form action="{{ route('admin.approvals.pengurus.approve', $app->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-action btn-approve" onclick="return confirm('Setujui anggota ini sebagai pengurus?')">SETUJUI</button>
                                            </form>
                                            <form action="{{ route('admin.approvals.pengurus.reject', $app->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-action btn-reject" onclick="return confirm('Tolak permohonan anggota ini?')">TOLAK</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i data-lucide="inbox"></i></div>
                                            <h3 style="font-weight: 800; color: #0f172a; margin-bottom: 8px;">Antrian Kosong</h3>
                                            <p style="color: #64748b; font-size: 0.9rem;">Belum ada permohonan baru untuk ditinjau saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
    function logout() { localStorage.clear(); window.location.href = '/login'; }
</script>
@endsection
