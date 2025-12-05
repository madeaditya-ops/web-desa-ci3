<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Daftar Potensi</h1>
    <p class="mb-4">Manajemen data potensi yang dapat ditampilkan di website.</p>

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
            <h6 class="m-0 font-weight-bold text-primary">Data Potensi</h6>
            <a href="<?= site_url('potensi/create') ?>" class="btn btn-primary btn-sm float-right">
                <i class="fas fa-plus"></i> Tambah Potensi
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th style="width: 15%;">Gambar</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($potensi as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $item->nama ?></td>
                            <td><?= substr($item->deskripsi, 0, 100) ?>...</td>
                            <td><?= $item->kategori ?></td>
                            <td><?= $item->lokasi ?></td>
                            <td class="text-center">
                                <?php if($item->gambar): ?>
                                    <img src="<?= base_url('uploads/potensi/'.$item->gambar) ?>" width="100" class="img-thumbnail">
                                <?php else: ?>
                                    <span class="badge badge-secondary">Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('potensi/edit/'.$item->id_potensi) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= site_url('potensi/delete/'.$item->id_potensi) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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