<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Anggota</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Anggota</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('anggota_lembaga/update/'.$anggota['id']) ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="lembaga_id" value="<?= $anggota['lembaga_id'] ?>"> 

                <div class="form-group">
                    <label for="nama">Nama Anggota</label>
                    <input type="text" name="nama" id="nama" class="form-control" 
                           value="<?= $anggota['nama']?>" required>
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <textarea name="jabatan" id="jabatan" class="form-control" rows="3" required><?= $anggota['jabatan'] ?></textarea>
                </div>


                <div class="form-group">
                    <label>Foto Saat Ini</label><br>
                    <?php if($anggota['foto']): ?>
                        <img src="<?= base_url('uploads/anggota_lembaga/'.$anggota['foto']) ?>" width="150" class="img-thumbnail mb-2">
                    <?php else: ?>
                        <p class="text-muted">Tidak ada foto</p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Ganti Foto</label>
                    <div class="custom-file">
                        <input type="file" name="foto" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Pilih file baru...</label>
                    </div>
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    <input type="hidden" name="old_foto" value="<?= $anggota['foto'] ?>">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="aktif" <?= $anggota['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= $anggota['status'] == 'nonaktif' ? 'selected' : '' ?>>Non Aktif</option>
                    </select>
                </div>

                <a href="<?= site_url('anggota_lembaga/'.$anggota['lembaga_id']) ?>" class="btn btn-secondary">Kembali</a>
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
