<div class="container-fluid">

    <?php if($this->session->flashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('message') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('success_file')): ?>
        <div class="alert alert-info">
            <strong>Surat berhasil dibuat!</strong> Silakan pilih aksi berikut:
            <br class="d-none d-md-block"><br class="d-none d-md-block">
            <a href="<?= base_url('uploads/surat/'.$this->session->flashdata('success_file')) ?>"
               class="btn btn-success btn-sm mr-2" target="_blank">
                <i class="fas fa-file-word"></i> Download Word
            </a>
            <a href="<?= site_url('admin/cetak_pdf/'.$this->session->flashdata('success_file')) ?>"
               class="btn btn-danger btn-sm" target="_blank">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Surat: <?= htmlspecialchars($surat->nama_surat) ?>
            </h6>
        </div>

        <div class="card-body">
            <form method="post" autocomplete="off">
                <?php $banjar_rendered = false; // flag agar select banjar/kode hanya satu ?>
                <?php if (!empty($placeholders)): ?>
                    <div class="row">
                        <?php foreach ($placeholders as $ph): ?>
                            <?php $ph_clean = trim($ph); ?>
                            <?php
                                // tentukan layout: full width untuk textarea / panjang nama / bidang khusus
                                $is_textarea = (strlen($ph_clean) > 15);
                                $is_full = $is_textarea;
                                $ph_key = strtolower(preg_replace('/[^\w]+/u', '_', $ph_clean)); // dipakai sebagai name
                                $is_date = (stripos($ph_key, 'tgl') !== false || stripos($ph_key, 'tanggal') !== false);
                                $is_number = ($ph_key === 'nomor_surat' || $ph_key === 'nomor');
                                $is_banjar = ($ph_key === 'banjar');
                                $is_kode = in_array($ph_key, ['kode','kode_dusun','kode_banjar']);
                                $is_gender = in_array($ph_key, ['jenis_kelamin','gender','jk','sex']);
                                $is_marital = in_array($ph_key, ['status_perkawinan','perkawinan','status']);
                                $col_class = $is_full ? 'col-12' : 'col-md-6';
                            ?>

                            <?php
                                // Jika placeholder berkaitan dengan banjar/kode, render SATU select gabungan
                                if (($is_banjar || $is_kode)):
                                    if (!$banjar_rendered):
                                        $banjar_rendered = true;
                            ?>
                                        <div class="<?= $col_class ?> mb-3">
                                            <label for="kode_banjar" class="font-weight-bold">Banjar / Kode Banjar</label>
                                            <select name="kode_banjar" id="kode_banjar" class="form-control">
                                                <option value="">-- Pilih Banjar --</option>
                                                <?php foreach($dusun as $d): ?>
                                                    <option value="<?= htmlspecialchars($d->kode_dusun) ?>"
                                                        data-name="<?= htmlspecialchars($d->nama_dusun) ?>"
                                                        <?= set_select('kode_banjar', $d->kode_dusun) ?>>
                                                        <?= htmlspecialchars($d->nama_dusun) ?> (<?= htmlspecialchars($d->kode_dusun) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!-- hidden input untuk menyimpan nama banjar agar placeholder [banjar] terbaca -->
                                            <input type="hidden" name="banjar" id="banjar" value="<?= set_value('banjar') ?>">
                                        </div>
                            <?php
                                    endif;
                                    // lewati output input lain untuk placeholder banjar/kode (sudah disediakan di atas)
                                    continue;
                                endif;
                            ?>

                            <div class="<?= $col_class ?> mb-3">
                                <label for="<?= htmlspecialchars($ph_key) ?>" class="font-weight-bold">
                                    <?= ucfirst(str_replace('_',' ', strtolower($ph_clean))) ?>
                                </label>

                                <?php if ($is_gender): ?>
                                    <select name="<?= htmlspecialchars($ph_key) ?>" id="<?= htmlspecialchars($ph_key) ?>" class="form-control">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" <?= set_select($ph_key, 'L') ?>>Laki-laki</option>
                                        <option value="P" <?= set_select($ph_key, 'P') ?>>Perempuan</option>
                                    </select>

                                <?php elseif ($is_marital): ?>
                                    <select name="<?= htmlspecialchars($ph_key) ?>" id="<?= htmlspecialchars($ph_key) ?>" class="form-control">
                                        <option value="">-- Pilih Status Perkawinan --</option>
                                        <option value="Belum Kawin" <?= set_select($ph_key, 'Belum Kawin') ?>>Belum Kawin</option>
                                        <option value="Kawin" <?= set_select($ph_key, 'Kawin') ?>>Kawin</option>
                                        <option value="Cerai Hidup" <?= set_select($ph_key, 'Cerai Hidup') ?>>Cerai Hidup</option>
                                        <option value="Cerai Mati" <?= set_select($ph_key, 'Cerai Mati') ?>>Cerai Mati</option>
                                    </select>

                                <?php elseif ($is_date): ?>
                                    <input type="date"
                                           class="form-control"
                                           name="<?= htmlspecialchars($ph_key) ?>"
                                           id="<?= htmlspecialchars($ph_key) ?>"
                                           value="<?= set_value($ph_key) ?>">

                                <?php elseif ($is_number): ?>
                                    <input type="number"
                                           class="form-control"
                                           name="<?= htmlspecialchars($ph_key) ?>"
                                           id="<?= htmlspecialchars($ph_key) ?>"
                                           value="<?= set_value($ph_key) ?>"
                                           placeholder="Hanya angka">

                                <?php elseif ($is_textarea): ?>
                                    <textarea class="form-control"
                                              name="<?= htmlspecialchars($ph_key) ?>"
                                              id="<?= htmlspecialchars($ph_key) ?>"
                                              rows="4"
                                              placeholder="Isi <?= ucfirst(str_replace('_',' ', strtolower($ph_clean))) ?>"><?= set_value($ph_key) ?></textarea>

                                <?php else: ?>
                                    <input type="text"
                                           class="form-control"
                                           name="<?= htmlspecialchars($ph_key) ?>"
                                           id="<?= htmlspecialchars($ph_key) ?>"
                                           value="<?= set_value($ph_key) ?>"
                                           placeholder="Isi <?= ucfirst(str_replace('_',' ', strtolower($ph_clean))) ?>">
                                <?php endif; ?>
                            </div>

                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-danger">Tidak ada placeholder ditemukan di template surat ini.</p>
                <?php endif; ?>

                <div class="d-flex justify-content-end mt-3">
                    <a href="<?= site_url('admin/daftar_surat') ?>" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Generate Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script: sinkronkan hidden banjar dengan select kode_banjar -->
<script>
    (function(){
        var kodeSelect = document.getElementById('kode_banjar');
        var banjarInput = document.getElementById('banjar');

        function syncBanjar(){
            if (!kodeSelect) return;
            var opt = kodeSelect.options[kodeSelect.selectedIndex];
            var name = opt ? opt.getAttribute('data-name') || '' : '';
            if (banjarInput) banjarInput.value = name;
        }

        // set initial value: jika ada set_value('banjar') kosong, coba isi berdasarkan selected kode
        document.addEventListener('DOMContentLoaded', function(){
            syncBanjar();
        });

        if (kodeSelect){
            kodeSelect.addEventListener('change', syncBanjar);
        }
    })();
</script>
