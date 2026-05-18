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
                        <?php $no = 1;
                        foreach ($arsip as $a): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($a->created_at)) ?></td>
                                <td><?= htmlspecialchars($a->nama) ?></td>
                                <td>
                                    <?php
                                    $jenis_template = strtolower(trim($a->jenis_template ?? ''));
                                    $nama_surat = strtoupper(trim($a->jenis_surat_tujuan ?? $a->judul ?? ''));

                                    $is_keterangan =
                                        ($jenis_template === 'keterangan') ||
                                        ($nama_surat === 'SURAT KETERANGAN');

                                    $noPg = trim((string)($a->nomor_pengantar ?? ''));
                                    $kd   = trim((string)($a->kode_banjar ?? ''));

                                    if ($is_keterangan) {

                                        // khusus surat keterangan: ambil dari data_surat.no_nasional
                                        $noAwal = trim((string)($a->no_nasional_data ?? ''));

                                        // ambil nomor belakang dari nomor_pengantar
                                        $parts = explode('/', ltrim($noPg, '/'));
                                        $cleanNoPg = trim(end($parts));
                                    } else {

                                        // surat lain pakai nomor template biasa
                                        $noAwal = trim((string)(
                                            $a->nomor_template_surat
                                            ?? $a->nomor_template_asli
                                            ?? ''
                                        ));

                                        $cleanNoPg = preg_replace('/^[0-9]+\/+/', '', ltrim($noPg, '/'));
                                    }

                                    if ($noAwal !== '' && $cleanNoPg !== '') {
                                        echo htmlspecialchars($noAwal . '/' . $cleanNoPg);
                                    } elseif ($noAwal !== '') {
                                        echo htmlspecialchars($noAwal);
                                    } elseif ($cleanNoPg !== '') {
                                        echo htmlspecialchars($cleanNoPg);
                                    } else {
                                        echo '-';
                                    }

                                    if ($kd !== '') {
                                        echo '/KBD.' . htmlspecialchars($kd);
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $surat_awal = strtoupper(trim($a->jenis_surat ?? '-'));
                                    $surat_tujuan = strtoupper(trim($a->jenis_surat_tujuan ?? $a->judul ?? '-'));
                                    $keterangan = strtoupper(trim($a->keterangan ?? ''));

                                    echo '<span class="badge badge-secondary">';
                                    echo htmlspecialchars($surat_awal . ' untuk');
                                    echo '</span>';

                                    echo '<br>';

                                    echo '<span class="badge badge-info">';

                                    if ($surat_tujuan === 'SURAT KETERANGAN' && $keterangan !== '') {
                                        echo htmlspecialchars($surat_tujuan . ' ' . $keterangan);
                                    } else {
                                        echo htmlspecialchars($surat_tujuan);
                                    }

                                    echo '</span>';
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($a->status == 'menunggu'): ?>
                                        <span class="badge badge-warning p-2">
                                            <i class="fas fa-clock"></i> Menunggu
                                        </span>
                                    <?php elseif ($a->status == 'disetujui'): ?>
                                        <span class="badge badge-success p-2">
                                            <i class="fas fa-check-circle"></i> Disetujui
                                        </span>

                                        <br>

                                        <?php if ($a->status_ambil == 'sudah'): ?>
                                            <span class="badge badge-primary mt-1">
                                                <i class="fas fa-check"></i> Sudah diambil
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-danger mt-1">
                                                <i class="fas fa-times"></i> Belum diambil
                                            </span>
                                        <?php endif; ?>

                                    <?php elseif ($a->status == 'ditolak'): ?>

                                        <span class="badge badge-danger p-2">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>

                                        <?php if (isset($a->new_approved) && $a->new_approved == 1): ?>
                                            <br>
                                            <span class="badge badge-warning mt-1">
                                                <i class="fas fa-bell"></i> Penolakan Baru
                                            </span>
                                        <?php endif; ?>

                                        <?php if (!empty($a->alasan_tolak)): ?>
                                            <div class="mt-2">

                                                <div class="alert alert-danger py-2 px-2 mb-0">
                                                    <small>
                                                        <strong>Alasan Ditolak:</strong><br>
                                                        <?= nl2br(htmlspecialchars($a->alasan_tolak)) ?>
                                                    </small>
                                                </div>

                                            </div>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($a->status == 'disetujui'): ?>

                                        <a href="<?= site_url('kadus/download_arsip/' . $a->id) ?>" class="btn btn-primary btn-sm mb-1">
                                            <i class="fas fa-download"></i> Unduh
                                        </a>

                                        <br>

                                        <?php if ($a->status_ambil == 'belum'): ?>

                                            <a href="<?= site_url('kadus/verifikasi_ambil/' . $a->id) ?>"
                                                class="btn btn-success btn-sm swal-confirm"
                                                data-title="Verifikasi Pengambilan?"
                                                data-text="Pastikan surat benar-benar sudah diambil warga."
                                                data-icon="question"
                                                data-confirm="Ya, verifikasi">
                                                <i class="fas fa-check"></i> Verifikasi Ambil
                                            </a>

                                        <?php else: ?>

                                            <button class="btn btn-secondary btn-sm mb-1" disabled>
                                                <i class="fas fa-check-double"></i> Sudah Diambil
                                            </button>

                                            <br>

                                            <small class="text-muted">
                                                <?= !empty($a->tanggal_ambil)
                                                    ? date('d-m-Y H:i', strtotime($a->tanggal_ambil))
                                                    : '-' ?>
                                                <br>
                                                Oleh: <?= htmlspecialchars($a->diambil_oleh ?? '-') ?>
                                            </small>

                                        <?php endif; ?>

                                    <?php elseif ($a->status == 'ditolak'): ?>

                                        <a href="<?= site_url('kadus/lengkapi/' . $a->id) ?>"
                                            class="btn btn-warning btn-sm swal-confirm"
                                            data-title="Lengkapi Data?"
                                            data-text="Apakah Anda yakin ingin melengkapi data surat ini?"
                                            data-icon="question"
                                            data-confirm="Ya, lengkapi">

                                            <i class="fas fa-edit"></i>
                                            Lengkapi Data

                                        </a>

                                        <br>

                                        <button type="button"
                                            class="btn btn-danger btn-sm btn-hapus mt-1"
                                            data-url="<?= site_url('kadus/hapus_pengajuan/' . $a->id) ?>">

                                            <i class="fas fa-trash"></i>
                                            Hapus

                                        </button>

                                    <?php else: ?>

                                        <span class="text-muted small font-italic">
                                            Menunggu Verifikasi
                                        </span>

                                    <?php endif; ?>
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