<section class="galeri_foto" id="galeri_foto">
 <div class="container-fluid">
    <div class="row bg-dark-subtle px-3 px-md-5 py-3">
      <div class="col m-0 p-0">
        <div class="d-flex align-items-center">
          <h4 class="fw-bold text-start m-0" style="color:var(--primary);"><?=$title;?></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid px-3 px-md-5 py-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php foreach ($galeri as $item): ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <img src="<?= base_url('uploads/galeri/' . $item->gambar); ?>" class="card-img-top" alt="UMKM Desa Blahbatuh">
            <div class="card-body">
              <p class="caption fw-bold mb-1"><?= potong_caption($item->caption, 35); ?></p>
              <span class="badge2"><?= $item->created_at ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-center mt-5 small">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house-door text-primary me-2"></i>
            </li>
            <?php $this->load->view('partials/breadcrumb'); ?>
        </ol>
    </div>
  </div>
</section>