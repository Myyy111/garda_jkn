document.addEventListener('DOMContentLoaded', () => {
    if(typeof lucide !== 'undefined') lucide.createIcons();
});

function goToStep(s) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
    document.getElementById('step' + s).classList.add('active');
    
    // Update dots
    document.querySelectorAll('.step-item').forEach(el => el.classList.remove('active'));
    for(let i=1; i<=s; i++) {
        document.getElementById('dot' + i).classList.add('active');
    }
    if(typeof lucide !== 'undefined') lucide.createIcons();
}

window.goToStep = goToStep;

function selectInterest(val) {
    document.getElementById('is_interested').value = val ? "1" : "0";
    if (val) {
        goToStep(2);
    } else {
        window.location.href = "/member/profile";
    }
}

window.selectInterest = selectInterest;

function selectExperience(val) {
    document.getElementById('has_org_experience').value = val ? "1" : "0";
    if (val) {
        goToStep(3);
    } else {
        // Show loading if direct submit
        if(typeof showToast !== 'undefined') showToast('Memproses pendaftaran...', 'info');
        document.getElementById('applyForm').submit();
    }
}

window.selectExperience = selectExperience;
