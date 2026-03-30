const token = localStorage.getItem('auth_token');
const role = localStorage.getItem('user_role');

if (!token) window.location.href = '/login';

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('topbarDate').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    loadProfileInfo();
});

async function loadProfileInfo() {
    try {
        const response = await axios.get('member/profile');
        const user = response.data.data;
        const nameEl = document.getElementById('sidebarName');
        const nikEl = document.getElementById('sidebarNik');
        const avatarEl = document.getElementById('sidebarAvatar');

        if (nameEl) nameEl.innerText = user.name;
        if (nikEl) nikEl.innerText = 'NIK: ' + user.nik;
        
        // Match member portal initials or photo
        if (avatarEl) {
            if (user.photo_url) {
                avatarEl.innerHTML = `<img src="${user.photo_url}" style="width:100%; height:100%; object-fit:cover; object-position:top;">`;
            } else {
                const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
                avatarEl.innerHTML = `<span style="font-size:1.5rem; font-weight:800; color:white;">${initials}</span>`;
            }
        }
    } catch (e) {
        console.error("Failed to load profile for sidebar", e);
    }
}

document.getElementById('passwordForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('btnSubmit');
    const originalText = btn.innerHTML;

    const payload = {
        current_password: document.getElementById('current_password').value,
        new_password: document.getElementById('new_password').value,
        new_password_confirmation: document.getElementById('new_password_confirmation').value
    };

    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader-2" class="spin" style="width:18px;height:18px;"></i> Memproses...';
    lucide.createIcons();

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
        btn.innerHTML = originalText;
        lucide.createIcons();
    }
});

function openSuccessModal() {
    const modal = document.getElementById('successModal');
    modal.style.display = 'flex';
    lucide.createIcons();
}

function closeSuccessModal() {
    const modal = document.getElementById('successModal');
    modal.style.display = 'none';
}

window.togglePassword = function(id) {
    const input = document.getElementById(id);
    const btn = document.getElementById('icon-' + id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<i data-lucide="eye-off" style="width:18px;height:18px;"></i>';
    } else {
        input.type = 'password';
        btn.innerHTML = '<i data-lucide="eye" style="width:18px;height:18px;"></i>';
    }
    lucide.createIcons();
}