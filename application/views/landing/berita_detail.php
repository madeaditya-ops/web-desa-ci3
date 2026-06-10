<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <!-- Title -->
    <title><?= htmlspecialchars($berita['judul']); ?></title>

    <!-- SEO Meta -->
    <meta name="description" content="<?= substr(strip_tags($berita['isi']), 0, 160); ?>">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="<?= htmlspecialchars($berita['judul']); ?>">
    <meta property="og:description" content="<?= substr(strip_tags($berita['isi']), 0, 160); ?>">
    <meta property="og:image" content="<?= base_url('uploads/berita/' . $berita['gambar']); ?>">
    <meta property="og:url" content="<?= current_url(); ?>">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="Website Desa Blahbatuh">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-9">

      <div class="card shadow-sm border-0">

        <div class="ratio ratio-16x9">
          <img src="<?= base_url('uploads/berita/' . $berita['gambar']); ?>"
               alt="<?= htmlspecialchars($berita['judul']); ?>"
               class="img-fluid rounded-top object-fit-cover">
        </div>

        <div class="card-body p-4">

          <h1 class="fw-bold mb-3"><?= htmlspecialchars($berita['judul']); ?></h1>

          <div class="d-flex flex-wrap gap-2 mb-2">
                  <span class="badge1">Berita</span>
                  <span class="badge2"> <?=$berita['created_at']?> </span>
          </div>

          <div class="lh-lg">
            <strong><?= lokasi_berita($berita['lokasi'] ?? null); ?></strong>
            <?= nl2br($berita['isi']); ?>
          </div>

          <hr>

          <?php
          $share_url = base_url('berita/' . $berita['slug']);
          $share_text =
            "Berita Blahbatuh\n\n" .
            $berita['judul'] . "\n\n" .
            "Selengkapnya silahkan kunjungi link berikut:\n" .
            $share_url;
          ?>
          
        <span class="fw-semibold text-muted">Bagikan ke:</span>
          <div class="d-flex gap-2 mt-2">
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

    </div>
  </div>

  <div class="d-flex justify-content-center mt-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house-door text-primary me-2"></i>
            </li>
            <?php $this->load->view('partials/breadcrumb'); ?>
        </ol>
    </div>
</div>


</body>
</html>
<!-- End berita detail section -->