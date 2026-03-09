<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Import Data Warga</h1>

    <!-- INSTRUKSI -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <h6 class="alert-heading">📋 Panduan Pengisian Template</h6>
        <ul class="mb-0 small">
            <li><strong>Download template terlebih dahulu</strong> dengan mengklik tombol di bawah</li>
            <li><strong>Isi dengan ID</strong>, bukan nama (contoh: gunakan "1" untuk ID Dusun, bukan "Banjar Sari")</li>
            <li><strong>Semua 15 kolom harus diisi</strong></li>
            <li>Kolom wajib: No KK, NIK, Nama, ID Jenis Kelamin, ID Agama, Pekerjaan</li>
            <li>ID Hubungan = 1 untuk Kepala Keluarga</li>
            <li><strong>NIK tidak boleh duplikat</strong></li>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <span>Download Template</span>
        </div>
        <div class="card-body">
            <a href="<?= base_url('warga/download_template') ?>" 
               class="btn btn-info mb-2">
                <i class="fas fa-download"></i> Download Template Excel
            </a>
            <p class="text-muted small">Template sudah berisi header dan format yang benar</p>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <form id="formImport" enctype="multipart/form-data">

                <div class="form-group">
                    <label><strong>Pilih File Excel (.xlsx)</strong></label>
                    <input type="file" name="file_excel" 
                           accept=".xlsx,.xls"
                           class="form-control" required>
                </div>

                <button type="button" 
                        id="btnPreview"
                        class="btn btn-success">
                    <i class="fas fa-eye"></i> Preview Data
                </button>

                <a href="<?= base_url('warga') ?>" 
                   class="btn btn-secondary">
                   <i class="fas fa-arrow-left"></i> Kembali
                </a>

            </form>

        </div>
    </div>

</div>

<!-- MODAL PREVIEW -->
<div class="modal fade" id="modalPreview" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Preview Data Import</h5>
        <button type="button" class="close" data-dismiss="modal">
          &times;
        </button>
      </div>

      <div class="modal-body" id="previewContent">
          <div class="text-center">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
      </div>

      <div class="modal-footer">
        <button type="button" 
                id="btnImport"
                class="btn btn-primary">
            <i class="fas fa-check"></i> Proses Import
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
                id="btnImport"
                class="btn btn-primary">
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

