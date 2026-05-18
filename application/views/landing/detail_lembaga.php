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
          <img src="<?=base_url('uploads/lembaga/'.$meta['image'] ?? 'default.jpeg')?>" alt="Lembaga Desa Blahbatuh" class="struktur-img">
        </div>
      </div>
    </div>
    </div>

    <div class="container-fluid">
        <div class="row bg-dark-subtle px-4 px-md-5 py-3">
        <div class="col m-0 p-0">
            <div class="d-flex align-items-center">
            <h4 class="section-subtitle">
                <?php if (!empty($anggota)) : ?>
                    Daftar Anggota
                <?php elseif (!empty($bidang)) : ?>
                    Daftar Bidang
                <?php endif; ?>
            </h4>
            </div>
        </div>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5">
        <div class="row g-2 row-aparat">

        <?php if (!empty($anggota)) : ?>

            <?php foreach ($anggota as $item): ?>
                <div class="col-sm-3">
                    <div class="card aparat-card mb-2">
                        <div class="card-body text-center card-aparat-body">
                            <img src="<?= base_url('uploads/anggota_lembaga/' . ($item['foto'] ?? 'default.jpeg')); ?>" 
                                class="aparat-photo">
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

        <?php elseif (!empty($bidang)) : ?>

            <?php foreach ($bidang as $item): ?>
                <div class="col-12">
                <div class="card shadow-sm border-0 mb-3 mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class=" bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                <i class="bi <?= $item['icon']; ?>"></i>
                            </div>
                            <h5 class="card-title ms-3 mb-0 fw-bold" style="color: var(--primary);">
                                <?= $item['nama_bidang']; ?>
                            </h5>
                        </div>
                        <p class="card-text text-muted"><?= $item['deskripsi']; ?></p>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>

        <?php else : ?>

            <div class="col-12">
                <p class="text-center">Data belum tersedia.</p>
            </div>

        <?php endif; ?>

        </div>
    </div>




</section>




