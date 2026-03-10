<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Judul Halaman -->
    <title><?= isset($title) ? $title : 'Website Resmi Desa Blahbatuh'; ?></title>
    
    <!-- Deskripsi SEO -->
    <meta name="description" content="<?= isset($meta_description) ? $meta_description : 'Website Resmi Desa Blahbatuh sebagai media informasi publik, pelayanan administrasi, dan transparansi pemerintah desa.'; ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= current_url(); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/image/favicon-96x96.png') ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/image/favicon.svg') ?>" />
    <link rel="shortcut icon" href="<?= base_url('assets/image/favicon.ico') ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/image/apple-touch-icon.png') ?>" />
    <link rel="manifest" href="<?= base_url('assets/image/site.webmanifest') ?>" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= isset($og_title) ? $og_title : 'Website Resmi Desa Blahbatuh'; ?>">
    <meta property="og:description" content="<?= isset($og_description) ? $og_description : 'Website Resmi Desa Blahbatuh sebagai media informasi publik, pelayanan administrasi, dan transparansi pemerintah desa.'; ?>">
    <meta property="og:url" content="<?= current_url(); ?>">
    <meta property="og:image" content="<?= base_url('assets/image/logo_desa_blahbatuh.png'); ?>">
    <meta property="og:site_name" content="Website Resmi Desa Blahbatuh">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= isset($twitter_title) ? $twitter_title : 'Website Resmi Desa Blahbatuh'; ?>">
    <meta name="twitter:description" content="<?= isset($twitter_description) ? $twitter_description : 'Website Resmi Desa Blahbatuh sebagai media informasi publik, pelayanan administrasi, dan transparansi pemerintah desa.'; ?>">
    <meta name="twitter:image" content="<?= base_url('assets/image/logo_desa_blahbatuh.png'); ?>">
    <meta name="twitter:site" content="@DesaBlahbatuh">

    <!-- Theme Color Mobile Browser -->
    <meta name="theme-color" content="#006400">

    <!-- CSS & Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

    <!-- Sweet Alert -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     
    <!-- Structured Data / Schema.org -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "GovernmentOrganization",
      "name": "Pemerintah Desa Blahbatuh",
      "alternateName": "Website Resmi Pemerintah Desa Blahbatuh",
      "url": "<?= base_url(); ?>",
      "logo": "<?= base_url('assets/image/logo_desa_blahbatuh.png'); ?>",
      "sameAs": [
        "https://www.facebook.com/DesaBlahbatuh",
        "https://www.instagram.com/DesaBlahbatuh"
      ]
    }
    </script>
</head>
<body>
