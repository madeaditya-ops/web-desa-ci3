<div class="container-fluid">

  <h1 class="h3 mb-4 text-gray-800">Data Warga</h1>
  <div class="mb-3">
    <a href="<?= base_url('warga/tambah') ?>"
      class="btn btn-primary">
      + Tambah Warga
    </a>
    <button type="button"
      class="btn btn-success"
      data-toggle="modal"
      data-target="#modalImport">
      Import Excel
    </button>


    <a href="<?= base_url('warga/download_template') ?>"
      class="btn btn-info">
      Download Template
    </a>
  </div>

  <div class="card shadow">
    <div class="card-body table-responsive">

      <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
        <thead class="text-center">
          <tr>
            <th>No</th>
            <th>Aksi</th>
            <th>Foto</th>
            <th>Dusun</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Hubungan</th>
            <th>Agama</th>
            <th>Status Perkawinan</th>
            <th>Kewarganegaraan</th>
            <th>Pendidikan</th>
            <th>Tempat Lahir</th>
            <th>Pekerjaan</th>
            <th>Jenis Kelamin</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody >
          <?php $no = 1;
          foreach ($warga as $w): ?>
            <tr>
              <td><?= $no++ ?></td>
               <td>
                <a href="<?= site_url('warga/detail/' . $w->id) ?>"
                  class="btn btn-info btn-sm">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="<?= base_url('warga/hapus/' . $w->id) ?>"
                  class="btn btn-danger btn-sm"
                  onclick="return confirm('Yakin ingin menghapus data ini?')">
                  <i class="fas fa-trash"></i>
                <a href="<?= base_url('warga/edit/' . $w->id) ?>" class="btn btn-warning btn-icon-split">
                  <span class="icon text-white-20">
                    <i class="fas fa-edit"></i>
                  </span>
                </a>
              </td>
              <td class="text-center">

                <?php if ($w->foto): ?>

                  <img src="<?= base_url('uploads/foto_warga/' . $w->foto) ?>" width="60">

                <?php else: ?>

                  <img src="<?= base_url('uploads/foto_warga/defult.png') ?>" width="60">

                <?php endif ?>

              </td>
              <td><?= $w->nama_dusun ?></td>
              <td><?= $w->no_nik ?></td>
              <td><?= $w->nama ?></td>
              <td><?= $w->hubungan ?></td>
              <td><?= $w->agama ?></td>
              <td><?= $w->status_perkawinan ?></td>
              <td><?= $w->kewarganegaraan ?></td>
              <td><?= $w->pendidikan ?></td>
              <td><?= $w->tempat_lahir ?></td>
              <td><?= $w->pekerjaan ?></td>
              <td><?= $w->jenis_kelamin ?></td>
              <td><?= $w->nama_keterangan ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>

    </div>
  </div>

</div>

<!-- MODAL IMPORT -->
<div class="modal fade" id="modalImport" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Import Data Warga</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          &times;
        </button>
      </div>

      <div class="modal-body">

        <form id="formImport" enctype="multipart/form-data">

          <div class="form-group">
            <label>Pilih File Excel (.xlsx)</label>
            <input type="file"
              name="file_excel"
              class="form-control"
              accept=".xlsx,.xls"
              required>
          </div>

        </form>

        <button type="button"
          id="btnPreview"
          class="btn btn-info mb-3">
          Preview Data
        </button>

        <!-- AREA PREVIEW -->
        <div id="previewContainer"
          style="max-height:300px; overflow:auto; display:none;">
        </div>

        <!-- Progress -->
        <div class="progress mt-3"
          style="height:25px; display:none;"
          id="progressContainer">
          <div id="progressBar"
            class="progress-bar progress-bar-striped progress-bar-animated"
            style="width:0%">
            0%
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button"
          id="btnImport"
          class="btn btn-primary"
          style="display:none;">
          Proses Import
        </button>

        <button type="button"
          class="btn btn-secondary"
          data-dismiss="modal">
          Batal
        </button>
      </div>

    </div>
  </div>
</div>