<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Data Keluarga</h1>

    <a href="<?= base_url('keluarga/tambah') ?>" class="btn btn-primary mb-3">
        + Tambah Keluarga
    </a>

    <div class="card shadow">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>No KK</th>
                        <th>Kepala Keluarga</th>
                        <th>Dusun</th>
                        <th>Alamat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($keluarga as $k): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $k->no_kk ?></td>
                            <td><?= $k->nama_kepala_keluarga ?></td>
                            <td><?= $k->nama_dusun ?></td>
                            <td><?= $k->alamat ?></td>
                            <td>
                                <a href="<?= base_url('keluarga/detail/' . $k->id) ?>"
                                    class="btn btn-info btn-sm">
                                    Detail
                                </a>
                                <a href="<?= base_url('keluarga/edit/' . $k->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('keluarga/delete/' . $k->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Anggota Keluarga - No KK: <span id="noKKLabel"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover" id="memberTable">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Hubungan</th>
                            <th>Jenis Kelamin</th>
                            <th>Umur</th>
                        </tr>
                    </thead>
                    <tbody id="memberTableBody">
                        <tr>
                            <td colspan="6" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>