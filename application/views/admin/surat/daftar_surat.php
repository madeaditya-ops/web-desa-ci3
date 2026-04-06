<div class="container-fluid">

<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-archive mr-1"></i> Teamplate Surat
        </h6>
        <div>
            <span class="text-muted mr-2 small">Manajemen Surat</span>
        </div>
    </div>
    <?php if($this->session->flashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('message') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Surat</th>
                            <th width="15%">File</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($surat as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td>
                                <strong><?= htmlspecialchars($row->nama_surat) ?></strong>
                            </td>
                            <td class="text-center">
                                <?php
                                    $file_path = 'uploads/template_surat/' . $row->file_template;
                                    $ext = pathinfo($row->file_template, PATHINFO_EXTENSION) ?: 'docx';
                                    $safe_name = preg_replace('/[^A-Za-z0-9_\-]+/', '_', trim($row->nama_surat));
                                    $download_name = $safe_name . '.' . $ext;
                                ?>
                                <?php if (!empty($row->file_template) && file_exists(FCPATH . $file_path)): ?>
                                    <a href="<?= base_url($file_path) ?>"
                                       download="<?= htmlspecialchars($download_name) ?>"
                                       class="btn btn-outline-primary btn-sm"
                                       title="Download <?= htmlspecialchars($row->nama_surat) ?>"
                                       target="_blank">
                                        <i class="fas fa-file-download"></i> Download
                                    </a>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('admin/edit_surat/'.$row->id_template) ?>"
                                   class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i> Edit Surat
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
