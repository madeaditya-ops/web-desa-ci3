<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Arsip Surat</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h3,
        p {
            text-align: center;
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eeeeee;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h3>LAPORAN ARSIP SURAT KADUS</h3>

    <p>
        Periode:
        <?php if (!empty($from) || !empty($to)): ?>
            <?= !empty($from) ? date('d-m-Y', strtotime($from)) : '-' ?>
            s/d
            <?= !empty($to) ? date('d-m-Y', strtotime($to)) : '-' ?>
        <?php else: ?>
            Semua Surat
        <?php endif; ?>
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Nomor Pengantar</th>
                <th>Jenis Surat</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($arsip)): ?>
                <?php $no = 1;
                foreach ($arsip as $a): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($a->created_at)) ?></td>
                        <td><?= htmlspecialchars($a->nama ?? '-') ?></td>
                        <td>
                            <?php
                            $jenis = strtoupper(trim($a->jenis_surat_tujuan ?? $a->jenis_surat ?? $a->judul ?? ''));

                            if ($jenis === 'SURAT KETERANGAN') {
                                $noTpl = trim((string)($a->no_nasional ?? ''));
                            } else {
                                $noTpl = trim((string)($a->nomor_template_surat ?? $a->nomor_template_db ?? ''));
                            }

                            $noPg = trim((string)($a->nomor_pengantar ?? ''));
                            $kd   = trim((string)($a->kode_banjar ?? ''));

                            if ($noTpl !== '' && $noPg !== '') {
                                $cleanNoPg = preg_replace('/^\d+\//', '', ltrim($noPg, '/'));
                                $nomor = $noTpl . '/' . $cleanNoPg;
                            } elseif ($noPg !== '') {
                                $nomor = $noPg;
                            } elseif ($noTpl !== '') {
                                $nomor = $noTpl;
                            } else {
                                $nomor = '-';
                            }

                            if ($kd !== '' && strpos($nomor, '/KBD.') === false) {
                                $nomor .= '/KBD.' . $kd;
                            }

                            echo htmlspecialchars($nomor);
                            ?>
                        </td>
                        <td>
                            <?php

                            $pengantar = trim((string)($a->jenis_surat ?? ''));

                            $keterangan = strtoupper(
                                trim((string)($a->keterangan_data ?? ''))
                            );

                            $tujuan = strtoupper(
                                trim((string)($a->jenis_surat_tujuan ?? ''))
                            );

                            // KONDISI 1
                            // ada keterangan -> SOLAR
                            if ($pengantar !== '' && $keterangan !== '') {

                                echo htmlspecialchars($pengantar . ' untuk');
                                echo '<br>';
                                echo htmlspecialchars('SURAT KETERANGAN ' . $keterangan);

                                // KONDISI 2
                                // ada tujuan -> DOMISILI
                            } elseif ($pengantar !== '' && $tujuan !== '') {

                                echo htmlspecialchars($pengantar . ' untuk');
                                echo '<br>';
                                echo htmlspecialchars($tujuan);

                                // FALLBACK
                            } else {

                                echo htmlspecialchars(
                                    $pengantar
                                        ?: $tujuan
                                        ?: $a->judul
                                        ?: '-'
                                );
                            }
                            ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>