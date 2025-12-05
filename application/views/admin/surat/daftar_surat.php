<div class="container-fluid">
    <?php if($this->session->flashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('message') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Surat</h6>
            <a href="<?= site_url('admin/upload_template') ?>" class="btn btn-primary btn-sm float-right">
                <i class="fas fa-plus"></i> Tambah Template
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Surat</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
            <?php $no = 1; foreach ($surat as $row): ?>
                   <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row->nama_surat ?></td>
                        <td>
                            <?php
                                $file_path = 'uploads/template/' . $row->file_template;
                                $ext = pathinfo($row->file_template, PATHINFO_EXTENSION) ?: 'docx';
                                // buat nama file download dari nama surat, aman untuk filesystem/URL
                                $safe_name = preg_replace('/[^A-Za-z0-9_\-]+/', '_', trim($row->nama_surat));
                                $download_name = $safe_name . '.' . $ext;
                            ?>
                            <?php if (!empty($row->file_template) && file_exists(FCPATH . $file_path)): ?>
                                <a href="<?= base_url($file_path) ?>"
                                   download="<?= htmlspecialchars($download_name) ?>"
                                   title="Download <?= htmlspecialchars($row->nama_surat) ?>" target="_blank">
                                    Download
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        <td>
                             <a href="<?= site_url('admin/edit_surat/'.$row->id_template) ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i> Edit Surat
                                </a>
                            <a href="<?= site_url('admin/delete_surat/'.$row->id_template) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

</div>