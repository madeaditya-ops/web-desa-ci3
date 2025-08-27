<h3>Upload Template Surat</h3>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Pilih Dusun</label>
       <select name="dusun_id" class="form-control" required>
    <option value="">-- Pilih Dusun --</option>
    <?php foreach ($dusun as $d): ?>
        <option value="<?= $d['id_dusun'] ?>"><?= $d['nama_dusun'] ?></option>
    <?php endforeach; ?>
</select>

    </div>

    <div class="form-group">
        <label>Jenis Surat</label>
        <input type="text" name="jenis_surat" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Upload Template (Word)</label>
        <input type="file" name="file_template" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Upload</button>
</form>
