
    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Edit Foto Galeri</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Galeri</h6>
            </div>
            <div class="card-body">
                <form action="<?= site_url('galeri/update/'.$galeri->id_galeri) ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="caption">Caption</label>
                        <input type="text" name="caption" id="caption" class="form-control" value="<?= $galeri->caption ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Gambar Saat Ini</label><br>
                        <?php if($galeri->gambar): ?>
                            <img src="<?= base_url('uploads/galeri/'.$galeri->gambar) ?>" width="150" class="img-thumbnail mb-2">
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
                        <input type="hidden" name="old_gambar" value="<?= $galeri->gambar ?>">
                    </div>

                    <a href="<?= site_url('galeri') ?>" class="btn btn-secondary">Kembali</a>
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
