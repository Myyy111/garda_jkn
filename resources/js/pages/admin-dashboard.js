    let mainChart = null, genderChart = null, eduChart = null, ageChart = null;

    async function updateDashboard(months) {
        try {
            // Use relative path with /api/ baseURL
            const res = await window.axios.get(`admin/dashboard?range=${months}`);
            const d = res.data.data;
            
            // Sync summary stats
            if (document.getElementById('count-total')) document.getElementById('count-total').innerText = d.summary.total_members.toLocaleString('id-ID');
            if (document.getElementById('count-month')) document.getElementById('count-month').innerText = d.summary.new_this_month.toLocaleString('id-ID');
            if (document.getElementById('count-provinces')) document.getElementById('count-provinces').innerText = d.summary.total_provinces;
            if (document.getElementById('count-logs')) document.getElementById('count-logs').innerText = d.summary.total_logs.toLocaleString('id-ID');

            // Render Charts
            renderMainChart(d.growth);
            renderPieChart('genderChart', d.distribution.gender, ['#3b82f6', '#f43f5e']);
            renderPieChart('eduChart', d.distribution.education, ['#6366f1', '#8b5cf6', '#ec4899', '#f97316', '#10b981']);
            renderPieChart('ageChart', d.distribution.age, ['#0ea5e9', '#22c55e', '#eab308', '#f97316', '#ef4444']);
        } catch (e) {
            console.error("Dashboard Sync Error:", e);
        }
    }

    // Attach to window for the onchange handler in Blade
    window.updateDashboard = updateDashboard;

    // Run on load
    document.addEventListener('DOMContentLoaded', () => {
        updateDashboard(6);
    });

    function renderMainChart(data) {
        const ctx = document.getElementById('mainChart').getContext('2d');
        if (mainChart) mainChart.destroy();
        mainChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(i => i.month),
                datasets: [{
                    label: 'Pendaftaran Anggota',
                    data: data.map(i => i.total),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });
    }

    function renderPieChart(id, data, colors) {
        const ctx = document.getElementById(id).getContext('2d');
        const chartMap = { genderChart, eduChart, ageChart };
        if (chartMap[id]) chartMap[id].destroy();
        
        const newChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    data: Object.values(data),
                    backgroundColor: colors,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15, font: { size: 11, weight: '600' } } } }
            }
        });

        if (id === 'genderChart') genderChart = newChart;
        if (id === 'eduChart') eduChart = newChart;
        if (id === 'ageChart') ageChart = newChart;
    }
