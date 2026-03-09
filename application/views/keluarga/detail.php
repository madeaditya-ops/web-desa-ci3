<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header text-center">

            <h4>KARTU KELUARGA</h4>

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-6">
                    <b>No KK :</b> <?= $keluarga->no_kk ?>
                </div>

                <div class="col-md-6">
                    <b>Kepala Keluarga :</b> <?= $keluarga->nama_kepala_keluarga ?>
                </div>

                <div class="col-md-6">
                    <b>Dusun :</b> <?= $keluarga->nama_dusun ?>
                </div>

                <div class="col-md-6">
                    <b>Alamat :</b> <?= $keluarga->alamat ?>
                </div>

            </div>

            <hr>

            <table class="table table-bordered">

                <thead class="text-center">

                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Hubungan</th>
                        <th>JK</th>
                        <th>Tanggal Lahir</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php $no = 1;
                    foreach ($anggota as $a): ?>

                        <tr>

                            <td><?= $no++ ?></td>

                            <td class="text-center">

                                <?php if ($a->foto): ?>

                                    <img src="<?= base_url('uploads/foto_warga/' . $a->foto) ?>" width="60">

                                <?php else: ?>

                                    <img src="<?= base_url('uploads/foto_warga/default.png') ?>" width="60">

                                <?php endif ?>

                            </td>

                            <td><?= $a->no_nik ?></td>

                            <td><?= $a->nama ?></td>

                            <td><?= $a->hubungan ?></td>

                            <td><?= $a->jenis_kelamin_id == 1 ? 'Laki-laki' : 'Perempuan' ?></td>

                            <td><?= $a->tanggal_lahir ?></td>

                            <td class="text-center">

                            

                                <a href="<?= base_url('keluarga/edit_foto/' . $a->id) ?>"
                                    class="btn btn-warning btn-sm">

                                    Edit Foto

                                </a>

                                <a href="<?= base_url('keluarga/delete/' . $a->id) ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus anggota keluarga ini?')">

                                    Hapus

                                </a>

                            </td>

                        </tr>

                    <?php endforeach ?>

                </tbody>

            </table>

            <a href="<?= base_url('keluarga') ?>"
                class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </div>

</div>