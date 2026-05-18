<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 20px;
        }

        .kop {
            text-align: center;
            line-height: 1.6;
            border: 2px solid black;
            border-collapse: collapse;
        }

        .kop h1 {
            font-size: 24px;
            margin: 0;
        }

        .kop h2 {
            font-size: 22px;
            margin: 0;
        }

        .kop p {
            margin: 2px 0;
            font-size: 20px;
        }

        hr {
            border: 1px solid black;
            margin: 10px 0;
        }

        .periode {
            text-align: right;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background-color: #d9d9d9;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            width: 100%;
        }

        .ttd {
            width: 200px;
            float: right;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <div class="kop">
        <h1>LAPORAN PENGADUAN MASYARAKAT</h1>
        <h2>PEMERINTAH DESA BLAHBATUH</h2>
        <p>Jl. Kebo Iwa No.2, Blahbatuh, Gianyar, Bali 80581</p>
        <p>Telp. (0361) 942830 | Email: desablahbatuhofc@gmail.com</p>
    </div>

    <hr>

    <!-- PERIODE -->
    <div class="periode">
        <b>Periode:</b>
        <?= isset($start_date) && $start_date ? date('d-m-Y', strtotime($start_date)) : '-' ?>
        s/d
        <?= isset($end_date) && $end_date ? date('d-m-Y', strtotime($end_date)) : '-' ?>
    </div>
    <br>

    <!-- TABEL -->
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>ID</th>
                <th>Nama Pelapor</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($pengaduan)) : ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            <?php else : ?>
                <?php $no = 1; foreach ($pengaduan as $p): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $p->id_pengaduan ?></td>
                    <td><?= $p->nama_pelapor ?></td>
                    <td><?= $p->nama_kategori ?></td>
                    <td><?= substr(strip_tags($p->deskripsi), 0, 80) ?></td>
                    <td class="text-center"><?= date('d-m-Y', strtotime($p->created_at)) ?></td>
                    <td><?= $p->lokasi_pengaduan ?></td>
                    <td class="text-center"><?= ucfirst($p->status) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- TOTAL -->
            <tr>
                <td colspan="7" class="text-right"><b>Total Pengaduan</b></td>
                <td class="text-center"><b><?= count($pengaduan) ?></b></td>
            </tr>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <div class="ttd">
            <p>Blahbatuh, <?= date('d-m-Y') ?></p>
            <p><b>Kepala Desa</b></p>

            <br><br><br>

            <p><b>(_____________________)</b></p>
        </div>
    </div>

</body>
</html>