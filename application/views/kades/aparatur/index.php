<!DOCTYPE html>
<html>
<head>
    <title>Data Aparatur</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <h2>Data Aparatur</h2>
    <a href="<?= site_url('aparatur/tambah') ?>">➕ Tambah Aparatur</a>
    <br><br>

    <table id="tabelAparatur" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($aparatur as $a): ?>
            <tr>
                <td><?= $a->id_aparatur ?></td>
                <td><?= $a->nama ?></td>
                <td><?= $a->jabatan ?></td>
                <td>
                    <?php if($a->foto): ?>
                        <img src="<?= base_url('uploads/aparatur/'.$a->foto) ?>" width="60">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= site_url('aparatur/edit/'.$a->id_aparatur) ?>">✏️ Edit</a> | 
                    <a href="<?= site_url('aparatur/hapus/'.$a->id_aparatur) ?>" onclick="return confirm('Hapus data ini?')">🗑 Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#tabelAparatur').DataTable({
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50, 100],
                "ordering": true,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(disaring dari total _MAX_ data)"
                }
            });
        });
    </script>
</body>
</html>
