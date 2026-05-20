<div class="container-fluid">

    <h3 class="mb-4">Tambah Keluarga Dan Anggotanya</h3>

    <div class="card shadow">
        <div class="card-body">
            <h5 class="mt-4">Kepala Keluarga</h5>
            <form method="post" action="<?= base_url('kadus/simpan_kk') ?>">


                <!-- ========================= -->
                <!-- KEPALA KELUARGA -->
                <!-- ========================= -->

                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label>No KK</label>
                        <input type="text" name="no_kk" class="form-control" required
                            maxlength="16"
                            pattern="[0-9]{16}"
                            inputmode="numeric"
                            placeholder="isi dengan 16 angka"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16)">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>Dusun</label>
                        <input type="text" class="form-control"
                            value="<?= $dusun->nama_dusun ?>"
                            readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                            value="Br. <?= $dusun->nama_dusun ?> /Kec. Blahbatuh Kab. Gianyar"
                            readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>NIK</label>
                        <input type="text" name="nik_kepala" class="form-control" required
                            maxlength="16"
                            pattern="[0-9]{16}"
                            inputmode="numeric"
                            placeholder="isi dengan 16 angka"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16)">
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Nama</label>
                        <input type="text" name="nama_kepala" class="form-control" required>
                    </div>

                    <!-- 🔥 TAMBAHAN BARU -->
                    <div class="col-md-4 mt-2">
                        <label>Tempat Lahir</label>
                        <input name="tempat_lahir_kepala" class="form-control">
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_kepala" class="form-control">
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Pekerjaan</label>
                        <input name="pekerjaan_kepala" class="form-control">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>Jenis Kelamin</label>
                        <select name="jk_kepala" class="form-control">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <?php foreach ($jenis_kelamin as $jk): ?>
                                <option value="<?= $jk->id ?>">
                                    <?= $jk->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Agama</label>
                        <select name="agama_kepala" class="form-control">
                            <option value="">-- Pilih Agama --</option>
                            <?php foreach ($agama as $a): ?>
                                <option value="<?= $a->id ?>">
                                    <?= $a->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Status Perkawinan</label>
                        <select name="status_kepala" class="form-control">
                            <option value="">-- Pilih Status Perkawinan --</option>
                            <?php foreach ($status_perkawinan as $s): ?>
                                <option value="<?= $s->id ?>">
                                    <?= $s->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Pendidikan</label>
                        <select name="pendidikan_kepala" class="form-control">
                            <option value="">-- Pilih Pendidikan --</option>
                            <?php foreach ($pendidikan as $p): ?>
                                <option value="<?= $p->id ?>">
                                    <?= $p->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Kewarganegaraan</label>
                        <select name="kewarganegaraan_kepala" class="form-control">
                            <option value="">-- Pilih Kewarganegaraan --</option>
                            <?php foreach ($kewarganegaraan as $k): ?>
                                <option value="<?= $k->id ?>">
                                    <?= $k->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- ========================= -->
                <!-- ANGGOTA -->
                <!-- ========================= -->
                <h5 class="mt-4">Anggota Keluarga</h5>

                <div id="anggota-wrapper"></div>

                <button type="button" id="tambah" class="btn btn-success btn-sm mt-2">
                    ➕ Tambah Anggota
                </button>

                <!-- ========================= -->
                <!-- SUBMIT -->
                <!-- ========================= -->
                <div class="mt-4 text-right">
                    <button type="submit" class="btn btn-primary">
                        💾 Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- ========================= -->
<!-- SCRIPT TAMBAH ANGGOTA -->
<!-- ========================= -->
<script>
    let max = 8;

    document.getElementById('tambah').onclick = function() {

        let items = document.querySelectorAll('.item');
        let jumlah = items.length;

        if (jumlah >= max) {
            alert('Maksimal 8 anggota!');
            return;
        }

        let no = jumlah + 1;

        let html = `
    <div class="item border p-3 mt-3">

        <h6 class="mb-3 text-primary">
            👤 Anggota ${no}
        </h6>

        <div class="row">

            <div class="col-md-4">
                <label>NIK</label>
                <input name="anggota_nik[]" class="form-control
                maxlength="16"
                pattern="[0-9]{16}"
                inputmode="numeric"
                placeholder="isi dengan 16 angka"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16)">
            </div>

            <div class="col-md-4">
                <label>Nama</label>
                <input name="anggota_nama[]" class="form-control">
            </div>

                    <!-- 🔥 TAMBAHAN BARU -->
            <div class="col-md-4 mt-2">
                <label>Tempat Lahir</label>
                <input name="anggota_tempat_lahir" class="form-control">
            </div>

            <div class="col-md-4 mt-2">
                <label>Tanggal Lahir</label>
                <input type="date" name="anggota_tanggal_lahir" class="form-control">
            </div>

            <div class="col-md-4 mt-2">
                <label>Pekerjaan</label>
                <input name="anggota_pekerjaan" class="form-control">
            </div>

            <div class="col-md-4">
                <label>Hubungan</label>
                <select name="anggota_hubungan[]" class="form-control">
                    <option value="">-- Pilih Hubungan --</option>
                    <?php foreach ($hubungan as $h): ?>
                    <option value="<?= $h->id ?>"><?= $h->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mt-2">
                <label>Jenis Kelamin</label>
                <select name="anggota_jk[]" class="form-control">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <?php foreach ($jenis_kelamin as $jk): ?>
                    <option value="<?= $jk->id ?>"><?= $jk->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mt-2">
                <label>Agama</label>
                <select name="anggota_agama[]" class="form-control">
                    <option value="">-- Pilih Agama --</option>
                    <?php foreach ($agama as $a): ?>
                    <option value="<?= $a->id ?>"><?= $a->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mt-2">
                <label>Status</label>
                <select name="anggota_status[]" class="form-control">
                    <option value="">-- Pilih Status --</option>
                    <?php foreach ($status_perkawinan as $s): ?>
                    <option value="<?= $s->id ?>"><?= $s->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mt-2">
                <label>Pendidikan</label>
                <select name="anggota_pendidikan[]" class="form-control">
                    <option value="">-- Pilih Pendidikan --</option>
                    <?php foreach ($pendidikan as $p): ?>
                    <option value="<?= $p->id ?>"><?= $p->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mt-2">
                <label>Kewarganegaraan</label>
                <select name="anggota_kewarganegaraan[]" class="form-control">
                    <option value="">-- Pilih Kewarganegaraan --</option>
                    <?php foreach ($kewarganegaraan as $k): ?>
                    <option value="<?= $k->id ?>"><?= $k->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <button type="button" class="btn btn-danger btn-sm mt-2 remove">
            ❌ Hapus
        </button>

    </div>
    `;

        document.getElementById('anggota-wrapper').insertAdjacentHTML('beforeend', html);
    }

    // 🔥 AUTO RENUMBER SAAT HAPUS
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove')) {
            e.target.closest('.item').remove();
            updateNomor();
        }
    });

    function updateNomor() {
        let items = document.querySelectorAll('.item');

        items.forEach((el, index) => {
            let title = el.querySelector('h6');
            title.innerHTML = "👤 Anggota " + (index + 1);
        });
    }
</script>

<script>
    document.getElementById('dusun').addEventListener('change', function() {

        let selected = this.options[this.selectedIndex];
        let namaDusun = selected.getAttribute('data-nama');

        if (namaDusun) {
            let alamat = "Br. " + namaDusun + " /Kec. Blahbatuh Kab. Gianyar";
            document.getElementById('alamat').value = alamat;
        }
    });
</script>

<script>
    // 🔥 HITUNG UMUR OTOMATIS
    document.addEventListener('change', function(e) {

        if (e.target.name === 'anggota_tanggal_lahir[]') {

            let item = e.target.closest('.item');
            let tgl = new Date(e.target.value);
            let today = new Date();

            let umur = today.getFullYear() - tgl.getFullYear();
            let m = today.getMonth() - tgl.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < tgl.getDate())) {
                umur--;
            }

            item.querySelector('.umur').value = umur + ' Tahun';
        }

    });
</script>

<script>
    document.addEventListener('change', function(e) {

        if (e.target.name === 'anggota_status[]') {

            let item = e.target.closest('.item');

            let tglInput = item.querySelector('[name="anggota_tanggal_lahir[]"]').value;
            let statusText = e.target.options[e.target.selectedIndex].text.toLowerCase();

            if (!tglInput) return;

            let tgl = new Date(tglInput);
            let today = new Date();

            let umur = today.getFullYear() - tgl.getFullYear();

            if (umur < 17 && statusText.includes('kawin')) {

                alert('⚠️ Umur belum 17 tahun, tidak boleh status kawin');

                e.target.value = ""; // reset pilihan
            }
        }
    });
</script>