<div class="container-fluid">
    <style>
        .kpi-card { border-radius: .75rem; overflow: hidden; color: #fff; }
        .kpi-card .card-body { padding: 1.25rem; }
        .kpi-icon { font-size: 2.25rem; opacity: .9; }
        .kpi-value { font-size: 2.25rem; font-weight: 700; line-height: 1; }
        .card-graph { border-radius: .75rem; }

        /* ubah ukuran chart menjadi lebih kecil */
        .card-graph .card-body { padding: 0.9rem; }
        #suratChart { max-height: 120px !important; height: 90px !important; }

        /* Ringkasan cepat - diperkecil */
        .card-quick .card-header { font-size: 0.95rem; padding: .6rem .9rem; }
        .card-quick .card-body { padding: .9rem; font-size: 0.88rem; }
        .card-quick .list-unstyled li { padding: .25rem 0; display:flex; justify-content:space-between; align-items:center; }
        .card-quick .list-unstyled small { font-size: .82rem; color: #6c757d; }
        .card-quick .btn { padding: .35rem .6rem; font-size: .78rem; }

        .small-muted { color: #6c757d; font-size: .9rem; }
        .chart-legend { display:flex; gap:1rem; align-items:center; margin-top:.5rem; }
        .legend-dot { width:12px; height:12px; border-radius:50%; display:inline-block; margin-right:.45rem; }
    </style>

    <div class="row mb-4">
        <?php $avg7 = (isset($chart_data) && is_array($chart_data) && count($chart_data)) ? round(array_sum($chart_data) / count($chart_data), 2) : 0; ?>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card kpi-card" style="background: linear-gradient(90deg,#4e73df,#224abe);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small-muted">Total Surat Keluar</div>
                        <div class="kpi-value"><?= number_format($total_surats ?? 0) ?></div>
                        <div class="small-muted mt-1">Sejak awal pencatatan</div>
                    </div>
                    <div class="text-right">
                        <i class="fas fa-file-alt kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card kpi-card" style="background: linear-gradient(90deg,#1cc88a,#17a673);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small-muted">Surat Keluar Hari Ini</div>
                        <div class="kpi-value"><?= number_format($today_count ?? 0) ?></div>
                        <div class="small-muted mt-1">Aktivitas hari ini</div>
                    </div>
                    <div class="text-right">
                        <i class="fas fa-calendar-day kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 mb-3">
            <div class="card kpi-card" style="background: linear-gradient(90deg,#36b9cc,#188aad);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small-muted">Rata-rata / Hari (7 hari)</div>
                        <div class="kpi-value"><?= $avg7 ?></div>
                        <div class="small-muted mt-1">Menggambarkan tren</div>
                    </div>
                    <div class="text-right">
                        <i class="fas fa-chart-line kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- lebih luas untuk grafik -->
        <div class="col-lg-9 mb-4">
            <div class="card card-graph shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Surat Keluar - 7 Hari Terakhir</strong>
                    <div class="small-muted">Update otomatis</div>
                </div>
                <div class="card-body">
                    <canvas id="suratChart" height="90"></canvas>

                    <div class="chart-legend">
                        <div><span class="legend-dot" style="background: rgba(54,162,235,0.8)"></span> Surat per hari</div>
                        <div class="ml-3 small-muted">Total: <strong><?= array_sum($chart_data ?? []) ?></strong></div>
                        <div class="ml-3 small-muted">Periode: <strong><?= htmlspecialchars($chart_labels[0] ?? '-') ?> — <?= htmlspecialchars(end($chart_labels) ?? '-') ?></strong></div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <a href="<?= site_url('admin/arsip') ?>" class="btn btn-outline-primary btn-sm mr-2">
                            <i class="fas fa-archive"></i> Lihat Arsip
                        </a>
                        <a href="<?= site_url('admin/arsip') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-download"></i> Unduh Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ringkasan cepat diperkecil -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm card-quick">
                <div class="card-header"><strong>Ringkasan Cepat</strong></div>
                <div class="card-body">
                    <p class="small-muted mb-2">Distribusi Surat (7 hari)</p>
                    <ul class="list-unstyled mb-2">
                        <?php
                            $labels = $chart_labels ?? [];
                            $data = $chart_data ?? [];
                            for ($i = count($labels) - 1; $i >= 0; $i--):
                                $lab = $labels[$i] ?? '';
                                $val = $data[$i] ?? 0;
                        ?>
                        <li>
                            <div><small><?= htmlspecialchars($lab) ?></small></div>
                            <div><strong><?= $val ?></strong></div>
                        </li>AC
                        <?php endfor; ?>
                    </ul>

                    <hr style="margin: .5rem 0;">
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('admin/upload_template') ?>" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus"></i> Unggah
                        </a>
                        <a href="<?= site_url('admin/arsip') ?>" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-folder-open"></i> Arsip
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    const labels = <?= json_encode($chart_labels ?? []) ?>;
    const dataset = <?= json_encode($chart_data ?? []) ?>;
    const ctx = document.getElementById('suratChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0,0,0,200);
    gradient.addColorStop(0, 'rgba(54,162,235,0.85)');
    gradient.addColorStop(1, 'rgba(54,162,235,0.25)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Surat per Hari',
                data: dataset,
                backgroundColor: gradient,
                borderColor: 'rgba(54,162,235,1)',
                borderWidth: 1,
                hoverBackgroundColor: 'rgba(54,162,235,0.95)',
                borderRadius: 6,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ' ' + ctx.parsed.y + ' surat';
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                }
            }
        }
    });
})();
</script>