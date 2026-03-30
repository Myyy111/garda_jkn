<x-admin-layout title="Audit Logs - Garda JKN">
    <div class="mb-4">
        <h1 class="modal-title">Log Audit Sistem</h1>
        <p class="text-muted">Riwayat aktivitas dan perubahan data kependudukan.</p>
    </div>

    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 200px;">Waktu & Tanggal</th>
                        <th>Aktor Pelaksana</th>
                        <th>Jenis Log</th>
                        <th>Entitas Target</th>
                        <th>Metadata Perubahan</th>
                    </tr>
                </thead>
                <tbody id="logTableBody">
                    <!-- Data loaded via JS -->
                </tbody>
            </table>
        </div>
        <div class="table-footer" id="pagination">
            <!-- Pagination info -->
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/pages/admin_audit_logs_index.js'])
    @endpush
</x-admin-layout>

@push("scripts")
<script>
    window.sessionSuccess = "{{ session("success") }}";
    window.sessionError = "{{ session("error") }}";
</script>
@endpush
