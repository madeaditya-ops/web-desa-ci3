    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Edit Potensi</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Potensi</h6>
            </div>
            <div class="card-body">
                <form action="<?= site_url('potensi/update/'.$potensi->id_potensi) ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">Nama Potensi</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= $potensi->nama ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control" required><?= $potensi->deskripsi ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Ekonomi Lokal" <?= ($potensi->kategori == 'Ekonomi Lokal') ? 'selected' : ''; ?>>Ekonomi Lokal</option>
                            <option value="Cagar Budaya" <?= ($potensi->kategori == 'Cagar Budaya') ? 'selected' : ''; ?>>Cagar Budaya</option>
                            <option value="Objek Wisata" <?= ($potensi->kategori == 'Objek Wisata') ? 'selected' : ''; ?>>Objek Wisata</option>
                            <option value="Infrastruktur" <?= ($potensi->kategori == 'Infrastruktur') ? 'selected' : ''; ?>>Infrastruktur</option>
                            <option value="Agrowisata" <?= ($potensi->kategori == 'Agrowisata') ? 'selected' : ''; ?>>Agrowisata</option>
                            <option value="Organisasi Sosial" <?= ($potensi->kategori == 'Organisasi Sosial') ? 'selected' : ''; ?>>Organisasi Sosial</option>
                            <option value="Seni & Budaya" <?= ($potensi->kategori == 'Seni & Budaya') ? 'selected' : ''; ?>>Seni & Budaya</option>
                            <option value="Olahraga" <?= ($potensi->kategori == 'Olahraga') ? 'selected' : ''; ?>>Olahraga</option>
                            <option value="Lainnya" <?= ($potensi->kategori == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control" value="<?= $potensi->lokasi ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Gambar Saat Ini</label><br>
                        <?php if($potensi->gambar): ?>
                            <img src="<?= base_url('uploads/potensi/'.$potensi->gambar) ?>" width="150" class="img-thumbnail mb-2">
                        <?php else: ?>
                            <p class="text-muted">Tidak ada gambar</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Ganti Gambar</label>
                        <div class="custom-file">
                            <input type="file" name="gambar" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Pilih file baru...</label>
                        </div>
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                        <input type="hidden" name="old_gambar" value="<?= $potensi->gambar ?>">
                    </div>

                    <a href="<?= site_url('potensi') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
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
