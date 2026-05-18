<div class="container-fluid">
    <h1 class="h3 mb-4">Tambah Warga</h1>

    
    <div class="card shadow">
        <div class="card-body">

            <form action="<?= base_url('warga/simpan') ?>" method="post">

                <div class="form-group">
                    <label>No KK</label>
                    <select name="keluarga_id" class="form-control" required>
                        <option value="">-- Pilih Keluarga --</option>
                        <?php foreach($keluarga as $k): ?>
                            <option value="<?= $k->id ?>">
                                <?= $k->no_kk  ?> - <?= $k->nama_kepala_keluarga ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="no_nik" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Hubungan Dalam KK</label>
                    <select name="hubungan_id" class="form-control" required>
                        <option value="">-- Pilih Hubungan --</option>
                        <?php foreach($hubungan as $h): ?>
                            <option value="<?= $h->id ?>">
                                <?= $h->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin_id" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <?php foreach($jenis_kelamin as $jk): ?>
                            <option value="<?= $jk->id ?>">
                                <?= $jk->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Agama</label>
                    <select name="agama_id" class="form-control" required>
                        <option value="">-- Pilih Agama --</option>
                        <?php foreach($agama as $a): ?>
                            <option value="<?= $a->id ?>">
                                <?= $a->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status Perkawinan</label>
                    <select name="status_perkawinan_id" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <?php foreach($status_perkawinan as $sp): ?>
                            <option value="<?= $sp->id ?>">
                                <?= $sp->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kewarganegaraan</label>
                    <select name="kewarganegaraan_id" class="form-control" required>
                        <option value="">-- Pilih Kewarganegaraan --</option>
                        <?php foreach($kewarganegaraan as $kw): ?>
                            <option value="<?= $kw->id ?>">
                                <?= $kw->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pendidikan</label>
                    <select name="pendidikan_id" class="form-control" required>
                        <option value="">-- Pilih Pendidikan --</option>
                        <?php foreach($pendidikan as $p): ?>
                            <option value="<?= $p->id ?>">
                                <?= $p->nama ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?= base_url('warga') ?>" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>
