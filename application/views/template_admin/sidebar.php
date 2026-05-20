<style>
    .badge-counter {
    font-size: 0.9rem;   
    padding: 0.3em 0.4em; 
    }

</style>



<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <?php
    // 1. Cek role user yang sedang login
    $role = $this->session->userdata('role');
    $jumlah_notif = 0;
    $judul_dropdown = "Pemberitahuan";

    // 2. Hitung notifikasi berdasarkan Role
    if ($role == 'admin') {
        // ADMIN: Hitung pengajuan yang masih 'menunggu' dari Kadus
        $jumlah_notif = $this->db->join('users', 'users.id_user = data_surat.id_user')
            ->where(['data_surat.status' => 'menunggu', 'users.role' => 'kadus'])
            ->count_all_results('data_surat');
        $judul_dropdown = "Pengajuan Surat Baru";
    } elseif ($role == 'kadus') {
        // KADUS: Hitung surat miliknya yang sudah 'disetujui' atau 'ditolak' dan belum dilihat
        $id_user = $this->session->userdata('id_user');

        $this->db->where('id_user', $id_user);
        $this->db->where('new_approved', 1);
        $this->db->group_start();
        $this->db->where('status', 'disetujui');
        $this->db->or_where('status', 'ditolak');
        $this->db->group_end();

        $jumlah_notif = $this->db->count_all_results('data_surat');
        $judul_dropdown = "Status Surat Dusun";
    }
    ?>
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand bg-white d-flex align-items-center justify-content-center" href="<?= base_url('Landing') ?>">
        <img src="<?= base_url('assets/image/logo_desa.svg'); ?>" alt="Logo Desa" class="img-fluid w-100" style="max-height: 65px;">
    </a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    <?php if ($this->session->userdata('role') == 'superadmin'): ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="<?= site_url('dashboard') ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Landing Page
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
                    <a class="collapse-item" href="<?= site_url('berita') ?>"> Data Berita</a>
                    <a class="collapse-item" href="<?= site_url('berita/create') ?>">Tambah Data</a>
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
                    <a class="collapse-item" href="<?= site_url('aparatur') ?>">Data Aparatur</a>
                    <a class="collapse-item" href="<?= site_url('aparatur/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsewarga"
                aria-expanded="true" aria-controls="collapsewarga">
                <i class="fas fa-users"></i>
                <span>Warga</span>
            </a>
            <div id="collapsewarga" class="collapse" aria-labelledby="headingwarga"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('keluarga/index') ?>">Data Keluarga</a>
                    <a class="collapse-item" href="<?= site_url('keluarga/tambah') ?>">Tambah keluarga</a>
                    <a class="collapse-item" href="<?= site_url('warga/index') ?>">Data Warga</a>
                    <a class="collapse-item" href="<?= site_url('warga/tambah') ?>">Tambah Warga</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLembaga"
            aria-expanded="true" aria-controls="collapseLembaga">
            <i class="fas fa-user-tie"></i>
            <span>Lembaga</span>
        </a>
        <div id="collapseLembaga" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('lembaga')?>">Data Lembaga</a>
                <a class="collapse-item" href="<?= site_url('lembaga/create')?>">Tambah Lembaga</a>
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
                    <a class="collapse-item" href="<?= site_url('galeri') ?>">Data Galeri</a>
                    <a class="collapse-item" href="<?= site_url('galeri/create') ?>">Tambah Data</a>
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
                    <a class="collapse-item" href="<?= site_url('potensi') ?>">Data Potensi</a>
                    <a class="collapse-item" href="<?= site_url('potensi/create') ?>">Tambah Data</a>
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
                    <a class="collapse-item" href="<?= site_url('peraturan') ?>">Data Peraturan</a>
                    <a class="collapse-item" href="<?= site_url('peraturan/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>
       
    <div class="sidebar-heading mt-3">
        Public Service
    </div>
     <!-- Pengaduan Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengaduan"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-file-alt"></i>
            <span>Pengaduan</span>
            <span class="badge badge-danger notif_pengaduan"  style="display: none; font-size: 12px"></span>
        </a>
        <div id="collapsePengaduan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('PengaduanAdmin')?>">
                    Data Pengaduan
                    <span class="badge badge-danger notif_pengaduan"  style="display: none; font-size: 12px"></span>
                </a>
                <a class="collapse-item" href="<?= site_url('PengaduanAdmin/arsip')?>">Arsip Pengaduan</a>
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
                    <a class="collapse-item" href="<?= site_url('surat') ?>">Data Surat</a>
                    <a class="collapse-item" href="<?= site_url('Template_surat/create') ?>">Tambah Data</a>
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
                    <a class="collapse-item" href="<?= site_url('apbdes') ?>">Data APBDES</a>
                    <a class="collapse-item" href="<?= site_url('apbdes/create') ?>">Tambah Data</a>
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
                    <a class="collapse-item" href="<?= site_url('dusun') ?>">Data Dusun</a>
                    <a class="collapse-item" href="<?= site_url('dusun/create') ?>">Tambah Data</a>
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
                    <a class="collapse-item" href="<?= site_url('users') ?>">Data Users</a>
                    <a class="collapse-item" href="<?= site_url('users/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <?php if ($this->session->userdata('role') == 'admin'): ?>
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('admin'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('admin/daftar_surat'); ?>">
                <i class="fas fa-list"></i>
                <span>Surat</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link position-relative"
                href="<?= site_url('admin/verifikasi_data') ?>">
                <i class="fas fa-file"></i>
                <span>Antrian Surat</span>

                <?php if ($jumlah_notif > 0): ?>
                    <span class="badge badge-danger"><?= $jumlah_notif ?></span>
                <?php endif; ?>
            </a>
            <div id="collapseSurat" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('admin/verifikasi_data') ?>">Surat Masuk</a>
                    <a class="collapse-item" href="<?= site_url('admin/verifikasi_selesai') ?>">Data Surat Selesai</a>
                </div>
            </div>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('admin/arsip'); ?>">
                <i class="fas fa-archive"></i>
                <span>Arsip Surat</span></a>
        </li>
    <?php endif; ?>

    <?php if ($this->session->userdata('role') == 'kadus'): ?>
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('kadus'); ?>">
                <i class="fas fa-file-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('kadus/buat_surat'); ?>">
                <i class="fas fa-file-alt"></i>
                <span>Buat Surat</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('kadus/arsip'); ?>">
                <i class="fas fa-file-alt"></i>
                <span>Arsip Surat Dusun</span>
                <?php if ($jumlah_notif > 0): ?>
                    <span class="badge badge-danger"><?= $jumlah_notif ?></span>
                <?php endif; ?>
            </a>

        </li>

             <!-- warga Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWarga"
            aria-expanded="true" aria-controls="collapseWarga">
            <i class="fas fa-file-alt"></i>
            <span>Data Warga</span>
            <span  style="display: none; font-size: 12px;"></span>
        </a>
        <div id="collapseWarga" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= base_url('kadus/jumlah_kk'); ?>">
                    Data KK
                    <span class="badge"  style="display: none; font-size: 12px;"></span>
                </a>
                <a class="collapse-item" href="<?= base_url('kadus/data_warga'); ?>">Data Warga</a>
            </div>
        </div>
    </li>
         <!-- Pengaduan Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengaduan"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-file-alt"></i>
            <span>Pengaduan</span>
            <span class="badge badge-danger jumlah_notif_kadus"  style="display: none; font-size: 12px;"></span>
        </a>
        <div id="collapsePengaduan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= site_url('PengaduanAdmin')?>">
                    Data Pengaduan
                    <span class="badge badge-danger jumlah_notif_kadus"  style="display: none; font-size: 12px;"></span>
                </a>
                <a class="collapse-item" href="<?= site_url('PengaduanAdmin/arsip')?>">Arsip Pengaduan</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

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

                <!-- Notification Item - Alerts -->
                <!-- <?php if($this->session->userdata('role') == 'superadmin') { ?>
                    <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#"
                        id="alertsDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-bell fa-fw fa-lg"></i>
                        <span class="badge badge-danger badge-counter notif_pengaduan"  style="display: none;"></span>
                    </a>

                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow" id="dropdown_notifikasi">
                        <span class="dropdown-item text-center small text-gray-500">
                        Tidak ada notifikasi
                        </span>
                    </div>
                </li>
                <?php } ?> -->


                <!-- Notification Item - Alerts -->
                <!-- <?php if($this->session->userdata('role') == 'kadus') { ?>
                    <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#"
                        id="alertsDropdownKadus" role="button" data-toggle="dropdown">
                        <i class="fas fa-bell fa-fw fa-lg"></i>
                        <span class="badge badge-danger badge-counter notif_pengaduan_kadus"  style="display: none;"></span>
                    </a>

                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow" id="dropdown_notifikasi_kadus">
                        <span class="dropdown-item text-center small text-gray-500">
                        Tidak ada notifikasi
                        </span>
                    </div>
                </li>
                <?php } ?> -->
<!-- 
                <?php if ($role == 'admin' || $role == 'kadus'): ?>
                    <li class="nav-item dropdown no-arrow mx-2">
                        <a class="nav-link dropdown-toggle position-relative"
                            href="#"
                            id="notifDropdown"
                            role="button"
                            data-toggle="dropdown">

                            <i class="fas fa-bell fa-fw fa-lg"></i>

                            <span id="notifBadge"
                                class="badge badge-danger badge-counter"
                                style="<?= $jumlah_notif > 0 ? '' : 'display:none;' ?>">
                                <?= $jumlah_notif ?>
                            </span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow"
                            style="width:400px;"
                            id="notifDropdownMenu">

                            <h6 class="dropdown-header"><?= $judul_dropdown ?></h6>

                            <div id="notifList">
                                <div class="text-center small text-gray-500 py-2">
                                    Memuat...
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endif; ?> -->

            <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle position-relative" href="#"
       id="alertsDropdownGlobal"
       role="button"
       data-toggle="dropdown">

        <i class="fas fa-bell fa-fw fa-lg"></i>

        <span class="badge badge-danger notif_global"
              style="display:none;"></span>
    </a>

   <div class="dropdown-list dropdown-menu dropdown-menu-right shadow"
     id="dropdown_notifikasi_global">

    <div id="notif_pengaduan_area"></div>
    <div id="notif_surat_area">
        <span class="dropdown-item text-center small text-gray-500">
            Tidak ada notifikasi
        </span>
    </div>

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
                            src="<?= base_url('assets/admin/img/undraw_profile.svg') ?>">
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