<x-admin-layout title="Pengaturan Akun - Admin Garda JKN">
    <div class="table-card p-4 mx-auto" style="max-width: 600px;">
        <div class="modal-header">
            <div>
                <h2 class="modal-title">Keamanan & Password</h2>
                <p class="text-muted" style="font-size: 0.85rem; margin-top: 4px;">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun.</p>
            </div>
        </div>
        <div class="modal-body">
            <form id="passwordForm">
                <div class="form-group">
                    <label class="form-label">Kata Sandi Saat Ini</label>
                    <div class="input-group-password" style="position: relative;">
                        <input type="password" id="current_password" class="form-input" placeholder="Masukkan password sekarang" required>
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('current_password')" tabindex="-1">
                            <span id="icon-current_password" style="display: flex;">
                                <i data-lucide="eye" style="width: 18px; height: 18px; color: var(--text-muted);"></i>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Kata Sandi Baru</label>
                    <div class="input-group-password" style="position: relative;">
                        <input type="password" id="new_password" class="form-input" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('new_password')" tabindex="-1">
                            <span id="icon-new_password" style="display: flex;">
                                <i data-lucide="eye" style="width: 18px; height: 18px; color: var(--text-muted);"></i>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                    <div class="input-group-password" style="position: relative;">
                        <input type="password" id="new_password_confirmation" class="form-input" placeholder="Ulangi password baru" required>
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('new_password_confirmation')" tabindex="-1">
                            <span id="icon-new_password_confirmation" style="display: flex;">
                                <i data-lucide="eye" style="width: 18px; height: 18px; color: var(--text-muted);"></i>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="flex justify-between mt-4" style="justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i data-lucide="save" style="width:18px;height:18px;margin-right:8px;"></i> Update Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal Template -->
    <div id="successModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 400px; text-align: center; padding: 40px;">
            <div style="width: 80px; height: 80px; background: #ecfdf5; color: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <i data-lucide="check-circle" style="width: 48px; height: 48px;"></i>
            </div>
            <h3 class="modal-title" style="font-size: 1.5rem; margin-bottom: 8px;">Berhasil!</h3>
            <p class="text-muted" style="font-size: 0.95rem; margin-bottom: 24px;">Kata sandi Anda telah diperbarui.</p>
            <button class="btn btn-primary w-full" onclick="closeSuccessModal()" style="padding: 14px;">Selesai</button>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/pages/common_settings.js'])
    @endpush
</x-admin-layout>
