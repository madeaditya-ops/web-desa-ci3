<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Peraturan Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Tambah Peraturan</h6>
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

            <form action="<?= site_url('peraturan/store') ?>" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="judul">Judul Peraturan</label>
                    <input type="text" name="judul" id="judul" class="form-control" value="<?= set_value('judul') ?>">
                    <?= form_error('judul', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label>File Peraturan</label>
                    <div class="custom-file">
                        <input type="file" name="file_peraturan" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Pilih file...</label>
                    </div>
                    <small class="form-text text-muted">File wajib diisi. Tipe file: docx, pdf. Ukuran maks: 2MB.</small>
                    </div>

                <a href="<?= site_url('peraturan') ?>" class="btn btn-secondary">Kembali</a>
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