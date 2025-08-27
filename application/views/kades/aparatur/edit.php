<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Aparatur</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Aparatur</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('aparatur/update/'.$aparatur->id_aparatur) ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama Aparatur</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $aparatur->nama ?>" required>
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control" value="<?= $aparatur->jabatan ?>" required>
                </div>

                <div class="form-group">
                    <label>Foto Saat Ini</label><br>
                    <?php if($aparatur->foto): ?>
                        <img src="<?= base_url('uploads/aparatur/'.$aparatur->foto) ?>" width="150" class="img-thumbnail mb-2">
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
                    <input type="hidden" name="old_foto" value="<?= $aparatur->foto ?>">
                </div>

                <a href="<?= site_url('aparatur') ?>" class="btn btn-secondary">Kembali</a>
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