@extends('layouts.app')

@section('title', 'Manajemen Informasi - Pengurus Garda JKN')

@section('content')
<div class="admin-layout">
    <aside class="sidebar">
        <div class="sb-brand">Garda JKN</div>
        <nav class="sb-menu">
            <a href="/pengurus/dashboard" class="sb-link"><i data-lucide="layout-dashboard" style="width: 16px; height: 16px;"></i> Dashboard</a>
            <a href="/pengurus/members" class="sb-link"><i data-lucide="users" style="width: 16px; height: 16px;"></i> Anggota Wilayah</a>
            <a href="/pengurus/informations" class="sb-link active"><i data-lucide="megaphone" style="width: 16px; height: 16px;"></i> Informasi</a>
            <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
                <a href="/settings" class="sb-link"><i data-lucide="settings" style="width: 16px; height: 16px;"></i> Pengaturan Akun</a>
                <a href="#" class="sb-link" onclick="logout()"><i data-lucide="log-out" style="width: 16px; height: 16px;"></i> Logout</a>
            </div>
        </nav>
    </aside>

    <main class="main-body">
        <header class="top-header">
            <div style="font-weight: 600; color: #1e293b; font-size: 1rem;">Pusat Informasi & Pengumuman Wilayah</div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <span id="date-now-header" style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;"></span>
                <div style="width: 32px; height: 32px; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">PR</div>
            </div>
        </header>

        <div class="view-container">
            <div class="row mb-4 align-items-end">
                <div class="col-md-6">
                    <h1 class="h3 font-weight-bold text-dark mb-1">Manajemen Informasi</h1>
                    <p class="text-muted mb-0">Kelola pengumuman untuk anggota di wilayah Anda</p>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-primary px-4 shadow-sm" onclick="openAddModal()">
                        <i class="bi bi-plus-lg me-2"></i> Buat Informasi Baru
                    </button>
                </div>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-light">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0 font-weight-bold text-dark">Daftar Pengumuman</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4" style="width: 150px;">Tanggal</th>
                                    <th>Informasi</th>
                                    <th style="width: 120px;">Tipe</th>
                                    <th style="width: 100px;">Status</th>
                                    <th class="text-end pe-4" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="infoTableBody" class="border-top-0">
                                <!-- Content loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-light py-3">
                    <div id="paginationContainer"></div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal Tab (Add/Edit) - Identical to Admin -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form id="infoForm" onsubmit="submitForm(event)">
                <input type="hidden" id="infoId">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Informasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Judul</label>
                        <input type="text" id="title" class="form-control" required placeholder="Contoh: Pengumuman Rapat Anggota">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Tipe Informasi</label>
                            <select id="type" class="form-select" onchange="toggleAttachmentField()">
                                <option value="text">Teks Manual</option>
                                <option value="image">Foto/Gambar</option>
                                <option value="pdf">Dokumen PDF</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Aktif (Tampilkan)</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" id="textField">
                        <label class="form-label font-weight-bold">Isi Informasi</label>
                        <textarea id="content" class="form-control" rows="5" placeholder="Ketik informasi di sini..."></textarea>
                    </div>

                    <div class="mb-3 d-none" id="attachmentField">
                        <label class="form-label font-weight-bold" id="attachmentLabel">Lampiran File</label>
                        <input type="file" id="attachment" name="attachment" class="form-control">
                        <div id="currentAttachment" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan Informasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-layout { display: flex; min-height: 100vh; background: #f8fafc; }
    .sidebar { width: 260px; background: #004aad; color: white; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 1050; }
    .sb-brand { padding: 24px 32px; font-size: 1.1rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .sb-menu { padding: 20px 12px; flex: 1; }
    .sb-link { display: flex; align-items: center; padding: 10px 16px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 6px; font-weight: 500; font-size: 0.875rem; margin-bottom: 4px; transition: 0.15s; gap: 12px; }
    .sb-link:hover, .sb-link.active { background: rgba(255,255,255,0.1); color: white; }
    
    .main-body { margin-left: 260px; flex: 1; width: calc(100% - 260px); }
    .top-header { height: 61px; background: white; border-bottom: 1px solid #e2e8f0; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; }
    .view-container { padding: 32px; }

    .btn-icon { width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; border: none; }
    .btn-light-info { background: #e0f2fe; color: #0ea5e9; }
    .btn-light-danger { background: #fee2e2; color: #ef4444; }
    .cursor-pointer { cursor: pointer; }
</style>
@endpush

@push('scripts')
<script>
    const token = localStorage.getItem('auth_token');
    const role = localStorage.getItem('user_role');
    if (!token || (role !== 'pengurus' && role !== 'admin')) window.location.href = '/login';

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('date-now-header').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        lucide.createIcons();
        fetchData();
    });

    // Reuse logic from admin info page
    async function fetchData(page = 1) {
        try {
            const res = await axios.get(`admin/informations?page=${page}`);
            renderTable(res.data.data.data);
            renderPagination(res.data.data);
        } catch (e) {
            showToast('Gagal memuat data', 'error');
        }
    }

    function renderTable(items) {
        const body = document.getElementById('infoTableBody');
        body.innerHTML = '';
        items.forEach(item => {
            body.innerHTML += `
                <tr>
                    <td class="ps-4">${new Date(item.created_at).toLocaleDateString()}</td>
                    <td>
                        <div class="font-weight-bold">${item.title}</div>
                        <small class="text-muted">${item.attachment_path ? 'Ada Lampiran' : 'Teks Saja'}</small>
                    </td>
                    <td><span class="badge bg-primary">${item.type.toUpperCase()}</span></td>
                    <td><span class="badge ${item.is_active ? 'bg-success' : 'bg-secondary'}">${item.is_active ? 'AKTIF' : 'DRAFT'}</span></td>
                    <td class="text-end pe-4">
                        <button class="btn btn-icon btn-light-info" onclick="openEditModal(${item.id})"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
            `;
        });
    }

    function renderPagination(meta) {
        const container = document.getElementById('paginationContainer');
        container.innerHTML = `<div class="small text-muted">Halaman ${meta.current_page} dari ${meta.last_page}</div>`;
    }

    function openAddModal() {
        document.getElementById('infoId').value = '';
        document.getElementById('infoForm').reset();
        new bootstrap.Modal(document.getElementById('infoModal')).show();
    }

    async function toggleAttachmentField() {
        const type = document.getElementById('type').value;
        const field = document.getElementById('attachmentField');
        field.classList.toggle('d-none', type === 'text');
    }

    function logout() { localStorage.clear(); window.location.href = '/login'; }
</script>
@endpush
