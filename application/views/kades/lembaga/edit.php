<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Lembaga</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Lembaga</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('lembaga/update/'.$lembaga['id']) ?>" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="nama">Nama Lembaga</label>
                    <input type="text" name="nama" id="nama" class="form-control" 
                           value="<?= $lembaga['nama']?>" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required><?= $lembaga['deskripsi'] ?></textarea>
                </div>

                <div class="form-group">
                    <label>Jenis Lembaga</label>
                    <select name="jenis_lembaga" class="form-control">
                        <option value="">--Pilih Jenis Lembaga--</option>
                        <option value="lembaga_desa" <?= $lembaga['jenis_lembaga'] == 'lembaga_desa' ? 'selected' : '' ?>>Lembaga Desa</option>
                        <option value="lembaga_kemasyarakatan" <?= $lembaga['jenis_lembaga'] == 'lembaga_kemasyarakatan' ? 'selected' : '' ?>>Lembaga Kemasyarakatan</option>
                        <option value="badan_usaha" <?= $lembaga['jenis_lembaga'] == 'badan_usaha' ? 'selected' : '' ?>>Badan Usaha Milik Desa (BUMDesa)</option>
                        <option value="lembaga_lainnya" <?= $lembaga['jenis_lembaga'] == 'lembaga_lainnya' ? 'selected' : '' ?>>Lembaga Lainnya</option>
                    </select>
                </div>


                <div class="form-group">
                    <label>Image Saat Ini</label><br>
                    <?php if($lembaga['image']): ?>
                        <img src="<?= base_url('uploads/lembaga/'.$lembaga['image']) ?>" width="150" class="img-thumbnail mb-2">
                    <?php else: ?>
                        <p class="text-muted">Tidak ada image</p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Ganti Image</label>
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Pilih file baru...</label>
                    </div>
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah image.</small>
                    <input type="hidden" name="old_image" value="<?= $lembaga['image'] ?>">
                </div>

                <div class="form-group">
                    <label for="tipe_struktur">Tipe Struktur</label>
                    <select name="tipe_struktur" id="tipe_struktur" class="form-control" required>
                        <option value="anggota" <?= $lembaga['tipe_struktur'] == 'anggota' ? 'selected' : '' ?>>Anggota</option>
                        <option value="bidang" <?= $lembaga['tipe_struktur'] == 'bidang' ? 'selected' : '' ?>>Bidang</option>
                    </select>
                </div>

                <a href="<?= site_url('lembaga') ?>" class="btn btn-secondary">Kembali</a>
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
