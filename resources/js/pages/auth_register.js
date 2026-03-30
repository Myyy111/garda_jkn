document.addEventListener('DOMContentLoaded', () => {
        loadProvinces();
    });

    async function loadProvinces() {
        try {
            const res = await axios.get('master/provinces');
            const sel = document.getElementById('province');
            sel.innerHTML = '<option value="">Pilih...</option>';
            res.data.data.forEach(p => { 
                sel.innerHTML += `<option value="${p.id}">${p.name}</option>`; 
            });
        } catch (e) {
            console.error('Gagal mengambil data provinsi', e);
        }
    }

    async function loadCities(provId) {
        const sel = document.getElementById('city');
        const distSel = document.getElementById('district');
        sel.innerHTML = '<option value="">Pilih...</option>';
        distSel.innerHTML = '<option value="">Pilih...</option>';
        if(!provId) return;
        try {
            const res = await axios.get(`master/cities?province_id=${provId}`);
            res.data.data.forEach(c => { 
                sel.innerHTML += `<option value="${c.id}">${c.type === 'KOTA' ? 'KOTA ' : 'KAB. '}${c.name}</option>`; 
            });
        } catch (e) {
            console.error('Gagal mengambil data kota', e);
        }
    }

    async function loadDistricts(cityId) {
        const sel = document.getElementById('district');
        sel.innerHTML = '<option value="">Pilih...</option>';
        if(!cityId) return;
        try {
            const res = await axios.get(`master/districts?city_id=${cityId}`);
            res.data.data.forEach(d => { 
                sel.innerHTML += `<option value="${d.id}">${d.name}</option>`; 
            });
        } catch (e) {
            console.error('Gagal mengambil data kecamatan', e);
        }
    }

    document.getElementById('registerForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const payload = {
            nik: document.getElementById('nik').value,
            jkn_number: document.getElementById('jkn_number').value,
            name: document.getElementById('name').value,
            phone: document.getElementById('phone').value,
            birth_date: document.getElementById('birth_date').value,
            password: document.getElementById('password').value,
            gender: document.getElementById('gender').value,
            education: document.getElementById('education').value,
            occupation: document.getElementById('occupation').value,
            province_id: document.getElementById('province').value,
            city_id: document.getElementById('city').value,
            district_id: document.getElementById('district').value,
            address_detail: document.getElementById('address').value,
        };

        try {
            const res = await axios.post('member/register', payload);
            if(res.data.success) {
                showToast('Pendaftaran berhasil! Silakan login.', 'success');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
            }
        } catch (error) {
            showToast(error.response?.data?.message || 'Gagal mendaftar. Silakan periksa kembali data Anda.', 'error');
        }
    });