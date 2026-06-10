<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 25px; border-radius: 8px; border: 1px solid #dddddd;">

        <h2 style="color: #2c3e50; margin-top: 0;">
            Informasi Status Pengaduan
        </h2>

        <p>Halo, <strong><?= $nama_pelapor ?></strong>,</p>

        <p>
            Pengaduan Anda dengan detail berikut:
        </p>

        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <p style="margin: 0;">
                <strong>Deskripsi Pengaduan:</strong><br>
                <?= $deskripsi ?>
            </p>
        </div>

        <p>
            Status pengaduan saat ini:
        </p>

        <p style="font-size: 16px;">
            <strong style="color: #2980b9;">
                <?= strtoupper($status) ?>
            </strong>
        </p>

        <?php if($status == 'diproses'): ?>

            <div style="background: #fff3cd; padding: 15px; border-radius: 5px; color: #856404;">
                Laporan Anda telah diverifikasi dan sedang dalam proses penanganan oleh petugas kami.
            </div>

        <?php elseif($status == 'ditolak'): ?>

            <div style="background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24;">
                <strong>Alasan Penolakan:</strong><br>
                <?= $keterangan ?>
            </div>

        <?php elseif($status == 'selesai'): ?>

            <div style="background: #d4edda; padding: 15px; border-radius: 5px; color: #155724;">
                Pengaduan Anda telah selesai ditindaklanjuti. Terima kasih atas partisipasi Anda dalam pelayanan masyarakat Desa Blahbatuh.
            </div>

        <?php endif; ?>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid #dddddd;">

        <p style="margin-bottom: 5px;">
            Hormat kami,
        </p>

        <strong>
            Kantor Desa Blahbatuh
        </strong>

        <p style="font-size: 12px; color: #888888; margin-top: 20px;">
            Email ini dikirim otomatis oleh sistem pengaduan Desa Blahbatuh.
        </p>

    </div>

</body>
</html>