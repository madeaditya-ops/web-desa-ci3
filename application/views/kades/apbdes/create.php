<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Data APBDes Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Tambah Data</h6>
        </div>
        <div class="card-body">
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('apbdes/store') ?>" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="tahun">Tahun Anggaran</label>
                    <input type="number" name="tahun" id="tahun" class="form-control" 
                           placeholder="Contoh: 2024" value="<?= set_value('tahun') ?>">
                    <?= form_error('tahun', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="judul">Judul / Keterangan</label>
                    <input type="text" name="judul" id="judul" class="form-control" 
                           placeholder="Contoh: APBDes Perubahan 2024" value="<?= set_value('judul') ?>">
                    <?= form_error('judul', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label>File APBDes (pdf/jpg/jpeg/png/webp)</label>
                    <div class="custom-file">
                        <input type="file" name="file_apbdes" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Pilih file...</label>
                    </div>
                    <small class="form-text text-muted">File wajib diisi. Maksimal 2MB.</small>
                </div>

                <a href="<?= site_url('apbdes') ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>