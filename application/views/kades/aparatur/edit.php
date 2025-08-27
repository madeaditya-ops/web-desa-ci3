<!DOCTYPE html>
<html>
<head>
    <title>Edit Aparatur</title>
</head>
<body>
    <h2>Edit Aparatur</h2>
    <form action="<?= site_url('aparatur/edit/'.$aparatur->id_aparatur) ?>" method="post" enctype="multipart/form-data">
        <p>Nama: <input type="text" name="nama" value="<?= $aparatur->nama ?>" required></p>
        <p>Jabatan: <input type="text" name="jabatan" value="<?= $aparatur->jabatan ?>" required></p>
        <p>Foto: 
            <?php if($aparatur->foto): ?>
                <img src="<?= base_url('uploads/aparatur/'.$aparatur->foto) ?>" width="80"><br>
            <?php endif; ?>
            <input type="file" name="foto">
        </p>
        <button type="submit">Update</button>
        <a href="<?= site_url('aparatur') ?>">Kembali</a>
    </form>
</body>
</html>
