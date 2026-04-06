<div class="container-fluid">
    <h1 class="h3 mb-4">Tambah Keluarga</h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="<?= base_url('keluarga/simpan') ?>" method="post">

                <div class="form-group">
                    <label>No KK</label>
                    <input type="text" name="no_kk" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Kepala Keluarga</label>
                    <input type="text" name="nama_kepala_keluarga" class="form-control" required
                        placeholder="isi dengan nama kepala keluarga">
                </div>


                <div class="form-group">
                    <label>Dusun</label>
                    <select name="id_dusun" id="dusun" class="form-control" required>
                        <option value="">-- Pilih Dusun --</option>
                        <?php foreach ($dusun as $d): ?>
                            <option value="<?= $d->id_dusun ?>">
                                <?= $d->nama_dusun ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>


                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?= base_url('keluarga') ?>" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>


<script>
    document.getElementById('dusun').addEventListener('change', function() {

        let selectedText = this.options[this.selectedIndex].text;

        if (selectedText !== '-- Pilih Dusun --') {
            document.getElementById('alamat').value =
                "Br. " + selectedText + " /Kec. Blahbatuh Kab. Gianyar";
        } else {
            document.getElementById('alamat').value = "";
        }

    });
</script>