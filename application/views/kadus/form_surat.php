<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Isi Data Surat</h1>
    <p class="mb-4">
        Lengkapi data untuk
        <b><?= htmlspecialchars($template->nama_surat, ENT_QUOTES, 'UTF-8') ?></b>
    </p>

    <div class="card shadow-lg border-0">

        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Formulir Data Surat</h6>
        </div>

        <div class="card-body">

            <form action="<?= site_url('kadus/proses_surat') ?>" method="POST">

                <input type="hidden" name="id_template" value="<?= $template->id_template ?>">

                <!-- PILIH WARGA -->
                <div class="card mb-4 border-left-info shadow-sm">
                    <div class="card-body">

                        <h6 class="font-weight-bold text-info mb-3">Pilih Data Warga</h6>

                        <div class="form-group">

                            <label>Pilih Warga</label>

                            <select class="form-control select2" id="select_warga">

                                <option value="">-- Pilih Warga --</option>

                                <?php foreach ($warga as $w): ?>

                                    <option
                                        data-nama="<?= $w->nama ?>"
                                        data-nik="<?= $w->no_nik ?>"
                                        data-tempat="<?= $w->tempat_lahir ?>"
                                        data-tgl="<?= $w->tanggal_lahir ?>"
                                        data-pekerjaan="<?= $w->pekerjaan ?>"
                                        data-jk="<?= $w->jenis_kelamin ?>"
                                        data-agama="<?= $w->agama ?>"
                                        data-status="<?= $w->status_perkawinan ?>">
                                        <?= $w->nama ?> - <?= $w->no_nik ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <small class="text-muted">
                                Memilih warga akan otomatis mengisi data.
                            </small>

                        </div>

                    </div>
                </div>


                <div class="row">

                    <!-- DATA DIRI -->
                    <div class="col-md-6">

                        <div class="card border-left-primary shadow-sm mb-4">
                            <div class="card-body">

                                <h6 class="font-weight-bold text-primary mb-3">Data Diri</h6>

                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="form-group">
                                    <label>No. NIK</label>
                                    <input type="number" class="form-control" id="nik" name="nik" required>
                                </div>

                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                                </div>

                                <div class="form-group">

                                    <label>Jenis Kelamin</label>

                                    <select class="form-control"
                                        id="jenis_kelamin"
                                        name="jenis_kelamin"
                                        required>

                                        <option value="">-- Pilih Jenis Kelamin --</option>

                                        <?php foreach ($list_jk as $jk): ?>

                                            <option value="<?= htmlspecialchars($jk->nama) ?>">

                                                <?= htmlspecialchars($jk->nama) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                            </div>
                        </div>

                    </div>


                    <!-- DATA TAMBAHAN -->
                    <div class="col-md-6">

                        <div class="card border-left-success shadow-sm mb-4">
                            <div class="card-body">

                                <h6 class="font-weight-bold text-success mb-3">Data Tambahan</h6>

                                <div class="form-group">

                                    <label>Agama</label>

                                    <select class="form-control"
                                        id="agama"
                                        name="agama"
                                        required>

                                        <option value="">-- Pilih --</option>

                                        <?php foreach ($list_agama as $agama): ?>

                                            <option value="<?= htmlspecialchars($agama->nama) ?>">

                                                <?= htmlspecialchars($agama->nama) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" required>
                                </div>

                                <div class="form-group">

                                    <label>Status Perkawinan</label>

                                    <select class="form-control"
                                        id="sts_kawin"
                                        name="sts_kawin"
                                        required>

                                        <option value="">-- Pilih Status Perkawinan --</option>

                                        <?php foreach ($status_kawin_list as $status): ?>

                                            <option value="<?= htmlspecialchars($status->nama) ?>">

                                                <?= htmlspecialchars($status->nama) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="form-group">
                                    <label>Maksud dan Tujuan</label>

                                    <textarea class="form-control" id="tujuan" name="tujuan" rows="3" required></textarea>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>


                <!-- NOMOR SURAT -->
                <div class="card border-left-warning shadow-sm mb-4">
                    <div class="card-body">

                        <h6 class="font-weight-bold text-warning mb-3">Informasi Nomor Surat</h6>

                        <div class="row">

                            <div class="col-md-8">

                                <div class="form-group">

                                    <label>Kode / Jenis Surat</label>

                                    <select class="form-control"
                                        name="id_template_tujuan"
                                        id="id_template_tujuan"
                                        required>

                                        <option value="">-- Pilih Jenis Surat --</option>

                                        <?php
                                        $jenis_template_aktif = $template->jenis_template ?? '';
                                        ?>

                                        <?php foreach ($surat_list as $surat): ?>

                                            <?php
                                            $jenis_tujuan = $surat->jenis_template ?? '';

                                            // SURAT PENGANTAR RESMI
                                            // tampil semua surat admin kecuali SURAT KETERANGAN utama
                                            if ($jenis_template_aktif === 'pengantar_resmi') {
                                                if ($jenis_tujuan === 'keterangan') {
                                                    continue;
                                                }
                                            }

                                            // SURAT PENGANTAR LAINNYA
                                            // hanya tampil SURAT KETERANGAN utama
                                            elseif ($jenis_template_aktif === 'pengantar_lainnya') {
                                                if ($jenis_tujuan !== 'keterangan') {
                                                    continue;
                                                }
                                            }
                                            ?>

                                            <option value="<?= $surat->id_template ?>">
                                                <?= $surat->nomor_template_surat ?> - <?= $surat->nama_surat ?>
                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div id="fieldTambahanSurat" style="display:none;" class="mt-3">

                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <input type="text"
                                            name="keterangan"
                                            id="keterangan"
                                            class="form-control"
                                            placeholder="Masukkan keterangan">
                                    </div>

                                    <div class="form-group">
                                        <label>Nomor Surat Nasional</label>
                                        <input type="text"
                                            name="no_nasional"
                                            id="no_nasional"
                                            class="form-control"
                                            placeholder="Masukkan nomor surat nasional">
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Nomor Urut</label>

                                    <input type="number" class="form-control" name="no" required>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>


                <!-- BUTTON -->
                <div class="text-right">

                    <a href="<?= site_url('kadus') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-file-download"></i> Buat & Download Surat
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const selectSurat = document.getElementById('id_template_tujuan');
        const fieldTambahan = document.getElementById('fieldTambahanSurat');

        function cekSuratKeterangan() {

            if (!selectSurat || !fieldTambahan) return;

            const selectedText =
                selectSurat.options[selectSurat.selectedIndex]
                .text
                .toUpperCase()
                .trim();

            // 🔥 HANYA SURAT KETERANGAN
            if (selectedText.endsWith('SURAT KETERANGAN')) {

                fieldTambahan.style.display = 'block';

            } else {

                fieldTambahan.style.display = 'none';

                document.getElementById('keterangan').value = '';
                document.getElementById('no_nasional').value = '';
            }
        }

        selectSurat.addEventListener('change', cekSuratKeterangan);

        cekSuratKeterangan();
    });
</script>