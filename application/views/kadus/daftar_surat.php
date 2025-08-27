<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengajuan Surat</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

    <h3>Daftar Pengajuan Surat</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Surat</th>
                <th>Dusun</th>
                <th>Status</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pengajuan as $p): ?>
                <tr>
                    <td><?= $p->id_pengajuan ?></td>
                    <td><?= $p->nik_warga ?></td>
                    <td><?= $p->nama_warga ?></td>
                    <td><?= $p->jenis_surat ?></td>
                    <td><?= $p->nama_dusun ?></td>
                    <td>
                        <?php if ($p->status == 'menunggu'): ?>
                            <span class="badge bg-warning">Menunggu</span>
                        <?php elseif ($p->status == 'disetujui'): ?>
                            <span class="badge bg-success">Disetujui</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Ditolak</span>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if ($p->file_surat): ?>
                            <a href="<?= base_url('uploads/surat/'.$p->file_surat) ?>" target="_blank" class="btn btn-sm btn-info">Download</a>
                        <?php else: ?>
                            -
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</body>
</html>
