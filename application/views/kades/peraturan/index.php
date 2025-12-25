<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Daftar Peraturan</h1>
    <p class="mb-4">Manajemen data peraturan desa yang telah diunggah ke sistem.</p>

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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Peraturan</h6>
            <a href="<?= site_url('peraturan/create') ?>" class="btn btn-primary btn-sm float-right">
                <i class="fas fa-plus"></i> Tambah Peraturan
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Judul Peraturan</th>
                            <th>File</th>
                            <th>Tanggal Dibuat</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($peraturan_list as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($item->judul, ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <a href="<?= base_url('uploads/peraturan/' . $item->file_peraturan) ?>" target="_blank">
                                    <i class="fas fa-file-alt"></i>
                                    <?= htmlspecialchars($item->file_peraturan, ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </td>
                            <td>
                                <?= date('d F Y', strtotime($item->created_at)) ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('peraturan/edit/'.$item->id_peraturan) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= site_url('peraturan/delete/'.$item->id_peraturan) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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