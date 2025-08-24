<!DOCTYPE html>
<html>
<head>
    <title>Tambah Aparatur</title>
</head>
<body>
    <h2>Tambah Aparatur</h2>
    <form action="<?= site_url('aparatur/tambah') ?>" method="post" enctype="multipart/form-data">
        <p>Nama: <input type="text" name="nama" required></p>
        <p>Jabatan: <input type="text" name="jabatan" required></p>
        <p>Foto: <input type="file" name="foto"></p>
        <button type="submit">Simpan</button>
        <a href="<?= site_url('aparatur') ?>">Kembali</a>
    </form>
</body>
</html>
