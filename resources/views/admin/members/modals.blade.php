<!-- Modal Tambah Member -->
<div id="addModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Registrasi Basis Data Anggota</h3>
            <button onclick="window.closeAddModal()" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">NIK (16 Digit)</label>
                    <input type="text" id="addNik" class="form-input" placeholder="Wajib 16 digit sesuai KTP">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Kartu JKN</label>
                    <input type="text" id="addJknNumber" class="form-input" placeholder="Opsional (13 digit)">
                </div>
            </div>
            <div class="grid-2" style="grid-template-columns: 2fr 1fr;">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" id="addName" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" id="addPhone" class="form-input" placeholder="0812...">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" id="addBirthDate" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-group-password" style="position: relative;">
                        <input type="password" id="addPassword" class="form-input" placeholder="Min. 6 Karakter">
                        <button type="button" class="password-toggle-btn" onclick="window.togglePassword('addPassword')" tabindex="-1">
                            <span id="icon-addPassword" style="display: flex;">
                                <i data-lucide="eye" style="width: 18px; height: 18px; color: var(--text-muted);"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select id="addGender" class="form-input">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pendidikan</label>
                    <select id="addEducation" class="form-input">
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="Diploma">Diploma</option>
                        <option value="S1/D4">S1/D4</option>
                        <option value="S2">S2</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Pekerjaan</label>
                    <select id="addOccupation" class="form-input">
                        <option value="BELUM/TIDAK BEKERJA">BELUM/TIDAK BEKERJA</option>
                        <option value="MENGURUS RUMAH TANGGA">MENGURUS RUMAH TANGGA</option>
                        <option value="PELAJAR/MAHASISWA">PELAJAR/MAHASISWA</option>
                        <option value="PENSIUNAN">PENSIUNAN</option>
                        <option value="PEGAWAI NEGERI SIPIL">PEGAWAI NEGERI SIPIL</option>
                        <option value="TNI/POLRI">TNI / POLRI</option>
                        <option value="KARYAWAN SWASTA">KARYAWAN SWASTA</option>
                        <option value="KARYAWAN BUMN/BUMD">KARYAWAN BUMN/BUMD</option>
                        <option value="WIRASWASTA">WIRASWASTA</option>
                        <option value="PETANI/PEKEBUN">PETANI/PEKEBUN</option>
                        <option value="NELAYAN/PERIKANAN">NELAYAN/PERIKANAN</option>
                        <option value="BURUH HARIAN LEPAS">BURUH HARIAN LEPAS</option>
                        <option value="PEDAGANG">PEDAGANG</option>
                        <option value="PERANGKAT DESA">PERANGKAT DESA</option>
                        <option value="TENAGA MEDIS">TENAGA MEDIS (DOKTER/PERAWAT)</option>
                        <option value="LAINNYA">LAINNYA</option>
                    </select>
                </div>
            </div>
            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">Provinsi</label>
                    <select id="addProvince" class="form-input" onchange="window.loadAddCities(this.value)">
                        <option value="">Pilih...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kab/Kota</label>
                    <select id="addCity" class="form-input" onchange="window.loadAddDistricts(this.value)">
                        <option value="">Pilih...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kecamatan</label>
                    <select id="addDistrict" class="form-input">
                        <option value="">Pilih...</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Lengkap</label>
                <textarea id="addAddress" class="form-input" rows="2" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="window.closeAddModal()">Batal</button>
            <button class="btn btn-primary" id="btnSubmitAdd" onclick="window.submitAdd()">Simpan Anggota</button>
        </div>
    </div>
</div>

<!-- Modal Edit Member -->
<div id="editModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Data Anggota</h3>
            <button onclick="window.closeEditModal()" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">NIK (16 Digit)</label>
                    <input type="text" id="editNik" class="form-input" readonly title="NIK tidak dapat diubah">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Kartu JKN</label>
                    <input type="text" id="editJknNumber" class="form-input" placeholder="Opsional">
                </div>
            </div>
            <div class="grid-3" style="grid-template-columns: 2fr 1fr 1fr;">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" id="editName" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" id="editPhone" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select id="editGender" class="form-input">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" id="editBirthDate" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Pendidikan</label>
                    <select id="editEducation" class="form-input">
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="Diploma">Diploma</option>
                        <option value="S1/D4">S1/D4</option>
                        <option value="S2">S2</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Pekerjaan</label>
                <select id="editOccupation" class="form-input">
                    <option value="BELUM/TIDAK BEKERJA">BELUM/TIDAK BEKERJA</option>
                    <option value="MENGURUS RUMAH TANGGA">MENGURUS RUMAH TANGGA</option>
                    <option value="PELAJAR/MAHASISWA">PELAJAR/MAHASISWA</option>
                    <option value="PENSIUNAN">PENSIUNAN</option>
                    <option value="PEGAWAI NEGERI SIPIL">PEGAWAI NEGERI SIPIL</option>
                    <option value="TNI/POLRI">TNI / POLRI</option>
                    <option value="KARYAWAN SWASTA">KARYAWAN SWASTA</option>
                    <option value="KARYAWAN BUMN/BUMD">KARYAWAN BUMN/BUMD</option>
                    <option value="WIRASWASTA">WIRASWASTA</option>
                    <option value="PETANI/PEKEBUN">PETANI/PEKEBUN</option>
                    <option value="NELAYAN/PERIKANAN">NELAYAN/PERIKANAN</option>
                    <option value="BURUH HARIAN LEPAS">BURUH HARIAN LEPAS</option>
                    <option value="PEDAGANG">PEDAGANG</option>
                    <option value="PERANGKAT DESA">PERANGKAT DESA</option>
                    <option value="TENAGA MEDIS">TENAGA MEDIS (DOKTER/PERAWAT)</option>
                    <option value="LAINNYA">LAINNYA</option>
                </select>
            </div>
            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">Provinsi</label>
                    <select id="editProvince" class="form-input" onchange="window.loadEditCities(this.value)">
                        <option value="">Pilih...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kab/Kota</label>
                    <select id="editCity" class="form-input" onchange="window.loadEditDistricts(this.value)">
                        <option value="">Pilih...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kecamatan</label>
                    <select id="editDistrict" class="form-input">
                        <option value="">Pilih...</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Lengkap</label>
                <textarea id="editAddress" class="form-input" rows="2" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="modal-footer" style="justify-content: space-between;">
             <button class="btn" onclick="window.resetPassword()" style="color: var(--danger); background: none; border: 1px solid #fee2e2; padding: 6px 12px; border-radius: 8px;">Reset Kata Sandi</button>
             <div style="display:flex; gap:12px;">
                <button class="btn btn-secondary" onclick="window.closeEditModal()">Batal</button>
                <button class="btn btn-primary" id="btnSubmitEdit" onclick="window.submitEdit()">Simpan</button>
             </div>
        </div>
    </div>
</div>
