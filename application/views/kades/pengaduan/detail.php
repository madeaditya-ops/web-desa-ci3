<style>

.timeline {
    list-style: none;
    padding-left: 0;
    margin: 0;
}


.timeline li {
    position: relative;
    padding-left: 40px;
    margin-bottom: 30px;
}


.timeline li::before {
    content: '';
    position: absolute;
    left: 9px;
    top: 0;
    width: 2px;
    height: calc(100% + 30px); 
    background: #e3e6f0;
}


.timeline li:last-child::before {
    display: none;
}


.timeline .dot {
    position: absolute;
    left: 0;
    top: 0;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #e3e6f0;
    border: 2px solid #e3e6f0;
    z-index: 2;
}


.timeline .content {
    font-size: 15px;
    color: #858796;
    line-height: 1.4;
}


.timeline li.active .dot {
    background: #1cc88a;
    border-color: #1cc88a;
}

.timeline li.active::before {
    background: #1cc88a;
}

.timeline li.active .content {
    color: #1cc88a;
    font-weight: 600;
}


.timeline li.rejected .dot {
    background: #e74a3b;
    border-color: #e74a3b;
}

.timeline li.rejected::before {
    background: #e74a3b;
}

.timeline li.rejected .content {
    color: #e74a3b;
    font-weight: 600;
}


.timeline small {
    font-size: 12px;
    display: block;
    margin-top: 4px;
}


@media (max-width: 576px) {
    .timeline li {
        padding-left: 35px;
    }

    .timeline .dot {
        width: 14px;
        height: 14px;
    }

    .timeline li::before {
        left: 7px;
    }
}
</style>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengaduan</h1>
        <a href="<?= site_url('pengaduan_kades') ?>" 
           class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

    <div class="row">

        <!-- INFORMASI PENGADUAN -->
        <div class="col-lg-8">

            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    Informasi Pengaduan
                </div>


                <div class="card-body">

                    <table class="table table-borderless">
                        <tr>
                            <th>Id Pengaduan</th>
                            <td><?= $pengaduan->id_pengaduan ?? '-' ?></td>
                        </tr>
                        <tr>
                            <th>Nama Pelapor</th>
                            <td><?= $pengaduan->nama_pelapor ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $pengaduan->email_pelapor ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td><?= date('d-m-Y', strtotime($pengaduan->created_at)) ?></td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td><?= $pengaduan->lokasi_pengaduan ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php
                                $status = $pengaduan->status;

                                if ($status == 'pending') {
                                    echo '<span class="badge badge-warning">Pending</span>';
                                } elseif ($status == 'diproses') {
                                    echo '<span class="badge badge-primary">Diproses</span>';
                                } elseif ($status == 'ditolak') {
                                    echo '<span class="badge badge-danger">Ditolak</span>';
                                } elseif ($status == 'selesai') {
                                    echo '<span class="badge badge-success">Selesai</span>';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>

                    <hr>

                    <h6 class="font-weight-bold">Deskripsi Pengaduan</h6>
                    <p><?= nl2br($pengaduan->deskripsi) ?></p>

                    <?php if (!empty($pengaduan->foto_bukti)) : ?>
                        <hr>
                        <h6 class="font-weight-bold">Foto Laporan</h6>
                        <img src="<?= base_url('uploads/pengaduan/'.$pengaduan->foto_bukti) ?>" 
                             class="img-fluid rounded shadow"
                             style="max-height:400px;">
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- PANEL VERIFIKASI -->
        <div class="col-lg-4">

            <!-- Timeline Status -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Progress Status</h6>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="active">
                            <div class="dot"></div>
                            <div class="content">Pengaduan Dibuat</div>
                        </li>

                        <li class="<?= in_array($pengaduan->status, ['diproses','ditolak','selesai']) ? 'active' : '' ?>">
                            <div class="dot"></div>
                            <div class="content">
                                Diverifikasi
                                <?php if($pengaduan->status == 'ditolak'): ?>
                                    <small class="text-danger d-block">Pengaduan Ditolak</small>
                                <?php endif; ?>
                            </div>
                        </li>

                        <li class="<?= in_array($pengaduan->status, ['diproses','selesai']) ? 'active' : '' ?>">
                            <div class="dot"></div>
                            <div class="content">Diproses</div>
                        </li>

                        <li class="<?= ($pengaduan->status == 'selesai') ? 'active' : '' ?>">
                            <div class="dot"></div>
                            <div class="content">Selesai</div>
                        </li>

                    </ul>
                </div>
            </div>

            <!-- Jika Status Pending -->
            <?php if ($status == 'pending') : ?>

                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-dark">
                        Verifikasi Pengaduan
                    </div>

                    <div class="card-body">

                        <form method="post" action="<?= site_url('pengaduan_kades/verifikasi/'.$pengaduan->id_pengaduan) ?>">

                            <button type="submit" name="aksi" value="proses" class="btn btn-primary btn-block mb-3">
                                <i class="fas fa-check"></i> Setujui & Proses
                            </button>

                            <hr>

                            <div class="form-group">
                                <label>Catatan Penolakan</label>
                                <textarea name="keterangan_verifikasi" 
                                          class="form-control"
                                          rows="3"></textarea>
                            </div>

                            <button type="submit" 
                                    name="aksi" 
                                    value="tolak"
                                    class="btn btn-danger btn-block">
                                <i class="fas fa-times"></i> Tolak Pengaduan
                            </button>

                        </form>

                    </div>
                </div>

            <?php endif; ?>

            <!-- Jika Status Diproses -->
            <?php if ($status == 'diproses') : ?>

                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        Selesaikan Pengaduan
                    </div>

                    <div class="card-body">

                        <form method="post" 
                              enctype="multipart/form-data"
                              action="<?= site_url('pengaduan_kades/selesai/'.$pengaduan->id_pengaduan) ?>">

                            <div class="form-group">
                                <label>Upload Bukti Penyelesaian</label>
                                <input type="file" 
                                       name="foto_tindaklanjut" 
                                       class="form-control" >
                            </div>

                            <button type="submit" 
                                    class="btn btn-success btn-block">
                                <i class="fas fa-check-circle"></i> Tandai Selesai
                            </button>

                        </form>

                    </div>
                </div>

            <?php endif; ?>

            <!-- Jika Ditolak -->
            <?php if ($status == 'ditolak') : ?>
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger text-white">
                        Catatan Penolakan
                    </div>
                    <div class="card-body">
                        <?= nl2br($pengaduan->keterangan_verifikasi) ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($pengaduan->foto_tindaklanjut)) : ?>
                <hr>
                <h6 class="font-weight-bold">Foto Tindak Lanjut</h6>
                <img src="<?= base_url('uploads/pengaduan_tindaklanjut/'.$pengaduan->foto_tindaklanjut) ?>" 
                    class="img-fluid rounded shadow"
                    style="max-height:400px;">
            <?php endif; ?>

        </div>
    </div>

</div>





