document.getElementById('adminLoginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const payload = { 
            username: document.getElementById('username').value,
            password: document.getElementById('password').value 
        };

        try {
            const res = await axios.post('admin/login', payload);
            if(res.data.success) {
                showToast('Otorisasi admin berhasil!', 'success');
                localStorage.setItem('auth_token', res.data.data.token);
                localStorage.setItem('user_role', 'admin');
                localStorage.setItem('user_name', 'Administrator');
                
                setTimeout(() => {
                    window.location.href = '/admin/dashboard';
                }, 1000);
            }
        } catch (error) {
            let errorMsg = 'Kredensial admin tidak valid.';
            if (error.response?.data?.message) {
                errorMsg = error.response.data.message;
            }
            showToast(errorMsg, 'error');
        }
    });