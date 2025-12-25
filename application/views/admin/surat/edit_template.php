
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Template: <?= htmlspecialchars($surat->nama_surat) ?>
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

            <div class="row">
                <div class="col-lg-6">
                    <h5>Preview Template</h5>
                    <div style="border: 1px solid #ddd; padding: 20px; background: #f9f9f9; max-height: 500px; overflow-y: auto;">
                        <?= $html_content ?>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h5>Edit Text</h5>
                    <form method="post">
                        <div class="form-group">
                            <label for="old_text" class="font-weight-bold">Teks Lama (cari)</label>
                            <textarea name="old_text" id="old_text" class="form-control" rows="4" placeholder="Masukkan teks yang ingin diganti"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="new_text" class="font-weight-bold">Teks Baru (ganti dengan)</label>
                            <textarea name="new_text" id="new_text" class="form-control" rows="4" placeholder="Masukkan teks pengganti"></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Ganti Teks
                            </button>
                            <a href="<?= site_url('admin/daftar_surat') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>

                    <hr>
                    <h6 class="text-muted">Tips:</h6>
                    <ul class="small text-muted">
                        <li>Copy teks dari preview di sebelah kiri</li>
                        <li>Paste di kolom "Teks Lama"</li>
                        <li>Tulis teks pengganti di kolom "Teks Baru"</li>
                        <li>Klik tombol Ganti Teks</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>