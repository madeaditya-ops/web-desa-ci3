<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Peraturan</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Peraturan</h6>
        </div>
        <div class="card-body">
            
            <form action="<?= site_url('peraturan/update/'.$peraturan->id_peraturan) ?>" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="judul">Judul Peraturan</label>
                    <input type="text" name="judul" id="judul" class="form-control" value="<?= $peraturan->judul ?>" required>
                    <?= form_error('judul', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label>File Saat Ini</label><br>
                    <?php if($peraturan->file_peraturan): ?>
                        <a href="<?= base_url('uploads/peraturan/'.$peraturan->file_peraturan) ?>" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-file-alt"></i> <?= $peraturan->file_peraturan ?>
                        </a>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada file</p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Ganti File</label>
                    <div class="custom-file">
                        <input type="file" name="file_peraturan" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Pilih file baru...</label>
                    </div>
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file. (Tipe: docx, pdf)</small>
                    <input type="hidden" name="old_file_peraturan" value="<?= $peraturan->file_peraturan ?>">
                </div>

                <a href="<?= site_url('peraturan') ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
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