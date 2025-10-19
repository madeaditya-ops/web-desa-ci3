<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="<?= site_url('/'); ?>">
      <img src="<?= base_url('assets/image/logo_desa.svg'); ?>" alt="Logo Desa" class="img-fluid w-100" style="max-height: 65px;">
    </a>

    <!-- Hamburger Menu -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="humberger">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header pt-3">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <!-- Beranda -->
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">

          <!-- Beranda -->
          <li class="nav-item">
            <a class="nav-link <?= ($this->router->class == 'Landing' ? 'active' : '') ?>" href="<?= site_url('/'); ?>">Beranda</a>
          </li>

          <!-- Profile Desa Dropdown -->
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= (
                in_array($this->uri->segment(2), 
                ['sejarah_desa','visi_misi','struktur_pemerintahan','peta_wilayah']) 
                ? 'active' : '') ?>" 
            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profile Desa
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?= ($this->uri->segment(2) == 'sejarah_desa' ? 'active' : '') ?>" href="<?= site_url('landing/sejarah_desa'); ?>">Sejarah Desa</a></li>
            <li><a class="dropdown-item <?= ($this->uri->segment(2) == 'visi_misi' ? 'active' : '') ?>" href="<?= site_url('landing/visi_misi'); ?>">Visi Misi</a></li>
            <li><a class="dropdown-item <?= ($this->uri->segment(2) == 'struktur_pemerintahan' ? 'active' : '') ?>" href="<?= site_url('landing/struktur_pemerintahan'); ?>">Struktur Pemerintahan</a></li>
            <li><a class="dropdown-item <?= ($this->uri->segment(2) == 'peta_wilayah' ? 'active' : '') ?>" href="<?= site_url('landing/peta_wilayah'); ?>">Peta Wilayah</a></li>
          </ul>
        </li>

        
          <!-- Potensi Desa -->
          <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'potensi_desa' ? 'active' : '') ?>" href="<?= site_url('landing/potensi_desa'); ?>">Potensi Desa</a>
          </li>

          <!-- Informasi Publik Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?= (
              in_array($this->uri->segment(2), ['peraturan_desa','apbdes']) 
              ? 'active' : '') ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Informasi Publik
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item <?= ($this->uri->segment(2) == 'peraturan_desa' ? 'active' : '') ?>" href="<?= site_url('landing/peraturan_desa'); ?>">Peraturan Desa</a></li>
              <li><a class="dropdown-item <?= ($this->uri->segment(2) == 'apbdes' ? 'active' : '') ?>" href="<?= site_url('landing/apbdes'); ?>">APBDes</a></li>
            </ul>
          </li>

          <!-- Pusat Layanan Dropdown -->
          <li class="nav-item dropdown <?= ($this->uri->segment(1) == 'login' ? 'active' : '') ?>">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Pusat Layanan
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item <?= ($this->uri->segment(1) == 'login' ? 'active' : '') ?>" href="<?= base_url('login'); ?>" target="_blank">Pengajuan Surat</a></li>
            </ul>
          </li>
        </ul>

        <!-- Tombol Login -->
        <div class="d-flex">
          <a href="<?= base_url('login'); ?>" class="btn btn-custom w-100" target="_blank">Login</a>
        </div>
      </div>
    </div>
  </div>
</nav>
