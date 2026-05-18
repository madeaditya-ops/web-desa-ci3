<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Bidang</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Bidang</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('bidang_lembaga/update/'.$bidang['id']) ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="lembaga_id" value="<?= $bidang['lembaga_id'] ?>"> 

                <div class="form-group">
                    <label for="nama_bidang">Nama Bidang</label>
                    <input type="text" name="nama_bidang" id="nama_bidang" class="form-control" 
                           value="<?= $bidang['nama_bidang']?>" required>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" required><?= set_value('deskripsi', $bidang['deskripsi']); ?></textarea>
                    <?= form_error('deskripsi', '<small class="text-danger">', '</small>'); ?>
                </div>
                

                <a href="<?= site_url('bidang_lembaga/'.$bidang['lembaga_id']) ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>


