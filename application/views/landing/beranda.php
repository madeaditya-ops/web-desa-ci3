<style>
  .text-justify {
    text-align: justify;
    text-justify: inter-word;
}
</style>


<!-- Hero Slider  -->
<section class="slider">
    <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img src="<?= base_url("assets/image/slider4.svg");?>" class="d-block w-100" alt="Slider 1">
        </div>
        <div class="carousel-item">
        <img src="<?= base_url("assets/image/slider5.svg");?>" class="d-block w-100" alt="Slider 2">
        </div>
        <div class="carousel-item">
        <img src="<?= base_url("assets/image/slider6.svg");?>" class="d-block w-100" alt="Slider 3">
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

<!-- Berita -->
<section class="berita py-5" id="berita">
  <div class="container-fluid px-4 px-md-5">
    <h2 class="text-center fw-bold mb-4">Berita Terbaru</h2>
    <hr class="mx-auto mb-5" style="width: 120px; border-top: 4px solid #dc3545;">
    <?php foreach ($berita as $item): ?>
    <!-- Card -->
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card mb-5 shadow-sm border-0 card-berita">
          <div class="row g-0">
            <div class="col-lg-6 aspect-ratio-box">
              <img src="<?= base_url('uploads/berita/' . $item['gambar']); ?>" class="img-fluid rounded w-100 h-100 object-fit-cover img-berita" alt="Berita" 
                data-bs-toggle="modal" data-bs-target="#modalBerita<?=$item['id_berita']?>">
            </div>
            <div class="col-lg-6 d-flex align-items-center">
              <div class="card-body p-4 p-md-5">
                <h4 class="card-title fw-bold mb-2"> <?=$item['judul']?> </h4>
                <div class="d-flex flex-wrap gap-2 mb-2">
                  <span class="badge1">Berita</span>
                  <span class="badge2"> <?=$item['created_at']?> </span>
                </div>
                <p class="card-text text-justify"><?=potong_deskripsi_perkata($item['isi'], 250);?></p>
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
              <h3 class="modal-title mb-2 fw-bold lh-sm" id="staticBackdropLabel"><?=$item['judul']?></h3>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge1">Berita</span>
                <span class="badge2"><?=$item['created_at']?></span>
              </div>
              <p class="modal-desc text-justify"><?=$item['isi']?></p>
              <div class="icon-sosmed mt-2">
                <a href="https://www.facebook.com/kantor.desablahbatuh" target="_blank"><i class="bi bi-facebook fs-3 me-3"></i></a>
                <a href="https://www.instagram.com/desablahbatuh.ofc" target="_blank"><i class="bi bi-instagram fs-3 me-3"></i></a>
                <a href="https://www.youtube.com/@kantordesablahbatuh" target="_blank"><i class="bi bi-youtube fs-3"></i></a>
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
  </div>
</section>
<!-- End berita section -->

<!-- Galeri Foto-->
<section class="galeri pb-5" id="galeri">
  <div class="container-fluid px-4 px-md-5">
    <h2 class="text-center fw-bold mb-4">Galeri Foto</h2>
    <hr class="mx-auto mb-5" style="width: 120px; border-top: 4px solid #dc3545;">

    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php foreach ($galeri as $item): ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <img src="<?= base_url('uploads/galeri/' . $item['gambar']); ?>" class="card-img-top" alt="UMKM Desa Blahbatuh">
            <div class="card-body">
              <p class="caption fw-bold mb-1"><?= potong_caption($item['caption'], 35); ?></p>
              <span class="badge2"><?= $item['created_at'] ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
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



