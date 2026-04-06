<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Verifikasi Selesai</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Verifikasi Selesai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive"> 
  
  <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Banjar</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>
  <tbody>
<?php $no = 1; foreach($selesai as $s): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $s->nama ?></td>
    <td><?= $s->nik ?></td>
    <td><?= $s->banjar ?></td>
    <td><?= date('d-m-Y', strtotime($s->created_at)) ?></td>
    <td class="text-center">
        <?php
            if ($s->status == 'menunggu') {
                echo '<span class="badge badge-warning">Menunggu</span>';
            } elseif ($s->status == 'disetujui') {
                echo '<span class="badge badge-success">disetujui</span>';
            } else {
                echo '<span class="badge badge-danger">Ditolak</span>';
            }
        ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>

</table>
            </div>
        </div>
    </div>
