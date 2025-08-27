<!DOCTYPE html>
<html>
<head>
    <title>Buat Surat Pengantar</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>

    <h3>Buat Surat Pengantar</h3>
    <form method="post" action="<?= site_url('kadus/buat_surat') ?>">
        <div class="form-group">
            <label>NIK Warga</label>
            <input type="text" name="nik" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama Warga</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Dusun</label>
            <select name="dusun_id" class="form-control" required>
                <option value="">-- Pilih Dusun --</option>
                <?php foreach ($dusun as $d): ?>
                    <option value="<?= $d->id_dusun ?>"><?= $d->nama_dusun ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label>Jenis Surat</label>
            <input type="text" name="jenis_surat" class="form-control" placeholder="Contoh: Domisili" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Kirim ke Admin</button>
    </form>

</body>
</html>
