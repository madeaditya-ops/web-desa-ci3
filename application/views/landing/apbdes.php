<style>
  .btn-lihat{
    background-color: var(--accent);
    border: none;
    color: #fff;
  }
  .btn-lihat:hover{
    background-color: var(--accent);
    border: none;
    color: #fff;
  }
</style>
<section class="apbdes" id="apbdes">
  <div class="container-fluid">
    <div class="row bg-dark-subtle px-4 px-md-5 py-3">
      <div class="col m-0 p-0">
        <div class="d-flex align-items-center">
          <h4 class="fw-bold text-start m-0" style="color:var(--primary);"><?=$title;?></h4>
        </div>
      </div>
    </div>
  </div>


    <!-- Pencarian Apbdes -->
     <div class="container-fluid px-4 px-md-5 mt-4">
        <div class="card border-0 shadow-sm">
           <div class="card-body">
             <form id="tampilapbdes" name="tampilapbdes" method="POST" action="<?= site_url('landing/apbdes'); ?>">
               <div class="row g-3">
                 <!-- Tahun -->
                 <div class="col-md-6">
                   <label for="tahun" class="form-label fw-semibold">Tahun</label>
                   <?= $dropdown_tahun; ?>
                 </div>
     
                 <!-- Judul -->
                 <div class="col-md-6">
                   <label for="judul" class="form-label fw-semibold">Judul</label>
                   <?= $dropdown_judul?>
                 </div>
               </div>
     
               <!-- Tombol -->
               <div class="text-end mt-4">
                 <button type="submit" class="btn btn-sm btn-custom px-3">
                   <i class="bi bi-search me-2"></i> Cari
                 </button>
               </div>
             </form>
           </div>
        </div>
     </div>

     <!-- Hasil Pencarian -->
      <div class="container-fluid px-4 px-md-5 mt-4">
        <?php if (!empty($hasil)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Judul</th>
                <th>File</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($hasil as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row->tahun; ?></td>
                    <td><?= $row->judul; ?></td>
                    <td>
                    <?php if (!empty($row->file_apbdes)): ?>
                        <a href="<?= base_url('uploads/apbdes/'.$row->file_apbdes); ?>" target="_blank" 
                        class="btn btn-sm btn-lihat"><i class="bi bi-eye"></i> Lihat
                        </a>
                    <?php else: ?>
                        <span class="text-muted">Tidak ada file</span>
                    <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-warning">Data tidak ditemukan untuk pilihan tersebut.</div>
        <?php endif; ?>
      </div>
  
</section>
