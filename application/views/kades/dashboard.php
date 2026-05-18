
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
                        <div class="small">Galeri</div>
                        <div class="h3 mb-0"><?= number_format($count_galeri ?? 0) ?></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="small">Peraturan</div>
                        <div class="h3 mb-0"><?= number_format($count_peraturan ?? 0) ?></div>
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
                        <p class="mb-0">
                            <?= htmlspecialchars($chart_labels[0] ?? '-') ?> 
                            — <?= htmlspecialchars(end($chart_labels) ?? '-') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--  Pengaduan Section Start -->
  <section id="pengaduan">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mt-3 mb-3">
                    <div class="card-header">
                        <h5>Distribusi Kategori Pengaduan Tahun <?= $tahun ?></h5>
                    </div>
                    <div class="card-body" style="height: 305px;">
                        <canvas id="pieKategori"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mt-3 mb-2">
                    <div class="card-header">
                        <strong>Rata rata waktu pengaduan selesai</strong>
                    </div>
                    <div class="card-body">
                        <strong><?= format_hari_jam($rata_rata_waktu) ?></strong>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Pengaduan per Bulan (<?= $tahun_bar ?>)</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="barPengaduan"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
  </section>
 <!-- Pengaduan Section End -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Line Chart Surat -->
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

<!-- Pie Chart Kategori Pengaduan -->
<script>
(function () {
    const pieLabels = <?= $pie_labels ?>;
    const pieData   = <?= $pie_data ?>;
    const pieColors = <?= $pie_colors ?>;

    const canvas = document.getElementById('pieKategori');

    // jika tidak ada data
    if (!pieLabels || pieLabels.length === 0) {
        canvas.outerHTML =
            '<p class="text-center text-muted">Tidak ada data pengaduan tahun ini</p>';
        return;
    }

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: pieColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.raw;
                            const percent = total ? ((value / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + value + ' (' + percent + '%)';
                        }
                    }
                }
            }
        }
    });
})();
</script>

<!-- Bar Chart Pengaduan per Bulan -->
 <script>
(function () {
    const Barlabels = <?= $bar_labels ?>;
    const dataValues = <?= $bar_data ?>;

    const ctx = document.getElementById('barPengaduan').getContext('2d');

        // jika tidak ada data
    if (!Barlabels || Barlabels.length === 0) {
        ctx.canvas.outerHTML =
            '<p class="text-center text-muted">Tidak ada data pengaduan tahun ini</p>';
        return;
    }

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Barlabels,
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: dataValues,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
})();
</script>