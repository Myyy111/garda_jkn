let role = 'member';

    function switchRole(newRole) {
        role = newRole;
        document.getElementById('btn-member').classList.toggle('active', role === 'member');
        document.getElementById('btn-pengurus').classList.toggle('active', role === 'pengurus');
        
        const label = document.getElementById('identityLabel');
        label.innerText = (role === 'member') ? 'NIK Anggota (16 Digit)' : 'NIK Pengurus (16 Digit)';
    }

    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const payload = { 
            nik: document.getElementById('identity').value,
            password: document.getElementById('password').value 
        };

        try {
            const res = await axios.post('member/login', payload);
            if(res.data.success) {
                const userData = res.data.data;
                const memberRole = userData.member.role; // 'anggota' atau 'pengurus'

                // Logika Pembatasan Hak Akses:
                // 1. Jika login sebagai 'pengurus' tapi NIK hanya punya role 'anggota' -> TOLAK
                if (role === 'pengurus' && memberRole !== 'pengurus') {
                    showToast('Maaf, NIK Anda belum terdaftar sebagai Pengurus JKN.', 'error');
                    return;
                }

                // Jika lolos, simpan token dan role login yang dipilih
                localStorage.setItem('auth_token', userData.token);
                localStorage.setItem('user_role', (role === 'pengurus') ? 'pengurus' : 'member');
                localStorage.setItem('user_name', userData.member.name);
                
                showToast('Login berhasil, mengalihkan...', 'success');
                
                setTimeout(() => {
                    if (role === 'pengurus') {
                        window.location.href = '/pengurus/dashboard';
                    } else {
                        window.location.href = '/member/profile';
                    }
                }, 1000);
            }
        } catch (error) {
            let errorMsg = 'Identitas atau password salah.';
            if (error.response?.data?.message) {
                errorMsg = error.response.data.message;
            }
            showToast(errorMsg, 'error');
        }
    });