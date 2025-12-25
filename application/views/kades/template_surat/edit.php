<!-- views/kades/template_surat/edit.php -->

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Template Surat</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Template</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('template_surat/update/'.$template->id_template) ?>" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="nama_surat">Nama Surat</label>
                    <input type="text" name="nama_surat" id="nama_surat" class="form-control" value="<?= set_value('nama_surat', $template->nama_surat) ?>" required>
                    <?= form_error('nama_surat', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="file_template">File Template (docx/pdf)</label>
                    <input type="file" name="file_template" id="file_template" class="form-control-file">
                    <small class="form-text text-muted">File saat ini: 
                        <a href="<?= base_url('uploads/template_surat/' . $template->file_template) ?>" target="_blank">
                            <?= htmlspecialchars($template->file_template, ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </small>
                    <small class="form-text text-danger">Kosongkan jika tidak ingin mengubah file.</small>
                </div>

                <div class="form-group">
                    <label for="level_akses">Level Akses</label>
                    <select name="level_akses" id="level_akses" class="form-control" required>
                        <option value="">-- Pilih Level Akses --</option>
                        <option value="admin" <?= set_select('level_akses', 'admin', $template->level_akses == 'admin') ?>>Admin</option>
                        <option value="kadus" <?= set_select('level_akses', 'kadus', $template->level_akses == 'kadus') ?>>Kadus</option>
                    </select>
                    <?= form_error('level_akses', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="dusun_id">Khusus Dusun (Opsional)</label>
                    <select name="dusun_id" id="dusun_id" class="form-control">
                        <option value="">-- Semua Dusun --</option>
                        <?php foreach($dusun as $d): ?>
                            <option value="<?= $d->id_dusun ?>" <?= set_select('dusun_id', $d->id_dusun, $template->dusun_id == $d->id_dusun) ?>>
                                <?= htmlspecialchars($d->nama_dusun, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                     <small class="form-text text-muted">Jika dikosongkan, template ini berlaku untuk semua dusun.</small>
                </div>

                <a href="<?= site_url('template_surat') ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
