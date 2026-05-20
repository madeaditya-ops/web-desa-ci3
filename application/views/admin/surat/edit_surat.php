<style>
    .badge-terbaru {
        background: #1cc88a;
        color: #fff;
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 6px;
    }

    .select2-terbaru {
        background: #28a745;
        color: #fff;
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 6px;
    }

    /* Preview KTP normal */
    #previewKtp {
        max-width: 100%;
        border-radius: 6px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    /* Mode kecil setelah OCR */
    #previewKtp.minimal {
        max-width: 220px;
        opacity: 0.85;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
    }

    /* Wrapper agar rapi */
    .ktp-preview-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>



    <div class="container-fluid">

    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('message') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('show_action_modal')): ?>
        <?php
        $file = $this->session->flashdata('success_file');
        $nama = $this->session->flashdata('nama_penerima');
        $wa   = $this->session->flashdata('no_wa_warga');

        $linkFile = base_url('uploads/surat/' . $file);
        $pesanWa  = urlencode(
            "Halo $nama,\n\nSurat Anda sudah selesai dibuat.\n\nSilakan download melalui link berikut:\n$linkFile\n\nTerima kasih."
        );
        ?>

        <!-- MODAL POPUP -->
        <div class="modal fade show"
            id="modalAksiSurat"
            style="display:block;background:rgba(0,0,0,.5);"
            tabindex="-1">

            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content shadow-lg">

                    <div class="modal-header bg-success text-white">
                        <h6 class="modal-title">
                            <i class="fas fa-check-circle"></i> Surat Berhasil Dibuat
                        </h6>
                    </div>

                    <div class="modal-body text-center">

                        <!-- DOWNLOAD -->
                        <a href="<?= $linkFile ?>"
                            target="_blank"
                            class="btn btn-success btn-block mb-2">
                            <i class="fas fa-download"></i> Download Surat
                        </a>

                        <!-- KIRIM WA -->
                        <?php if (!empty($wa)): ?>
                            <a href="https://wa.me/<?= preg_replace('/\D/', '', $wa) ?>?text=<?= $pesanWa ?>"
                                target="_blank"
                                class="btn btn-success btn-block"
                                style="background:#25D366;border-color:#25D366;">
                                <i class="fab fa-whatsapp"></i> Kirim via WhatsApp
                            </a>
                        <?php endif; ?>

                    </div>

                    <div class="modal-footer p-2">
                        <button type="button"
                            class="btn btn-light btn-sm btn-block"
                            onclick="closeModalSuratRedirect()">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function closeModalSuratRedirect() {
                document.getElementById('modalAksiSurat').style.display = 'none';

                setTimeout(() => {
                    window.location.href = "<?= site_url('admin/arsip') ?>";
                }, 300);
            }
        </script>

    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Surat : <?= htmlspecialchars($surat->nama_surat) ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="col-12 mb-4">
                <div class="card border-left-primary shadow-sm">
                    <div class="card-body">

                        <div class="form-group">

                            <label>Pilih Warga</label>

                            <select class="form-control select2" id="select_warga_admin">
                                <option value="">-- Pilih Warga --</option>

                                <?php foreach ($warga as $w): ?>
                                    <option value="<?= $w->no_nik ?>"
                                        data-nama="<?= $w->nama ?>"
                                        data-nik="<?= $w->no_nik ?>"
                                        data-tempat="<?= $w->tempat_lahir ?>"
                                        data-tgl="<?= $w->tanggal_lahir ?>"
                                        data-pekerjaan="<?= $w->pekerjaan ?>"
                                        data-jk="<?= $w->jenis_kelamin ?>"
                                        data-agama="<?= $w->agama ?>"
                                        data-id_dusun="<?= $w->id_dusun ?>"
                                        data-banjar="<?= $w->nama_dusun ?>"
                                        data-kode="<?= $w->kode_dusun ?>"
                                        data-status="<?= $w->status_perkawinan ?>">

                                        <?= $w->nama ?> - <?= $w->no_nik ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <small class="text-muted">
                                Memilih warga akan otomatis mengisi data.
                            </small>

                        </div>
                        <!-- 
                        <h6 class="font-weight-bold text-primary mb-2">
                            <i class="fas fa-id-card mr-1"></i>
                            Upload Foto KTP
                        </h6>

                            <p class="text-muted mb-3" style="font-size: 14px;">
                                Gunakan fitur ini untuk <b>mengisi data surat secara otomatis</b> berdasarkan
                                KTP pemohon. Pastikan foto KTP terlihat jelas agar data terbaca dengan baik.
                            </p>

                            <!-- INPUT FILE -->
                            <!-- <input type="file"
                                id="uploadKtp"
                                class="form-control"
                                accept="image/*"> -->

                            <!-- INFO PENGGUNAAN -->
                            <!-- <ul class="mt-3 mb-2 text-muted" style="font-size: 13px; padding-left: 18px;">
                                <li>Foto KTP harus <b>jelas, lurus, dan tidak blur</b></li>
                                <li>Gunakan pencahayaan yang cukup</li>
                                <li>Data akan <b>otomatis masuk ke form</b>, silakan cek kembali</li>
                            </ul> -->

                            <!-- CATATAN KEAMANAN -->
                            <!-- <div class="alert alert-info py-2 px-3 mt-3 mb-0" style="font-size: 13px;">
                                <i class="fas fa-info-circle mr-1"></i>
                                Foto KTP <b>tidak disimpan</b> di sistem, hanya digunakan sementara untuk
                                membantu pengisian data.
                            </div> -->

                        <!-- PREVIEW -->
                        <!-- <div class="mt-3 ktp-preview-wrapper">
                            <img id="previewKtp" style="display:none;">
                            <small id="ktpStatus" class="text-success" style="display:none;">
                            </small>
                        </div> -->
                        <div class="col-4 mb-4">
                            <!-- <label class="font-weight-bold">Pilih Data Warga</label>
                           <select id="pilihWarga" class="form-control" style="width:100%">
                                <option value="">-- Pilih Nama Warga --</option>
                                <?php foreach ($data_warga as $w): ?>
                                    <option value="<?= $w->id ?>"
                                            data-terbaru="<?= (int)$w->is_new_approved ?>">
                                        <?= htmlspecialchars($w->nama) ?> (<?= $w->nik ?>) - <?= $w->banjar ?>
                                    </option>
                                <?php endforeach; ?>
                            </select> -->


                                <!-- <small class="text-muted">
                                    Pilih nama untuk mengisi otomatis data surat
                                </small> -->
                            </div>


                    </div>
                </div>
            </div>
            <form method="post" autocomplete="off" action="<?= site_url('admin/edit_surat/' . $surat->id . '/' . ($id_pengajuan ?? '')) ?>">
                <input type="hidden" name="id_pengajuan" value="<?= (isset($auto_warga) && $auto_warga != null) ? $auto_warga->id : '' ?>">
                <?php $banjar_rendered = false; // flag agar select banjar/kode hanya satu 
                ?>
                <?php if (!empty($placeholders)): ?>
                    <div class="row">
                        <?php foreach ($placeholders as $ph): ?>
                            <?php $ph_clean = trim($ph); ?>
                            <?php
                            $ph_key = strtolower(preg_replace('/[^\w]+/u', '_', $ph_clean));
                            // ⛔ SKIP PLACEHOLDER TTD (JANGAN BUAT INPUT)
                            if (in_array($ph_key, [
                                'ttd_kades',
                                'ttd_sekdes',
                                'ttd_bendesa',
                                'kadesttd'
                            ])) {
                                continue;
                            }

                            $auto_date_placeholders = [
                                'tanggal_surat',
                                'tgl_surat',
                                'tanggal_keluar',
                                'tgl_keluar',
                                'tanggal'
                            ];

                            // ⛔ TANGGAL KELUAR AUTO (JANGAN BUAT INPUT)
                            if (in_array($ph_key, $auto_date_placeholders)) {
                                continue;
                            }

                            // Mapping label yang lebih user-friendly
                            $label_mapping = [
                                'nomor_surat' => 'Nomor Surat',
                                'nomor' => 'Nomor Surat',
                                'nama' => 'Nama Lengkap',
                                'tempat_lahir' => 'Tempat Lahir',
                                'tanggal_lahir' => 'Tanggal Lahir',
                                'tgl_lahir' => 'Tanggal Lahir',
                                'jenis_kelamin' => 'Jenis Kelamin',
                                'gender' => 'Jenis Kelamin',
                                'jk' => 'Jenis Kelamin',
                                'sex' => 'Jenis Kelamin',
                                'kelamin' => 'Jenis Kelamin',
                                'agama' => 'Agama',
                                'religion' => 'Agama',
                                'status_perkawinan' => 'Status Perkawinan',
                                'perkawinan' => 'Status Perkawinan',
                                'status' => 'Status Perkawinan',
                                'pekerjaan' => 'Pekerjaan',
                                'job' => 'Pekerjaan',
                                'occupation' => 'Pekerjaan',
                                'alamat' => 'Alamat',
                                'address' => 'Alamat',
                                'banjar' => 'Banjar',
                                'kode' => 'Kode Banjar',
                                'kode_dusun' => 'Kode Banjar',
                                'kode_banjar' => 'Kode Banjar',
                                'tanggal' => 'Tanggal',
                                'tgl' => 'Tanggal',
                                'tahun' => 'Tahun',
                                'bulan' => 'Bulan',
                                'hari' => 'Hari'
                            ];

                            // tentukan layout: full width untuk textarea / panjang nama / bidang khusus
                            $is_textarea = (strlen($ph_clean) > 15);
                            $is_full = $is_textarea;
                            $ph_key = strtolower(preg_replace('/[^\w]+/u', '_', $ph_clean)); // dipakai sebagai name
                            $is_date = (stripos($ph_key, 'tgl') !== false || stripos($ph_key, 'tanggal') !== false);
                            $is_number = ($ph_key === 'nomor_surat' || $ph_key === 'nomor');
                            $is_pengantar = in_array($ph_key, ['nomor_pengantar', 'no_pengantar', 'nomor_pengantar_kelian']);
                            $is_nik = in_array($ph_key, ['nik', 'nomor_nik', 'nik_penduduk', 'no_ktp']);
                            $is_banjar = ($ph_key === 'banjar');
                            $is_keterangan = (stripos($ph_key, 'keterangan') !== false);
                            $is_tujuan = (stripos($ph_key, 'tujuan') !== false);
                            $is_pewaris = (stripos($ph_key, 'pewaris') !== false);
                            $is_menikah = (stripos($ph_key, 'menikah') !== false || stripos($ph_key, 'nikah') !== false);
                            $is_kode = in_array($ph_key, ['kode', 'kode_dusun', 'kode_banjar']);
                            $is_gender = in_array($ph_key, ['jenis_kelamin', 'gender', 'jk', 'sex', 'kelamin']);
                            $is_religion = in_array($ph_key, ['agama', 'religion']);
                            $is_marital = in_array($ph_key, ['status_perkawinan', 'perkawinan', 'status']);
                            $col_class = $is_full ? 'col-12' : 'col-md-6';

                            // Tentukan label yang akan ditampilkan
                            $display_label = isset($label_mapping[$ph_key]) ? $label_mapping[$ph_key] : ucwords(str_replace('_', ' ', strtolower($ph_clean)));
                            ?>

                            <?php
                            // Jika placeholder berkaitan dengan banjar/kode, render SATU select gabungan
                            if (($is_banjar || $is_kode)):
                                if (!$banjar_rendered):
                                    $banjar_rendered = true;
                            ?>
                                    <div class="<?= $col_class ?> mb-3">
                                        <label for="kode_banjar" class="font-weight-bold">Banjar / Kode Banjar</label>

                                        <select name="kode_banjar" id="kode_banjar" class="form-control" required>
                                            <option value="">-- Pilih Banjar --</option>

                                            <?php foreach ($dusun as $d): ?>
                                                <option value="<?= htmlspecialchars($d->kode_dusun) ?>"
                                                    data-name="<?= htmlspecialchars($d->nama_dusun) ?>"
                                                    <?= (($data_surat->kode_banjar ?? '') == $d->kode_dusun) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($d->nama_dusun) ?>
                                                    (<?= htmlspecialchars($d->kode_dusun) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <input type="hidden"
                                            name="banjar"
                                            id="banjar"
                                            value="<?= htmlspecialchars($data_surat->banjar ?? '') ?>">

                                    </div>
                            <?php
                                endif;
                                // lewati output input lain untuk placeholder banjar/kode (sudah disediakan di atas)
                                continue;
                            endif;
                            ?>

                                <div class="<?= $col_class ?> mb-3">
                                    <label for="<?= htmlspecialchars($ph_key) ?>" class="font-weight-bold">
                                        <?= $display_label ?>
                                    </label>

                                <?php if ($is_gender): ?>

                                    <?php
                                    $current_value = '';

                                    // prioritas 1: dari form submit ulang
                                    if (!empty(set_value($ph_key))) {
                                        $current_value = set_value($ph_key);
                                    }
                                    // prioritas 2: dari auto_warga (WAJIB DIPERTAHANKAN)
                                    elseif (isset($auto_warga->$ph_key)) {
                                        $current_value = $auto_warga->$ph_key;
                                    }
                                    ?>

                                    <select name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        class="form-control"
                                        required>

                                        <option value="">-- Pilih Jenis Kelamin --</option>

                                        <?php foreach ($list_jk as $jk): ?>
                                            <option value="<?= $jk->nama ?>"
                                                <?= ($current_value == $jk->nama) ? 'selected' : '' ?>>
                                                <?= $jk->nama ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>



                                <?php elseif ($is_religion): ?>
                                    <select name="agama" id="agama" class="form-control">
                                        <option value="">-- Pilih Agama --</option>

                                        <?php foreach ($list_agama as $a): ?>
                                            <option value="<?= $a->nama ?>"
                                                <?= (isset($auto_warga->agama) && $auto_warga->agama == $a->nama) ? 'selected' : '' ?>>
                                                <?= $a->nama ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                <?php elseif ($is_marital): ?>
                                    <?php
                                    $current_value = '';

                                        // Prioritas 1: set_value (jika form submit ulang)
                                        if (!empty(set_value($ph_key))) {
                                            $current_value = set_value($ph_key);
                                        }

                                    // Prioritas 2: Ambil dari auto_warga (PAKSA KE status_perkawinan)
                                    elseif (isset($auto_warga->sts_kawin)) {
                                        $current_value = $auto_warga->sts_kawin;
                                    }
                                    ?>
                                    <select name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        class="form-control"
                                        required>

                                        <option value="">-- Pilih Status Perkawinan --</option>

                                        <?php foreach ($status_kawin_list as $s): ?>
                                            <option value="<?= $s->nama ?>"
                                                <?= ($current_value == $s->nama) ? 'selected' : '' ?>>
                                                <?= $s->nama ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>

                                <?php elseif ($is_date): ?>

                                    <?php
                                    $current_value = set_value($ph_key);

                                    if (empty($current_value) && isset($data_surat->tanggal_lahir)) {
                                        $current_value = $data_surat->tanggal_lahir;
                                    }
                                    ?>
                                    <input type="date"
                                        class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        value="<?= set_value($ph_key) ?>">

                                <?php elseif ($is_number): ?>
                                    <input type="number"
                                        class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        value="<?= set_value($ph_key) ?>"
                                        placeholder="isi nomor surat dengan angka">

                                <?php elseif ($is_pengantar): ?>

                                    <?php
                                    $current_value = set_value($ph_key);

                                    if (empty($current_value) && isset($data_surat->nomor_pengantar)) {
                                        $current_value = $data_surat->nomor_pengantar;
                                    }
                                    ?>

                                    <input type="number"
                                        class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        value="<?= htmlspecialchars($current_value) ?>"
                                        placeholder="isi nomor pengantar banjar dengan angka">

                                <?php elseif ($is_nik): ?>
                                    <?php
                                    $current_value = '';

                                    if (!empty(set_value($ph_key))) {
                                        $current_value = set_value($ph_key);
                                    } elseif (isset($auto_warga->nik)) {
                                        $current_value = $auto_warga->nik;
                                    }
                                    ?>
                                    <input type="number"
                                        class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        value="<?= htmlspecialchars($current_value) ?>"
                                        placeholder="isi nomor nik dengan angka">


                                <?php elseif ($is_menikah): ?>
                                    <input type="text"
                                        class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        value="<?= set_value($ph_key) ?>"
                                        placeholder="isi nama suami/istri yang bersangkutan">

                                <?php elseif ($is_pewaris): ?>
                                    <input type="text"
                                        class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        value="<?= set_value($ph_key) ?>"
                                        placeholder="isi nama pewaris yang bersangkutan">

                                <?php elseif ($is_keterangan): ?>
                                    <input type="text"
                                        class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        value="<?= set_value($ph_key) ?>"
                                        placeholder="isi keterangan dengan huruf besar">


                                <?php elseif ($is_tujuan): ?>
                                    <input type="text"
                                        class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        value="<?= set_value($ph_key) ?>"
                                        placeholder="isi tujuan untuk apa surat ini dibuat">


                                <?php elseif ($is_textarea): ?>
                                    <textarea class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        rows="4"
                                        placeholder="Isi <?= $display_label ?>"><?= set_value($ph_key) ?></textarea>

                                <?php else: ?>
                                    <input type="text"
                                        class="form-control" required
                                        name="<?= htmlspecialchars($ph_key) ?>"
                                        id="<?= htmlspecialchars($ph_key) ?>"
                                        value="<?= set_value($ph_key) ?>"
                                        placeholder="Isi <?= $display_label ?>">
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
    (function() {
        var kodeSelect = document.getElementById('kode_banjar');
        var banjarInput = document.getElementById('banjar');

        function syncBanjar() {
            if (!kodeSelect) return;
            var opt = kodeSelect.options[kodeSelect.selectedIndex];
            var name = opt ? opt.getAttribute('data-name') || '' : '';
            if (banjarInput) banjarInput.value = name;
        }

        // set initial value: jika ada set_value('banjar') kosong, coba isi berdasarkan selected kode
        document.addEventListener('DOMContentLoaded', function() {
            syncBanjar();
        });

        if (kodeSelect) {
            kodeSelect.addEventListener('change', syncBanjar);
        }
    })();
</script>

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const upload = document.getElementById('uploadKtp');
    const preview = document.getElementById('previewKtp');
    // ===============================
    // KECILKAN PREVIEW KTP (MINIMAL)
    // ===============================
    const status = document.getElementById('ktpStatus');

    if (preview) {
        preview.classList.add('minimal');
    }

    if (status) {
        status.style.display = 'inline';
    }

    /* ===============================
       HELPER: FORMAT TANGGAL
       dd-MM-yyyy / dd/MM/yyyy → yyyy-MM-dd
    ================================ */
    function toHtmlDateFormat(dateStr) {
        if (!dateStr || typeof dateStr !== 'string') return '';
        const parts = dateStr.split(/[-\/]/);
        if (parts.length !== 3) return '';
        const [dd, mm, yyyy] = parts;
        return `${yyyy}-${mm.padStart(2,'0')}-${dd.padStart(2,'0')}`;
    }

    /* ===============================
       HELPER: SET VALUE BY ALIAS (AMAN)
    ================================ */
    function setValueByAliases(aliases, value, withPlaceholder = true) {
        if (value === undefined || value === null || value === '') return;

        aliases.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;

            // INPUT & TEXTAREA
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.value = value;

                // 🔥 placeholder ikut berubah
                if (withPlaceholder) {
                    el.setAttribute('placeholder', value);
                }
            }

            // SELECT
            if (el.tagName === 'SELECT') {
                for (let i = 0; i < el.options.length; i++) {
                    if (
                        el.options[i].value.toString().toUpperCase() ===
                        value.toString().toUpperCase()
                    ) {
                        el.selectedIndex = i;

                        // 🔥 trigger change agar banjar sinkron
                        el.dispatchEvent(new Event('change'));
                        break;
                    }
                }
            }
        });
    }


    /* ===============================
       PREPROCESS IMAGE (ANTI BURAM)
    ================================ */
    function preprocessImage(file, callback) {
        const img = new Image();
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            // OCR suka resolusi BESAR
            const scale = 2;
            canvas.width = img.width * scale;
            canvas.height = img.height * scale;

            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const d = imgData.data;

            // grayscale + threshold ringan
            for (let i = 0; i < d.length; i += 4) {
                const gray = d[i] * 0.3 + d[i + 1] * 0.59 + d[i + 2] * 0.11;
                const val = gray > 140 ? 255 : 0;
                d[i] = d[i + 1] = d[i + 2] = val;
            }

            ctx.putImageData(imgData, 0, 0);
            canvas.toBlob(blob => callback(blob), 'image/png');
        };
        img.src = URL.createObjectURL(file);
    }
    /* ===============================
       AUTO CROP KTP (ASUMSI RATIO 85.6:54)
    ================================ */
    function autoCropKTP(file, callback) {
        const img = new Image();
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);

            const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const d = imgData.data;

            // Grayscale
            for (let i = 0; i < d.length; i += 4) {
                const g = d[i] * 0.3 + d[i + 1] * 0.59 + d[i + 2] * 0.11;
                d[i] = d[i + 1] = d[i + 2] = g;
            }
            ctx.putImageData(imgData, 0, 0);

            // Cari area non-putih (deteksi kartu)
            let minX = canvas.width,
                minY = canvas.height,
                maxX = 0,
                maxY = 0;
            const threshold = 245;

            for (let y = 0; y < canvas.height; y++) {
                for (let x = 0; x < canvas.width; x++) {
                    const i = (y * canvas.width + x) * 4;
                    if (d[i] < threshold) {
                        minX = Math.min(minX, x);
                        minY = Math.min(minY, y);
                        maxX = Math.max(maxX, x);
                        maxY = Math.max(maxY, y);
                    }
                }
            }

            // fallback kalau gagal
            if (maxX <= minX || maxY <= minY) {
                console.warn('Auto crop gagal, pakai gambar asli');
                canvas.toBlob(blob => callback(blob), 'image/png');
                return;
            }

            const cropCanvas = document.createElement('canvas');
            cropCanvas.width = maxX - minX;
            cropCanvas.height = maxY - minY;

            cropCanvas
                .getContext('2d')
                .drawImage(canvas, minX, minY, cropCanvas.width, cropCanvas.height, 0, 0, cropCanvas.width, cropCanvas.height);

            cropCanvas.toBlob(blob => callback(blob), 'image/png');
        };

        img.src = URL.createObjectURL(file);
    }

    /* ===============================
       PARSING & ISI FORM
    ================================ */
    function processOcrText(text) {
        text = (text || '').toUpperCase().replace(/\r/g, '');

        // helper kecil: rapikan
        const cleanLine = (s) => (s || '')
            .toUpperCase()
            .replace(/O/g, '0')
            .replace(/[^\w\s:\/\-,.]/g, ' ')
            .replace(/\s+/g, ' ')
            .trim();

        // potong jika ketemu label berikutnya (biar tidak nyambung)
        const cutAtNextLabel = (value) => {
            if (!value) return '';
            const stopLabels = [
                'TEMPAT', 'TGL', 'LAHIR',
                'JENIS', 'KELAMIN', 'GOL', 'DARAH',
                'ALAMAT', 'RT', 'RW', 'KEL', 'DESA', 'KECAMATAN',
                'AGAMA', 'STATUS', 'PEKERJAAN', 'KEWARGANEGARAAN', 'BERLAKU', 'HINGGA',
                'PROVINSI', 'KABUPATEN', 'KOTA'
            ];
            let cut = value.length;
            for (const lb of stopLabels) {
                const idx = value.indexOf(' ' + lb);
                if (idx > 0 && idx < cut) cut = idx;
            }
            return value.substring(0, cut).trim();
        };

        // ambil setelah "LABEL : ..."
        const pickValue = (labelRegex) => {
            const m = text.match(labelRegex);
            return m ? cleanLine(m[1] || '') : '';
        };

        // normalisasi NIK (OCR sering salah huruf jadi angka)
        const normalizeNik = (raw) => {
            if (!raw) return '';
            let s = raw.toUpperCase().replace(/\s+/g, '');
            s = s
                .replace(/O/g, '0').replace(/D/g, '0')
                .replace(/I/g, '1').replace(/L/g, '1')
                .replace(/Z/g, '2')
                .replace(/S/g, '5')
                .replace(/B/g, '8')
                .replace(/G/g, '6')
                .replace(/Q/g, '0');
            s = s.replace(/[^\d]/g, '');
            const m = s.match(/\d{16}/);
            return m ? m[0] : '';
        };

        console.log('HASIL OCR:', text);

        // ===== NIK =====
        let nikRaw = pickValue(/\bNIK\b\s*:\s*([^\n]+)/i);
        nikRaw = cutAtNextLabel(nikRaw);
        let nik = normalizeNik(nikRaw);

        // ===== NAMA =====
        let nama = pickValue(/\bNAMA\b\s*:\s*([^\n]+)/i);
        nama = cutAtNextLabel(nama);

        // ===== TTL =====
        let ttl = pickValue(/\bTEMPAT\/TGL LAHIR\b\s*:\s*([^\n]+)/i) ||
            pickValue(/\bTEMPAT\/TANGGAL LAHIR\b\s*:\s*([^\n]+)/i);
        ttl = cleanLine(ttl);

        let tempat_lahir = '';
        let tanggal_lahir = '';
        const ttlMatch = ttl.match(/(.+),\s*(\d{2}[\/\-]\d{2}[\/\-]\d{4})/);
        if (ttlMatch) {
            tempat_lahir = cutAtNextLabel(ttlMatch[1].trim());
            tanggal_lahir = toHtmlDateFormat(ttlMatch[2]);
        }

        // ===== Jenis kelamin =====
        let jkLine = pickValue(/\bJENIS KELAMIN\b\s*:\s*([^\n]+)/i);
        jkLine = cleanLine(jkLine);
        let jenis_kelamin = '';
        if (jkLine.includes('LAKI')) jenis_kelamin = 'Laki-laki';
        else if (jkLine.includes('PEREMPUAN')) jenis_kelamin = 'Perempuan';

        // ===== Agama =====
        let agamaLine = pickValue(/\bAGAMA\b\s*:\s*([^\n]+)/i);
        agamaLine = cutAtNextLabel(agamaLine);
        let agama = '';
        ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDDHA', 'KONGHUCU'].forEach(a => {
            if (agamaLine.includes(a)) agama = a.charAt(0) + a.slice(1).toLowerCase();
        });

        // ===== Status perkawinan =====
        let statusLine = pickValue(/\bSTATUS PERKAWINAN\b\s*:\s*([^\n]+)/i) ||
            pickValue(/\bSTATUS\b\s*:\s*([^\n]+)/i);
        statusLine = cleanLine(statusLine);
        let status = '';
        if (statusLine.includes('BELUM') && statusLine.includes('KAWIN')) status = 'Belum Kawin';
        else if (statusLine.includes('KAWIN')) status = 'Kawin';
        else if (statusLine.includes('CERAI HIDUP')) status = 'Cerai Hidup';
        else if (statusLine.includes('CERAI MATI')) status = 'Cerai Mati';
        else if (statusLine.includes('CERAI')) status = 'Cerai';

        // ===== Pekerjaan =====
        let pekerjaan = pickValue(/\bPEKERJAAN\b\s*:\s*([^\n]+)/i);
        pekerjaan = cutAtNextLabel(pekerjaan);

        // ===== Alamat =====
        let alamat = pickValue(/\bALAMAT\b\s*:\s*([^\n]+)/i);
        alamat = cutAtNextLabel(alamat);

        // ===== ISI FORM =====
        setValueByAliases(['nik', 'nomor_nik', 'nik_penduduk', 'no_ktp'], nik);
        setValueByAliases(['nama', 'nama_lengkap', 'nama_penduduk'], nama);
        setValueByAliases(['tempat_lahir'], tempat_lahir);
        setValueByAliases(['tanggal_lahir', 'tgl_lahir'], tanggal_lahir);
        setValueByAliases(['jenis_kelamin', 'jk', 'gender'], jenis_kelamin);
        setValueByAliases(['agama'], agama);
        setValueByAliases(['status_perkawinan', 'perkawinan', 'status'], status);
        setValueByAliases(['pekerjaan', 'job', 'occupation'], pekerjaan);
        setValueByAliases(['alamat', 'alamat_lengkap', 'alamat_penduduk'], alamat);

        Swal.fire({
            icon: 'success',
            title: 'Scan Berhasil',
            text: 'Data KTP telah diisi otomatis. Silakan cek dan koreksi bila perlu.',
            confirmButtonColor: '#3085d6'
        });
    }


    /* ===============================
       EVENT UPLOAD KTP
    ================================ */
    upload.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';

        Swal.fire({
            title: 'Memproses KTP...',
            text: 'Sedang membaca data KTP',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        autoCropKTP(file, function(croppedBlob) {
            preprocessImage(croppedBlob, function(processedBlob) {
                Tesseract.recognize(
                    processedBlob,
                    'ind+eng', {
                        tessedit_pageseg_mode: Tesseract.PSM.SINGLE_BLOCK,
                        tessedit_char_whitelist: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789:-/., '
                    }
                ).then(({
                    data: {
                        text
                    }
                }) => {
                    Swal.close();
                    processOcrText(text);
                });
            });
        });
    });
</script>