    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Edit Berita</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Berita</h6>
            </div>
            <div class="card-body">
                <form action="<?= site_url('berita/update/'.$berita->id_berita) ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="judul">Judul Berita</label>
                        <input type="text" name="judul" id="judul" class="form-control" value="<?= $berita->judul ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="isi">Isi Berita</label>
                        <textarea name="isi" id="isi" rows="5" class="form-control" required><?= $berita->isi ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Gambar Saat Ini</label><br>
                        <?php if($berita->gambar): ?>
                            <img src="<?= base_url('uploads/berita/'.$berita->gambar) ?>" width="150" class="img-thumbnail mb-2">
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
                        <input type="hidden" name="old_gambar" value="<?= $berita->gambar ?>">
                    </div>

                    <a href="<?= site_url('berita') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Script untuk menampilkan nama file pada custom file input
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            var fileName = document.getElementById("customFile").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        })
    </script>
