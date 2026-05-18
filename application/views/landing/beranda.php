<style>
  .info .info-box{
    background-color: var(--primary);
    color: white;
    border-radius: 10px;
  }
  .text-justify {
    text-align: justify;
    text-justify: inter-word;
  }

  .btn-lihat{
    background-color: var(--accent);
    border: none;
    color: #fff;
    border-radius: 80px;
    padding: 8px 20px;

    &:hover{
        background: var(--light);
        border:1px solid var(--accent);
        color: var(--accent);
    }

  }

  .btn-active {
      background-color: var(--primary);
      color: #fff;
      border: 1px solid var(--primary);
  }


  .btn-inactive {
      background-color: transparent;
      color: var(--primary);
      border: 1px solid var(--primary);
  }


  .btn-inactive:hover {
      background-color: var(--primary);
      color: #fff;
  }
  

  .card-galeri {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        transition: all 0.25s ease;
    }
  
  .card-galeri:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    }


</style>

<header class="visually-hidden">
  <h1>Website Resmi Pemerintah Desa Blahbatuh</h1>
</header>

<!-- Hero Slider  -->
<section class="slider">
    <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img src="<?= base_url("assets/image/slider10.svg");?>" class="d-block w-100" alt="Slider 1">
        </div>
        <div class="carousel-item">
        <img src="<?= base_url("assets/image/slider9.svg");?>" class="d-block w-100" alt="Slider 2">
        </div>
        <div class="carousel-item">
        <img src="<?= base_url("assets/image/slider5.svg");?>" class="d-block w-100" alt="Slider 3">
        </div>
        <div class="carousel-item">
        <img src="<?= base_url("assets/image/slider11.svg");?>" class="d-block w-100" alt="Slider 4">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
</section>
<!-- End of Hero Slider  -->

<!-- Info -->
<section class="info pt-4 pb-3 py-md-5" id="info">
  <div class="container-fluid px-3 px-md-5">
    <div class="row g-2 g-md-3">
      
      <div class="col-6 col-md-3">
        <div class="info-box text-center p-2 p-md-3 shadow-sm text-white">
          <i class="bi bi-people-fill fs-3 fs-md-1 mb-2 mb-md-3"></i>
          <h6 class="fw-bold mb-1 mb-md-2">Penduduk</h6>
          <p class="fs-6 fs-md-5 mb-0">10.703 Jiwa</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="info-box text-center p-2 p-md-3 shadow-sm text-white">
          <i class="bi bi-house-fill fs-3 fs-md-1 mb-2 mb-md-3"></i>
          <h6 class="fw-bold mb-1 mb-md-2">Jumlah KK</h6>
          <p class="fs-6 fs-md-5 mb-0">2.379 KK</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="info-box text-center p-2 p-md-3 shadow-sm text-white">
          <i class="bi bi-gender-male fs-3 fs-md-1 mb-2 mb-md-3"></i>
          <h6 class="fw-bold mb-1 mb-md-2">Laki-laki</h6>
          <p class="fs-6 fs-md-5 mb-0">5.960 Jiwa</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="info-box text-center p-2 p-md-3 shadow-sm text-white">
          <i class="bi bi-gender-female fs-3 fs-md-1 mb-2 mb-md-3"></i>
          <h6 class="fw-bold mb-1 mb-md-2">Perempuan</h6>
          <p class="fs-6 fs-md-5 mb-0">5.953 Jiwa</p>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- Berita -->
<section class="berita py-5" id="berita">
  <div class="container-fluid px-4 px-md-5">
    <h2 class="text-center fw-bold mb-4">Berita Terbaru</h2>
    <hr class="mx-auto mb-5" style="width: 120px; border-top: 4px solid #dc3545;">
    <?php
      $current = uri_string();

      $active   = 'btn-active';
      $inactive = 'btn-inactive';
      ?>

      <div class="d-flex flex-row gap-2 mb-4">

          <a href="<?= site_url('landing#berita'); ?>"
            class=" px-3 py-2 rounded-3 <?= ($current == '' || $current == 'landing') ? $active : $inactive; ?>">
              Terbaru
          </a>

          <a href="<?= site_url('landing/berita_desa'); ?>"
            class=" px-3 py-2 rounded-3 <?= ($current == 'landing/berita_desa') ? $active : $inactive; ?>">
              Semua
          </a>
      </div>

    <?php foreach ($berita as $item): ?>
    <!-- Card -->
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card mb-2 shadow-sm border-0 card-berita">
          <div class="row g-0">
            <div class="col-lg-6 aspect-ratio-box">
              <img src="<?= base_url('uploads/berita/' . $item['gambar']); ?>" class="img-fluid rounded w-100 h-100 object-fit-cover img-berita" alt="Berita" 
                data-bs-toggle="modal" data-bs-target="#modalBerita<?=$item['id_berita']?>">
            </div>
            <div class="col-lg-6 d-flex align-items-center">
              <div class="card-body p-4 p-md-5">
                <h4 class="card-title fw-bold mb-2"><?=htmlspecialchars($item['judul'])?> </h4>
                <div class="d-flex flex-wrap gap-2 mb-2">
                  <span class="badge1">Berita</span>
                  <span class="badge2"> <?=$item['created_at']?> </span>
                </div>
                <p class="card-text text-justify">
                  <strong><?= lokasi_berita($item['lokasi'] ?? null); ?></strong>
                  <?=potong_deskripsi_perkata($item['isi'], 250);?>
                </p>
                <button type="button" class="btn btn-custom btn-lg mt-2 px-4" data-bs-toggle="modal" data-bs-target="#modalBerita<?=$item['id_berita']?>">
                  Selengkapnya
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalBerita<?=$item['id_berita']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <!-- Body -->
          <div class="modal-body">
            <div class="modal-img aspect-ratio-box">
              <img src="<?= base_url('uploads/berita/' . $item['gambar']); ?>" alt="Berita" class="img-fluid rounded w-100 h-100 object-fit-cover">
            </div>
            <div class="modal-subject mt-2">
              <h3 class="modal-title mb-2 fw-bold lh-sm" id="staticBackdropLabel"><?=htmlspecialchars($item['judul'])?></h3>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge1">Berita</span>
                <span class="badge2"><?=$item['created_at']?></span>
              </div>

              <p class="modal-desc text-justify">
                <strong><?= lokasi_berita($item['lokasi'] ?? null); ?></strong>
                <?= nl2br(htmlspecialchars($item['isi'])); ?>
              </p>
              <hr>
              
              <?php
              $share_url = base_url('berita/' . $item['slug']);
              $text =
                  "Berita Blahbatuh - " . 
                  $item['judul'] . "\n" .
                  "Selengkapnya silahkan kunjungi link berikut:\n" .
                  $share_url;
              ?>
              
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-semibold text-muted">Bagikan ke:</span>
              <div class="d-flex gap-2">

                <!-- WhatsApp -->
                <a href="https://wa.me/?text=<?= urlencode($text); ?>"
                  target="_blank"
                  class="btn btn-success btn-sm d-flex align-items-center gap-1">
                  <i class="bi bi-whatsapp"></i>
                  <span class="d-none d-md-inline">WhatsApp</span>
                </a>

                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($share_url); ?>"
                  target="_blank"
                  class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                  <i class="bi bi-facebook"></i>
                  <span class="d-none d-md-inline">Facebook</span>
                </a>
              </div>
            </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-custom" data-bs-dismiss="modal">Keluar</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

    <div class="d-flex justify-content-end mt-4 mb-4">
      <a href="<?= site_url('landing/berita_desa'); ?>"
        class="btn btn-lihat btn-sm px-4 border border-primary-subtle fw-normal d-inline-flex align-items-center gap-2">
        Lihat Semua
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>


  </div>
</section>
<!-- End berita section -->

<!-- Galeri Foto-->
<section class="galeri pb-5" id="galeri">
  <div class="container-fluid px-4 px-md-5">
    <h2 class="text-center fw-bold mb-4">Galeri Foto</h2>
    <hr class="mx-auto mb-5" style="width: 120px; border-top: 4px solid #dc3545;">
    <?php
      $current = uri_string();

      $active   = 'btn-active';
      $inactive = 'btn-inactive';
      ?>

      <div class="d-flex flex-row gap-2 mb-4">

          <a href="<?= site_url('landing#galeri'); ?>"
            class=" px-3 py-2 rounded-3 <?= ($current == '' || $current == 'landing') ? $active : $inactive; ?>">
              Terbaru
          </a>

          <a href="<?= site_url('landing/galeri_foto'); ?>"
            class=" px-3 py-2 rounded-3 <?= ($current == 'landing/galeri_foto') ? $active : $inactive; ?>">
              Semua
          </a>
      </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php foreach ($galeri as $item): ?>
        <div class="col">
          <div class="card h-100 shadow-sm card-galeri">
            <img src="<?= base_url('uploads/galeri/' . $item['gambar']); ?>" class="card-img-top" alt="Galeri Desa">
            <div class="card-body">
              <p class="caption fw-bold mb-1"><?= potong_caption($item['caption'], 35); ?></p>
              <span class="badge2"><?= $item['created_at'] ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-end mt-4 mb-4">
      <a href="<?= site_url('landing/galeri_foto'); ?>"
        class="btn btn-lihat btn-sm px-4 border border-primary-subtle fw-normal d-inline-flex align-items-center gap-2">
        Lihat Semua
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>

  </div>
</section>
<!-- Galeri foto section end -->

<!-- Galeri Video-->
<section class="galeri pb-5" id="galeri">
  <div class="container-fluid px-4 px-md-5">
    <h2 class="text-center fw-bold mb-4">Galeri Video</h2>
    <hr class="mx-auto mb-5" style="width: 120px; border-top: 4px solid #dc3545;">
      <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
          <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/zZNcNLGc58Y" title="YouTube video" allowfullscreen></iframe>
          </div>
        </div>
        <div class="col">
          <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/zZNcNLGc58Y" title="YouTube video" allowfullscreen></iframe>
          </div>
        </div>
      </div>
  </div>
</section>
<!-- Galeri video section end -->



<!-- <div class="icon-sosmed mt-2">
  <a href="https://www.facebook.com/kantor.desablahbatuh" target="_blank"><i class="bi bi-facebook fs-3 me-3"></i></a>
  <a href="https://www.instagram.com/desablahbatuh.ofc" target="_blank"><i class="bi bi-instagram fs-3 me-3"></i></a>
  <a href="https://www.youtube.com/@kantordesablahbatuh" target="_blank"><i class="bi bi-youtube fs-3"></i></a>
</div> -->