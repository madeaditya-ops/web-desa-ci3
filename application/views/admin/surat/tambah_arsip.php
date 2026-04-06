<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-plus mr-1"></i> Tambah Arsip Surat
            </h6>
            <a href="<?= site_url('admin/arsip') ?>" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('admin/simpan_arsip') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

               <div class="form-group">
                    <label>Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" class="form-control" required>
                </div>
                    <div class="form-group">
                        <label>Nomor Surat</label>
                        <input type="text" name="nomor_surat" class="form-control" required
                            placeholder="isi dengan contoh 470/11">
                    </div>

                    <div class="form-group">
                        <label>Nomor Pengantar</label>
                        <input type="text" name="nomor_pengantar" class="form-control"
                            placeholder="isi pengantar dengan 470/22" required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Banjar</label>
                        <select name="kode_banjar" id="kode_banjar" class="form-control" required>
                            <option value="">-- Pilih Banjar --</option>
                            <?php foreach ($dusun as $d): ?>
                                <option value="<?= $d->kode_dusun ?>"
                                        data-nama="<?= htmlspecialchars($d->nama_dusun) ?>">
                                    <?= htmlspecialchars($d->nama_dusun) ?> (<?= $d->kode_dusun ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Penerima</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Alamat Penerima</label>
                        <textarea name="alamat_penerima"
                                id="alamat_penerima"
                                class="form-control"
                                rows="2"
                                readonly
                                placeholder="Alamat akan terisi otomatis berdasarkan banjar"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jenis Surat</label>
                        <input type="text" name="jenis_surat" class="form-control"
                            placeholder="Contoh: Surat Keterangan Domisili" required>
                    </div>

                    <div class="form-group">
                        <label>Upload File Surat</label>
                        <input type="file" name="file_surat" class="form-control-file" accept=".pdf,.doc,.docx">
                        <small class="text-muted">
                            Format PDF/DOC/DOCX (max 2MB)
                        </small>
                    </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>


<script>
document.getElementById('kode_banjar').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const banjar = selected.getAttribute('data-nama');

    const alamatField = document.getElementById('alamat_penerima');

    if (!banjar) {
        alamatField.value = '';
        return;
    }

    alamatField.value = `Br. ${banjar} /Kec. Blahbatuh Kab. Gianyar`;
});
</script>
