<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            margin: 40px 60px;
        }

        #arsip {
            border-collapse: collapse;
            width: 100%;
        }

        #arsip td, #arsip th {
            border: 1px solid #333;
            padding: 6px;
        }

        #arsip th {
            background-color: #333;
            color: white;
            text-align: center;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>

<body>

    <!-- HEADER -->
    <table width="85%" border="0" align="center">
        <tr>
            <td align="center">
                <font size="4">LAPORAN PENGADUAN MASYARAKAT</font> <br/>
                <font size="4"><b>Pemerintah Desa Blahbatuh</b></font><br/>
                <font size="3">Jl. Kebo Iwa No.2, Blahbatuh, Kec. Blahbatuh, Kabupaten Gianyar, Bali 80581</font><br>
                <font size="3">Telp. (0361) 942830, Email: desablahbatuhofc@gmail.com</font>    
            </td>
        </tr>
    </table>


    <hr>

    <!-- PERIODE -->
    <div class="text-right">
        Periode: 
        <?= $start_date ? date('d-m-Y', strtotime($start_date)) : '-' ?> 
        s/d 
        <?= $end_date ? date('d-m-Y', strtotime($end_date)) : '-' ?>
    </div>

    <br>

    <!-- TABEL -->
    <table id="arsip">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($pengaduan)) : ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            <?php else : ?>
                <?php $no = 1; foreach ($pengaduan as $p): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $p->id_pengaduan ?></td>
                    <td><?= $p->nama_pelapor ?></td>
                    <td><?= $p->deskripsi ?></td>
                    <td class="text-center">
                        <?= date('d-m-Y', strtotime($p->created_at)) ?>
                    </td>
                    <td><?= $p->lokasi_pengaduan ?></td>
                    <td class="text-center"><?= ucfirst($p->status) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td colspan="6" class="text-right"><b>Total Pengaduan</b></td>
                <td class="text-center"><b><?= count($pengaduan) ?></b></td>
            </tr>
        </tbody>
    </table>

</body>
</html>