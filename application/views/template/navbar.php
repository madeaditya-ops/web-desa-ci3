<style>
.navbar{
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    width: 100%;
    z-index: 1000;
}


.navbar-brand img {
  height: clamp(62px, 14vw, 76px);
  width: auto;
}


.navbar,
.offcanvas-header,
.offcanvas-body {
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
}

.navbar-nav .nav-link,
.dropdown-menu .dropdown-item {
  font-size: 0.9rem;
  padding-top: 0.4rem;
  padding-bottom: 0.4rem;
}

.navbar-nav .nav-link {
    color: var(--secondary);

    &:hover{
        color: var(--primary);
    }

    &:active{
        color: var(--primary);
    }
}

.dropdown-menu .dropdown-item:hover{
    background-color: var(--light);
    color: var(--primary);

    &:active{
        background-color: var(--primary);
        color: #fff;
    }
}

.navbar-nav .nav-item .active {
  background: none;
  border-bottom: 2px solid var(--primary) ;
  color: #000;
}


/* Transisi hanya aktif di layar lebar (>=992px) */
@media (min-width: 992px) {
  .navbar .dropdown-menu {
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
    display: block;
    visibility: hidden;
    pointer-events: none;
  }

  .navbar .dropdown-menu.show {
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
    pointer-events: auto;
  }

}

@media (max-width: 991px) and (min-width: 577px) {
  /*.navbar-brand img {*/
  /*  max-height: 65px;*/
  /*}*/

  .navbar-nav .nav-link {
    font-size: 0.85rem;
  }

  .offcanvas {
    width: 70% !important;
  }
}

/* Mobile kecil (≤576px) */
@media (max-width: 576px) {
  .navbar {
    padding-top: 0.2rem;
    padding-bottom: 0.2rem;
  }

  /*.navbar-brand img {*/
  /*  max-height: 65px;*/
  /*}*/

  .navbar-nav .nav-link,
  .dropdown-menu .dropdown-item {
    font-size: 1rem;
    padding: 0.3rem 0.4rem;
  }

  .offcanvas {
    width: 80% !important;
  }

  .navbar-nav .nav-item {
    margin-bottom: 0.2rem;
  }

  .navbar-toggler {
    padding: 0.3rem 0.5rem;
    font-size: 0.85rem;
  }
}

@media (max-width: 480px) {
  /*.navbar-brand img {*/
  /*  max-height: 60px;*/
  /*}*/

  .navbar-nav .nav-link,
  .dropdown-menu .dropdown-item {
    font-size: 1rem;
    padding: 0.25rem 0.3rem;
  }

  .offcanvas {
    width: 85% !important;
  }

  .navbar-nav .nav-item {
    margin-bottom: 0.15rem;
  }
}
</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="<?= site_url('/'); ?>">
      <img src="<?= base_url('assets/image/logo_desa.svg' ? 'assets/image/logo_desa.png' : ''); ?>" alt="Logo Desa" class="img-fluid" >
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
            <li><a class="dropdown-item <?= ($this->uri->segment(2) == 'lembaga' ? 'active' : '') ?>" href="<?= site_url('landing/lembaga'); ?>">Lembaga</a></li>
          </ul>
        </li>

        

        
          <!-- Potensi Desa -->
          <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'potensi_desa' ? 'active' : '') ?>" href="<?= site_url('landing/potensi_desa'); ?>">Potensi</a>
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
              <li><a class="dropdown-item <?= ($this->uri->segment(2) == 'berita_desa' ? 'active' : '') ?>" href="<?= site_url('landing/berita_desa'); ?>">Berita Desa</a></li>
            </ul>
          </li>

          <!-- Pusat Layanan Dropdown -->
          <li class="nav-item dropdown <?= ($this->uri->segment(1) == 'login' ? 'active' : '') ?>">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Pusat Layanan
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item <?= ($this->uri->segment(1) == 'login' ? 'active' : '') ?>" href="<?= base_url('login'); ?>" target="_blank">Pengajuan Surat</a></li>
              <li><a class="dropdown-item <?= ($this->uri->segment(1) == 'pengaduan' ? 'active' : '') ?>" href="<?= base_url('pengaduan'); ?>" >Pengaduan Masyarakat</a></li>
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
