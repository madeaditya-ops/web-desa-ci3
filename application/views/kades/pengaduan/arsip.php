<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Arsip Pengaduan</h1>
    <p class="mb-4">Manajemen data pengaduan masyarakat yang telah ditindaklanjuti</p>

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

    <!-- Tabel Pengaduan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Arsip Pengaduan</h6>
        </div>
        <div class="card-body">
        
        <div class="export">
            <form method="get" action="<?= base_url('PengaduanAdmin/arsip') ?>" class="mb-3">
                <div class="form-row">
                    <div class="col-md-3">
                        <label>Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control"
                            value="<?= $this->input->get('start_date') ?>">
                    </div>

                    <div class="col-md-3">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control"
                            value="<?= $this->input->get('end_date') ?>">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-2">Filter</button>
                        <a href="<?= base_url('PengaduanAdmin/arsip') ?>" class="btn btn-secondary">Reset</a>
                    </div>

                    <div class="col-md-3 d-flex align-items-end justify-content-end">
                        <a href="<?= base_url('PengaduanAdmin/export_excel?start_date='.$this->input->get('start_date').'&end_date='.$this->input->get('end_date')) ?>" 
                        class="btn btn-sm py-2 px-3 btn-success mr-2"><i class="fas fa-file-excel mr-2"></i>Excel</a>

                        <a href="<?= base_url('PengaduanAdmin/export_pdf?start_date='.$this->input->get('start_date').'&end_date='.$this->input->get('end_date')) ?>" 
                        class="btn btn-sm py-2 px-3 btn-danger"><i class="fas fa-file-pdf mr-2"></i>PDF</a>
                    </div>
                </div>
            </form>
        </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-dark" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Id Pengaduan</th>
                            <th>Nama Pelapor</th>
                            <th>Deskripsi Singkat</th>
                            <th width="15%">Tanggal</th>
                            <th>Lokasi</th>
                            <th width="10%">Status</th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($pengaduan as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?= html_escape($p->id_pengaduan); ?>
                            </td>
                            <td>
                                <?= html_escape($p->nama_pelapor); ?>
                            </td>
                            <td>
                                <?= html_escape(mb_substr(strip_tags($p->deskripsi), 0, 70, 'UTF-8')); ?>
                                <?= strlen($p->deskripsi) > 70 ? '...' : ''; ?>
                            </td>
                            <td><?= date('d-m-Y', strtotime($p->created_at)) ?></td>
                            <td><?= html_escape($p->lokasi_pengaduan) ?></td>
                            <td class="text-center">
                                <span class="badge badge-success p-2">Selesai</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

