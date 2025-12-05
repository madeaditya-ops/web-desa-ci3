<!-- views/kades/template_surat/index.php -->

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Template Surat</h1>
    <p class="mb-4">Manajemen template surat yang akan digunakan dalam sistem.</p>

    <!-- Flash Messages -->
    <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Template Surat</h6>
            <a href="<?= site_url('template_surat/create') ?>" class="btn btn-primary btn-sm float-right">
                <i class="fas fa-plus"></i> Tambah Template
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Surat</th>
                            <th>File Template</th>
                            <th>Level Akses</th>
                            <th>Dusun</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($templates as $template): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($template->nama_surat, ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <a href="<?= base_url('uploads/template_surat/' . $template->file_template) ?>" target="_blank">
                                    <?= htmlspecialchars($template->file_template, ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </td>
                            <td><?= ucfirst(htmlspecialchars($template->level_akses, ENT_QUOTES, 'UTF-8')) ?></td>
                            <td><?= $template->nama_dusun ? htmlspecialchars($template->nama_dusun, ENT_QUOTES, 'UTF-8') : '<span class="text-muted">Semua Dusun</span>' ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('template_surat/edit/'.$template->id_template) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= site_url('template_surat/delete/'.$template->id_template) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
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
