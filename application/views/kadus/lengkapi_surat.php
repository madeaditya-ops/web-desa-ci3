<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">
        Lengkapi Data Surat
    </h1>

    <p class="mb-4">
        Silakan lengkapi kembali data surat yang ditolak admin.
    </p>

    <!-- ALASAN PENOLAKAN -->
    <div class="alert alert-danger shadow-sm">

        <h6 class="font-weight-bold mb-2">
            <i class="fas fa-times-circle"></i>
            Alasan Penolakan
        </h6>

        <?= !empty($surat->alasan_tolak)
            ? nl2br(htmlspecialchars($surat->alasan_tolak))
            : '-' ?>

    </div>

    <div class="card shadow-lg border-0">

        <div class="card-header bg-warning text-dark">
            <h6 class="m-0 font-weight-bold">
                Form Lengkapi Surat
            </h6>
        </div>

        <div class="card-body">

            <form action="<?= site_url('kadus/update_lengkapi/' . $surat->id) ?>"
      method="POST">

                <div class="row">

                    <!-- DATA DIRI -->
                    <div class="col-md-6">

                        <div class="card border-left-primary shadow-sm mb-4">

                            <div class="card-body">

                                <h6 class="font-weight-bold text-primary mb-3">
                                    Data Diri
                                </h6>

                                <div class="form-group">

                                    <label>Nama Lengkap</label>

                                    <input type="text"
                                           class="form-control"
                                           name="nama"
                                           value="<?= htmlspecialchars($surat->nama ?? '') ?>"
                                           required>

                                </div>

                                <div class="form-group">

                                    <label>No. NIK</label>

                                    <input type="number"
                                           class="form-control"
                                           name="nik"
                                           value="<?= htmlspecialchars($surat->nik ?? '') ?>"
                                           required>

                                </div>

                                <div class="form-group">

                                    <label>Tempat Lahir</label>

                                    <input type="text"
                                           class="form-control"
                                           name="tempat_lahir"
                                           value="<?= htmlspecialchars($surat->tempat_lahir ?? '') ?>"
                                           required>

                                </div>

                                <div class="form-group">

                                    <label>Tanggal Lahir</label>

                                    <input type="date"
                                           class="form-control"
                                           name="tanggal_lahir"
                                           value="<?= htmlspecialchars($surat->tanggal_lahir ?? '') ?>"
                                           required>

                                </div>

                                <div class="form-group">

                                    <label>Jenis Kelamin</label>

                                    <select class="form-control"
                                            name="jenis_kelamin"
                                            required>

                                        <option value="">-- Pilih --</option>

                                        <option value="Laki-laki"
                                            <?= ($surat->jenis_kelamin ?? '') == 'Laki-laki'
                                                ? 'selected'
                                                : '' ?>>
                                            Laki-laki
                                        </option>

                                        <option value="Perempuan"
                                            <?= ($surat->jenis_kelamin ?? '') == 'Perempuan'
                                                ? 'selected'
                                                : '' ?>>
                                            Perempuan
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- DATA TAMBAHAN -->
                    <div class="col-md-6">

                        <div class="card border-left-success shadow-sm mb-4">

                            <div class="card-body">

                                <h6 class="font-weight-bold text-success mb-3">
                                    Data Tambahan
                                </h6>

                                <div class="form-group">

                                    <label>Agama</label>

                                    <select class="form-control"
                                            name="agama"
                                            required>

                                        <option value="">-- Pilih --</option>

                                        <?php
                                        $agama_list = [
                                            'Hindu',
                                            'Islam',
                                            'Kristen',
                                            'Katolik',
                                            'Buddha',
                                            'Khonghucu'
                                        ];
                                        ?>

                                        <?php foreach ($agama_list as $agama): ?>

                                            <option value="<?= $agama ?>"
                                                <?= ($surat->agama ?? '') == $agama
                                                    ? 'selected'
                                                    : '' ?>>

                                                <?= $agama ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label>Pekerjaan</label>

                                    <input type="text"
                                           class="form-control"
                                           name="pekerjaan"
                                           value="<?= htmlspecialchars($surat->pekerjaan ?? '') ?>"
                                           required>

                                </div>

                                <div class="form-group">

                                    <label>Status Perkawinan</label>

                                    <select class="form-control"
                                            name="sts_kawin"
                                            required>

                                        <option value="">-- Pilih --</option>

                                        <?php
                                        $status_list = [
                                            'Belum Kawin',
                                            'Kawin',
                                            'Cerai Hidup',
                                            'Cerai Mati',
                                            'Janda/Duda'
                                        ];
                                        ?>

                                        <?php foreach ($status_list as $sts): ?>

                                            <option value="<?= $sts ?>"
                                                <?= ($surat->sts_kawin ?? '') == $sts
                                                    ? 'selected'
                                                    : '' ?>>

                                                <?= $sts ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label>Maksud dan Tujuan</label>

                                    <textarea class="form-control"
                                              name="tujuan"
                                              rows="3"
                                              required><?= htmlspecialchars($surat->tujuan ?? '') ?></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="text-right">

                    <a href="<?= site_url('kadus/arsip') ?>"
                       class="btn btn-secondary">

                        <i class="fas fa-arrow-left"></i>
                        Kembali

                    </a>

                    <button type="submit"
                            class="btn btn-warning px-4">

                            
                        <i class="fas fa-paper-plane"></i>
                        Kirim Ulang

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>