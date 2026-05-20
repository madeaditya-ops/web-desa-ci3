<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Keluarga</h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="<?= base_url('kadus/update_kk/' . $keluarga->id) ?>" method="post">

                <div class="form-group">
                    <label>No KK</label>
                    <input type="text" name="no_kk" class="form-control"
                        value="<?= $keluarga->no_kk ?>" required
                        maxlength="16"
                        pattern="[0-9]{16}"
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16)">
                </div>

                <div class="form-group">
                    <label>Nama Kepala Keluarga</label>
                    <input type="text" name="nama_kepala"
                        value="<?= isset($kepala) ? $kepala->nama : $keluarga->nama_kepala_keluarga ?>"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label>NIK Kepala Keluarga</label>
                    <input type="text" name="nik_kepala" class="form-control"
                        value="<?= isset($kepala) ? $kepala->no_nik : '' ?>"
                        required
                        maxlength="16"
                        pattern="[0-9]{16}"
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16)">
                </div>

                <div class="form-group">
                    <label>Dusun</label>
                    <select name="id_dusun" id="dusun" class="form-control" required>
                        <?php foreach ($dusun as $d): ?>
                            <option value="<?= $d->id_dusun ?>" <?= $keluarga->id_dusun == $d->id_dusun ? 'selected' : '' ?>>
                                <?= $d->nama_dusun ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control"><?= $keluarga->alamat ?></textarea>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin Kepala</label>
                    <select name="jk_kepala" class="form-control" required>
                        <option value="1" <?= (isset($kepala) && $kepala->jenis_kelamin_id == 1) ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="2" <?= (isset($kepala) && $kepala->jenis_kelamin_id == 2) ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Agama Kepala</label>
                    <select name="agama_kepala" class="form-control" required>
                        <option value="">-- Pilih Agama --</option>
                        <?php foreach ($agama as $a): ?>
                            <option value="<?= $a->id ?>" <?= (isset($kepala) && $kepala->agama_id == $a->id) ? 'selected' : '' ?>>
                                <?= $a->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status Perkawinan Kepala</label>
                    <select name="status_kepala" class="form-control" required>
                        <option value="">-- Pilih Status Perkawinan --</option>
                        <?php foreach ($status_perkawinan as $s): ?>
                            <option value="<?= $s->id ?>" <?= (isset($kepala) && $kepala->status_perkawinan_id == $s->id) ? 'selected' : '' ?>>
                                <?= $s->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kewarganegaraan Kepala</label>
                    <select name="kewarganegaraan_kepala" class="form-control" required>
                        <option value="">-- Pilih Kewarganegaraan --</option>
                        <?php foreach ($kewarganegaraan as $k): ?>
                            <option value="<?= $k->id ?>" <?= (isset($kepala) && $kepala->kewarganegaraan_id == $k->id) ? 'selected' : '' ?>>
                                <?= $k->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pendidikan Kepala</label>
                    <select name="pendidikan_kepala" class="form-control" required>
                        <option value="">-- Pilih Pendidikan --</option>
                        <?php foreach ($pendidikan as $p): ?>
                            <option value="<?= $p->id ?>" <?= (isset($kepala) && $kepala->pendidikan_id == $p->id) ? 'selected' : '' ?>>
                                <?= $p->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tempat Lahir Kepala</label>
                    <input type="text" name="tempat_lahir_kepala" class="form-control"
                        value="<?= isset($kepala) ? $kepala->tempat_lahir : '' ?>">
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir Kepala</label>
                    <input type="date" name="tanggal_lahir_kepala" class="form-control"
                        value="<?= isset($kepala) ? $kepala->tanggal_lahir : '' ?>">
                </div>

                <div class="form-group">
                    <label>Pekerjaan Kepala</label>
                    <input type="text" name="pekerjaan_kepala" class="form-control"
                        value="<?= isset($kepala) ? $kepala->pekerjaan : '' ?>">
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('kadus/jumlah_kk') ?>" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('dusun').addEventListener('change', function() {
        let selectedText = this.options[this.selectedIndex].text;

        if (selectedText !== '') {
            document.getElementById('alamat').value =
                "Br. " + selectedText + " /Kec. Blahbatuh Kab. Gianyar";
        }
    });
</script>