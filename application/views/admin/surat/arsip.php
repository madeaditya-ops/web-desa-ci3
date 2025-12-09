<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Arsip Surat</h6>
            <div>
                <a href="<?= site_url('admin/daftar_surat') ?>" class="btn btn-sm btn-secondary">Daftar Template</a>
            </div>
        </div>

        <div class="card-body">
            <!-- Filter tanggal -->
            <form method="get" action="<?= site_url('admin/arsip') ?>" class="form-inline mb-3">
                <label class="mr-2">Dari</label>
                <input type="date" name="from" class="form-control mr-3" value="<?= htmlspecialchars($filter_from ?? '') ?>">
                <label class="mr-2">Sampai</label>
                <input type="date" name="to" class="form-control mr-3" value="<?= htmlspecialchars($filter_to ?? '') ?>">
                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                <a href="<?= site_url('admin/arsip') ?>" class="btn btn-light">Reset</a>
            </form>

            <!-- Download / Export form (POST) -->
            <form id="arsipForm" method="post" action="<?= site_url('admin/arsip_download') ?>">
                <input type="hidden" name="from" value="<?= htmlspecialchars($filter_from ?? '') ?>">
                <input type="hidden" name="to"   value="<?= htmlspecialchars($filter_to ?? '') ?>">

                <div class="mb-3">
                    <button type="submit" name="type" value="csv" class="btn btn-sm btn-success">
                        <i class="fas fa-file-csv"></i> Download Laporan (CSV)
                    </button>
                    <button type="submit" name="type" value="zip" class="btn btn-sm btn-primary">
                        <i class="fas fa-file-archive"></i> Download Berkas (.zip)
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:30px;"><input type="checkbox" id="select_all"></th>
                                <th style="width:40px;">#</th>
                                <th>Nama Surat</th>
                                <th>Nomor Surat</th>
                                <th>Nama (Penerima)</th>
                                <th>File</th>
                                <th style="width:160px">Tanggal</th>
                                <th style="width:80px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($arsip as $a): ?>
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="<?= htmlspecialchars($a->id) ?>"></td>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($a->nama_surat ?? '-') ?></td>
                                <td><?= htmlspecialchars($a->nomor_surat ?? '-') ?></td>
                                <td><?= htmlspecialchars($a->nama ?? '-') ?></td>
                                <td>
                                    <?php if (!empty($a->filename) && file_exists(FCPATH.'uploads/surat/'.$a->filename)): ?>
                                        <a href="<?= base_url('uploads/surat/'.rawurlencode($a->filename)) ?>" target="_blank"><?= htmlspecialchars($a->filename) ?></a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($a->created_at ?? '-') ?></td>
                                <td>
                                    <?php if (!empty($a->filename) && file_exists(FCPATH.'uploads/surat/'.$a->filename)): ?>
                                        <a href="<?= base_url('uploads/surat/'.rawurlencode($a->filename)) ?>" class="btn btn-sm btn-outline-primary" target="_blank" title="Download"><i class="fas fa-download"></i></a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
(function(){
    // DataTables init if available
    if (typeof $.fn.DataTable === 'function') {
        $('#dataTable').DataTable({
            ordering: true,
            pageLength: 10,
            lengthChange: false,
            columnDefs: [{ orderable: false, targets: [0,5,7] }]
        });
    }

    // Select all checkboxes
    document.getElementById('select_all')?.addEventListener('change', function(e){
        var checked = e.target.checked;
        document.querySelectorAll('input[name="ids[]"]').forEach(function(cb){ cb.checked = checked; });
    });
})();
</script>