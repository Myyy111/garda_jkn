<x-admin-layout title="BPJS Keliling - Garda JKN">
    @push('styles')
        @vite(['resources/css/admin.css'])
    @endpush

    <div class="justify-between items-end mb-4 flex">
        <div>
            <h1 class="topbar-title" style="font-size: 1.75rem;">BPJS Keliling</h1>
            <p class="text-muted" style="margin-top: 4px;">Manajemen jadwal dan lokasi layanan operasional lapangan.</p>
        </div>
        <button class="btn btn-primary" id="btn-add" style="padding: 12px 24px;">+ Jadwalkan Kegiatan</button>
    </div>

    <div class="summary-grid">
        <div class="stat-card">
            <div class="stat-label">Total Agenda</div>
            <div class="stat-value" id="total-agenda">0</div>
        </div>
        <div class="stat-card stat-card-blue">
            <div class="stat-label">Terjadwal</div>
            <div class="stat-value" id="upcoming-agenda">0</div>
        </div>
        <div class="stat-card stat-card-green">
            <div class="stat-label">Selesai</div>
            <div class="stat-value" id="completed-agenda">0</div>
        </div>
    </div>

    <div class="table-card p-4">
        <div class="justify-between items-center mb-4 flex">
            <h3 class="modal-title">Daftar Agenda</h3>
        </div>

        <div class="event-grid" id="event-container">
            <!-- Data will be injected here via JS -->
            <div class="col-span-1 md:col-span-2 text-center text-muted p-4">Memuat data...</div>
        </div>
    </div>

    <!-- Modal Form -->
    <div id="bpjsModal" class="modal-overlay" style="display:none;">
        <div class="modal-content" style="max-width: 550px;">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Jadwal BPJS Keliling</h3>
                <button class="modal-close" id="btn-close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="bpjsForm">
                    <input type="hidden" id="bpjs_id" name="id">
                    
                    <div class="form-group">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text" id="title" name="title" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea id="description" name="description" class="form-input" rows="2" style="resize:none;"></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Tanggal Pelaksanaan</label>
                            <input type="date" id="event_date" name="event_date" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lokasi</label>
                            <input type="text" id="location" name="location" class="form-input" required>
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Jumlah Petugas</label>
                            <input type="number" id="staff_count" name="staff_count" class="form-input" value="1" min="1" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select id="status" name="status" class="form-input" required>
                                <option value="scheduled">Terjadwal</option>
                                <option value="ongoing">Berlangsung</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Batal</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-cancel-modal">Batal</button>
                <button type="submit" form="bpjsForm" class="btn btn-primary" id="btn-save">Simpan</button>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/pages/admin_bpjs_keliling_index.js'])
    @endpush
</x-admin-layout>
