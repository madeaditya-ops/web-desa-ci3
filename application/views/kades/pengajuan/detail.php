<!-- views/kades/pengajuan/detail.php -->

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengajuan Surat</h1>
        <a href="<?= site_url('pengajuan/kades') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <!-- Informasi Pengajuan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengajuan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Jenis Surat:</strong> <?= htmlspecialchars($pengajuan->nama_surat) ?></p>
                            <p><strong>Tanggal Pengajuan:</strong> <?= date('d/m/Y H:i', strtotime($pengajuan->created_at)) ?></p>
                            <p><strong>Status:</strong>
                                <span class="badge badge-warning">Diajukan</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Pemohon:</strong> <?= htmlspecialchars($pengajuan->username) ?></p>
                            <p><strong>Updated:</strong> <?= date('d/m/Y H:i', strtotime($pengajuan->updated_at)) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pemohon -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pemohon</h6>
                </div>
                <div class="card-body">
                    <?php $data_pemohon = json_decode($pengajuan->data_pemohon); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> <?= htmlspecialchars($data_pemohon->nama ?? '-') ?></p>
                            <p><strong>NIK:</strong> <?= htmlspecialchars($data_pemohon->nik ?? '-') ?></p>
                            <p><strong>Tempat Lahir:</strong> <?= htmlspecialchars($data_pemohon->tempat_lahir ?? '-') ?></p>
                            <p><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($data_pemohon->tanggal_lahir ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Alamat:</strong> <?= htmlspecialchars($data_pemohon->alamat ?? '-') ?></p>
                            <p><strong>No. HP:</strong> <?= htmlspecialchars($data_pemohon->no_hp ?? '-') ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($data_pemohon->email ?? '-') ?></p>
                            <p><strong>Pekerjaan:</strong> <?= htmlspecialchars($data_pemohon->pekerjaan ?? '-') ?></p>
                        </div>
                    </div>
                    <?php if (!empty($data_pemohon->keterangan)): ?>
                        <div class="mt-3">
                            <strong>Keterangan:</strong>
                            <p><?= nl2br(htmlspecialchars($data_pemohon->keterangan)) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Berkas Upload -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Berkas Upload</h6>
                </div>
                <div class="card-body">
                    <?php
                    $uploaded_files = json_decode($pengajuan->uploaded_files);
                    if (!empty($uploaded_files)):
                    ?>
                        <ul class="list-group">
                            <?php foreach ($uploaded_files as $file): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($file) ?>
                                    <a href="<?= base_url('uploads/surat/' . $file) ?>" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada berkas yang diupload</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Aksi Verifikasi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Verifikasi Pengajuan</h6>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('pengajuan/kades/approve/' . $pengajuan->id_pengajuan) ?>" method="post" class="mb-3">
                        <div class="form-group">
                            <label for="approve_notes">Catatan (Opsional)</label>
                            <textarea class="form-control" id="approve_notes" name="notes" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-check"></i> Setujui Pengajuan
                        </button>
                    </form>

                    <form action="<?= site_url('pengajuan/kades/reject/' . $pengajuan->id_pengajuan) ?>" method="post">
                        <div class="form-group">
                            <label for="reject_notes">Alasan Penolakan *</label>
                            <textarea class="form-control" id="reject_notes" name="notes" rows="3" placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-times"></i> Tolak Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
