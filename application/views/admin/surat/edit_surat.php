<div class="container mt-4">
    <h4>Edit Template Surat</h4>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Surat</label>
            <input type="text" name="nama_surat" class="form-control" value="<?= $template->nama_surat ?>" required>
        </div>

        <div class="mb-3">
            <label>Nomor Surat</label>
            <input type="text" name="nomor_surat" class="form-control" value="<?= $template->nomor_surat ?>" required>
        </div>

        <div class="mb-3">
            <label>Dusun</label>
            <select name="dusun_id" class="form-control">
                <option value="">-- Pilih Dusun --</option>
                <?php foreach ($dusun as $d): ?>
                    <option value="<?= $d['id_dusun'] ?>" <?= ($d['id_dusun']==$template->dusun_id)?'selected':'' ?>>
                        <?= $d['nama_dusun'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Level Akses</label>
            <select name="level_akses" class="form-control">
                <option value="kadus" <?= ($template->level_akses=='kadus')?'selected':'' ?>>Kadus</option>
                <option value="admin" <?= ($template->level_akses=='admin')?'selected':'' ?>>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label>File Template (kosongkan jika tidak diubah)</label>
            <input type="file" name="file_template" class="form-control">
            <small>File sekarang: <?= $template->file_template ?></small>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= site_url('admin/template_surat') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
