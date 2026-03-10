<html>
<body>
    <h3>Halo, <?= $nama_pelapor ?>!</h3>
    <p>Pengaduan Anda terkait: <strong>"<?= $deskripsi ?>"</strong></p>
    <p>Status saat ini: <strong><?= strtoupper($status) ?></strong></p>
    
    <div style="background: #f4f4f4; padding: 15px; border-radius: 5px;">
        <?php if($status == 'diproses'): ?>
            <p>Laporan Anda telah diverifikasi dan sedang dalam penanganan petugas kami.</p>
        <?php elseif($status == 'ditolak'): ?>
            <p>Mohon maaf, laporan Anda tidak dapat kami proses dengan alasan:</p>
            <p><i><?= $keterangan ?></i></p>
        <?php elseif($status == 'selesai'): ?>
            <p>Laporan Anda telah selesai ditindaklanjuti. Terima kasih telah berpartisipasi.</p>
        <?php endif; ?>
    </div>

    <p>Hormat kami,<br><strong>Kantor Desa Blahbatuh</strong></p>
</body>
</html>
