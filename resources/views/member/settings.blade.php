<x-member-layout title="Pengaturan Akun - Garda JKN">
    <div class="table-card" style="border-radius: 28px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden; background: #ffffff;">
        <div class="modal-header" style="background: #f8fafc; padding: 24px 40px; border-bottom: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="background: #e0e7ff; color: #4f46e5; padding: 12px; border-radius: 16px;">
                    <i data-lucide="shield-check" style="width: 24px; height: 24px;"></i>
                </div>
                <div>
                    <h2 class="modal-title" style="font-size: 1.25rem; margin: 0;">Keamanan & Password</h2>
                    <p class="text-muted" style="font-size: 0.9rem; margin: 4px 0 0 0;">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun.</p>
                </div>
            </div>
        </div>
        <div class="modal-body" style="padding: 40px;">
            <form id="passwordForm">
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">Kata Sandi Saat Ini</label>
                    <div style="position: relative;">
                        <input type="password" id="current_password" class="form-input" placeholder="Masukkan password sekarang" required style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 1rem;">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('current_password')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); border: none; background: none; color: #64748b; padding: 4px;">
                            <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">Kata Sandi Baru</label>
                    <div style="position: relative;">
                        <input type="password" id="new_password" class="form-input" placeholder="Minimal 8 karakter" required style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 1rem;">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('new_password')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); border: none; background: none; color: #64748b; padding: 4px;">
                            <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 32px;">
                    <label class="form-label" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">Konfirmasi Kata Sandi Baru</label>
                    <div style="position: relative;">
                        <input type="password" id="new_password_confirmation" class="form-input" placeholder="Ulangi password baru" required style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 1rem;">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('new_password_confirmation')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); border: none; background: none; color: #64748b; padding: 4px;">
                            <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                        </button>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="btnSubmit" style="padding: 12px 24px; border-radius: 12px; font-weight: 600;">
                        <i data-lucide="save" style="width:18px;height:18px; margin-right: 8px;"></i> Update Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 400px; text-align: center; padding: 40px; border-radius: 28px;">
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
</x-member-layout>
