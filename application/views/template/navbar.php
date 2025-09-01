<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="#">
      <img src="<?= base_url('assets/image/logo_desa.svg'); ?>" alt="Logo Desa" class="img-fluid w-100" style="max-height: 70px;">
    </a>

    <!-- Hamburger Menu -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header pt-3">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?= site_url('/'); ?>">Beranda</a>
          </li>

          <!-- Profile Desa Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Profile Desa
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= site_url('landing/sejarah_desa'); ?>">Sejarah Desa</a></li>
              <li><a class="dropdown-item" href="<?= site_url('landing/visi_misi'); ?>">Visi Misi</a></li>
              <li><a class="dropdown-item" href="<?= site_url('landing/struktur_pemerintahan'); ?>">Struktur Pemerintahan</a></li>
              <li><a class="dropdown-item" href="#">Peta Wilayah</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('landing/potensi_desa'); ?>">Potensi Desa</a>
          </li>

          <!-- Informasi Publik Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Informasi Publik
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= site_url('landing/peraturan_desa'); ?>">Peraturan Desa</a></li>
              <li><a class="dropdown-item" href="#">APBDes</a></li>
            </ul>
          </li>

          <!-- Pusat Layanan Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Pusat Layanan
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Pengajuan Surat</a></li>
            </ul>
          </li>
        </ul>

        <!-- Tombol Login -->
        <div class="d-flex">
          <a href="<?= base_url('login'); ?>" class="btn btn-custom w-100">Login</a>
        </div>
      </div>
    </div>
  </div>
</nav>