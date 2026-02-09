<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand bg-white d-flex align-items-center justify-content-center" href="<?=base_url('Landing')?>">
        <img src="<?= base_url('assets/image/logo_desa.svg'); ?>" alt="Logo Desa" class="img-fluid w-100" style="max-height: 65px;">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php if ($this->session->userdata('role') == 'kades'): ?>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= site_url('dashboard')?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-newspaper"></i>
            <span>Berita</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('berita')?>"> Data Berita</a>
                <a class="collapse-item" href="<?= site_url('berita/create')?>">Tambah Data</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-user-tie"></i>
            <span>Aparatur</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('aparatur')?>">Data Aparatur</a>
                <a class="collapse-item" href="<?= site_url('aparatur/create')?>">Tambah Data</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-images"></i>
            <span>Galeri</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('galeri')?>">Data Galeri</a>
                <a class="collapse-item" href="<?= site_url('galeri/create')?>">Tambah Data</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePotensi"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-seedling"></i>
            <span>Potensi desa</span>
        </a>
        <div id="collapsePotensi" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('potensi')?>">Data Potensi</a>
                <a class="collapse-item" href="<?= site_url('potensi/create')?>">Tambah Data</a>
            </div>
        </div>
    </li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSurat"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-file-alt"></i>
            <span>Surat</span>
        </a>
        <div id="collapseSurat" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('surat')?>">Data Surat</a>
                <a class="collapse-item" href="<?= site_url('Template_surat/create')?>">Tambah Data</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePeraturan"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-balance-scale"></i>
            <span>Peraturan Desa</span>
        </a>
        <div id="collapsePeraturan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('peraturan')?>">Data Peraturan</a>
                <a class="collapse-item" href="<?= site_url('peraturan/create')?>">Tambah Data</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAPBDES"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-money-check-alt"></i>
            <span>APBDES</span>
        </a>
        <div id="collapseAPBDES" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('apbdes')?>">Data APBDES</a>
                <a class="collapse-item" href="<?= site_url('apbdes/create')?>">Tambah Data</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDusun"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-home"></i>
            <span>Dusun</span>
        </a>
        <div id="collapseDusun" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('dusun')?>">Data Dusun</a>
                <a class="collapse-item" href="<?= site_url('dusun/create')?>">Tambah Data</a>
            </div>
        </div>
    </li>

    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-user-cog"></i>
            <span>Users</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('users')?>">Data Users</a>
                <a class="collapse-item" href="<?= site_url('users/create')?>">Tambah Data</a>
            </div>
        </div>
    </li>
    <?php endif;?>

    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('admin'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('admin/daftar_surat'); ?>">
            <i class="fas fa-file-alt"></i>
                <span>Surat</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('admin/arsip'); ?>">
            <i class="fas fa-file-alt"></i>
                <span>Arsip Surat</span></a>
    </li>
    <?php endif;?>

    <?php if ($this->session->userdata('role') == 'kadus'): ?>
    <li class="nav-item active">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-file-alt"></i>
                <span>Surat Dusun</span></a>
    </li>
    <?php endif;?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    
</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <!-- <form
                class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form> -->

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            <?= $this->session->userdata('username'); ?>
                        </span>
                        <img class="img-profile rounded-circle"
                            src="<?= base_url('assets/admin/img/undraw_profile.svg')?>">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <!-- <a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a> -->

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
<!-- End of Topbar -->