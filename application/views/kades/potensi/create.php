    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Tambah Potensi Baru</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Formulir Tambah Potensi</h6>
            </div>
            <div class="card-body">
                
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('potensi/store') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">Nama Potensi</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= set_value('nama') ?>">
                        <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control"><?= set_value('deskripsi') ?></textarea>
                        <?= form_error('deskripsi', '<small class="text-danger">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Ekonomi Lokal" <?= set_select('kategori', 'Ekonomi Lokal'); ?>>Ekonomi Lokal</option>
                            <option value="Cagar Budaya" <?= set_select('kategori', 'Cagar Budaya'); ?>>Cagar Budaya</option>
                            <option value="Objek Wisata" <?= set_select('kategori', 'Objek Wisata'); ?>>Objek Wisata</option>
                            <option value="Infrastruktur" <?= set_select('kategori', 'Infrastruktur'); ?>>Infrastruktur</option>
                            <option value="Agrowisata" <?= set_select('kategori', 'Agrowisata'); ?>>Agrowisata</option>
                            <option value="Organisasi Sosial" <?= set_select('kategori', 'Organisasi Sosial'); ?>>Organisasi Sosial</option>
                            <option value="Seni & Budaya" <?= set_select('kategori', 'Seni & Budaya'); ?>>Seni & Budaya</option>
                            <option value="Olahraga" <?= set_select('kategori', 'Olahraga'); ?>>Olahraga</option>
                            <option value="Lainnya" <?= set_select('kategori', 'Lainnya'); ?>>Lainnya</option>
                        </select>
                        <?= form_error('kategori', '<small class="text-danger">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control" value="<?= set_value('lokasi') ?>">
                        <?= form_error('lokasi', '<small class="text-danger">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label>Gambar</label>
                        <div class="custom-file">
                            <input type="file" name="gambar" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">Gambar wajib diisi. Tipe file: jpg, png, jpeg. Ukuran maks: 2MB.</small>
                    </div>

                    <a href="<?= site_url('potensi') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            var fileName = document.getElementById("customFile").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>

