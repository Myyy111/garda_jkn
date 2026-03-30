@extends('layouts.app')

@section('title', 'Informasi & Pengumuman - Garda JKN')

@section('content')
<div class="page-wrapper" style="font-family: 'Inter', sans-serif; background: #f8fafc; min-height: 100vh; padding: 60px 20px;">
    <div style="max-width: 1000px; margin: 0 auto;">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2" style="font-size: 0.8rem; font-weight: 600;">
                        <li class="breadcrumb-item"><a href="/member/profile" class="text-decoration-none text-muted">Portal Anggota</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Pusat Informasi</li>
                    </ol>
                </nav>
                <h1 class="h2 font-weight-bold text-dark mb-1">Pusat Informasi</h1>
                <p class="text-muted mb-0">Pengumuman dan berita terbaru untuk mendukung aktivitas Anda.</p>
            </div>
            <div class="d-none d-md-block">
                <a href="/member/profile" class="btn btn-secondary px-4 py-2 border-0 shadow-sm" style="background: white; color: #475569; font-weight: 600; border-radius: 10px;">
                    <i class="bi bi-person-circle me-2"></i> Profil Saya
                </a>
            </div>
        </div>

        <!-- Featured / Search (Optional Visual) -->
        <div class="mb-4">
            <div class="input-group input-group-lg shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <span class="input-group-text bg-white border-0 ps-4"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-0 py-3" placeholder="Cari pengumuman..." style="font-size: 1rem;" onkeyup="searchInformations(this.value)">
                <button class="btn btn-primary px-4" type="button">Cari</button>
            </div>
        </div>

        <div id="infoList" class="row g-4">
            <!-- Informations will be loaded here -->
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-3 text-muted font-weight-500">Menyiapkan informasi terbaru...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">Detail Informasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="modalContent" class="mb-4"></div>
                <div id="modalAttachment" class="text-center"></div>
            </div>
            <div class="modal-footer border-0 pb-4 pe-4">
                <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 10px;">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/css/pages/member_informations_index.css', 'resources/js/pages/member_informations_index.js'])




@endpush

@push("scripts")
<script>
    window.sessionSuccess = "{{ session("success") }}";
    window.sessionError = "{{ session("error") }}";
</script>
@endpush
