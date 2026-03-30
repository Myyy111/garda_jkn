document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('date-now').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

    if(window.sessionSuccess) {
        showToast(window.sessionSuccess, 'success');
    }
    if(window.sessionError) {
        showToast(window.sessionError, 'error');
    }
});

window.confirmAction = async function(formId, message, type) {
    const ok = await showConfirm('Konfirmasi Tindakan', message, { 
        type: type === 'success' ? 'primary' : 'danger', 
        confirmText: 'Ya, Lanjutkan',
        icon: type === 'success' ? 'check-circle' : 'alert-circle'
    });
    if (ok) {
        document.getElementById(formId).submit();
    }
}