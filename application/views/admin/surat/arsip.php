<div class="container-fluid">
    <div class="card shadow mb-4">

        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-archive mr-1"></i> Arsip Surat
            </h6>
            <a href="<?= site_url('admin/daftar_surat') ?>" class="btn btn-sm btn-secondary">
                <i class="fas fa-list"></i> Daftar Template
            </a>
        </div>
        <div class="card-body">

            <!-- FILTER & CETAK SEJAJAR -->
            <div class="d-flex flex-wrap justify-content-between align-items-end mb-3">

                <form method="get" action="<?= site_url('admin/arsip') ?>" class="form-inline mb-3">

                    <div class="form-group mr-2">
                        <label class="mr-2">Dari</label>
                        <input type="date" name="from" class="form-control"
                            value="<?= htmlspecialchars($filter_from ?? '') ?>">
                    </div>

                    <div class="form-group mr-2">
                        <label class="mr-2">Sampai</label>
                        <input type="date" name="to" class="form-control"
                            value="<?= htmlspecialchars($filter_to ?? '') ?>">
                    </div>

                    <button type="submit" class="btn btn-primary mr-1 swal-confirm">
                        <i class="fas fa-filter"></i> Filter
                    </button>

                    <!-- 🔥 reset bersih (tanpa query string) -->
                    <a href="<?= site_url('admin/arsip') ?>" class="btn btn-secondary mr-1 swal-confirm"
                        data-title="Reset Filter?"
                        data-text="Apakah Anda yakin ingin mereset filter?"
                        data-icon="warning"
                        data-confirm="Ya, reset">
                        <i class="fas fa-times"></i> Reset
                    </a>

                    <!-- 🔥 indikator filter aktif -->
                    <?php if (!empty($filter_from) || !empty($filter_to)) : ?>
                        <span class="badge badge-info ml-2">
                            Filter aktif
                        </span>
                    <?php endif; ?>

                </form>

                <!-- CETAK / DOWNLOAD -->
                <form method="post" action="<?= site_url('admin/arsip_download') ?>" class="form-inline mt-2 mt-md-0">
                    <input type="hidden" name="from" value="<?= htmlspecialchars($filter_from ?? '') ?>">
                    <input type="hidden" name="to" value="<?= htmlspecialchars($filter_to ?? '') ?>">

                    <a href="<?= site_url('admin/tambah_arsip') ?>"
                        class="btn btn-sm btn-primary mr-2 swal-confirm"
                        data-title="Tambah Arsip?"
                        data-text="Apakah Anda yakin ingin menambah arsip baru?"
                        data-icon="info"
                        data-confirm="Ya, tambah">
                        <i class="fas fa-plus"></i> Tambah Arsip
                    </a>

                    <button type="button"
                        class="btn btn-sm btn-danger mr-1"
                        data-toggle="modal" data-target="#modalFilterPdf">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                    <button type="button"
                        class="btn btn-sm btn-success mr-1"
                        data-toggle="modal" data-target="#modalFilterExcel">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>

                    <button type="submit" name="type" value="zip"
                        class="btn btn-sm btn-primary">
                        <i class="fas fa-file-archive"></i> Cetak ZIP
                    </button>
                </form>

                <!-- MODAL FILTER EXCEL -->
                <div class="modal fade" id="modalFilterExcel" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">

                            <form method="post" action="<?= site_url('admin/arsip_download') ?>">
                                <div class="modal-header">
                                    <h6 class="modal-title">Cetak Excel</h6>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <!-- kirim ulang filter tanggal -->
                                    <input type="hidden" name="from" value="<?= htmlspecialchars($filter_from ?? '') ?>">
                                    <input type="hidden" name="to" value="<?= htmlspecialchars($filter_to ?? '') ?>">
                                  <input type="hidden" name="type" value="xls">

                                    <div class="form-group">
                                        <label>Nama Surat</label>
                                        <select name="nama_surat" class="form-control form-control-sm">
                                            <option value="">-- Semua Surat --</option>

                                            <?php
                                            $nama_unik = [];

                                            foreach ($arsip as $a) {
                                                // 🔥 LOGIC BARU (SAMA SEPERTI TABLE)
                                                $jenis = trim((string)($a->jenis_surat_tujuan ?? ''));
                                                $nama  = trim((string)($a->nama_surat ?? ''));

                                                $hasil = '';
                                                if ($jenis !== '') {
                                                    $hasil = $jenis;
                                                } elseif ($nama !== '') {
                                                    $hasil = $nama;
                                                }

                                                if ($hasil !== '') {
                                                    $nama_unik[$hasil] = true;
                                                }
                                            }

                                            foreach (array_keys($nama_unik) as $nama):
                                            ?>
                                                <option value="<?= htmlspecialchars($nama) ?>">
                                                    <?= htmlspecialchars($nama) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Dari Tanggal</label>
                                        <input type="date" name="from" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Sampai Tanggal</label>
                                        <input type="date" name="to" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- MODAL FILTER PDF -->
                <div class="modal fade" id="modalFilterPdf" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">

                            <form method="post" action="<?= site_url('admin/arsip_download') ?>">
                                <div class="modal-header">
                                    <h6 class="modal-title">Cetak PDF</h6>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <!-- TYPE -->
                                    <input type="hidden" name="type" value="pdf">

                                    <!-- FILTER NAMA SURAT -->
                                    <div class="form-group">
                                        <label>Nama Surat</label>
                                        <select name="nama_surat" class="form-control form-control-sm">
                                            <option value="">-- Semua Surat --</option>

                                            <?php
                                            $nama_unik = [];

                                            foreach ($arsip as $a) {
                                                // 🔥 LOGIC BARU (SAMA SEPERTI TABLE)
                                                $jenis = trim((string)($a->jenis_surat_tujuan ?? ''));
                                                $nama  = trim((string)($a->nama_surat ?? ''));

                                                $hasil = '';
                                                if ($jenis !== '') {
                                                    $hasil = $jenis;
                                                } elseif ($nama !== '') {
                                                    $hasil = $nama;
                                                }

                                                if ($hasil !== '') {
                                                    $nama_unik[$hasil] = true;
                                                }
                                            }

                                            foreach (array_keys($nama_unik) as $nama):
                                            ?>
                                                <option value="<?= htmlspecialchars($nama) ?>">
                                                    <?= htmlspecialchars($nama) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- FILTER TANGGAL -->
                                    <div class="form-group">
                                        <label>Dari Tanggal</label>
                                        <input type="date" name="from" class="form-control"
                                            value="<?= htmlspecialchars($filter_from ?? '') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Sampai Tanggal</label>
                                        <input type="date" name="to" class="form-control"
                                            value="<?= htmlspecialchars($filter_to ?? '') ?>">
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-file-pdf"></i> Download PDF
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
            <!-- FILTER AUTO -->
            <div class="d-flex align-items-center flex-wrap mb-3 gap-2">


                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th width="40">No</th>
                                <th width="150">Tanggal Surat</th>
                                <th>Nomor Surat</th>
                                <th>Nomor Pengantar </th>
                                <th>Nama Penerima</th>
                                <th>Alamat Penerima</th>
                                <th>Jenis Surat</th>
                                <th>Status</th>
                                <th width="90">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($arsip)): ?>
                                <?php $no = 1;
                                foreach ($arsip as $a): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>

                                        <td><?= date('d-m-Y H:i', strtotime($a->created_at)) ?></td>


                                        <td>
                                            <?php
                                            $jenis_template = strtolower(trim(
                                                $a->jenis_template_tujuan ?: $a->jenis_template_asal ?: ''
                                            ));

                                            $noTpl = trim((string)($a->nomor_template_surat ?? ''));

                                            $noNasKadus  = trim((string)($a->no_nasional_kadus ?? ''));
                                            $noNasManual = trim((string)($a->no_nasional_manual ?? ''));

                                            $noNas = $noNasKadus !== '' ? $noNasKadus : $noNasManual;

                                            $noSrt = trim((string)($a->nomor_surat ?? ''));

                                            if ($jenis_template === 'keterangan') {
                                                $nomor_awal = $noNas;
                                            } else {
                                                $nomor_awal = $noTpl;
                                            }

                                            if ($nomor_awal !== '' && $noSrt !== '') {
                                                echo htmlspecialchars($nomor_awal . '/' . $noSrt . '/P.Blh');
                                            } elseif ($nomor_awal !== '') {
                                                echo htmlspecialchars($nomor_awal . '/P.Blh');
                                            } elseif ($noSrt !== '') {
                                                echo htmlspecialchars($noSrt . '/P.Blh');
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            $jenis_template = strtolower(trim(
                                                $a->jenis_template_tujuan ?: $a->jenis_template_asal ?: ''
                                            ));

                                            $noTpl = trim((string)($a->nomor_template_surat ?? ''));

                                            $noNasKadus  = trim((string)($a->no_nasional_kadus ?? ''));
                                            $noNasManual = trim((string)($a->no_nasional_manual ?? ''));

                                            $noNas = $noNasKadus !== '' ? $noNasKadus : $noNasManual;

                                            $noPg = trim((string)($a->nomor_pengantar ?? ''));
                                            $kd   = trim((string)($a->kode_banjar ?? ''));

                                            if ($jenis_template === 'keterangan') {
                                                $nomor_awal = $noNas;
                                            } else {
                                                $nomor_awal = $noTpl;
                                            }

                                            $cleanNoPg = preg_replace('/^\d+\//', '', ltrim($noPg, '/'));

                                            if ($nomor_awal !== '' && $cleanNoPg !== '') {
                                                echo htmlspecialchars($nomor_awal . '/' . $cleanNoPg);
                                            } elseif ($nomor_awal !== '') {
                                                echo htmlspecialchars($nomor_awal);
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

                                        <td><?= htmlspecialchars($a->nama ?? '-') ?></td>

                                        <td><?= htmlspecialchars($a->alamat_penerima ?? '-') ?></td>

                                        <td class="kolom-surat">
                                            <?php
                                            $jenis_template = strtolower(trim(
                                                $a->jenis_template_tujuan
                                                    ?: $a->jenis_template_asal
                                                    ?: ''
                                            ));

                                            // Surat dari Kadus
                                            $jenis_tujuan = trim((string)($a->jenis_surat_tujuan ?? ''));

                                            // Surat admin manual
                                            $nama_surat = trim((string)(
                                                $a->nama_surat_asal
                                                ?? $a->nama_surat
                                                ?? ''
                                            ));

                                            // Keterangan dari data_surat / arsip
                                            $keterangan = trim((string)(
                                                $a->keterangan
                                                ?? $a->jenis_surat
                                                ?? ''
                                            ));

                                            if ($jenis_tujuan !== '') {

                                                if ($jenis_template === 'keterangan' && $keterangan !== '') {
                                                    echo htmlspecialchars(strtoupper($jenis_tujuan . ' ' . $keterangan));
                                                } else {
                                                    echo htmlspecialchars($jenis_tujuan);
                                                }
                                            } elseif ($nama_surat !== '') {

                                                if ($jenis_template === 'keterangan' && $keterangan !== '') {
                                                    echo htmlspecialchars(strtoupper($nama_surat . ' ' . $keterangan));
                                                } else {
                                                    echo htmlspecialchars($nama_surat);
                                                }
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($a->status == 'menunggu'): ?>

                                                <span class="badge badge-warning">Menunggu</span>

                                            <?php elseif ($a->status == 'disetujui'): ?>

                                                <span class="badge badge-success">Disetujui</span>
                                                <br>

                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($a->file_admin) && file_exists(FCPATH . 'uploads/surat/' . $a->file_admin)): ?>
                                                <a href="<?= site_url('admin/preview_surat/' . $a->id) ?>" class="btn btn-sm btn-info swal-confirm" title="Preview"
                                                    data-title="Preview Surat?"
                                                    data-text="Apakah Anda yakin ingin melihat preview surat ini?"
                                                    data-icon="question"
                                                    data-confirm="Ya, preview">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('uploads/surat/' . rawurlencode($a->file_admin)) ?>" class="btn btn-sm btn-success swal-confirm" title="Download" target="_blank"
                                                    data-title="Download Surat?"
                                                    data-text="Apakah Anda yakin ingin mengunduh surat ini?"
                                                    data-icon="question"
                                                    data-confirm="Ya, unduh">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted mr-1"></span>
                                            <?php endif; ?>

                                            <!-- HAPUS: tampil SELALU walaupun tidak ada file -->
                                            <form action="<?= site_url('admin/hapus_arsip/' . $a->id) ?>" method="post" style="display:inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus arsip ini?');">
                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                                    value="<?= $this->security->get_csrf_hash(); ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const from = document.querySelector('[name="from"]').value;
            const to = document.querySelector('[name="to"]').value;

            if (from && to && from > to) {
                alert('Tanggal "Dari" tidak boleh lebih besar dari "Sampai"');
                e.preventDefault();
            }
        });
    </script>