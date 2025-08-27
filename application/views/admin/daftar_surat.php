<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengajuan Surat</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>
<div >
    <h3>Daftar Pengajuan Surat</h3>
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Surat</th>
                <th>Dusun</th>
                <th>Status</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($pengajuan)): ?>
                <?php foreach($pengajuan as $p): ?>
                    <tr>
                        <td><?= $p->id_pengajuan ?></td>
                        <td><?= $p->nik_warga ?></td>
                        <td><?= $p->nama_warga ?></td>
                        <td><?= ucfirst($p->jenis_surat) ?></td>
                        <td><?= $p->nama_dusun ?></td>
                        <td>
                            <?php if ($p->status == 'menunggu'): ?>
                                <span class="badge bg-warning">Menunggu</span>
                            <?php elseif ($p->status == 'disetujui'): ?>
                                <span class="badge bg-success">Disetujui</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Ditolak</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($p->file_surat)): ?>
                                <a href="<?= base_url('uploads/surat/'.$p->file_surat) ?>" target="_blank" class="btn btn-sm btn-info">Download</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($p->status == 'menunggu' && ($this->session->userdata('role')=='kades' || $this->session->userdata('role')=='admin')): ?>
                                <a href="<?= base_url('admin/konfirmasi/'.$p->id_pengajuan) ?>" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi surat ini?')">Konfirmasi</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">Belum ada pengajuan surat</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
