<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Daftar Pengaduan</h1>
    <p class="mb-4">Manajemen data pengaduan masyarakat yang masuk ke desa.</p>

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

    <!-- Statistik Pengaduan -->
    <div class="row row-cols-1 row-cols-md-5 mb-4 ">
        <div class="col mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pending
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $count_pending ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Diproses
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $count_diproses ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Ditolak
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $count_ditolak ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Selesai
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $count_selesai ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col mb-2">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                        Total 
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $total_pengaduan ?>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Tabel Pengaduan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengaduan</h6>
        </div>
        <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-dark" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Pelapor</th>
                            <th>Deskripsi Singkat</th>
                            <th width="15%">Foto</th>
                            <th width="15%">Tanggal</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($pengaduan as $p): ?>
                        <tr class="<?= $p->is_read == 0 ? 'table-primary text-dark' : '' ?>">
                            <td><?= $no++ ?></td>
                            <td>
                                <?= html_escape($p->nama_pelapor); ?>
                                <?php if($p->is_read == 0): ?>
                                    <span class="badge badge-danger ml-2">
                                        Baru
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= html_escape(mb_substr(strip_tags($p->deskripsi), 0, 70, 'UTF-8')); ?>
                                <?= strlen($p->deskripsi) > 70 ? '...' : ''; ?>
                            </td>
                            <td class="text-center">
                                <?php if($p->foto_bukti): ?>
                                    <img src="<?= base_url('uploads/pengaduan/'.$p->foto_bukti) ?>" width="100" class="img-thumbnail">
                                <?php else: ?>
                                    <span class="badge badge-secondary">Tidak</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d-m-Y', strtotime($p->created_at)) ?></td>
                            <td class="text-center">
                                <?php if($p->status == 'pending'): ?>
                                    <span class="badge badge-warning p-2">Pending</span>
                                <?php elseif($p->status == 'diproses'): ?>
                                    <span class="badge badge-primary p-2">Diproses</span>
                                <?php elseif($p->status == 'selesai'): ?>
                                    <span class="badge badge-success p-2">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-danger p-2">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('pengaduan_kades/detail/'.$p->id_pengaduan) ?>"
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
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

