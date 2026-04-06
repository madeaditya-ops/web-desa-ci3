<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Data APBDes</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Data</h6>
        </div>
        <div class="card-body">
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('apbdes/update/'.$apbdes->id_apbdes) ?>" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="tahun">Tahun Anggaran</label>
                    <input type="number" name="tahun" id="tahun" class="form-control" 
                           value="<?= set_value('tahun', $apbdes->tahun) ?>" required>
                    <?= form_error('tahun', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="judul">Judul / Keterangan</label>
                    <input type="text" name="judul" id="judul" class="form-control" 
                           value="<?= set_value('judul', $apbdes->judul) ?>" required>
                    <?= form_error('judul', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label>File Saat Ini</label><br>
                    <?php if($apbdes->file_apbdes): ?>
                        <a href="<?= base_url('uploads/apbdes/'.$apbdes->file_apbdes) ?>" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-file-alt"></i> <?= $apbdes->file_apbdes ?>
                        </a>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada file</p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Ganti File (pdf/docx/xlsx)</label>
                    <div class="custom-file">
                        <input type="file" name="file_apbdes" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Pilih file baru...</label>
                    </div>
                    <small class="form-text text-danger">Kosongkan jika tidak ingin mengubah file.</small>
                </div>

                <a href="<?= site_url('apbdes') ?>" class="btn btn-secondary">Kembali</a>
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