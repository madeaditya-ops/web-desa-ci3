<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section>
    <div class="container-fluid">
        <div class="row bg-light px-4 py-3">
            <h4 class="fw-bold text-start m-0" style="color:var(--primary);">APBDes Tahun <?= $tahun ?></h4>
        </div>
    </div>

    <div class="container my-4">

        <form method="get" class="mb-4">
            <div class="d-flex gap-2">
                <select name="tahun" class="form-select w-auto">
                    <?php for($i=date('Y'); $i>=date('Y')-2; $i--): ?>
                        <option value="<?= $i ?>" <?= $tahun == $i ? 'selected' : '' ?>>
                            <?= $i ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <button class="btn btn-primary btn-sm">Tampilkan</button>
            </div>
        </form>

        <div class="row g-3 mb-4">
            <?php
            $summary = [
                ['Pendapatan', $pendapatan, 'primary'],
                ['Anggaran Belanja', $belanja, 'danger'],
                ['Realisasi', $realisasi, 'success'],
                ['SiLPA', $silpa, 'info']
            ];
            foreach($summary as $s):
            ?>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted"><?= $s[0] ?></small>
                            <h6 class="fw-bold text-<?= $s[2] ?> mb-0">
                                Rp <?= number_format($s[1], 0, ',', '.') ?>
                            </h6>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <canvas id="apbdesChart" height="120"></canvas>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Rincian APBDes</h6>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="50">No</th>
                                <th>Kategori</th>
                                <th>Uraian</th>
                                <th>Jumlah (Rp)</th>
                                <th>Sumber Dana</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1; 
                            $kategori = ''; 
                            $subtotal = 0;
                            
                            foreach($rincian as $r):
                                if($kategori != $r->kategori):
                                    if($kategori != ''):
                            ?>
                                        <tr class="fw-bold bg-light">
                                            <td colspan="3" class="text-end">Total <?= ucfirst($kategori) ?></td>
                                            <td><?= number_format($subtotal, 0, ',', '.') ?></td>
                                            <td></td>
                                        </tr>
                                    <?php 
                                    endif; 
                                    $kategori = $r->kategori; 
                                    $subtotal = 0; 
                                    ?>
                                    
                                    <tr class="table-secondary fw-bold">
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td colspan="4"><?= strtoupper($r->kategori) ?></td>
                                    </tr>
                            <?php 
                                endif; 
                                $subtotal += $r->jumlah; 
                            ?>
                                <tr>
                                    <td></td>
                                    <td><?= $r->bidang ?></td>
                                    <td><?= $r->uraian ?></td>
                                    <td><?= number_format($r->jumlah, 0, ',', '.') ?></td>
                                    <td><?= $r->sumber_dana ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="fw-bold bg-light">
                                <td colspan="3" class="text-end">Total <?= ucfirst($kategori) ?></td>
                                <td><?= number_format($subtotal, 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mt-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Rincian Realisasi Belanja Desa</h6>

        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Bidang</th>
                        <th>Uraian Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Realisasi (Rp)</th>
                        <th>Sumber Dana</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rincian_realisasi)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada realisasi belanja
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $no = 1;
                        $total_realisasi = 0;
                        foreach ($rincian_realisasi as $r):
                            $total_realisasi += $r->jumlah;
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $r->bidang ?></td>
                            <td><?= $r->uraian ?></td>
                            <td class="text-center">
                                <?= date('d-m-Y', strtotime($r->tanggal)) ?>
                            </td>
                            <td class="text-end">
                                <?= number_format($r->jumlah, 0, ',', '.') ?>
                            </td>
                            <td class="text-center"><?= $r->sumber_dana ?></td>
                            <td><?= $r->keterangan ?></td>
                        </tr>
                        <?php endforeach; ?>

                        <tr class="fw-bold bg-light">
                            <td colspan="4" class="text-end">Total Realisasi</td>
                            <td class="text-end">
                                <?= number_format($total_realisasi, 0, ',', '.') ?>
                            </td>
                            <!-- <td colspan="2"></td> -->
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    </div>

    <script>
        const ctx = document.getElementById('apbdesChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pendapatan', 'Anggaran Belanja', 'Realisasi', 'SiLPA'],
                datasets: [{
                    data: [
                        <?= $pendapatan ?>,
                        <?= $belanja ?>,
                        <?= $realisasi ?>,
                        <?= $silpa ?>
                    ],
                    backgroundColor: ['#0d6efd', '#dc3545', '#198754', '#0dcaf0'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
</section>