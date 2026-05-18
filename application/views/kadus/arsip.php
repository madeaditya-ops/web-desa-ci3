<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Arsip Pengajuan Surat</h1>
    <p class="mb-4">Daftar surat yang telah Anda buat. File tersimpan di server dan siap diunduh kapan saja.</p>

    <?php $success = $this->session->flashdata('success'); ?>

    <?php if (!empty($success)): ?>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                Swal.fire({

                    icon: 'success',

                    title: 'Berhasil',

                    text: '<?= addslashes($success) ?>',

                    timer: 2500,

                    showConfirmButton: false

                });

            });
        </script>

    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Surat Masuk</h6>
        </div>
        <div class="card-body">
            <div class="mb-3 text-right">
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalCetakPDF">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </button>

                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCetakExcel">
                    <i class="fas fa-file-excel"></i> Cetak Excel
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Tanggal</th>
                            <th>Nama Warga</th>
                            <th>Nomor Pengantar</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($arsip as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($a->created_at)) ?></td>
                            <td><?= htmlspecialchars($a->nama) ?></td>
                            <td><?= htmlspecialchars($a->nomor_pengantar) ?></td>
                            <td><?= htmlspecialchars($a->judul) ?></td>
                            <td class="text-center">
                                <?php if($a->status == 'menunggu'): ?>
                                    <span class="badge badge-warning">Menunggu</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Disetujui</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('kadus/download_arsip/'.$a->id) ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-download"></i> Download
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
<!-- MODAL CETAK PDF -->
<div class="modal fade" id="modalCetakPDF" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?= site_url('kadus/arsip_pdf') ?>" method="get" target="_blank">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title">Cetak PDF Arsip</h6>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <small class="text-muted">
                        Kosongkan tanggal jika ingin mencetak semua arsip.
                    </small>

                    <div class="form-group mt-3">
                        <label>Dari Tanggal</label>
                        <input type="date" name="from" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="to" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="<?= site_url('kadus/arsip_pdf') ?>"
                       target="_blank"
                       class="btn btn-outline-danger">
                        <i class="fas fa-print"></i> Cetak Semua
                    </a>

                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Cetak Filter
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


<!-- MODAL CETAK EXCEL -->
<div class="modal fade" id="modalCetakExcel" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?= site_url('kadus/arsip_excel') ?>" method="get">
            <div class="modal-content">

                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title">
                        <i class="fas fa-file-excel"></i> Cetak Arsip Excel
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <small class="text-muted">
                        Kosongkan tanggal jika ingin mencetak semua arsip.
                    </small>

                    <div class="form-group mt-3">
                        <label>Dari Tanggal</label>
                        <input type="date" name="from" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="to" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="<?= site_url('kadus/arsip_excel') ?>"
                       class="btn btn-outline-success">
                        <i class="fas fa-file-excel"></i> Download Semua
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-download"></i> Download Filter
                    </button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>