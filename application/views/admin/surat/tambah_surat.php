<div class="container mt-4">
    <h4>Tambah Template Surat</h4>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('admin/tambah_surat') ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Surat</label>
            <input type="text" name="nama_surat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nomor Surat</label>
            <input type="text" name="nomor_surat" class="form-control" required>
            <small class="text-muted">Nomor harus unik, contoh: 001/DSN/I/2025</small>
        </div>

        <div class="mb-3">
            <label>Dusun</label>
            <select name="dusun_id" class="form-control">
                <option value="">-- Pilih Dusun --</option>
                <?php foreach ($dusun as $d): ?>
                    <option value="<?= $d['id_dusun'] ?>"><?= $d['nama_dusun'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Level Akses</label>
            <select name="level_akses" class="form-control">
                <option value="kadus">Kadus</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Upload File Template (.docx)</label>
            <input type="file" name="file_template" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= site_url('admin/template_surat') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
