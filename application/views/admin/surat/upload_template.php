<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Template Surat</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Upload Template Surat</h6>
        </div>
        <div class="card-body">
            
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

            <form action="<?= site_url('admin/upload_template') ?>" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="nama_surat">Nama Surat</label>
                    <input type="text" name="nama_surat" id="nama_surat" class="form-control" 
                           value="<?= set_value('nama_surat') ?>" required>
                    <?= form_error('nama_surat', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="file_template">File Template (Word)</label>
                    <div class="custom-file">
                        <input type="file" name="file_template" class="custom-file-input" id="customFile" required>
                        <label class="custom-file-label" for="customFile">Pilih file .doc/.docx...</label>
                    </div>
                    <small class="form-text text-muted">
                        Wajib file Word (.doc/.docx). Maksimal 5MB.
                    </small>
                </div>

                <div class="form-group">
                    <label for="level_akses">Level Akses</label>
                    <select name="level_akses" id="level_akses" class="form-control" required>
                        <option value="">-- Pilih Level Akses --</option>
                        <option value="kadus" <?= set_select('level_akses', 'kadus') ?>>Kadus</option>
                        <option value="admin" <?= set_select('level_akses', 'admin') ?>>Admin</option>
                    </select>
                </div>

                <div class="form-group">
    <label for="dusun_id">Pilih Dusun</label>
    <select name="dusun_id" id="dusun_id" class="form-control">
        <option value="">-- Pilih Dusun --</option>
        <?php if (!empty($dusun)): ?>
            <?php foreach ($dusun as $d): ?>
                <option value="<?= $d->id_dusun ?>" <?= set_select('dusun_id', $d->id_dusun) ?>>
                    <?= htmlspecialchars($d->nama_dusun, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">Data dusun tidak tersedia</option>
        <?php endif; ?>
    </select>
</div>


                <a href="<?= site_url('admin/daftar_surat') ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

</div>

<script>
    // Script untuk menampilkan nama file pada custom file input
    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    })
</script>
