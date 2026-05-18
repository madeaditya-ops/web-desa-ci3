<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Bidang Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Bidang Lembaga</h6>
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

            <form action="<?= site_url('bidang_lembaga/store') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="lembaga_id" value="<?= $lembaga['id'] ?>"> 
            
                <div class="form-group">
                    <label for="nama_bidang">Nama Bidang</label>
                    <input type="text" name="nama_bidang" id="nama_bidang" class="form-control" value="<?= set_value('nama_bidang') ?>" required>
                    <?= form_error('nama_bidang', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"><?= set_value('deskripsi'); ?></textarea>
                    <?= form_error('deskripsi', '<small class="text-danger">', '</small>'); ?>
                </div>


                <a href="<?= site_url('bidang_lembaga/'.$lembaga['id']) ?>" 
                    class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

</div>
