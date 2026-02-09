<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Isi Data Surat</h1>
    <p class="mb-4">Lengkapi data di bawah ini untuk surat "<?= htmlspecialchars($template->nama_surat, ENT_QUOTES, 'UTF-8') ?>".</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Data</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('kadus/proses_surat') ?>" method="POST">
                <input type="hidden" name="id_template" value="<?= $template->id_template ?>">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="nik">No. NIK</label>
                            <input type="number" class="form-control" id="nik" name="nik" required>
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <select class="form-control" id="agama" name="agama" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Hindu" selected>Hindu</option> <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>
                            <small class="form-text text-muted">Pilih agama warga sesuai KTP.</small>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" required>
                        </div>
                        <div class="form-group">
                            <label for="sts_kawin">Status Perkawinan</label>
                            <select class="form-control" id="sts_kawin" name="sts_kawin" required>
                                 <option value="">-- Pilih Status --</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                        </div>
                         <div class="form-group">
                            <label for="tujuan">Maksud dan Tujuan</label>
                            <textarea class="form-control" id="tujuan" name="tujuan" rows="3" required></textarea>
                        </div>
                        <hr>
                         <p class="font-weight-bold">Info Nomor Surat</p>
                        <div class="form-group">
                            <label for="kode_surat">Kode Surat (Pilih Jenis)</label>
                            <select class="form-control" id="kode_surat" name="kode_surat" required>
                                <option value="">-- Pilih Kode/Jenis Surat --</option>
                                <option value="470">470 - SURAT KETERANGAN DOMISILI</option>
                                <option value="472.36">472.36 - SURAT KETERANGAN AHLI WARIS</option>
                                <option value="472.5">472.5 - SURAT KETERANGAN BELUM KAWIN-NIKAH</option>
                                <option value="472.12">472.12 - SURAT KETERANGAN MENINGGAL</option>
                                <option value="401">401 - SURAT KETERANGAN KURANG MAMPU</option>
                                <option value="517">517 - SURAT KETERANGAN USAHA</option>
                                <option value="472.22">472.22 - SURAT KETERANGAN KAWIN-NIKAH</option>
                                <option value="470">470 - SURAT KETERANGAN DOMISILI PURA</option>
                                <option value="471.5">471.5 - SURAT KETERANGAN ORANGNYA SATU SAMA</option>
                                <option value="140">140 - SURAT KETERANGAN</option>
                            </select>
                            <small class="form-text text-muted">Pilih jenis surat untuk memasukkan kode secara otomatis.</small>
                        </div>
                         <div class="form-group">
                            <label for="no">Nomor Urut Surat</label>
                            <input type="number" class="form-control" id="no" name="no" required>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="<?= site_url('kadus') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Buat dan Download Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>