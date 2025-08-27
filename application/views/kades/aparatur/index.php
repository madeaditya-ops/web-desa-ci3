<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Daftar Aparatur</h1>
    <p class="mb-4">Manajemen data aparatur yang dapat ditampilkan di website.</p>

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
            <h6 class="m-0 font-weight-bold text-primary">Data Aparatur</h6>
            <a href="<?= site_url('aparatur/create') ?>" class="btn btn-primary btn-sm float-right">
                <i class="fas fa-plus"></i> Tambah Aparatur
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th style="width: 15%;">Foto</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($aparatur as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $item->nama ?></td>
                            <td><?= $item->jabatan ?></td>
                            <td class="text-center">
                                <?php if($item->foto): ?>
                                    <img src="<?= base_url('uploads/aparatur/'.$item->foto) ?>" width="100" class="img-thumbnail">
                                <?php else: ?>
                                    <span class="badge badge-secondary">Tidak ada foto</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('aparatur/edit/'.$item->id_aparatur) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= site_url('aparatur/delete/'.$item->id_aparatur) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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