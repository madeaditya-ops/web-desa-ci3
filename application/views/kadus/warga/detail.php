<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail Warga</h1>

    <div class="row">

        <!-- PROFIL WARGA -->
        <div class="col-lg-4">

            <div class="card shadow mb-4 border-left-primary">

                <div class="card-body text-center">

                    <img
                        src="<?= base_url('uploads/foto_warga/defult.png' . $warga->foto) ?>"
                        class="img-fluid rounded mb-2"
                        width="100">

                    <h4 class="font-weight-bold"><?= $warga->nama ?></h4>
                    <p class="text-muted fas fa-id-card text-primary "> Nik : <?= $warga->no_nik ?></p>

                    <hr>

                    <div class="text-left">

                        <p><i class="fas fa-home text-primary"></i>
                            <b>Banjar : </b> <?= $warga->nama_dusun ?>
                        </p>

                        <p><i class="fas fa-id-card text-primary"></i>
                            <b>No KK :</b> <?= $warga->no_kk ?>
                        </p>

                        <p><i class="fas fa-birthday-cake text-primary"></i>
                            <b>Tgl Lahir :</b> <?= date('d-m-Y', strtotime($warga->tanggal_lahir)) ?>
                        </p>

                        <p><i class="fas fa-map-marker-alt text-primary"></i>
                            <b> Tempat Lahir :</b> <?= $warga->tempat_lahir ?>
                        </p>
                        <p>
                            <i class="fas fa-user-clock text-primary"></i>
                            <b>Umur :</b>
                            <?php
                            if ($warga->tanggal_lahir) {
                                $tgl_lahir = new DateTime($warga->tanggal_lahir);
                                $today = new DateTime();
                                $umur = $today->diff($tgl_lahir)->y;
                                echo $umur . ' Tahun';
                            } else {
                                echo '-';
                            }
                            ?>
                        </p>
                        <p><i class="fas fa-venus-mars text-primary"></i>
                            <b>Jenis Kelamin :</b> <?= $warga->jenis_kelamin ?>
                        </p>

                        <p><i class="fas fa-pray text-primary"></i>
                            <b>Agama :</b> <?= $warga->agama ?>
                        </p>

                        <p><i class="fas fa-ring text-primary"></i>
                            <b>Status :</b> <?= $warga->status_kawin ?>
                        </p>

                        <p><i class="fas fa-info-circle text-primary"></i>
                            <b>Keterangan :</b> <?= $warga->nama_keterangan?>
                        </p>

                        <p><i class="fas fa-briefcase text-primary"></i>
                            <b>Pekerjaan :</b> <?= $warga->pekerjaan ?>
                        </p>
                        <a href="<?= base_url('kadus/edit/' . $warga->id) ?>" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-20">
                                <i class="fas fa-edit"></i> Edit
                            </span>
                        </a>
                         <a href="<?= base_url('kadus/detail/' . $warga->keluarga_id) ?>" class="btn btn-secondary">Kembali ke keluarga</a>
                         <a href="<?= base_url('kadus/data_warga') ?>" class="btn btn-danger">Kembali</a>
                    </div>

                </div>

            </div>
        </div>


        <!-- RIWAYAT SURAT -->
        <div class="col-lg-8">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt"></i> Riwayat Surat
                    </h6>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">

                            <thead class="text-center">

                                <tr>
                                    <th width="50">No</th>
                                    <th>Jenis Surat</th>
                                    <th>Tujuan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th width="120">Aksi</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php if ($riwayat_surat): ?>
                                    <?php $no = 1;
                                    foreach ($riwayat_surat as $s): ?>

                                        <tr>

                                            <td><?= $no++ ?></td>

                                            <td>
                                                <b><?= $s->nama_surat ?></b>
                                            </td>

                                            <td><?= $s->tujuan ?></td>

                                            <td>

                                                <?php if ($s->status == 'menunggu'): ?>

                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock"></i> Menunggu
                                                    </span>

                                                <?php elseif ($s->status == 'disetujui'): ?>

                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check"></i> Disetujui
                                                    </span>

                                                <?php else: ?>

                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times"></i> Ditolak
                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                            <td>
                                                <?= date('d-m-Y', strtotime($s->created_at)) ?>
                                            </td>
                                            <td>
                                                <a href="<?= site_url('warga/download_surat/' . $s->id) ?>"
                                                    class="btn btn-success btn-sm">

                                                    <i class="fas fa-cloud-download-alt"></i>

                                                </a>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            <i class="fas fa-info-circle"></i> Warga ini belum pernah membuat surat
                                        </td>
                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt"></i> Bantuan Desa
                    </h6>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">

                            <thead class="text-center">

                                <tr>
                                    <th width="50">No</th>
                                    <th>Jenis Surat</th>
                                    <th>Tujuan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th width="120">Aksi</th>
                                </tr>

                            </thead>

                            <tbody>

                              

                                        <tr>

                                            
                                              
                                            </td>

                                          

                                        </tr>


                               

                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            <i class="fas fa-info-circle"></i> Belum ada data bantuan untuk warga ini
                                        </td>
                                    </tr>

                               

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
            

        </div>
        

    </div>
</div>