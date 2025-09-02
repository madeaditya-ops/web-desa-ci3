<section class="peraturan_desa" id="peraturan_desa">
  <div class="container-fluid">
    <div class="row bg-dark-subtle px-4 px-md-5 py-3">
      <div class="col m-0 p-0">
        <div class="d-flex align-items-center">
          <h4 class="fw-bold text-start m-0" style="color:var(--primary);"><?=$title;?></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid px-4 px-md-5">
    <div class="table-responsive mt-4 mb-2 peraturan-table">
      <p class="mb-1">Daftar peraturan desa yang dapat Anda unduh atau lihat secara langsung.</p>
      <table class="table table-bordered table-hover align-middle shadow-sm">
        <thead class="table-dark text-center">
          <tr>
            <th scope="col" style="width: 5%;">No</th>
            <th scope="col">Nama File</th>
            <th scope="col" style="width: 20%;">Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($peraturan)): ?>
            <?php $no = 1; foreach ($peraturan as $item): ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $item['judul']; ?></td>
                <td class="text-center">
                <a href="<?= base_url('uploads/peraturan/' . $item['file_peraturan']); ?>" class="btn btn-sm btn-unduh me-1" download>
                    <i class="bi bi-download"></i> Unduh
                </a>
                <button class="btn btn-sm btn-lihat" data-bs-toggle="modal" data-bs-target="#previewModal"
                    data-file="<?= base_url('uploads/peraturan/' . $item['file_peraturan']); ?>">
                    <i class="bi bi-eye"></i> Lihat
                </button>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
            <td colspan="3" class="text-center text-muted py-3">
                Data peraturan desa belum tersedia.
            </td>
            </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- Modal Preview Dokumen -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Preview Dokumen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body p-0">
        <div class="ratio ratio-16x9">
          <iframe id="previewFrame" src="" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script Dinamis Modal -->
<script>
  const previewModal = document.getElementById('previewModal');
  previewModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const fileUrl = button.getAttribute('data-file');
    const iframe = document.getElementById('previewFrame');
    iframe.src = fileUrl;
  });

  previewModal.addEventListener('hidden.bs.modal', function () {
    document.getElementById('previewFrame').src = '';
  });
</script>