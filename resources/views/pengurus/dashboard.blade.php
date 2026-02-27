@extends('layouts.app')

@section('title', 'Pengurus Dashboard - Garda JKN')

@push('styles')
<style>
    .admin-layout { display: flex; min-height: 100vh; background: #f8fafc; }
    
    /* Elegant Brand Sidebar - Same theme as Admin */
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

    /* Professional Stats Cards */
    .stat-card { background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .stat-label { font-size: 0.65rem; text-transform: uppercase; font-weight: 600; color: #64748b; margin-bottom: 4px; letter-spacing: 0.025em; }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; }

    /* Chart Containers */
    .chart-box { background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 32px; margin-bottom: 24px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .title-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
</style>
@endpush

@section('content')
<div class="admin-layout">
    <aside class="sidebar">
        <div class="sb-brand">Garda JKN</div>
        <nav class="sb-menu">
            <a href="/pengurus/dashboard" class="sb-link active"><i data-lucide="layout-dashboard" style="width: 16px; height: 16px;"></i> Dashboard</a>
            <a href="/pengurus/members" class="sb-link"><i data-lucide="users" style="width: 16px; height: 16px;"></i> Anggota Wilayah</a>
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
            <div style="font-weight: 600; color: #1e293b; font-size: 1rem;">Portal Pengurus Operasional</div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <span id="date-now" style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;"></span>
                <div id="user-initials" style="width: 32px; height: 32px; background: #eff6ff; color: #004aad; border: 1px solid #dbeafe; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">PR</div>
            </div>
        </header>

        <div class="view-container">
            <div class="summary-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px;">
                <div class="stat-card">
                    <div class="stat-label">Anggota Terkelola</div>
                    <div class="stat-value" id="count-total">...</div>
                    <div style="font-size: 0.70rem; color: #3b82f6; font-weight: 600; margin-top: 8px;">Dalam Wilayah Anda</div>
                </div>
                <div class="stat-card" style="border-left: 3px solid #10b981;">
                    <div class="stat-label">Pendaftaran Baru</div>
                    <div class="stat-value" id="count-month" style="color: #059669;">...</div>
                    <div style="font-size: 0.7rem; color: #059669; font-weight: 600; margin-top: 8px;">Verifikasi Bulan Ini</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Informasi Aktif</div>
                    <div class="stat-value" id="count-info">...</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; margin-top: 12px;">Pengumuman Berjalan</div>
                </div>
            </div>

            <div class="chart-box">
                <div class="title-row">
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 800; color: #0f172a;">Statistik Anggota Wilayah</h3>
                        <p style="font-size: 0.85rem; color: #64748b; margin-top: 4px;">Perbandingan pendaftaran anggota per periode.</p>
                    </div>
                </div>
                <div style="position: relative; width: 100%; height: 350px;"><canvas id="mainChart"></canvas></div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <div class="chart-box" style="padding: 24px;">
                    <div class="title-row" style="margin-bottom: 24px;"><h3 style="font-size: 1rem; font-weight: 800; color: #0f172a;">Gender Wilayah</h3></div>
                    <div style="position: relative; width: 100%; height: 250px;"><canvas id="genderChart"></canvas></div>
                </div>
                <div class="chart-box" style="padding: 24px;">
                    <div class="title-row" style="margin-bottom: 24px;"><h3 style="font-size: 1rem; font-weight: 800; color: #0f172a;">Pekerjaan Wilayah</h3></div>
                    <div style="position: relative; width: 100%; height: 250px;"><canvas id="occupationChart"></canvas></div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('auth_token');
    const role = localStorage.getItem('user_role');
    
    // Auth Check
    if (!token || (role !== 'pengurus' && role !== 'admin')) window.location.href = '/login';

    let mainChartObj = null;
    let genderChartObj = null;
    let occupationChartObj = null;

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('date-now').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        lucide.createIcons();
        updateDashboard();
    });

    async function updateDashboard() {
        try {
            // Kita akan gunakan API admin dashboard sementara atau buat API khusus pengurus nanti
            const res = await axios.get(`admin/dashboard?range=6`);
            const data = res.data.data;
            
            // Set initials
            const name = localStorage.getItem('user_name') || 'Pengurus';
            document.getElementById('user-initials').innerText = name.substring(0, 2).toUpperCase();

            document.getElementById('count-total').innerText = data.total_members.toLocaleString();
            document.getElementById('count-month').innerText = (data.members_per_month[data.members_per_month.length-1]?.total || 0).toLocaleString();
            document.getElementById('count-info').innerText = '12'; // Dummy for now

            renderMainChart(data.members_per_month);
            genderChartObj = renderPie('genderChart', genderChartObj, data.gender_distribution, ['L', 'P'], ['#004aad', '#3b82f6']);
            occupationChartObj = renderPie('occupationChart', occupationChartObj, data.occupation_distribution, null, ['#004aad', '#3b82f6', '#60a5fa', '#93c5fd', '#bfdbfe', '#e2e8f0', '#f1f5f9']);
        } catch (e) {
            console.error(e);
            showToast('Gagal memuat data dashboard', 'error');
        }
    }

    function renderMainChart(data) {
        if (mainChartObj) mainChartObj.destroy();
        const ctx = document.getElementById('mainChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 74, 173, 0.2)');
        gradient.addColorStop(1, 'rgba(0, 74, 173, 0)');

        mainChartObj = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(i => i.month),
                datasets: [{
                    label: 'Registrasi Baru',
                    data: data.map(i => i.total),
                    borderColor: '#004aad',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#004aad',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });
    }

    function renderPie(id, chartObj, data, filter, colors) {
        if (chartObj) chartObj.destroy();
        return new Chart(document.getElementById(id), {
            type: 'doughnut',
            data: {
                labels: data.map(i => {
                    if (i.gender === 'L') return 'Laki-laki';
                    if (i.gender === 'P') return 'Perempuan';
                    return i.occupation || 'Lainnya';
                }),
                datasets: [{ 
                    data: data.map(i => i.total), 
                    backgroundColor: colors, 
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                cutout: '70%'
            }
        });
    }

    function logout() { localStorage.clear(); window.location.href = '/login'; }
</script>
@endpush
