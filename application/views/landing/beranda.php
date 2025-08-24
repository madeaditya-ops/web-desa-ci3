
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
        <img src="<?= base_url("assets/image/slider1.svg");?>" class="d-block w-100" alt="Slider 1">
        </div>
        <div class="carousel-item">
        <img src="<?= base_url("assets/image/slider2.svg");?>" class="d-block w-100" alt="Slider 2">
        </div>
        <div class="carousel-item">
        <img src="<?= base_url("assets/image/slider3.svg");?>" class="d-block w-100" alt="Slider 3">
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
  <div class="container-fluid px-4">
    <h2 class="text-center fw-bold mb-4">Berita Terbaru</h2>
    <hr class="mx-auto mb-5" style="width: 120px; border-top: 4px solid #dc3545;">

    <?php foreach ($berita as $item): ?>
    <!-- Card -->
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card mb-5 shadow-sm border-0">
          <div class="row g-0">
            <div class="col-lg-6">
              <img src="<?= base_url('uploads/' . $item['gambar']); ?>" class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="Berita">
            </div>
            <div class="col-lg-6 d-flex align-items-center">
              <div class="card-body p-5">
                <h4 class="card-title fw-bold mb-2"> <?=$item['judul']?> </h4>
                <div class="d-flex flex-wrap gap-2 mb-2">
                  <span class="badge1">Berita</span>
                  <span class="badge2"> <?=$item['created_at']?> </span>
                </div>
                <p class="card-text"><?=potong_deskripsi_perkata($item['isi'], 250);?></p>
                <button type="button" class="btn btn-custom btn-lg mt-2 px-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                  Selengkapnya
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <!-- Body -->
          <div class="modal-body">
            <div class="modal-img">
              <img src="<?= base_url('uploads/' . $item['gambar']); ?>" alt="Berita" class="img-fluid rounded w-100 h-100 object-fit-cover">
            </div>
            <div class="modal-subject mt-2">
              <h3 class="modal-title mb-1" id="staticBackdropLabel"><?=$item['judul']?></h3>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge1">Berita</span>
                <span class="badge2"><?=$item['created_at']?></span>
              </div>
              <p class="modal-desc"><?=$item['isi']?></p>
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
