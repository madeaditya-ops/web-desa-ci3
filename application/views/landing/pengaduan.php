<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

<style>

    .pengaduan-header{
        background-color: var(--primary);
        color: #fff;
        padding: 50px 15px 150px;
        text-align: center;
    }

    .pengaduan-header h2{
        font-weight: 700;
        margin-bottom: 15px;
    }

    .pengaduan-header p{
        font-size: 1.05rem;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .pengaduan-desc{
        max-width: 720px;
        margin: 0 auto;
        line-height: 1.7;
        font-size: 1.05rem;
    }


    .pengaduan-card{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 12px 30px rgba(0,0,0,.18);
        margin-top: -110px;
        padding: 35px 30px;
    }

    .pengaduan-card h4{
        color: var(--primary);
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
    }

    hr {
        height: 3px;
        background-color: var(--primary);
        border: none;
        opacity: 1;
        width: 100%;
        margin-bottom: 10px;
    }


    .pengaduan-card .form-control{
        background-color: #f2f2f2;
        border: none;
        border-radius: 8px;
        padding: 12px 14px;
    }

    .pengaduan-card label{
        font-weight: 600;
        font-size: 1rem;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .map-box{
        height: 220px;
        background: #eaeaea;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #777;
        font-size: .9rem;
    }


    .btn-pengaduan{
        background-color: var(--primary);
        color: #fff;
        padding: 6px 30px;
        border-radius: 30px;
    }

    .btn-pengaduan:hover{
        background-color: #a81216;
        color: #fff;
    }

    .turnstile-wrapper{
    display: flex;
    justify-content: center;
    margin-top: 25px;
    margin-bottom: 10px;
    }

    .turnstile-wrapper iframe{
        border-radius: 12px;
    }

    
    @media(max-width:768px){
        .pengaduan-header{
            padding: 70px 15px 140px;
        }
        .pengaduan-card{
            padding: 25px 20px;
            margin-top: -90px;
        }
    }
</style>


<!-- header -->
<section class="pengaduan-header">
    <div class="container">
        <h2>Pengaduan Masyarakat</h2>
        <p class="pengaduan-desc">
            Sampaikan keluhan Anda melalui layanan ini. Setiap pengaduan dari masyarakat
            akan kami tindak lanjuti demi kemajuan dan pelayanan desa yang lebih baik.
        </p>
    </div>
</section>

<!-- form -->
<section class="pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="pengaduan-card">

                    <h4>Form Pengaduan</h4>
                    <hr>

                    <form action="<?= site_url('pengaduan/store') ?>" method="post" enctype="multipart/form-data" novalidate>

                        <input type="hidden"
                        name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>">

                        
                        <div class="row g-3">
                            <!-- Nama -->
                            <div class="form-group col-md-6">
                                <label><span class="text-danger">*</span> Nama Lengkap</label>
                                <input type="text"
                                    name="nama_pelapor"
                                    maxlength="100"
                                    class="form-control <?= error_class('nama_pelapor') ?>"
                                    value="<?= old('nama_pelapor') ?>"
                                    placeholder="Masukkan Nama Anda">

                                <?php if (error('nama_pelapor')): ?>
                                    <small class="text-danger">
                                        <?= error('nama_pelapor') ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- Dusun Pelapor -->
                            <div class="form-group col-md-6">
                                <label for="dusun_pelapor"><span class="text-danger">*</span> Dusun Pelapor </label>
                                <select name="dusun_pelapor" id="dusun_pelapor" class="form-control <?= error_class('dusun_pelapor') ?>">
                                    <option value="">Pilih Dusun</option>
                                    <?php foreach ($dusun_pelapor as $dusun): ?>
                                        <option value="<?= $dusun->id_dusun ?>"
                                            <?= old('dusun_pelapor') == $dusun->id_dusun ? 'selected' : '' ?>>
                                            <?= $dusun->nama_dusun ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (error('dusun_pelapor')): ?>
                                    <small class="text-danger">
                                        <?= error('dusun_pelapor') ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                        </div>
                        

                        <div class="row">
                            <!-- Email -->
                            <div class="form-group col-md-6">
                                <label>Email <span class="text-secondary fw-light">(Opsional)</span></label>
                                <input type="email"
                                    name="email_pelapor"
                                    maxlength="100"
                                    class="form-control <?= error_class('email_pelapor') ?>"
                                    value="<?= old('email_pelapor') ?>"
                                    placeholder="Masukkan Email Anda">
                                <small class="text-muted">Sertakan email untuk mendapat informasi progres laporan</small>
                                <?php if (error('email_pelapor')): ?>
                                    <small class="text-danger">
                                        <?= error('email_pelapor') ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- Telepon -->
                            <div class="form-group col-md-6">
                                <label><span class="text-danger">*</span> No Telepon<span class="text-secondary fw-light"></span></label>
                                <input type="text"
                                    name="no_telepon"
                                    maxlength="100"
                                    class="form-control <?= error_class('no_telepon') ?>"
                                    value="<?= old('no_telepon') ?>"
                                    placeholder="Masukkan Telepon Anda">
                                 <?php if (error('no_telepon')): ?>
                                    <small class="text-danger">
                                        <?= error('no_telepon') ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            
                        </div>

                        <!-- Kategori Pengaduan -->
                         <div class="form-group col-12">
                            <label for="kategori_pengaduan"><span class="text-danger">*</span> Kategori Pengaduan</label>
                            <select name="kategori_pengaduan" id="kategori_pengaduan" class="form-control <?= error_class('kategori_pengaduan') ?>">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori_pengaduan as $kategori): ?>
                                    <option value="<?= $kategori->id_kategori ?>"
                                        <?= old('kategori_pengaduan') == $kategori->id_kategori ? 'selected' : '' ?>>
                                        <?= $kategori->nama_kategori ?>                                     
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (error('kategori_pengaduan')): ?>
                                <small class="text-danger">
                                    <?= error('kategori_pengaduan') ?>
                                </small>
                            <?php endif; ?>
                         </div>

                        <!-- Deskripsi -->
                        <div class="form-group col-12">
                            <label for="deskripsi" class="fw-semibold"><span class="text-danger">*</span> Deskripsi Laporan</label>
                            <textarea name="deskripsi"
                                    id="deskripsi"
                                    rows="4"
                                    maxlength="500"
                                    class="form-control <?= error_class('deskripsi') ?>"
                                    placeholder="Jelaskan keluhan yang Anda hadapi"><?= old('deskripsi') ?></textarea>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted">Maksimal 500 karakter</small>
                                <small id="charCounter" class="text-muted fw-semibold">0 / 500</small>
                            </div>
                            <?php if (error('deskripsi')): ?>
                                <small class="text-danger">
                                    <?= error('deskripsi') ?>
                                </small>
                            <?php endif; ?>
                        </div>

                        <!-- Foto -->
                        <div class="form-group col-12">
                            <label><span class="text-danger">*</span> Upload Bukti Foto</label>
                            <input type="file" name="foto_bukti" class="form-control" accept="image/*" >
                            <small class="text-muted">
                                Mohon lampirkan bukti foto guna mempercepat proses verifikasi.
                            </small>
                        </div>

                        <!-- Lokasi -->
                        <div class="form-group col-12">
                            <label>Lokasi</label>
                            <div class="map-box" id="map_pengaduan">
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <textarea id="lokasi_pengaduan" name="lokasi_pengaduan" class="form-control mt-2" readonly></textarea>
                        </div>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <!-- Captcha -->
                        <div class="turnstile-wrapper">
                            <div class="cf-turnstile"
                                data-sitekey="<?= $turnstile_site_key ?>"
                                data-theme="light"
                                data-size="normal">
                            </div>
                        </div>

                        <!-- Kirim -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-pengaduan" id="btnKirim">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const textarea = document.getElementById("deskripsi");
    const counter = document.getElementById("charCounter");
    const maxChars = 500;

    textarea.addEventListener("input", function () {

        let length = this.value.length;

        counter.textContent = length + " / " + maxChars + " karakter";

        // perubahan warna saat mendekati batas
        if (length > maxChars * 0.9) {
            counter.classList.remove("text-muted");
            counter.classList.add("text-danger");
        } else {
            counter.classList.remove("text-danger");
            counter.classList.add("text-muted");
        }
    });

});
</script>

<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>

<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<script src="<?= base_url('assets/js/map_pengaduan.js') ?>"></script>



<?php if ($this->session->flashdata('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '<?= $this->session->flashdata('success') ?>'
});
</script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    html: '<?= $this->session->flashdata('error') ?>'
});
</script>
<?php endif; ?>

<?php if ($this->session->flashdata('warning')): ?>
<script>
Swal.fire({
    icon: 'warning',
    title: 'Peringatan',
    html: '<?= $this->session->flashdata('warning') ?>'
});
</script>
<?php endif; ?>


