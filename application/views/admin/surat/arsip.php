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

                            <!-- FILTER -->
                            <form method="get" action="<?= site_url('admin/arsip') ?>" class="form-inline">
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

                                <button type="submit" class="btn btn-primary mr-1">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="<?= site_url('admin/arsip') ?>" class="btn btn-light">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </form>

                            <!-- CETAK / DOWNLOAD -->
                            <form method="post" action="<?= site_url('admin/arsip_download') ?>" class="form-inline mt-2 mt-md-0">
                                <input type="hidden" name="from" value="<?= htmlspecialchars($filter_from ?? '') ?>">
                                <input type="hidden" name="to"   value="<?= htmlspecialchars($filter_to ?? '') ?>">

                                <a href="<?= site_url('admin/tambah_arsip') ?>" class="btn btn-sm btn-primary mr-2">
                                    <i class="fas fa-plus"></i> Tambah Arsip
                                </a>

                                <button type="button"
                                        class="btn btn-sm btn-danger mr-1"
                                        data-toggle="modal"
                                        data-target="#modalFilterPdf">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </button>
                                <button type="button"
                                        class="btn btn-sm btn-success mr-1"
                                        data-toggle="modal"
                                        data-target="#modalFilterExcel">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                                <button type="submit" name="type" value="csv"
                                        class="btn btn-sm btn-success mr-1">
                                    <i class="fas fa-file-csv"></i> CSV
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
                                <input type="hidden" name="to"   value="<?= htmlspecialchars($filter_to ?? '') ?>">
                                <input type="hidden" name="type" value="xlsx">

                                <div class="form-group">
                                    <label>Nama Surat</label>
                                    <select name="nama_surat" class="form-control form-control-sm">
                                    <option value="">-- Semua Surat --</option>
                                    <?php
                                    $nama_unik = [];
                                    foreach ($arsip as $a) {
                                        if (!empty($a->nama_surat)) {
                                            $nama_unik[$a->nama_surat] = true;
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
                                  <!-- kirim ulang filter tanggal -->
                                    <input type="hidden" name="from" value="<?= htmlspecialchars($filter_from ?? '') ?>">
                                    <input type="hidden" name="to"   value="<?= htmlspecialchars($filter_to ?? '') ?>">
                                    <input type="hidden" name="type" value="pdf">

                                    <div class="form-group">
                                        <label>Nama Surat</label>
                                        <select name="nama_surat" class="form-control form-control-sm">
                                        <option value="">-- Semua Surat --</option>
                                        <?php
                                        $nama_unik = [];
                                        foreach ($arsip as $a) {
                                            if (!empty($a->nama_surat)) {
                                                $nama_unik[$a->nama_surat] = true;
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
                                    <th width="90">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($arsip)): ?>
                                <?php $no = 1; foreach ($arsip as $a): ?>
                                <tr>
                                <td class="text-center"><?= $no++ ?></td>

                                <td>
                                    <?= !empty($a->tanggal_surat)
                                        ? date('d-m-Y', strtotime($a->tanggal_surat))
                                        : date('d-m-Y', strtotime($a->created_at)) ?>
                                </td>


                            <td>
                                <?php
                                $noTpl = trim((string)($a->nomor_template_surat ?? '')); 
                                $noSrt = trim((string)($a->nomor_surat ?? ''));

                                echo htmlspecialchars(
                                    ($noTpl !== '' && $noSrt !== '')
                                        ? ($noTpl . '/' . $noSrt . '/P.Blh')
                                        : ($noSrt !== '' ? ($noSrt . '/P.Blh') : '-')
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                // Ambil data langsung dari kolom nomor_pengantar di database
                                $noPg = trim((string)($a->nomor_pengantar ?? '')); 

                                if ($noPg !== '') {
                                    // Karena di DB sudah lengkap (470/1/KBD.Tsn), langsung echo saja
                                    echo htmlspecialchars($noPg);
                                } else {
                                    // Jika benar-benar kosong, baru tampilkan default
                                    echo '-';
                                }
                                ?>
                            </td>


                                <td><?= htmlspecialchars($a->nama ?? '-') ?></td>

                                <td><?= htmlspecialchars($a->alamat_penerima ?? '-') ?></td>

                                <td class="kolom-surat">
                                    <?php
                                    $jenis = trim((string)($a->jenis_surat ?? ''));
                                    $nama  = trim((string)($a->nama_surat ?? ''));

                                    if ($jenis !== '' && $nama !== '') {
                                        echo htmlspecialchars($nama . ' ' . $jenis);
                                    } elseif ($jenis !== '') {
                                        echo htmlspecialchars($jenis);
                                    } elseif ($nama !== '') {
                                        echo htmlspecialchars($nama);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                
                            <td class="text-center">
                                    <?php if (!empty($a->file_admin) && file_exists(FCPATH.'uploads/surat/'.$a->file_admin)): ?>
                                        <a href="<?= site_url('admin/preview_surat/'.$a->id) ?>" class="btn btn-sm btn-info" title="Preview">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('uploads/surat/'.rawurlencode($a->file_admin)) ?>" class="btn btn-sm btn-success" title="Download" target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted mr-1"></span>
                                    <?php endif; ?>

                                    <!-- HAPUS: tampil SELALU walaupun tidak ada file -->
                                    <form action="<?= site_url('admin/hapus_arsip/'.$a->id) ?>" method="post" style="display:inline;"
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

