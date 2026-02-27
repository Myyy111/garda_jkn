@extends('layouts.app')

@section('title', 'Aplikasi Pengurus - Garda JKN')

@section('content')
<style>
    .apply-container { min-height: 100vh; background: #f8fafc; padding: 80px 20px; font-family: 'Inter', sans-serif; }
    .apply-card { 
        background: white; max-width: 640px; margin: 0 auto; border-radius: 24px; 
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid #e2e8f0; 
    }
    
    .card-header { 
        background: linear-gradient(135deg, #004aad 0%, #002d6a 100%); 
        color: white; padding: 60px 40px; text-align: center; position: relative;
    }
    .card-header h2 { font-family: 'Outfit', sans-serif; font-size: 1.75rem; font-weight: 800; margin-bottom: 8px; letter-spacing: -0.5px; }
    .card-header p { font-size: 0.95rem; opacity: 0.7; font-weight: 500; }
    
    /* Progress Stepper */
    .stepper { display: flex; justify-content: center; gap: 40px; margin-top: 32px; }
    .step-item { display: flex; flex-direction: column; align-items: center; gap: 8px; opacity: 0.4; transition: 0.3s; }
    .step-item.active { opacity: 1; }
    .step-circle { width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.2); border: 2px solid white; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800; }
    .step-item.active .step-circle { background: white; color: #004aad; }

    .card-body { padding: 48px 40px; }
    
    .question-section { text-align: center; animation: slideUp 0.5s ease forwards; }
    .question-text { font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 32px; line-height: 1.4; display: block; }
    
    .choice-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; width: 100%; max-width: 400px; margin: 0 auto; }
    .btn-choice {
        padding: 24px; border: 2px solid #f1f5f9; background: #f8fafc; border-radius: 16px;
        font-weight: 800; cursor: pointer; transition: 0.2s; color: #475569; display: flex; flex-direction: column; align-items: center; gap: 12px;
    }
    .btn-choice i { font-size: 1.5rem; color: #94a3b8; }
    .btn-choice:hover { border-color: #004aad; color: #004aad; background: #eff6ff; }
    .btn-choice:hover i { color: #004aad; }

    .step-content { display: none; }
    .step-content.active { display: block; }

    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-size: 0.75rem; font-weight: 800; color: #64748b; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em; }
    
    .form-control { width: 100%; padding: 14px 16px; border: 2px solid #f1f5f9; border-radius: 12px; font-size: 0.95rem; background: #f8fafc; transition: 0.2s; }
    .form-control:focus { border-color: #004aad; background: white; outline: none; }

    .primary-btn {
        width: 100%; padding: 16px; background: #004aad; color: white; border: none; border-radius: 12px;
        font-weight: 800; font-size: 1rem; cursor: pointer; transition: 0.2s; box-shadow: 0 10px 15px -3px rgba(0, 74, 173, 0.2);
    }
    .primary-btn:hover { background: #003a8c; transform: translateY(-1px); }

    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="apply-container">
    <div class="apply-card">
        <div class="card-header">
            <h2>Karir Pengurus</h2>
            <p>Jadilah bagian dari tim yang menggerakkan pelayanan publik JKN Nasional</p>
            
            <div class="stepper">
                <div class="step-item active" id="dot1"><div class="step-circle">1</div></div>
                <div class="step-item" id="dot2"><div class="step-circle">2</div></div>
                <div class="step-item" id="dot3"><div class="step-circle">3</div></div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('member.apply_pengurus') }}" method="POST" enctype="multipart/form-data" id="applyForm">
                @csrf
                
                <!-- Step 1: Interest -->
                <div class="step-content active" id="step1">
                    <div class="question-section">
                        <span class="question-text">Apakah Anda memiliki ketertarikan tinggi untuk berkontribusi sebagai Pengurus Garda JKN?</span>
                        <div class="choice-grid">
                            <button type="button" class="btn-choice" onclick="selectInterest(true)">
                                <i data-lucide="check-circle-2"></i>
                                YA, SAYA TERTARIK
                            </button>
                            <button type="button" class="btn-choice" onclick="selectInterest(false)">
                                <i data-lucide="x-circle"></i>
                                BELUM SAATNYA
                            </button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="is_interested" id="is_interested" value="0">

                <!-- Step 2: Experience Check -->
                <div class="step-content" id="step2">
                    <div class="question-section">
                        <span class="question-text">Apakah Anda memiliki rekam jejak atau pengalaman dalam organisasi sebelumnya?</span>
                        <div class="choice-grid">
                            <button type="button" class="btn-choice" onclick="selectExperience(true)">
                                <i data-lucide="briefcase"></i>
                                SAYA MEMILIKI
                            </button>
                            <button type="button" class="btn-choice" onclick="selectExperience(false)">
                                <i data-lucide="user-plus"></i>
                                TIDAK MEMILIKI
                            </button>
                        </div>
                        <button type="button" onclick="goToStep(1)" style="margin-top: 32px; background: none; border: none; color: #94a3b8; font-weight: 700; cursor: pointer; font-size: 0.8rem;">&larr; KEMBALI KE SEBELUMNYA</button>
                    </div>
                </div>

                <input type="hidden" name="has_org_experience" id="has_org_experience" value="0">

                <!-- Step 3: Experience Form -->
                <div class="step-content" id="step3">
                    <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
                        <i data-lucide="file-text" style="color: #004aad;"></i>
                        PORTFOLIO ORGANISASI
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Lembaga / Organisasi</label>
                        <input type="text" name="org_name" class="form-control" placeholder="Contoh: BEM Universitas / Karang Taruna">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Jabatan Terakhir</label>
                            <input type="text" name="org_position" class="form-control" placeholder="Contoh: Ketua / Sekretaris">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Durasi (Dalam Bulan)</label>
                            <input type="number" name="org_duration_months" class="form-control" placeholder="Contoh: 24">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Peran & Kontribusi</label>
                        <textarea name="org_description" class="form-control" rows="4" style="resize: none;" placeholder="Sebutkan tanggung jawab utama dan pencapaian Anda..."></textarea>
                    </div>

                    <div class="form-group" style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 2px dashed #e2e8f0;">
                        <label class="form-label">Dokumen Sertifikat (Opsional)</label>
                        <input type="file" name="org_certificate" style="font-size: 0.8rem; color: #64748b;" accept=".pdf,.jpg,.png">
                        <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 8px;">Maksimal file 10MB (PDF/JPG/PNG)</div>
                    </div>

                    <button type="submit" class="primary-btn">
                        KIRIM APLIKASI PENDAFTARAN
                    </button>
                    
                    <button type="button" onclick="goToStep(2)" style="width: 100%; margin-top: 16px; background: none; border: none; color: #94a3b8; font-weight: 700; cursor: pointer; font-size: 0.8rem;">KEMBALI KE SEBELUMNYA</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });

    function goToStep(s) {
        document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
        document.getElementById('step' + s).classList.add('active');
        
        // Update dots
        document.querySelectorAll('.step-item').forEach(el => el.classList.remove('active'));
        for(let i=1; i<=s; i++) {
            document.getElementById('dot' + i).classList.add('active');
        }
        lucide.createIcons();
    }

    function selectInterest(val) {
        document.getElementById('is_interested').value = val ? "1" : "0";
        if (val) {
            goToStep(2);
        } else {
            window.location.href = "{{ route('member.profile') }}";
        }
    }

    function selectExperience(val) {
        document.getElementById('has_org_experience').value = val ? "1" : "0";
        if (val) {
            goToStep(3);
        } else {
            // Show loading if direct submit
            showToast('Memproses pendaftaran...', 'info');
            document.getElementById('applyForm').submit();
        }
    }
</script>
@endsection
