<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Surat: <?= htmlspecialchars($surat->nama_surat) ?>
                <?php if (isset($is_editing_generated) && $is_editing_generated): ?>
                    <small class="text-muted">(Surat yang sudah di-generate)</small>
                <?php endif; ?>
            </h6>
        </div>

        <div class="card-body">
            <?php if($this->session->flashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('message') ?>
                    <button type="button" class="close" data-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" id="editForm">
                <div class="row">
                    <div class="col-lg-12">
                        <h5>Edit Preview Surat (WYSIWYG)</h5>
                        <div style="border: 1px solid #ccc; padding: 20px; margin: 10px 0; background: #fff;">
                            <textarea name="edited_html" id="editor" style="width: 100%; height: 500px;">
                                <?= $html_content ?>
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="<?= site_url('admin/daftar_surat') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>

            <h6 class="text-muted">Tips:</h6>
            <ul class="small text-muted">
                <li>Edit teks langsung di preview di atas menggunakan editor WYSIWYG</li>
                <li>Klik tombol Simpan Perubahan untuk update file surat</li>
                <li>Perubahan akan overwrite file surat yang sudah di-generate</li>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'), {
        toolbar: [
            'bold','italic','underline',
            '|','alignment',
            '|','bulletedList','numberedList',
            '|','undo','redo'
        ]
    })
    .catch(error => console.error(error));
</script>

