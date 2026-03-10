<style>
    .nama-lembaga {
        font-weight: 600;
        color: var(--primary);
    }

    .lembaga-card {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        transition: all 0.25s ease;
    }

    .lembaga-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    }


</style>

<section id="lembaga">
    <div class="container-fluid">
        <div class="row bg-dark-subtle px-4 px-md-5 py-3">
        <div class="col m-0 p-0">
            <div class="d-flex align-items-center">
            <h4 class="section-title"><?=$title;?></h4>
            </div>
        </div>
        </div>
    </div>

    <div class="container-fluid">
    <div class="py-4 px-4 px-md-5">
        <div class="row g-4">
        <?php foreach($lembaga as $slug => $row): ?>
        <div class="col-12 col-md-6 mb-4">
            <a href="<?= base_url('landing/lembaga/'.$row['slug']); ?>" 
            class="text-decoration-none text-dark">
                <div class="card lembaga-card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi <?= $row['icon']; ?> me-3 fs-4 text-danger"></i>
                                <h5 class="nama-lembaga mb-0"><?= $row['nama']; ?></h5>
                            </div>
                            <i class="bi bi-chevron-right text-secondary"></i>
                            </div>
                        <p class="text-muted small mb-0">
                            <?= $row['deskripsi']; ?>
                        </p>
                    </div>
                </div>

            </a>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
    </div>




</section>




