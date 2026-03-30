const token = localStorage.getItem('auth_token');
    const role = localStorage.getItem('user_role');
    if (!token || (role !== 'pengurus' && role !== 'admin')) window.location.href = '/login';

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('date-now').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
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

    // Global functions will handle initGlobalSidebar and logout from app.blade.php