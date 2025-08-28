<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Upload Template Surat</h1>

    <!-- Notifikasi flashdata -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Form upload -->
            <form action="<?= site_url('admin/upload_template'); ?>" method="post" enctype="multipart/form-data">

                <!-- Dusun -->
                <div class="form-group">
                    <label for="dusun_id">Dusun</label>
                    <select name="dusun_id" id="dusun_id" class="form-control" required>
                        <option value="">-- Pilih Dusun --</option>
                        <?php if (!empty($dusun)): ?>
                            <?php foreach ($dusun as $d): ?>
                                <option value="<?= $d['id_dusun']; ?>">
                                    <?= $d['nama_dusun']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Nama Surat -->
                <div class="form-group">
                    <label for="nama_surat">Nama Surat</label>
                    <input type="text" name="nama_surat" id="nama_surat" class="form-control" required>
                </div>

                <!-- Nomor Surat -->
                <div class="form-group">
                    <label for="nomor_surat">Nomor Surat</label>
                    <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" required>
                </div>

                <!-- Level Akses -->
                <div class="form-group">
                    <label for="level_akses">Level Akses</label>
                    <select name="level_akses" id="level_akses" class="form-control" required>
                        <option value="">-- Pilih Level --</option>
                        <option value="admin">Admin</option>
                        <option value="kadus">Kadus</option> <!-- ✅ sesuai enum di DB -->
                    </select>
                </div>

                <!-- File Template -->
                <div class="form-group">
                    <label for="file_template">File Template (.docx)</label>
                    <input type="file" name="file_template" id="file_template" class="form-control-file" accept=".doc,.docx,.pdf" required>
                    <small class="text-muted">Format: .doc, .docx, .pdf | Max: 2MB</small>
                </div>

                <!-- Tombol -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Upload
                </button>
                <a href="<?= site_url('admin/daftar_surat'); ?>" class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>

</div>
