<div class="container mt-4">
    <h4>Daftar Template Surat</h4>

    <a href="<?= site_url('admin/upload_template') ?>" class="btn btn-primary mb-3">Upload Template Baru</a>

    <!-- Form Search & Filter -->
   <form method="get" action="">
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="nama_surat" class="form-control" 
                   placeholder="Cari Nama Surat..." 
                   value="<?= $this->input->get('nama_surat') ?>">
        </div>
        <div class="col-md-4">
            <select name="dusun_id" class="form-control">
                <option value="">-- Filter Dusun --</option>
                <?php foreach($dusun_list as $d): ?>
                    <option value="<?= $d->id_dusun ?>" 
                        <?= ($this->input->get('dusun_id')==$d->id_dusun)?'selected':'' ?>>
                        <?= $d->nama_dusun ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter / Search</button>
            <a href="<?= site_url('admin/template_surat') ?>" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>


    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Surat</th>
                <th>Nomor Surat</th>
                <th>Dusun</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($templates as $t): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $t->nama_surat ?></td>
                <td><?= $t->nomor_surat ?></td>
                <td><?= $t->nama_dusun ?? '-' ?></td>
                <td>
                    <a href="ms-word:ofe|u|<?= base_url('uploads/template_surat/'.$t->file_template) ?>"class="btn btn-sm btn-info">Lihat</a>
                    <a href="<?= base_url('uploads/template_surat/'.$t->file_template) ?>" download class="btn btn-sm btn-success">Download</a>
                </td>
                <td>
                   <a href="<?= site_url('admin/edit_surat/'.$t->id_template) ?>" class="btn btn-sm btn-warning">Edit</a>
                   <a href="<?= site_url('admin/delete_surat/'.$t->id_template) ?>" 
                      onclick="return confirm('Yakin ingin menghapus template ini?')" 
                      class="btn btn-sm btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

