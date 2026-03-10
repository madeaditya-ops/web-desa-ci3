<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Lembaga Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Tambah Lembaga</h6>
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

            <form action="<?= site_url('lembaga/store') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama Lembaga</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= set_value('nama') ?>" required>
                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="Deskripsi">deskripsi</label>
                    <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="<?= set_value('deskripsi') ?>" required>
                    <?= form_error('deskripsi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control-file">
                </div>

                <div class="form-group">
                    <label>Tipe Struktur</label>
                    <select name="tipe_struktur" class="form-control">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="anggota">Anggota</option>
                        <option value="bidang">Bidang</option>
                    </select>
                    <?= form_error('tipe_struktur', '<small class="text-danger">', '</small>') ?>
                </div>
                <a href="<?= site_url('lembaga') ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

</div>
