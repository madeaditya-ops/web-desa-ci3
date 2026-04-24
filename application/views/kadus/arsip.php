<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Arsip Pengajuan Surat</h1>
    <p class="mb-4">Daftar surat yang telah Anda buat. File tersimpan di server dan siap diunduh kapan saja.</p>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Surat Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Tanggal</th>
                            <th>Nama Warga</th>
                            <th>Nomor Pengantar</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($arsip as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($a->created_at)) ?></td>
                            <td><?= htmlspecialchars($a->nama) ?></td>
                            <td><?= htmlspecialchars($a->nomor_pengantar) ?></td>
                            <td><?= htmlspecialchars($a->judul) ?></td>
                            <td class="text-center">
                                <?php if($a->status == 'menunggu'): ?>
                                    <span class="badge badge-warning">Menunggu</span>
                                <?php elseif($a->status == 'ditolak'): ?>
                                    <span class="badge badge-danger">Ditolak</span>
                                <?php elseif($a->status == 'setuju'): ?>
                                    <span class="badge badge-success">Disetujui</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= ucfirst($a->status) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('kadus/download_arsip/'.$a->id) ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($arsip)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data pengajuan surat.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>