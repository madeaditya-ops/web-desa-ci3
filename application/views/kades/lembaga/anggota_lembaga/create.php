<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Anggota Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Anggota Lembaga</h6>
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

            <form action="<?= site_url('anggota_lembaga/store') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="lembaga_id" value="<?= $lembaga['id'] ?>"> 
            
                <div class="form-group">
                    <label for="nama">Nama Anggota</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= set_value('nama') ?>" required>
                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control" value="<?= set_value('jabatan') ?>" required>
                    <?= form_error('jabatan', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control-file">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif" selected>Aktif</option>
                        <option value="nonaktif">Non Aktif</option>
                    </select>
                    <?= form_error('tipe_struktur', '<small class="text-danger">', '</small>') ?>
                </div>
                <a href="<?= site_url('anggota_lembaga/'.$lembaga['id']) ?>" 
                    class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

</div>
