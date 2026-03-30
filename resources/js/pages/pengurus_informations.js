const token = localStorage.getItem('auth_token');
    const role = localStorage.getItem('user_role');
    if (!token || (role !== 'pengurus' && role !== 'admin')) window.location.href = '/login';

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('date-now').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        fetchData();
    });

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

    // Global functions will handle initGlobalSidebar and logout from app.blade.php