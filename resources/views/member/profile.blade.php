@extends('layouts.app')

@section('title', 'Profil Saya - Garda JKN')

@push('styles')
<style>
    .page-wrapper { font-family: 'Inter', sans-serif; background: #f1f5f9; min-height: 100vh; padding: 40px 20px; }
    .profile-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }
    .p-name { font-size: 1.5rem; font-weight: 700; color: #1e293b; }
    .data-label { 
        font-size: 0.7rem; font-weight: 600; color: #64748b; 
        text-transform: uppercase; letter-spacing: 0.025em; margin-bottom: 6px;
        display: flex; align-items: center; gap: 6px;
    }
    .data-value { font-size: 0.95rem; font-weight: 500; color: #1e293b; }
    .btn { transition: all 0.15s ease; cursor: pointer; border-radius: 6px; font-weight: 500; font-size: 0.875rem; }
    .btn:active { transform: translateY(1px); }
    
    .icon-box { color: #94a3b8; width: 16px; height: 16px; }
    .status-badge {
        padding: 4px 10px; border-radius: 4px; font-size: 0.65rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.025em;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="page-wrapper">
    <div class="profile-card" style="max-width: 900px; margin: 0 auto; overflow: hidden;">
        <!-- Header Section -->
        <div style="height: 120px; background: #004aad; position: relative;">
            <div style="position: absolute; bottom: -45px; left: 32px; width: 100px; height: 100px; background: #fff; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); border: 4px solid #fff; overflow: hidden; transition: transform 0.2s;" id="avatarContainer">
                <i data-lucide="user" style="width: 40px; height: 40px; color: #64748b;"></i>
            </div>
            
            <a href="/member/informations" class="btn" style="position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(8px); text-decoration: none; padding: 6px 14px; font-size: 0.75rem; border-radius: 6px; display: flex; align-items: center; gap: 6px;">
                <i data-lucide="megaphone" style="width: 14px; height: 14px;"></i> Pusat Informasi
            </a>
        </div>

        <div style="padding: 56px 32px 32px 32px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #f1f5f9;">
                <div>
                    <h1 class="p-name" id="nameDisplay" style="margin-bottom: 4px;">...</h1>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span id="nikDisplay" style="color: #64748b; font-size: 0.875rem;">NIK: ...</span>
                        <span class="status-badge" style="background: #ecfdf5; color: #065f46; border: 1px solid #d1fae5;">Terverifikasi</span>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="/settings" class="btn" style="padding: 8px 16px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="settings" style="width: 16px; height: 16px;"></i> Pengaturan
                    </a>
                    <button class="btn btn-primary" onclick="openEditModal()" style="padding: 8px 16px; background: #004aad; border: none; color: white;">Edit Profil</button>
                    <button class="btn btn-secondary" onclick="logout()" style="padding: 8px 16px; background: white; border: 1px solid #e2e8f0; color: #64748b;">Keluar Sesi</button>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px;">
                <div class="data-section">
                    <h2 style="font-size: 0.875rem; font-weight: 600; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="contact" style="width: 16px; height: 16px; color: #004aad;"></i> Informasi Kontak
                    </h2>
                    
                    <div class="data-row" style="margin-bottom: 20px;">
                        <div class="data-label">WhatsApp</div>
                        <div class="data-value" id="phoneDisplay">...</div>
                    </div>
                    
                    <div class="data-row" style="margin-bottom: 20px;">
                        <div class="data-label">Tanggal Lahir</div>
                        <div class="data-value" id="birthDateDisplay">...</div>
                    </div>
                    
                    <div class="data-row">
                        <div class="data-label">Alamat Domisili</div>
                        <div class="data-value" id="regionDisplay" style="margin-bottom: 4px;">...</div>
                        <div style="font-size: 0.8125rem; color: #64748b; line-height: 1.5;" id="addressDetail">...</div>
                    </div>
                </div>

                <div class="data-section">
                    <h2 style="font-size: 0.875rem; font-weight: 600; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="id-card" style="width: 16px; height: 16px; color: #004aad;"></i> Status & Pekerjaan
                    </h2>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:24px;">
                        <div class="data-row">
                            <div class="data-label">Jenis Kelamin</div>
                            <div class="data-value" id="genderDisplay">...</div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">Pendidikan</div>
                            <div class="data-value" id="educationDisplay">...</div>
                        </div>
                    </div>

                    <div class="data-row" style="margin-bottom: 24px;">
                        <div class="data-label">Pekerjaan</div>
                        <div class="data-value" id="occupationDisplay">...</div>
                    </div>

                    <div class="data-row" style="padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;">
                        <div class="data-label">Status Anggota</div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                            <span style="font-weight: 600; color: #1e293b; font-size: 0.875rem;">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengurus Application Section -->
            <div id="pengurus-section" style="margin-top: 32px; padding: 24px; background: #eff6ff; border: 1px dashed #3b82f6; border-radius: 12px; display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: #1e3a8a; margin-bottom: 4px;">Pendaftaran Pengurus</h3>
                        <p style="font-size: 0.8125rem; color: #1e40af; opacity: 0.8;">Bantu kembangkan Garda JKN dengan menjadi bagian dari kepengurusan kami.</p>
                    </div>
                    <button class="btn btn-primary" onclick="openPengurusModal()" style="background: #1e3a8a; border: none; padding: 10px 20px;">Daftar Sekarang</button>
                </div>
            </div>

            <div id="pengurus-status-section" style="margin-top: 32px; padding: 24px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; display: none;">
                <h3 style="font-size: 0.875rem; font-weight: 700; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="shield-check" style="width: 18px; height: 18px; color: #1e3a8a;"></i> Informasi Kepengurusan
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <div class="data-label">Status Pendaftaran</div>
                        <div id="statusPengurusBadge" style="margin-top: 6px;"></div>
                    </div>
                    <div>
                        <div class="data-label">Perolehan Peran</div>
                        <div class="data-value" id="memberRoleDisplay">Anggota Biasa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pendaftaran Pengurus -->
<div id="pengurusModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.6); z-index:1001; align-items:center; justify-content:center; backdrop-filter: blur(4px);">
    <div style="background: white; width:500px; padding:0; border-radius: 12px; overflow:hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
        <div style="padding:20px 24px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
            <h3 style="font-size:1rem; font-weight:700; color:#1e293b; margin:0;">Formulir Calon Pengurus</h3>
            <button onclick="closePengurusModal()" style="background:none; border:none; color:#64748b; font-size:1.25rem; cursor:pointer;">&times;</button>
        </div>
        
        <div id="pengurusStep1" style="padding:32px; text-align:center;">
            <div style="width:64px; height:64px; background:#eff6ff; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                <i data-lucide="help-circle" style="width:32px; height:32px; color:#3b82f6;"></i>
            </div>
            <h4 style="font-size:1.125rem; font-weight:700; color:#1e293b; margin-bottom:12px;">Ingin Jadi Pengurus?</h4>
            <p style="color:#64748b; font-size:0.875rem; margin-bottom:24px;">Apakah anda bersedia berkontribusi lebih sebagai pengurus di Garda JKN?</p>
            <div style="display:flex; gap:12px;">
                <button class="btn btn-secondary" onclick="submitPengurusInterest(false)" style="flex:1; padding:12px;">Tidak Sekarang</button>
                <button class="btn btn-primary" onclick="showPengurusStep(2)" style="flex:1; padding:12px; background:#004aad; border:none;">Ya, Saya Ingin</button>
            </div>
        </div>

        <div id="pengurusStep2" style="padding:32px; text-align:center; display:none;">
            <div style="width:64px; height:64px; background:#f0fdf4; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                <i data-lucide="users" style="width:32px; height:32px; color:#22c55e;"></i>
            </div>
            <h4 style="font-size:1.125rem; font-weight:700; color:#1e293b; margin-bottom:12px;">Pengalaman Organisasi</h4>
            <p style="color:#64748b; font-size:0.875rem; margin-bottom:24px;">Apakah anda pernah memiliki pengalaman berorganisasi sebelumnya?</p>
            <div style="display:flex; gap:12px;">
                <button class="btn btn-secondary" onclick="submitPengurusInterest(true, false)" style="flex:1; padding:12px;">Tidak Ada</button>
                <button class="btn btn-primary" onclick="showPengurusStep(3)" style="flex:1; padding:12px; background:#004aad; border:none;">Ya, Ada</button>
            </div>
        </div>

        <div id="pengurusStep3" style="padding:32px; display:none;">
            <h4 style="font-size:1rem; font-weight:700; color:#1e293b; margin-bottom:20px;">Detail Pengalaman & Motivasi</h4>
            <div style="margin-bottom:16px;">
                <label class="label" style="font-size:0.75rem;">Berapa Organisasi yang Pernah Diikuti?</label>
                <input type="number" id="appOrgCount" class="form-input" placeholder="Contoh: 3" style="width:100%; margin-top:4px;">
            </div>
            <div style="margin-bottom:16px;">
                <label class="label" style="font-size:0.75rem;">Apa Saja Organisasi Tersebut?</label>
                <textarea id="appOrgName" class="form-input" rows="3" placeholder="Sebutkan nama-nama organisasi..." style="width:100%; margin-top:4px; resize:none;"></textarea>
            </div>
            <div style="margin-bottom:24px;">
                <label class="label" style="font-size:0.75rem;">Alasan Ingin Menjadi Pengurus?</label>
                <textarea id="appReason" class="form-input" rows="3" placeholder="Tuliskan motivasi anda..." style="width:100%; margin-top:4px; resize:none;"></textarea>
            </div>
            <div style="display:flex; gap:12px;">
                <button class="btn btn-secondary" onclick="showPengurusStep(2)" style="flex:1; padding:12px;">Kembali</button>
                <button class="btn btn-primary" onclick="submitPengurusInterest(true, true)" style="flex:2; padding:12px; background:#004aad; border:none;">Kirim Pendaftaran</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil (Modern) -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.6); z-index:1000; align-items:center; justify-content:center; backdrop-filter: blur(4px);">
    <div style="background: white; width:600px; padding:0; overflow:hidden; border-radius: 8px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="padding:20px 32px; border-bottom:1px solid #e2e8f0; background:#fff; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size:1rem; font-weight:700; color: #1e293b; margin: 0;">Edit Profil Anggota</h3>
            <button onclick="closeEditModal()" style="background: none; border: none; font-size: 1.25rem; color: #64748b; cursor: pointer;">&times;</button>
        </div>
        <div style="padding:32px; max-height: 75vh; overflow-y: auto;">
            <div style="margin-bottom: 24px;">
                <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 8px; display: block;">Foto Profil</label>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <img id="editPhotoPreview" src="" style="width: 72px; height: 72px; border-radius: 12px; object-fit: cover; object-position: top; background: #f1f5f9; border: 2px solid #e2e8f0; padding: 2px;">
                    <div style="flex: 1;">
                        <input type="file" id="editPhoto" accept="image/*" class="form-input" style="width: 100%; padding: 6px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.75rem;">
                        <small style="color: #94a3b8; font-size: 0.7rem; margin-top: 4px; display: block;">Rekomendasi: 400x400px, JPG/PNG. Max 10MB.</small>
                    </div>
                </div>
            </div>
            <div style="margin-bottom: 20px;">
                <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Nama Lengkap</label>
                <input type="text" id="editName" class="form-input" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
            </div>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:20px;">
                <div>
                    <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">No. WhatsApp</label>
                    <input type="text" id="editPhone" class="form-input" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                </div>
                <div>
                    <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Tanggal Lahir</label>
                    <input type="date" id="editBirthDate" class="form-input" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:20px;">
                <div>
                    <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Jenis Kelamin</label>
                    <select id="editGender" class="form-input" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Tingkat Pendidikan</label>
                    <select id="editEducation" class="form-input" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="Diploma">Diploma</option>
                        <option value="S1/D4">S1/D4</option>
                        <option value="S2">S2</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Sektor Pekerjaan</label>
                <select id="editOccupation" class="form-input" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                    <option value="Petani">Petani</option>
                    <option value="Pedagang">Pedagang</option>
                    <option value="Nelayan">Nelayan</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="Karyawan">Karyawan</option>
                    <option value="PNS">PNS</option>
                    <option value="TNI/POLRI">TNI / POLRI</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:20px;">
                <div>
                    <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Provinsi</label>
                    <select id="editProvince" class="form-input" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem;" onchange="loadCities(this.value)">
                        <option value="">Pilih...</option>
                    </select>
                </div>
                <div>
                    <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Kab/Kota</label>
                    <select id="editCity" class="form-input" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem;" onchange="loadDistricts(this.value)">
                        <option value="">Pilih...</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom:20px;">
                <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Kecamatan</label>
                <select id="editDistrict" class="form-input" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                    <option value="">Pilih...</option>
                </select>
            </div>
            <div>
                <label class="label" style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Alamat Lengkap Rumah</label>
                <textarea id="editAddress" class="form-input" rows="2" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 0.875rem; resize: none;"></textarea>
            </div>
        </div>
        <div style="padding:20px 32px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:12px;">
            <button class="btn btn-secondary" onclick="closeEditModal()" style="padding: 8px 16px; border-radius: 6px; border: 1px solid #e2e8f0; background: white; color: #64748b; font-weight: 500;">Batal</button>
            <button class="btn btn-primary" onclick="submitUpdate()" style="padding: 8px 16px; border-radius: 6px; border: none; background: #004aad; color: white; font-weight: 500;">Simpan Perubahan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentData = null;

    document.addEventListener('DOMContentLoaded', async () => {
        fetchProfile();
    });

    async function fetchProfile() {
        try {
            const res = await axios.get('member/profile');
            currentData = res.data.data;
            updateUI(currentData);
            lucide.createIcons();
        } catch (e) {
            console.error(e);
            if (e.response?.status === 403) {
                showToast('Akses ditolak. Halaman ini hanya untuk Anggota.', 'error');
                setTimeout(() => window.location.href = '/login', 2000);
            } else {
                showToast('Gagal memuat profil. Silakan coba lagi.', 'error');
            }
        }
    }

    function updateUI(d) {
        document.getElementById('nameDisplay').innerText = d.name;
        document.getElementById('nikDisplay').innerText = `NIK: ${d.nik}`;
        document.getElementById('phoneDisplay').innerText = d.phone;
        document.getElementById('birthDateDisplay').innerText = d.birth_date ? d.birth_date : '-';
        document.getElementById('genderDisplay').innerText = d.gender === 'L' ? 'Laki-laki' : 'Perempuan';
        document.getElementById('educationDisplay').innerText = d.education;
        document.getElementById('occupationDisplay').innerText = d.occupation;
        document.getElementById('addressDetail').innerText = d.address_detail;
        document.getElementById('regionDisplay').innerText = `${d.district.name}, ${d.city.name}, ${d.province.name}`;
        
        // Photo or Initials
        if (d.photo_path) {
            document.getElementById('avatarContainer').innerHTML = `<img src="${d.photo_url}" style="width: 100%; height: 100%; object-fit: cover; object-position: top;" alt="${d.name}">`;
        } else {
            const initials = d.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
            document.getElementById('avatarContainer').innerHTML = `<span style="font-weight: 700; color: #64748b; font-size: 1.5rem;">${initials}</span>`;
        }

        // Pengurus Logic
        const pSection = document.getElementById('pengurus-section');
        const psSection = document.getElementById('pengurus-status-section');
        const statusBadge = document.getElementById('statusPengurusBadge');
        const roleDisplay = document.getElementById('memberRoleDisplay');

        if (d.status_pengurus === 'tidak_mendaftar') {
            pSection.style.display = 'block';
            psSection.style.display = 'none';
        } else {
            pSection.style.display = 'none';
            psSection.style.display = 'block';
            roleDisplay.innerText = d.role === 'pengurus' ? 'Pengurus Garda JKN' : 'Anggota Biasa';
            
            let badgeHtml = '';
            if (d.status_pengurus === 'pendaftaran_diterima') {
                badgeHtml = '<span class="status-badge" style="background:#fef3c7; color:#92400e; border:1px solid #fde68a;">Menunggu Verifikasi</span>';
            } else if (d.status_pengurus === 'aktif') {
                badgeHtml = '<span class="status-badge" style="background:#ecfdf5; color:#065f46; border:1px solid #d1fae5;">Kepengurusan Aktif</span>';
            } else {
                badgeHtml = `<span class="status-badge">${d.status_pengurus}</span>`;
            }
            statusBadge.innerHTML = badgeHtml;
        }
    }

    // --- Pengurus Modal Logic ---
    function openPengurusModal() {
        showPengurusStep(1);
        document.getElementById('pengurusModal').style.display = 'flex';
    }

    function closePengurusModal() {
        document.getElementById('pengurusModal').style.display = 'none';
    }

    function showPengurusStep(step) {
        document.getElementById('pengurusStep1').style.display = step === 1 ? 'block' : 'none';
        document.getElementById('pengurusStep2').style.display = step === 2 ? 'block' : 'none';
        document.getElementById('pengurusStep3').style.display = step === 3 ? 'block' : 'none';
    }

    async function submitPengurusInterest(interested, hasOrg = false) {
        const btn = event?.currentTarget;
        const originalText = btn ? btn.innerText : 'Kirim';
        
        const payload = {
            is_interested_pengurus: interested,
            has_org_experience: hasOrg
        };

        if (interested && hasOrg) {
            payload.org_count = document.getElementById('appOrgCount').value;
            payload.org_name = document.getElementById('appOrgName').value;
            payload.pengurus_reason = document.getElementById('appReason').value;

            if (!payload.org_count || !payload.org_name || !payload.pengurus_reason) {
                showToast('Mohon lengkapi semua data pendaftaran.', 'warning');
                return;
            }
        }

        if (btn) {
            btn.disabled = true;
            btn.innerText = 'Mengirim...';
        }

        try {
            await axios.post('member/apply-pengurus', payload);
            showToast('Data kepengurusan berhasil disimpan!', 'success');
            closePengurusModal();
            fetchProfile(); // Refresh UI
        } catch (e) {
            console.error(e);
            let msg = 'Gagal menyimpan data.';
            if (e.response?.data?.errors) {
                msg = Object.values(e.response.data.errors).flat().join(' ');
            } else if (e.response?.data?.message) {
                msg = e.response.data.message;
            }
            showToast(msg, 'error');
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerText = originalText;
            }
        }
    }

    // --- Modal Logic ---
    async function openEditModal() {
        if(!currentData) return;
        
        document.getElementById('editName').value = currentData.name;
        document.getElementById('editPhone').value = currentData.phone;
        document.getElementById('editBirthDate').value = currentData.birth_date;
        document.getElementById('editGender').value = currentData.gender;
        document.getElementById('editEducation').value = currentData.education;
        document.getElementById('editOccupation').value = currentData.occupation;
        document.getElementById('editAddress').value = currentData.address_detail;
        document.getElementById('editPhotoPreview').src = currentData.photo_url;
        document.getElementById('editPhoto').value = '';
        
        document.getElementById('editModal').style.display = 'flex';
        
        // Populate regions
        await loadProvinces(currentData.province_id);
        await loadCities(currentData.province_id, currentData.city_id);
        await loadDistricts(currentData.city_id, currentData.district_id);
    }

    function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }

    async function loadProvinces(selectedId = null) {
        const res = await axios.get('master/provinces');
        const sel = document.getElementById('editProvince');
        sel.innerHTML = '<option value="">Pilih...</option>';
        res.data.data.forEach(p => {
            sel.innerHTML += `<option value="${p.id}" ${p.id == selectedId ? 'selected' : ''}>${p.name}</option>`;
        });
    }

    async function loadCities(provId, selectedId = null) {
        const sel = document.getElementById('editCity');
        const distSel = document.getElementById('editDistrict');
        
        // Reset both child dropdowns
        sel.innerHTML = '<option value="">Pilih...</option>';
        distSel.innerHTML = '<option value="">Pilih...</option>';
        
        if(!provId) return;

        const res = await axios.get(`master/cities?province_id=${provId}`);
        res.data.data.forEach(c => {
            const prefix = c.type === 'KOTA' ? 'KOTA ' : 'KAB. ';
            sel.innerHTML += `<option value="${c.id}" ${c.id == selectedId ? 'selected' : ''}>${prefix}${c.name}</option>`;
        });
    }

    async function loadDistricts(cityId, selectedId = null) {
        const sel = document.getElementById('editDistrict');
        sel.innerHTML = '<option value="">Pilih...</option>';
        
        if(!cityId) return;

        const res = await axios.get(`master/districts?city_id=${cityId}`);
        res.data.data.forEach(d => {
            sel.innerHTML += `<option value="${d.id}" ${d.id == selectedId ? 'selected' : ''}>${d.name}</option>`;
        });
    }

    async function submitUpdate() {
        const formData = new FormData();
        formData.append('_method', 'PUT'); // Spofing method for multipart data
        formData.append('name', document.getElementById('editName').value);
        formData.append('phone', document.getElementById('editPhone').value);
        formData.append('birth_date', document.getElementById('editBirthDate').value);
        formData.append('gender', document.getElementById('editGender').value);
        formData.append('education', document.getElementById('editEducation').value);
        formData.append('occupation', document.getElementById('editOccupation').value);
        const provId = document.getElementById('editProvince').value;
        const cityId = document.getElementById('editCity').value;
        const distId = document.getElementById('editDistrict').value;

        if (provId) formData.append('province_id', provId);
        if (cityId) formData.append('city_id', cityId);
        if (distId) formData.append('district_id', distId);

        formData.append('address_detail', document.getElementById('editAddress').value);

        const photoInput = document.getElementById('editPhoto');
        if (photoInput.files[0]) {
            formData.append('photo', photoInput.files[0]);
        }

        const btn = event.currentTarget;
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'Menyimpan...';

        try {
            await axios.post('member/profile', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            showToast('Profil berhasil diperbarui!', 'success');
            closeEditModal();
            fetchProfile(); // Refresh UI
        } catch (e) {
            console.error(e);
            showToast(e.response?.data?.message || 'Gagal memperbarui profil.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerText = originalText;
        }
    }

    function logout() { localStorage.clear(); window.location.href = '/login'; }
</script>
@endpush
