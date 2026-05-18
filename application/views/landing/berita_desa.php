<style>
  .text-justify {
    text-align: justify;
    text-justify: inter-word;
  }
  .pagination {
    gap: 6px;
  }

  .pagination .page-link {
      border-radius: 8px;
      color: #0d6efd;
      padding: 8px 14px;
      font-weight: 500;
      transition: all 0.2s ease-in-out;
  }

  .pagination .page-link:hover {
      background-color: var(--accent);
      color: #fff;
  }

  .pagination .active .page-link {
      background-color: var(--accent);
      border-color: var(--accent);
      color: #fff;
  }
</style>

<section class="berita_desa" id="berita_desa">

  <!-- Header Section -->
  <div class="container-fluid">
    <div class="row bg-dark-subtle px-3 px-md-5 py-3">
      <div class="col">
        <h4 class="fw-bold m-0" style="color:var(--primary);">
          <?= $title; ?>
        </h4>
      </div>
    </div>
  </div>

  <!-- Content Section -->
  <div class="container-fluid px-3 px-md-5">
    <div class="row row-cols-1 row-cols-md-3 g-4 py-4">

      <?php foreach ($berita as $item): ?>

        <!-- Card Column -->
        <div class="col">
          <div class="card h-100">

            <!-- Thumbnail -->
            <img src="<?= base_url('uploads/berita/' . $item->gambar); ?>"
                 class="card-img-top card-img-wrapper"
                 alt="berita_desa"
                 data-bs-toggle="modal"
                 data-bs-target="#modalBerita<?= $item->id_berita; ?>">
            <!-- Card Body -->
            <div class="card-body d-flex flex-column flex-grow-1">
              <h4 class="card-title fw-bold mb-2">
                <?= htmlspecialchars($item->judul); ?>
              </h4>

              <div class="d-flex flex-wrap gap-2 mb-2">
                <span class="badge1">Berita</span>
                <span class="badge2"><?= $item->created_at; ?></span>
              </div>

              <p class="card-text text-justify">
                <strong><?= lokasi_berita($item->lokasi ?? null); ?></strong>
                <?= potong_deskripsi_perkata($item->isi, 250); ?>
              </p>

            <div class="row mt-auto">
              <div class="col-12 col-md-6">
                <button type="button"
                        class="btn btn-custom btn-lg w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#modalBerita<?= $item->id_berita; ?>">
                  Selengkapnya
                </button>
              </div>
            </div>

            </div>
          </div>
        </div>


        <!-- Modal Detail Berita -->
        <div class="modal fade"
             id="modalBerita<?= $item->id_berita; ?>"
             tabindex="-1"
             aria-hidden="true">

          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

              <div class="modal-body">
                <!-- Gambar -->
                <img src="<?= base_url('uploads/berita/' . $item->gambar); ?>"
                     class="img-fluid rounded mb-3 w-100"
                     alt="detail_berita">

                <!-- Konten -->
                <h3 class="fw-bold mb-2">
                  <?= htmlspecialchars($item->judul); ?>
                </h3>

                <div class="d-flex flex-wrap gap-2 mb-3">
                  <span class="badge1">Berita</span>
                  <span class="badge2"><?= $item->created_at; ?></span>
                </div>

                <p class="text-justify">
                  <strong><?= lokasi_berita($item->lokasi ?? null); ?></strong>
                  <?= $item->isi; ?>
                </p>

                <hr>

                <?php
                  $share_url = base_url('berita/' . $item->slug);
                  $share_text =
                    "Berita Desa Blahbatuh - " . $item->judul . "\n" .
                    "Selengkapnya: " . $share_url;
                ?>

                <!-- Share Button -->
                <div class="d-flex justify-content-between align-items-center">
                  <span class="fw-semibold text-muted">Bagikan ke:</span>

                  <div class="d-flex gap-2">
                    <a href="https://wa.me/?text=<?= urlencode($share_text); ?>"
                       target="_blank"
                       class="btn btn-success btn-sm">
                      <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($share_url); ?>"
                       target="_blank"
                       class="btn btn-primary btn-sm">
                      <i class="bi bi-facebook"></i> Facebook
                    </a>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button"
                        class="btn btn-custom"
                        data-bs-dismiss="modal">
                  Keluar
                </button>
              </div>

            </div>
          </div>
        </div>

      <?php endforeach; ?>

    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      <?= $pagination; ?>
    </div>

    <div class="d-flex justify-content-center mt-4 small">
      <ol class="breadcrumb">
          <li class="breadcrumb-item">
              <i class="bi bi-house-door text-primary me-2"></i>
          </li>
          <?php $this->load->view('partials/breadcrumb'); ?>
      </ol>
    </div>
  </div>
  
</section>
<!-- End berita section -->