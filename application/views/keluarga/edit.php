<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Keluarga</h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="<?= base_url('keluarga/update/' . $keluarga->id) ?>" method="post">

                <div class="form-group">
                    <label>No KK</label>
                    <input type="text" name="no_kk" class="form-control" value="<?= $keluarga->no_kk ?>" required>
                </div>

                <div class="form-group">
                    <label>Nama Kepala Keluarga</label>
                    <input type="text" name="nama_kepala_keluarga"
                        value="<?= $keluarga->nama_kepala_keluarga ?>"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Dusun</label>
                    <select name="id_dusun" class="form-control" required>
                        <?php foreach ($dusun as $d): ?>
                            <option value="<?= $d->id_dusun ?>" <?= $keluarga->id_dusun == $d->id_dusun ? 'selected' : '' ?>>
                                <?= $d->nama_dusun ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control"><?= $keluarga->alamat ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('keluarga') ?>" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>