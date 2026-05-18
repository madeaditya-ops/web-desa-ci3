<div class="container-fluid">

    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('message') ?>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user-check mr-1"></i> Verifikasi Data Surat Kadus
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th width="40">No</th>
                            <th>Nama Warga</th>
                            <th>NIK</th>
                            <th>Kadus</th>
                            <th>Banjar</th>
                            <th>Tanggal Input</th>
                            <th>Status</th>
                            <th width="130">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (!empty($menunggu)): ?>
                            <?php $no = 1;
                            foreach ($menunggu as $p): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>

                                    <td><?= htmlspecialchars($p->nama ?? '-', ENT_QUOTES, 'UTF-8') ?></td>

                                    <td><?= htmlspecialchars($p->nik ?? '-', ENT_QUOTES, 'UTF-8') ?></td>

                                    <td>
                                        <?= htmlspecialchars($p->dibuat_oleh ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td><?= htmlspecialchars($p->banjar ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                    <td class="text-center">
                                        <?= !empty($p->created_at)
                                            ? date('d-m-Y H:i', strtotime($p->created_at))
                                            : '-' ?>
                                    </td>

                                    <td class="text-center">
                                        <?php
                                        if ($p->status == 'menunggu') {
                                            echo '<span class="badge badge-warning">Menunggu</span>';
                                        } elseif ($p->status == 'disetujui') {
                                            echo '<span class="badge badge-success">disetujui</span>';
                                        } else {
                                            echo '<span class="badge badge-danger">Ditolak</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-info btn-sm btn-detail"
                                            data-id="<?= $p->id ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-success btn-sm btn-setujui"
                                            data-url="<?= site_url('admin/edit_surat/' . $p->id_template . '/' . $p->id) ?>">

                                            <i class="fas fa-check"></i>

                                        </button>

                                        <a href="#" class="btn btn-danger btn-sm"
                                            onclick="konfirmasiTolak(<?= $p->id ?>)">
                                            <i class="fas fa-times"></i>
                                        </a>

                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada data menunggu verifikasi
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTolak" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="formTolak" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alasan Penolakan</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                </div>
                <div class="modal-body">
                    <textarea name="alasan" class="form-control" placeholder="Tulis alasan penolakan di sini..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" type="submit">Tolak Sekarang</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function konfirmasiTolak(id) {
        $('#formTolak').attr('action', '<?= site_url('admin/tolak/') ?>' + id);
        $('#modalTolak').modal('show');
    }
</script>



<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title font-weight-bold">
                    <i class="fas fa-file-alt mr-1"></i> Detail Data Surat
                </h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table class="table table-sm table-bordered">
                    <tbody id="detailContent">
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <a href="#" id="btnSetujui" class="btn btn-success">
                    <i class="fas fa-check"></i> Setujui
                </a>
                <a href="#" id="btnTolak" class="btn btn-danger">
                    <i class="fas fa-times"></i> Tolak
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>