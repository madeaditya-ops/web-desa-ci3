<style>
    .struktur-img {
    width: 100%;
    height: auto;
    object-fit: cover;
    display: block;
    margin: auto;
  }

</style>


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
          <img src="<?=base_url('assets/image/struktur_pemdes.jpeg')?>" alt="Struktur Pemerintahan Desa" class="struktur-img">
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
    <div class="row g-2 row-aparat">
      <?php foreach ($aparatur as $item): ?>
        <div class="col-sm-3">
          <div class="card aparat-card mb-2">
            <div class="card-body text-center card-aparat-body">
              <img src="<?= base_url('uploads/aparatur/' . $item['foto']); ?>" alt="Kepala Desa" class="aparat-photo">
              <p class="aparat-nama">
                <?= ucwords(strtolower($item['nama'])) ?>
              </p>
              <p class="aparat-jabatan">
                <?= ucwords(strtolower($item['jabatan'])) ?>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>