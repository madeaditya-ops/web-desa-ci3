<section>
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

        .small-muted { color: white; font-size: .9rem; }
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

    </div>
</section>