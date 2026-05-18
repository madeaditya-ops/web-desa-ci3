
<section>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="small">Template Surat</div>
                        <div class="h3 mb-0"><?= number_format($count_templates ?? 0) ?></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="small">Potensi</div>
                        <div class="h3 mb-0"><?= number_format($count_potensi ?? 0) ?></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="small">Jumlah-KK</div>
                        <div class="h3 mb-0"><?= number_format($count_keluarga ?? 0) ?></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="small">Warga</div>
                        <div class="h3 mb-0"><?= number_format($count_warga ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="small text-muted">APBDes</div>
                        <div class="h4"><?= number_format($count_apbdes ?? 0) ?></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="small text-muted">Berita</div>
                        <div class="h4"><?= number_format($count_berita ?? 0) ?></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="small text-muted">Aparatur</div>
                        <div class="h4"><?= number_format($count_aparatur ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart & summary -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header"><strong>Surat Dibuat (7 Hari Terakhir)</strong></div>
                    <div class="card-body">
                        <canvas id="arsipChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header"><strong>Ringkasan Arsip</strong></div>
                    <div class="card-body">
                        <p class="mb-2 small text-muted">Total Arsip</p>
                        <h4><?= number_format($count_arsip ?? 0) ?></h4>
                        <hr>
                        <p class="small text-muted mb-1">Periode</p>
                        <p class="mb-0"><?= htmlspecialchars($chart_labels[0] ?? '-') ?> — <?= htmlspecialchars(end($chart_labels) ?? '-') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    const labels = <?= json_encode($chart_labels ?? []) ?>;
    const data = <?= json_encode($chart_values ?? []) ?>;
    const ctx = document.getElementById('arsipChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Surat',
                data: data,
                fill: true,
                borderColor: 'rgba(54,162,235,1)',
                backgroundColor: 'rgba(54,162,235,0.15)',
                tension: 0.35,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
                x: { grid: { display: false } }
            }
        }
    });
})();
</script>