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
  <div class="container-fluid px-5">
    <h2 class="text-center fw-bold mb-4">Berita Terbaru</h2>
    <hr class="mx-auto mb-5" style="width: 120px; border-top: 4px solid #dc3545;">

    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card mb-5 shadow-lg border-0">
          <div class="row g-0">
            <div class="col-lg-6">
              <img src="<?= base_url('assets/image/slider2.svg'); ?>" class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="Berita 1">
            </div>
            <div class="col-lg-6 d-flex align-items-center">
              <div class="card-body p-5">
                <h3 class="card-title fw-bold mb-3">Judul Berita</h3>
                <p class="card-text fs-5">Deskripsi berita. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint adipisci, veniam modi suscipit quos explicabo vitae, nulla iure quidem, voluptate ipsa laborum! Eos provident tempora corrupti laborum quidem voluptate veniam.</p>
                <a href="#" class="btn btn-custom btn-lg mt-3 px-4">Selengkapnya</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
