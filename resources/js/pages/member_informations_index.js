document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        fetchInformations();
    });

    let allInformations = [];

    async function fetchInformations() {
        try {
            const res = await axios.get('member/informations');
            allInformations = res.data.data;
            renderInformations(allInformations);
        } catch (e) {
            console.error(e);
            document.getElementById('infoList').innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="text-danger mb-3">
                        <i data-lucide="alert-circle" style="width: 48px; height: 48px;"></i>
                    </div>
                    <h5>Gagal Memuat Informasi</h5>
                    <p class="text-muted">Terjadi kesalahan teknis. Silakan coba login ulang.</p>
                </div>
            `;
            lucide.createIcons();
        }
    }

    function searchInformations(val) {
        const filtered = allInformations.filter(item => 
            item.title.toLowerCase().includes(val.toLowerCase()) || 
            (item.content && item.content.toLowerCase().includes(val.toLowerCase()))
        );
        renderInformations(filtered);
    }

    function renderInformations(items) {
        const container = document.getElementById('infoList');
        if (items.length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center py-5">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" style="width: 200px; opacity: 0.5;">
                    <h5 class="mt-3 text-muted">Belum ada informasi terbaru</h5>
                </div>
            `;
            return;
        }

        container.innerHTML = '';
        items.forEach(item => {
            let previewHtml = '';
            if (item.type === 'image' && item.attachment_url) {
                previewHtml = `
                    <div class="position-relative overflow-hidden" style="height: 180px;">
                        <img src="${item.attachment_url}" class="w-100 h-100 card-img-preview" style="object-fit: cover; object-position: center;">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge bg-dark bg-opacity-50 blur-sm text-white border-0 py-1 px-2" style="font-size: 0.65rem; backdrop-filter: blur(4px);">
                                <i class="bi bi-image me-1"></i> FOTO
                            </span>
                        </div>
                    </div>
                `;
            } else if (item.type === 'pdf' && item.attachment_url) {
                previewHtml = `
                    <div class="d-flex align-items-center justify-content-center bg-light border-bottom-light" style="height: 180px;">
                        <div class="text-center p-4">
                            <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-circle p-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                <i class="bi bi-file-earmark-pdf fs-1"></i>
                            </div>
                            <div class="small text-muted font-weight-bold letter-spacing-1">DOKUMEN PDF</div>
                        </div>
                    </div>
                `;
            }

            const card = `
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-up transition-all overflow-hidden" onclick="showDetail(${item.id})" style="cursor: pointer; border-radius: 16px;">
                        ${previewHtml}
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <small class="text-muted font-weight-500">${formatDateShort(item.created_at)}</small>
                            </div>
                            <h4 class="h5 font-weight-bold text-dark mb-3 line-clamp-2" style="line-height: 1.4;">${item.title}</h4>
                            <p class="text-muted small mb-0 line-clamp-3" style="line-height: 1.6;">
                                ${item.content || 'Lihat detail untuk informasi selengkapnya.'}
                            </p>
                        </div>
                        <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center border-top-light">
                            <span class="text-primary small font-weight-bold">Baca Selengkapnya</span>
                            <i class="bi bi-chevron-right text-primary small"></i>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', card);
        });
        lucide.createIcons();
    }

    async function showDetail(id) {
        const modalEl = document.getElementById('detailModal');
        const modal = new bootstrap.Modal(modalEl);
        
        try {
            const res = await axios.get(`member/informations/${id}`);
            const item = res.data.data;

            document.getElementById('modalTitle').innerText = item.title;
            document.getElementById('modalContent').innerHTML = item.content ? `<div class="p-2" style="white-space: pre-wrap; line-height: 1.8; color: #334155; font-size: 1.05rem;">${item.content}</div>` : '';
            
            const attachmentContainer = document.getElementById('modalAttachment');
            attachmentContainer.innerHTML = '';

            if (item.type === 'image' && item.attachment_url) {
                attachmentContainer.innerHTML = `
                    <div class="mt-3 p-2 bg-light rounded" style="border: 1px dashed #cbd5e1;">
                        <img src="${item.attachment_url}" class="img-fluid rounded shadow-sm" style="max-height: 500px">
                    </div>
                `;
            } else if (item.type === 'pdf' && item.attachment_url) {
                attachmentContainer.innerHTML = `
                    <div class="alert alert-light border shadow-sm d-flex align-items-center justify-content-between p-4" style="border-radius: 12px;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-box bg-danger text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-file-earmark-pdf fs-4"></i>
                            </div>
                            <div class="text-start">
                                <strong class="d-block text-dark">Berkas Pengumuman</strong>
                                <small class="text-muted">Format PDF terlampir</small>
                            </div>
                        </div>
                        <a href="${item.attachment_url}" target="_blank" class="btn btn-primary px-4" style="border-radius: 8px;">
                            Buka Berkas
                        </a>
                    </div>
                `;
            }

            modal.show();
        } catch (e) {
            showToast('Gagal memuat detail informasi', 'error');
        }
    }

    function getTypeIcon(type) {
        switch(type) {
            case 'text': return '<i class="bi bi-chat-left-text"></i>';
            case 'image': return '<i class="bi bi-image"></i>';
            case 'pdf': return '<i class="bi bi-file-earmark-pdf"></i>';
            default: return '<i class="bi bi-megaphone"></i>';
        }
    }

    function getTypeBadgeClass(type) {
        switch(type) {
            case 'text': return 'bg-primary-subtle text-primary border border-primary-subtle';
            case 'image': return 'bg-success-subtle text-success border border-success-subtle';
            case 'pdf': return 'bg-danger-subtle text-danger border border-danger-subtle';
            default: return 'bg-secondary-subtle text-secondary border border-secondary';
        }
    }

    function formatDateShort(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    }