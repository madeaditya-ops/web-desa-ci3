<div class="container-fluid">

<style>
.chart-pie,
.chart-bar {
    position: relative;
    height: 340px;
    width: 100%;
}

#myPieChart,
#myBarChart {
    width: 100% !important;
    height: 100% !important;
}

.shortcut-card {
    text-decoration: none;
    color: inherit;
}

.shortcut-card:hover {
    text-decoration: none;
    transform: translateY(-2px);
    transition: .2s;
}
</style>

<h1 class="h3 mb-4 text-gray-800">Dashboard Kadus</h1>

<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Surat
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?= (int)($jumlah_total_surat ?? 0) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Menunggu
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?= (int)($jumlah_menunggu ?? 0) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Disetujui
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?= (int)($jumlah_disetujui ?? 0) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    Ditolak
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?= (int)($jumlah_ditolak ?? 0) ?>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row mb-4">

    <div class="col-md-4 mb-3">
        <a href="<?= site_url('kadus/form_surat/131') ?>" class="shortcut-card">
            <div class="card shadow border-left-primary">
                <div class="card-body">
                    <i class="fas fa-plus-circle text-primary mr-2"></i>
                    Buat Surat Baru
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="<?= site_url('kadus/arsip') ?>" class="shortcut-card">
            <div class="card shadow border-left-success">
                <div class="card-body">
                    <i class="fas fa-folder-open text-success mr-2"></i>
                    Lihat Arsip Surat
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="<?= site_url('kadus/arsip') ?>" class="shortcut-card">
            <div class="card shadow border-left-warning">
                <div class="card-body">
                    <i class="fas fa-clock text-warning mr-2"></i>
                    Surat Menunggu
                </div>
            </div>
        </a>
    </div>

</div>

<div class="row">

    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Status Surat</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie">
                    <canvas id="myPieChart"></canvas>
                </div>

                <div class="mt-3 text-center small">

    <span class="mr-3">
        <i class="fas fa-circle text-warning"></i>
        Menunggu:
        <b><?= (int)($jumlah_menunggu ?? 0) ?></b>
    </span>

    <span class="mr-3">
        <i class="fas fa-circle text-success"></i>
        Disetujui:
        <b><?= (int)($jumlah_disetujui ?? 0) ?></b>
    </span>

    <span class="mr-3">
        <i class="fas fa-circle text-danger"></i>
        Ditolak:
        <b><?= (int)($jumlah_ditolak ?? 0) ?></b>
    </span>

</div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Surat Per Bulan</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>


</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // DATA PIE CHART
    // =========================

    const statusData = <?= json_encode($status_distribution ?? []); ?>;

    let statusMenunggu = 0;
    let statusDisetujui = 0;
    let statusDitolak = 0;

    statusData.forEach(function(item) {

        let status = String(item.status || '')
            .toLowerCase()
            .trim();

        let jumlah = parseInt(item.jumlah, 10) || 0;

        if (status === 'menunggu') {
            statusMenunggu = jumlah;

        } else if (status === 'disetujui') {
            statusDisetujui = jumlah;

        } else if (status === 'ditolak') {
            statusDitolak = jumlah;
        }
    });

    const totalSurat =
        statusMenunggu +
        statusDisetujui +
        statusDitolak;

    // =========================
    // TEXT TENGAH PIE
    // =========================

    const centerTextPlugin = {

        id: 'centerText',

        beforeDraw(chart) {

            const {
                width,
                height,
                ctx
            } = chart;

            ctx.restore();

            // ANGKA TOTAL
            ctx.font = 'bold 34px sans-serif';
            ctx.fillStyle = '#5a5c69';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            ctx.fillText(
                totalSurat,
                width / 2,
                height / 2 - 10
            );

            // TEXT TOTAL SURAT
            ctx.font = '15px sans-serif';
            ctx.fillStyle = '#858796';

            ctx.fillText(
                'Total Surat',
                width / 2,
                height / 2 + 20
            );

            ctx.save();
        }
    };

    // =========================
    // PIE CHART
    // =========================

    const pieCanvas = document.getElementById('myPieChart');

    if (pieCanvas) {

        new Chart(pieCanvas, {

            type: 'doughnut',

            data: {

                labels: [

                    'Menunggu (' + statusMenunggu + ')',

                    'Disetujui (' + statusDisetujui + ')',

                    'Ditolak (' + statusDitolak + ')'
                ],

                datasets: [{

                    data: [
                        statusMenunggu,
                        statusDisetujui,
                        statusDitolak
                    ],

                    backgroundColor: [
                        '#f6c23e',
                        '#1cc88a',
                        '#e74a3b'
                    ],

                    borderColor: '#ffffff',

                    borderWidth: 4,

                    hoverOffset: 0
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                animation: {
                    duration: 800
                },

                cutout: '72%',

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {
                        enabled: true
                    }
                }
            },

            plugins: [centerTextPlugin]
        });
    }

    // =========================
    // BAR CHART
    // =========================

    const bulanData = <?= json_encode($surat_per_bulan ?? []); ?>;

    const namaBulan = [
        'Jan', 'Feb', 'Mar', 'Apr',
        'Mei', 'Jun', 'Jul', 'Agu',
        'Sep', 'Okt', 'Nov', 'Des'
    ];

    let dataBulan = new Array(12).fill(0);

    bulanData.forEach(function(item) {

        let bulan = parseInt(item.bulan, 10);
        let jumlah = parseInt(item.jumlah, 10) || 0;

        if (bulan >= 1 && bulan <= 12) {
            dataBulan[bulan - 1] = jumlah;
        }
    });

    const barCanvas =
        document.getElementById('myBarChart');

    if (barCanvas) {

        new Chart(barCanvas, {

            type: 'bar',

            data: {

                labels: namaBulan,

                datasets: [{

                    label: 'Jumlah Surat',

                    data: dataBulan,

                    backgroundColor: '#4e73df',

                    borderRadius: 8,

                    borderSkipped: false
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }
                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

});
</script>