<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pengaduan</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">

    <?php
    // Helper untuk menampilkan "-" jika data kosong
    function tampil($value)
    {
        return !empty(trim($value ?? '')) ? $value : '-';
    }
    ?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0"
        style="background-color:#f4f4f4; padding:20px 10px;">

        <tr>
            <td align="center">

                <!-- Container -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0"
                    style="
                        max-width:600px;
                        background:#ffffff;
                        border-radius:8px;
                        overflow:hidden;
                        border:1px solid #dddddd;
                    ">

                    <!-- Header -->
                    <tr>
                        <td style="background:#2c3e50; padding:20px;">
                            <h2 style="margin:0; color:#ffffff; font-size:24px;">
                                Pengaduan Baru Masuk
                            </h2>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:25px;">

                            <p style="margin-top:0; color:#333333; line-height:1.6;">
                                Terdapat pengaduan baru yang dikirim melalui
                                <strong>Sistem Pengaduan Desa Blahbatuh</strong>.
                            </p>

                            <!-- Table -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                style="border-collapse:collapse; font-size:14px;">

                                <tr>
                                    <td width="35%"
                                        style="
                                            padding:12px;
                                            border:1px solid #dddddd;
                                            background:#f9f9f9;
                                        ">
                                        <strong>Nama</strong>
                                    </td>

                                    <td style="padding:12px; border:1px solid #dddddd;">
                                        <?= tampil($nama) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:12px; border:1px solid #dddddd;">
                                        <strong>Email</strong>
                                    </td>

                                    <td style="padding:12px; border:1px solid #dddddd;">
                                        <?= tampil($email) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        style="
                                            padding:12px;
                                            border:1px solid #dddddd;
                                            background:#f9f9f9;
                                        ">
                                        <strong>No Telepon</strong>
                                    </td>

                                    <td style="padding:12px; border:1px solid #dddddd;">
                                        <?= tampil($no_telepon) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:12px; border:1px solid #dddddd;">
                                        <strong>Dusun Pelapor</strong>
                                    </td>

                                    <td style="padding:12px; border:1px solid #dddddd;">
                                        <?= tampil($nama_dusun) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        style="
                                            padding:12px;
                                            border:1px solid #dddddd;
                                            background:#f9f9f9;
                                        ">
                                        <strong>Lokasi</strong>
                                    </td>

                                    <td style="padding:12px; border:1px solid #dddddd;">
                                        <?= tampil($lokasi) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:12px; border:1px solid #dddddd;">
                                        <strong>Tanggal</strong>
                                    </td>

                                    <td style="padding:12px; border:1px solid #dddddd;">
                                        <?= tampil($tanggal) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td valign="top"
                                        style="
                                            padding:12px;
                                            border:1px solid #dddddd;
                                            background:#f9f9f9;
                                        ">
                                        <strong>Deskripsi</strong>
                                    </td>

                                    <td
                                        style="
                                            padding:12px;
                                            border:1px solid #dddddd;
                                            line-height:1.6;
                                        ">
                                        <?= !empty(trim($deskripsi ?? '')) ? nl2br($deskripsi) : '-' ?>
                                    </td>
                                </tr>

                            </table>

                            <!-- Button -->
                            <table border="0" cellspacing="0" cellpadding="0"
                                style="margin-top:25px;">

                                <tr>
                                    <td align="center"
                                        style="border-radius:5px;"
                                        bgcolor="#2c3e50">

                                        <a href="<?= base_url('auth/login') ?>"
                                            target="_blank"
                                            style="
                                                font-size:14px;
                                                font-family:Arial, sans-serif;
                                                color:#ffffff;
                                                text-decoration:none;
                                                padding:12px 20px;
                                                display:inline-block;
                                                font-weight:bold;
                                            ">

                                            Lihat Pengaduan

                                        </a>

                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="
                                background:#f8f8f8;
                                padding:15px;
                                text-align:center;
                                font-size:12px;
                                color:#777777;
                                border-top:1px solid #dddddd;
                                line-height:1.6;
                            ">

                            Email ini dikirim otomatis oleh
                            <strong>Sistem Pengaduan Desa Blahbatuh</strong>.

                            <br>

                            Mohon tidak membalas email ini.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>

    </table>

</body>
</html>