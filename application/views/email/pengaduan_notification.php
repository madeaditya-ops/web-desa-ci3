<h3>Pengaduan Baru Masuk</h3>
<hr>
<table cellpadding="5">
    <tr>
        <td><strong>Nama</strong></td>
        <td>: <?= $nama ?></td>
    </tr>
    <tr>
        <td><strong>Email</strong></td>
        <td>: <?= $email ?></td>
    </tr>
    <tr>
        <td><strong>Lokasi</strong></td>
        <td>: <?= $lokasi ?></td>
    </tr>
    <tr>
        <td><strong>Deskripsi</strong></td>
        <td>: <?= nl2br($deskripsi) ?></td>
    </tr>
    <tr>
        <td><strong>Tanggal</strong></td>
        <td>: <?= $tanggal ?></td>
    </tr>
</table>

<hr>
<p style="font-size:12px;color:gray">
Email ini dikirim otomatis oleh Sistem Pengaduan Desa.
Mohon tidak membalas email ini.
</p>