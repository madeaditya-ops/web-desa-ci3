<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Daftar Anggota Lembaga</h1>
    <p class="mb-4">Manajemen data anggota lembaga yang ditampilkan di website desa.</p>

    <!-- Flash Message -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Anggota Lembaga</h6>
            <a href="<?= site_url('anggota_lembaga/create/'.$lembaga['id']) ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Anggota
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:5%">No</th>
                            <th>Nama Anggota</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th style="width:25%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($anggota)): ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    Data Anggota belum tersedia.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($anggota as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($item['nama']) ?></td>
                                    <td><?= htmlspecialchars($item['jabatan']) ?></td>
                                    <td><?= htmlspecialchars($item['status']) ?></td>
                                    
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?= site_url('anggota_lembaga/edit/'.$item['id']) ?>"
                                               class="btn btn-warning btn-sm"
                                               title="Edit Lembaga">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= site_url('anggota_lembaga/delete/'.$item['id']) ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus anggota lembaga ini?')"
                                               title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
