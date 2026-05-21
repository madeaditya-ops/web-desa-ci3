<style>
    .badge-counter {
        font-size: 0.9rem;
        padding: 0.3em 0.4em;
    }
</style>



<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <?php

    $role = $this->session->userdata('role');
    $jumlah_notif = 0;
    $judul_dropdown = "Pemberitahuan";


    if ($role == 'admin') {

        $jumlah_notif = $this->db->join('users', 'users.id_user = data_surat.id_user')
            ->where(['data_surat.status' => 'menunggu', 'users.role' => 'kadus'])
            ->count_all_results('data_surat');
        $judul_dropdown = "Pengajuan Surat Baru";
    } elseif ($role == 'kadus') {
        
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

        <!-- Nav Item - Berita -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBerita"
                aria-expanded="true" aria-controls="collapseBerita">
                <i class="fas fa-newspaper"></i>
                <span>Berita</span>
            </a>
            <div id="collapseBerita" class="collapse" aria-labelledby="headingBerita" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('berita') ?>">Data Berita</a>
                    <a class="collapse-item" href="<?= site_url('berita/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Aparatur -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAparatur"
                aria-expanded="true" aria-controls="collapseAparatur">
                <i class="fas fa-user-tie"></i>
                <span>Aparatur</span>
            </a>
            <div id="collapseAparatur" class="collapse" aria-labelledby="headingAparatur"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('aparatur') ?>">Data Aparatur</a>
                    <a class="collapse-item" href="<?= site_url('aparatur/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Warga -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWargaSuperadmin"
                aria-expanded="true" aria-controls="collapseWargaSuperadmin">
                <i class="fas fa-users"></i>
                <span>Warga</span>
            </a>
            <div id="collapseWargaSuperadmin" class="collapse" aria-labelledby="headingWargaSuperadmin"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('keluarga/index') ?>">Data Keluarga</a>
                    <a class="collapse-item" href="<?= site_url('keluarga/tambah') ?>">Tambah keluarga</a>
                    <a class="collapse-item" href="<?= site_url('warga/index') ?>">Data Warga</a>
                    <a class="collapse-item" href="<?= site_url('warga/tambah') ?>">Tambah Warga</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Lembaga -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLembaga"
                aria-expanded="true" aria-controls="collapseLembaga">
                <i class="fas fa-user-tie"></i>
                <span>Lembaga</span>
            </a>
            <div id="collapseLembaga" class="collapse" aria-labelledby="headingLembaga"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('lembaga') ?>">Data Lembaga</a>
                    <a class="collapse-item" href="<?= site_url('lembaga/create') ?>">Tambah Lembaga</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Galeri -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGaleri"
                aria-expanded="true" aria-controls="collapseGaleri">
                <i class="fas fa-images"></i>
                <span>Galeri</span>
            </a>
            <div id="collapseGaleri" class="collapse" aria-labelledby="headingGaleri" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('galeri') ?>">Data Galeri</a>
                    <a class="collapse-item" href="<?= site_url('galeri/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Potensi Desa -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePotensi"
                aria-expanded="true" aria-controls="collapsePotensi">
                <i class="fas fa-seedling"></i>
                <span>Potensi desa</span>
            </a>
            <div id="collapsePotensi" class="collapse" aria-labelledby="headingPotensi" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('potensi') ?>">Data Potensi</a>
                    <a class="collapse-item" href="<?= site_url('potensi/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Peraturan Desa -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePeraturan"
                aria-expanded="true" aria-controls="collapsePeraturan">
                <i class="fas fa-balance-scale"></i>
                <span>Peraturan Desa</span>
            </a>
            <div id="collapsePeraturan" class="collapse" aria-labelledby="headingPeraturan" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('peraturan') ?>">Data Peraturan</a>
                    <a class="collapse-item" href="<?= site_url('peraturan/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>

        <div class="sidebar-heading mt-3">
            Public Service
        </div>

        <!-- Nav Item - Pengaduan (superadmin) -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengaduanSuperadmin"
                aria-expanded="true" aria-controls="collapsePengaduanSuperadmin">
                <i class="fas fa-file-alt"></i>
                <span>Pengaduan</span>
                <span class="badge badge-danger notif_pengaduan" style="display: none; font-size: 12px"></span>
            </a>
            <div id="collapsePengaduanSuperadmin" class="collapse" aria-labelledby="headingPengaduanSuperadmin" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('PengaduanAdmin') ?>">
                        Data Pengaduan
                        <span class="badge badge-danger notif_pengaduan" style="display: none; font-size: 12px"></span>
                    </a>
                    <a class="collapse-item" href="<?= site_url('PengaduanAdmin/arsip') ?>">Arsip Pengaduan</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Surat (superadmin) -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSuratSuperadmin"
                aria-expanded="true" aria-controls="collapseSuratSuperadmin">
                <i class="fas fa-file-alt"></i>
                <span>Surat</span>
            </a>
            <div id="collapseSuratSuperadmin" class="collapse" aria-labelledby="headingSuratSuperadmin" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('surat') ?>">Data Surat</a>
                    <a class="collapse-item" href="<?= site_url('Template_surat/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - APBDES -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAPBDES"
                aria-expanded="true" aria-controls="collapseAPBDES">
                <i class="fas fa-money-check-alt"></i>
                <span>APBDES</span>
            </a>
            <div id="collapseAPBDES" class="collapse" aria-labelledby="headingAPBDES" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('apbdes') ?>">Data APBDES</a>
                    <a class="collapse-item" href="<?= site_url('apbdes/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Dusun -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDusun"
                aria-expanded="true" aria-controls="collapseDusun">
                <i class="fas fa-home"></i>
                <span>Dusun</span>
            </a>
            <div id="collapseDusun" class="collapse" aria-labelledby="headingDusun" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('dusun') ?>">Data Dusun</a>
                    <a class="collapse-item" href="<?= site_url('dusun/create') ?>">Tambah Data</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Users -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
                aria-expanded="true" aria-controls="collapseUsers">
                <i class="fas fa-user-cog"></i>
                <span>Users</span>
            </a>
            <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
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
            <!-- FIX: ID diganti menjadi collapseSuratAdmin agar tidak bentrok dengan superadmin -->
            <div id="collapseSuratAdmin" class="collapse" aria-labelledby="headingSuratAdmin" data-parent="#accordionSidebar">
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
                <i class="fas fa-fw fa-tachometer-alt"></i>
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

        <!-- Nav Item - Data Warga (kadus) -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWargaKadus"
                aria-expanded="true" aria-controls="collapseWargaKadus">
                <i class="fas fa-file-alt"></i>
                <span>Data Warga</span>
                <span style="display: none; font-size: 12px;"></span>
            </a>
            <!-- FIX: ID diganti menjadi collapseWargaKadus agar tidak bentrok -->
            <div id="collapseWargaKadus" class="collapse" aria-labelledby="headingWargaKadus" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('kadus/jumlah_kk'); ?>">
                        Data KK
                        <span class="badge" style="display: none; font-size: 12px;"></span>
                    </a>
                    <a class="collapse-item" href="<?= base_url('kadus/data_warga'); ?>">Data Warga</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pengaduan (kadus) -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengaduanKadus"
                aria-expanded="true" aria-controls="collapsePengaduanKadus">
                <i class="fas fa-file-alt"></i>
                <span>Pengaduan</span>
                <span class="badge badge-danger jumlah_notif_kadus" style="display: none; font-size: 12px;"></span>
            </a>
            <!-- FIX: ID diganti menjadi collapsePengaduanKadus agar tidak bentrok dengan superadmin -->
            <div id="collapsePengaduanKadus" class="collapse" aria-labelledby="headingPengaduanKadus" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= site_url('PengaduanAdmin') ?>">
                        Data Pengaduan
                        <span class="badge badge-danger jumlah_notif_kadus" style="display: none; font-size: 12px;"></span>
                    </a>
                    <a class="collapse-item" href="<?= site_url('PengaduanAdmin/arsip') ?>">Arsip Pengaduan</a>
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