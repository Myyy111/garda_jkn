// resources/js/pages/admin_bpjs_keliling_index.js

document.addEventListener('DOMContentLoaded', () => {
    // We are not using Vue here, we use vanilla JS for consistency based on previous tasks.
    
    const token = localStorage.getItem('auth_token');
    if (!token) {
        window.location.href = '/login/admin';
        return;
    }

    const eventContainer = document.getElementById('event-container');
    const totalAgendaEl = document.getElementById('total-agenda');
    const upcomingAgendaEl = document.getElementById('upcoming-agenda');
    const completedAgendaEl = document.getElementById('completed-agenda');
    
    // Modal elements
    const modal = document.getElementById('bpjsModal');
    const form = document.getElementById('bpjsForm');
    const btnAdd = document.getElementById('btn-add');
    const btnCloseModal = document.getElementById('btn-close-modal');
    const modalTitle = document.getElementById('modal-title');
    const hiddenId = document.getElementById('bpjs_id');

    // Stats
    let eventsData = [];

    // Load data
    function loadData() {
        window.axios.get('admin/bpjs-keliling')
            .then(res => {
                eventsData = res.data.data;
                renderEvents();
                updateStats();
            })
            .catch(err => {
                console.error("Gagal memuat data BPJS Keliling", err);
                window.showToast('Gagal memuat data', 'error');
            });
    }

    function renderEvents() {
        eventContainer.innerHTML = '';
        if (eventsData.length === 0) {
            eventContainer.innerHTML = '<div class="col-span-1 md:col-span-2 text-center text-muted p-4">Tidak ada agenda ditemukan.</div>';
            return;
        }

        eventsData.forEach(event => {
            const dateObj = new Date(event.event_date);
            const dateStr = dateObj.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
            
            let statusBadge = '';
            let bgClass = '';
            if (event.status === 'scheduled') {
                statusBadge = '<span class="status-badge badge-info">TERJADWAL</span>';
                bgClass = 'bg-blue-50';
            } else if (event.status === 'ongoing') {
                statusBadge = '<span class="status-badge badge-warning">BERLANGSUNG</span>';
                bgClass = 'bg-yellow-50';
            } else if (event.status === 'completed') {
                statusBadge = '<span class="status-badge badge-success">SELESAI</span>';
                bgClass = 'bg-green-50';
            } else {
                statusBadge = '<span class="status-badge badge-error">BATAL</span>';
                bgClass = 'bg-red-50';
            }

            const html = `
            <div class="event-card ${bgClass}">
                <div class="event-image">
                    <i data-lucide="map-pin" style="width: 40px; height: 40px; opacity: 0.5;"></i>
                </div>
                <div class="event-body flex flex-col justify-between" style="width: 100%;">
                    <div>
                        <div class="justify-between flex mb-2">
                            ${statusBadge}
                            <span class="text-muted font-bold" style="font-size: 0.75rem;">${dateStr}</span>
                        </div>
                        <h4 class="font-bold text-dark mb-2" style="font-size: 1rem;">${event.title}</h4>
                        <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 0;">${event.location}<br/>${event.description || ''}</p>
                    </div>
                    
                    <div class="event-footer mt-4 flex justify-between items-center" style="border-top: 1px solid #eee; padding-top: 10px;">
                        <span class="text-muted" style="font-size: 0.75rem;">
                            <i data-lucide="users" style="width:12px;height:12px;display:inline;margin-right:4px;"></i> 
                            ${event.staff_count} Petugas
                        </span>
                        <div class="flex gap-2">
                            <button class="btn-icon-square btn-edit" title="Edit" onclick="editEvent(${event.id})">
                                <i data-lucide="edit-2"></i>
                            </button>
                            <button class="btn-icon-square btn-delete" title="Hapus" onclick="deleteEvent(${event.id})">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            `;
            eventContainer.innerHTML += html;
        });

        // re-init lucide icons
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    function updateStats() {
        const total = eventsData.length;
        const upcoming = eventsData.filter(e => e.status === 'scheduled').length;
        const completed = eventsData.filter(e => e.status === 'completed').length;
        
        if (totalAgendaEl) totalAgendaEl.innerText = total;
        if (upcomingAgendaEl) upcomingAgendaEl.innerText = upcoming;
        if (completedAgendaEl) completedAgendaEl.innerText = completed;
    }

    // Handlers
    const btnCancelModal = document.getElementById('btn-cancel-modal');

    function closeModal() {
        modal.classList.add('hide');
        setTimeout(() => { modal.style.display = 'none'; }, 300);
    }

    function openModal(title) {
        modalTitle.innerText = title;
        modal.style.display = 'flex';
        modal.classList.remove('hide');
    }

    btnAdd.addEventListener('click', () => {
        form.reset();
        hiddenId.value = '';
        openModal('Tambah Agenda BPJS Keliling');
    });

    btnCloseModal.addEventListener('click', closeModal);
    if (btnCancelModal) {
        btnCancelModal.addEventListener('click', closeModal);
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const id = hiddenId.value;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        const saveBtn = document.getElementById('btn-save');
        saveBtn.disabled = true;
        saveBtn.innerText = 'Menyimpan...';

        let request;
        if (id) {
            request = window.axios.put(`admin/bpjs-keliling/${id}`, data);
        } else {
            request = window.axios.post('admin/bpjs-keliling', data);
        }

        request.then(res => {
            window.showToast(res.data.message, 'success');
            closeModal();
            loadData();
        }).catch(err => {
            console.error(err);
            let errMsg = 'Terjadi kesalahan pengisian';
            if (err.response && err.response.data.errors) {
                errMsg = Object.values(err.response.data.errors).map(e => e.join(', ')).join('<br>');
            }
            window.showToast('Validasi Gagal: ' + errMsg, 'error');
        }).finally(() => {
            saveBtn.disabled = false;
            saveBtn.innerText = 'Simpan';
        });
    });

    window.editEvent = function(id) {
        const event = eventsData.find(e => e.id === id);
        if (!event) return;

        hiddenId.value = event.id;
        document.getElementById('title').value = event.title;
        document.getElementById('description').value = event.description || '';
        document.getElementById('event_date').value = event.event_date;
        document.getElementById('location').value = event.location;
        document.getElementById('staff_count').value = event.staff_count;
        document.getElementById('status').value = event.status;

        openModal('Edit Agenda');
    };

    window.deleteEvent = function(id) {
        window.showConfirm('Hapus Agenda?', 'Data yang dihapus tidak dapat dikembalikan!', {type: 'danger', icon: 'trash-2'}).then((result) => {
            if (result) {
                window.axios.delete(`admin/bpjs-keliling/${id}`)
                    .then(res => {
                        window.showToast(res.data.message, 'success');
                        loadData();
                    })
                    .catch(err => {
                        console.error(err);
                        window.showToast('Terjadi kesalahan sistem.', 'error');
                    });
            }
        });
    };

    // Auto load
    loadData();
});
