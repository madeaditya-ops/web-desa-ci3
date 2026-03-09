<style>
.preview-wrapper {
    background: #f8f9fc;
    padding: 20px;
}

.preview-card {
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
}

.preview-header {
    border-bottom: 1px solid #e3e6f0;
    padding: 16px 20px;
}

.preview-header h6 {
    font-size: 15px;
    font-weight: 600;
}

.file-badge {
    font-size: 12px;
    background: #f1f3f8;
    border: 1px solid #d1d3e2;
}

.preview-toolbar {
    background: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
    padding: 10px 15px;
}

.preview-content {
    padding: 25px;
    background: #fff;
    max-height: 600px;
    overflow-y: auto;
    font-size: 14px;
    line-height: 1.6;
}

.preview-content::-webkit-scrollbar {
    width: 6px;
}
.preview-content::-webkit-scrollbar-thumb {
    background: #cfd3e0;
    border-radius: 3px;
}
</style>



<div class="container-fluid preview-wrapper">


        <div class="preview-card mb-4">

            <!-- HEADER -->
            <div class="preview-header d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h6 class="text-primary mb-1">
                        <i class="fas fa-file-alt mr-1"></i>
                        Preview Surat
                    </h6>
                    <small class="text-muted">
                        <?= htmlspecialchars($arsip->nama_surat ?? 'Dokumen Arsip') ?>
                    </small>
                </div>

                <span class="badge file-badge mt-2 mt-md-0">
                    <?= htmlspecialchars($arsip->filename ?? '-') ?>
                </span>
            </div>

            <!-- TOOLBAR -->
            <div class="preview-toolbar d-flex flex-wrap justify-content-between align-items-center">

                <div class="mb-2 mb-md-0">
                    <a href="<?= base_url('uploads/surat/' . rawurlencode($arsip->filename ?? '')) ?>"
                       target="_blank"
                       class="btn btn-sm btn-primary <?= empty($arsip->filename) ? 'disabled' : '' ?>">
                        <i class="fas fa-download mr-1"></i> Download Surat
                    </a>

                    <a href="<?= site_url('admin/arsip') ?>"
                       class="btn btn-sm btn-outline-secondary ml-2">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>

                <small class="text-muted">
                    <i class="fas fa-eye mr-1"></i> Mode Preview
                </small>
            </div>

            <!-- PREVIEW CONTENT -->
            <div class="preview-content">
                <?php if (!empty($html_content)) : ?>
                    <?= $html_content ?>
                <?php else : ?>
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Preview belum tersedia atau konten surat kosong.
                    </div>
                <?php endif; ?>
            </div>

        </div>

</div>
