<!DOCTYPE html>
<html>
<head>
    <title>Tambah Dusun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h2>Tambah Dusun</h2>
   <form method="post" action="<?php echo site_url('dusun/tambah'); ?>">
    <div class="mb-3">
        <label class="form-label">Nama Dusun</label>
        <input type="text" class="form-control" name="nama_dusun" required>
    </div>
    <button type="submit" name="submit" class="btn btn-success">Simpan</button>
    <a href="<?php echo site_url('dusun'); ?>" class="btn btn-secondary">Kembali</a>
</form>

</body>
</html>
