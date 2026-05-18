<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Verifikasi Selesai</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Verifikasi Selesai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Banjar</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($selesai as $s): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $s->nama ?></td>
                                <td><?= $s->nik ?></td>
                                <td><?= $s->banjar ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($s->created_at)) ?></td>
                                <td class="text-center">
                                    <?php if ($s->status == 'menunggu'): ?>

                                        <span class="badge badge-warning">Menunggu</span>

                                    <?php elseif ($s->status == 'disetujui'): ?>

                                        <span class="badge badge-success">Disetujui</span>
                                        <br>

                                        <?php if ($s->status_ambil == 'sudah'): ?>

                                            <span class="badge badge-primary mt-1">
                                                Sudah diambil
                                            </span>

                                            <br>
                                            <small class="text-muted">
                                                <?= !empty($s->tanggal_ambil)
                                                    ? date('d-m-Y H:i', strtotime($s->tanggal_ambil))
                                                    : '-' ?>
                                                <br>
                                                Oleh: <?= htmlspecialchars($s->diambil_oleh ?? '-') ?>
                                            </small>

                                        <?php else: ?>

                                            <span class="badge badge-danger mt-1">
                                                Belum diambil
                                            </span>

                                        <?php endif; ?>

                                    <?php else: ?>

                                        <span class="badge badge-danger">Ditolak</span>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>