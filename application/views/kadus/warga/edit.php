<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Warga</h1>

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

    <div class="card shadow">
        <div class="card-body">

            <form action="<?= base_url('kadus/update/' . $warga->id) ?>" method="post">

                <div class="form-group">
                    <label>No KK</label>
                    <select name="keluarga_id" class="form-control">
                        <?php foreach ($keluarga as $k): ?>
                            <option value="<?= $k->id ?>" <?= $warga->keluarga_id == $k->id ? 'selected' : '' ?>>
                                <?= $k->no_kk ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="no_nik" class="form-control" value="<?= $warga->no_nik ?>">
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= $warga->nama ?>">
                </div>

                <div class="form-group">
                    <label>Hubungan Dalam KK</label>
                    <select name="hubungan_id" class="form-control" required>
                        <option value="">-- Pilih Hubungan --</option>
                        <?php foreach ($hubungan as $h): ?>
                            <option value="<?= $h->id ?>" <?= ($warga->hubungan_id == $h->id) ? 'selected' : '' ?>>
                                <?= $h->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin_id" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <?php foreach ($jenis_kelamin as $jk): ?>
                            <option value="<?= $jk->id ?>" <?= ($warga->jenis_kelamin_id == $jk->id) ? 'selected' : '' ?>>
                                <?= $jk->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Agama</label>
                    <select name="agama_id" class="form-control" required>
                        <option value="">-- Pilih Agama --</option>
                        <?php foreach ($agama as $a): ?>
                            <option value="<?= $a->id ?>" <?= ($warga->agama_id == $a->id) ? 'selected' : '' ?>>
                                <?= $a->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status Perkawinan</label>
                    <select name="status_perkawinan_id" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <?php foreach ($status_perkawinan as $sp): ?>
                            <option value="<?= $sp->id ?>" <?= ($warga->status_perkawinan_id == $sp->id) ? 'selected' : '' ?>>
                                <?= $sp->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kewarganegaraan</label>
                    <select name="kewarganegaraan_id" class="form-control" required>
                        <option value="">-- Pilih Kewarganegaraan --</option>
                        <?php foreach ($kewarganegaraan as $kw): ?>
                            <option value="<?= $kw->id ?>" <?= ($warga->kewarganegaraan_id == $kw->id) ? 'selected' : '' ?>>
                                <?= $kw->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pendidikan</label>
                    <select name="pendidikan_id" class="form-control" required>
                        <option value="">-- Pilih Pendidikan --</option>
                        <?php foreach ($pendidikan as $p): ?>
                            <option value="<?= $p->id ?>" <?= ($warga->pendidikan_id == $p->id) ? 'selected' : '' ?>>
                                <?= $p->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="<?= $warga->tempat_lahir ?>" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= $warga->tanggal_lahir ?>" required>
                </div>

                <div class="form-group">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="<?= $warga->pekerjaan ?>" required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <select name="id_keterangan" class="form-control">
                        <option value="">-- Pilih Keterangan --</option>
                        <?php foreach ($keterangan_list as $k): ?>
                            <option value="<?= $k->id_keterangan ?>" <?= ($warga->id_keterangan == $k->id_keterangan) ? 'selected' : '' ?>>
                                <?= $k->nama_keterangan ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Catatan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="3"><?= $warga->keterangan ?></textarea>
                </div>

                <button type="submit" class="btn btn-success"
                >Update</button>
                <a href="<?= base_url('warga') ?>" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>