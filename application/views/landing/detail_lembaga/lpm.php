<style>
    .struktur-img {
    width: 50%;
    height: auto;
    object-fit: cover;
    display: block;
    margin: auto;
  }

</style>

<section id="bpd">
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
          <img src="<?=base_url('assets/image/bpd.jpeg')?>" alt="Struktur Pemerintahan Desa" class="struktur-img">
        </div>
      </div>
    </div>
    </div>

    <div class="container-fluid">
        <div class="row bg-dark-subtle px-4 px-md-5 py-3">
        <div class="col m-0 p-0">
            <div class="d-flex align-items-center">
            <h4 class="section-subtitle">Anggota <?=$title;?></h4>
            </div>
        </div>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5">
        <div class="row g-2 row-aparat">
            <div class="col-sm-3">
            <div class="card aparat-card mb-2">
                <div class="card-body text-center card-aparat-body">
                <img src="<?= base_url('uploads/anggota_bpd/' . ($item['foto'] ?? 'default.jpeg')); ?>" alt="Anggota BPD" class="aparat-photo">
                <p class="aparat-nama">
                    I Balik Suteja 
                </p>
                <p class="aparat-jabatan">
                    Ketua
                </p>
                </div>
            </div>
            </div>
        </div>
    </div>



</section>




