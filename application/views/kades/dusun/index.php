<!DOCTYPE html>
<html>
<head>
    <title>Data Dusun</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body >

<div class="container">
    <h2 class="mb-4">Data Dusun</h2>
    <a href="<?php echo site_url('dusun/tambah'); ?>" class="btn btn-primary mb-3">+ Tambah Dusun</a>
    
    <div class="card shadow">
        <div class="card-body">
            <table id="dusunTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dusun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($dusun as $d): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $d->nama_dusun; ?></td>
                        <td>
                            <a href="<?= site_url('dusun/edit/'.$d->id_dusun); ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= site_url('dusun/hapus/'.$d->id_dusun); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery + Bootstrap JS + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#dusunTable').DataTable({
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data tersedia",
            "infoFiltered": "(disaring dari total _MAX_ data)"
        }
    });
});
</script>

</body>
</html>
