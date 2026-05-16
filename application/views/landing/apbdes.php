<style>
  .preview-img{
    width: 100%;
    height: auto;
    border-radius: 10px;
    display: block;
  }

  .preview-pdf-wrapper{
    width: 100%;
    overflow: hidden;
    border-radius: 10px;
    border: 1px solid #ddd;
    background: #fff;
  }

  .preview-pdf{
    width: 100%;
    height: 500px;
    border: none;
    display: block;
  }

  /* Tablet */
  @media (max-width: 768px){
    .preview-pdf{
      height: 350px;
    }
  }

  /* HP */
  @media (max-width: 576px){
    .preview-pdf{
      height: 250px;
    }
  }

  .card-apbdes{
    border: none;
    border-radius: 12px;
    overflow: hidden;
  }

  .apbdes-meta{
    font-size: 14px;
    color: #6c757d;
  }

  .apbdes-title{
    font-size: 18px;
    font-weight: 600;
    color: #212529;
  }
</style>

<section class="apbdes" id="apbdes">

  <!-- Header -->
  <div class="container-fluid">
    <div class="row bg-dark-subtle px-4 px-md-5 py-3">
      <div class="col m-0 p-0">
        <div class="d-flex align-items-center">
          <h4 class="fw-bold text-start m-0" style="color:var(--primary);">
            <?= $title; ?>
          </h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter -->
  <div class="container-fluid px-4 px-md-5 mt-4">

    <div class="card border-0 shadow-sm">
      <div class="card-body">

        <form id="tampilapbdes"
              name="tampilapbdes"
              method="POST"
              action="<?= site_url('landing/apbdes'); ?>">

          <div class="row g-3">

            <!-- Tahun -->
            <div class="col-md-6">
              <label for="tahun" class="form-label fw-semibold">
                Tahun
              </label>

              <?= $dropdown_tahun; ?>
            </div>

            <!-- Judul -->
            <div class="col-md-6">
              <label for="judul" class="form-label fw-semibold">
                Judul
              </label>

              <?= $dropdown_judul; ?>
            </div>

          </div>

          <div class="text-end mt-4">
            <button type="submit" class="btn btn-sm btn-custom px-3">
              <i class="bi bi-search me-2"></i> Cari
            </button>
          </div>

        </form>

      </div>
    </div>

  </div>

  <!-- Hasil -->
  <div class="container-fluid px-4 px-md-5 mt-4 mb-5">

    <?php if (!empty($hasil)) : ?>

      <div class="row">

        <?php foreach ($hasil as $row): ?>

          <?php
            $file = $row->file_apbdes;
            $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $url  = base_url('uploads/apbdes/'.$file);
          ?>

          <div class="col-lg-12 mb-4">

            <div class="card shadow-sm card-apbdes">

              <div class="card-body">

                <div class="apbdes-meta mb-2">
                  Tahun <?= $row->tahun; ?>
                </div>

                <h5 class="apbdes-title mb-3">
                  <?= $row->judul; ?>
                </h5>

                <?php if (!empty($row->file_apbdes)): ?>

                  <!-- Preview Gambar -->
                  <?php if (in_array($ext, ['jpg','jpeg','png','webp'])): ?>

                    <img src="<?= $url; ?>"
                         alt="Preview APBDes"
                         class="preview-img shadow-sm">

                  <!-- Preview PDF -->
                  <?php elseif ($ext == 'pdf'): ?>

                    <div class="preview-pdf-wrapper">
                      <iframe src="<?= $url; ?>#toolbar=0&navpanes=0&scrollbar=0"
                              class="preview-pdf">
                      </iframe>
                    </div>

                  <?php endif; ?>

                <?php else: ?>

                  <div class="alert alert-light border text-muted mb-0">
                    Tidak ada file
                  </div>

                <?php endif; ?>

              </div>

            </div>

          </div>

        <?php endforeach; ?>

      </div>

    <?php else: ?>

      <div class="alert alert-warning">
        Data tidak ditemukan untuk pilihan tersebut.
      </div>

    <?php endif; ?>

  </div>

</section>