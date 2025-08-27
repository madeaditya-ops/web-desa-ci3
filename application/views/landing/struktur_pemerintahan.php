<section class="struktur_pemerintahan" id="struktur_pemerintahan">
  <div class="container-fluid">
    <div class="row bg-dark-subtle px-4 px-md-5 py-3">
      <div class="col m-0 p-0">
        <div class="d-flex align-items-center">
          <h4 class="section-title"><?=$title;?></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid px-4 px-md-5">
    <div class="row">
      <div class="col">
        <div class="card rounded-0 border-0 my-3">
          <img src="<?=base_url('assets/image/struktur_pemerintahan.jpg')?>" alt="Struktur Pemerintahan Desa" class="struktur-img">
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row bg-dark-subtle px-4 px-md-5 py-3">
      <div class="col m-0 p-0">
        <div class="d-flex align-items-center">
          <h4 class="section-subtitle">Aparat Pemerintah Desa</h4>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid px-4 px-md-5">
    <div class="row">
      <div class="col-sm-3">
        <div class="card aparat-card">
          <div class="card-body text-center">
            <img src="<?=base_url('upload/aparat/foto1.jpeg')?>" alt="Kepala Desa" class="aparat-photo">
            <p class="aparat-nama">
              <?= ucwords(strtolower("GEDE SATYA KUSUMA, S.H.")) ?>
            </p>
            <p class="aparat-jabatan">
              <?= ucwords(strtolower("PERBEKEL BLAHBATUH")) ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>