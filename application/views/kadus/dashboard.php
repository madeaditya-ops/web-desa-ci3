<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Template Surat</h1>
    <p class="mb-4">Pilih template surat yang akan digunakan atau unduh blanko kosong.</p>

    <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Surat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Surat</th>
                            <!-- <th>File Template</th> -->
                            <th style="width: 25%;">Aksi</th> </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($templates as $template): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($template->nama_surat, ENT_QUOTES, 'UTF-8') ?></td>
                            <!-- <td>
                                <a href="<?= base_url('uploads/template_surat/' . $template->file_template) ?>" target="_blank">
                                    <?= htmlspecialchars($template->file_template, ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </td> -->
                            <td class="text-center">
                                <a href="<?= site_url('kadus/form_surat/'.$template->id_template) ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-signature"></i> Buat Surat
                                </a>
                                <a href="<?= site_url('kadus/download_blanko/'.$template->id_template) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-download"></i> Download Blanko
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>