<style>
    .nama-lembaga {
        font-weight: 600;
        color: var(--primary);
    }

    .lembaga-row {
        border-bottom: 1px solid #dee2e6;
        transition: background-color 0.25s ease;
    }

    .lembaga-row:hover {
        background-color: #d2d4d7;
    }

    .lembaga-accordion .accordion-button {
        background-color: var(--bs-dark-bg-subtle);
        color: inherit;
        font-weight: 600;
        box-shadow: none;
    }

    .lembaga-accordion .accordion-button:not(.collapsed) {
        background-color: var(--bs-dark-bg-subtle);
        color: inherit;
    }

</style>

<section id="lembaga">
    <div class="container-fluid mb-5">
        <div class="row bg-dark-subtle px-4 px-md-5 py-3">
        <div class="col m-0 p-0">
            <div class="d-flex align-items-center">
            <h4 class="section-title"><?=$title;?></h4>
            </div>
        </div>
        </div>
    </div>

        
<div class="container-fluid px-4 px-md-5">
    <div class="accordion lembaga-accordion" id="accordionLembaga">
        <?php $accordion_index = 0; ?>
        <?php foreach($lembaga_group as $jenis => $items): ?>
            <?php if(empty($items)) continue; ?>
            <?php
                $accordion_index++;
                $heading_id = 'headingLembaga' . $accordion_index;
                $collapse_id = 'collapseLembaga' . $accordion_index;
            ?>

            <div class="accordion-item border-0 shadow-sm mb-4">
                <h2 class="accordion-header" id="<?= $heading_id; ?>">
                    <button class="accordion-button px-4 px-md-5 py-3" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#<?= $collapse_id; ?>"
                        aria-expanded="true"
                        aria-controls="<?= $collapse_id; ?>">
                        <span class="section-title mb-0"><?= $nama_jenis[$jenis]; ?></span>
                    </button>
                </h2>

                <div id="<?= $collapse_id; ?>"
                    class="accordion-collapse collapse show"
                    aria-labelledby="<?= $heading_id; ?>">
                    <div class="accordion-body px-0 pt-4 pb-0">
                        <div class="mb-5">
                            <?php foreach($items as $row): ?>

                            <?php
                            $url = base_url('landing/lembaga/'.$row['slug']);

                            if ($row['slug'] == 'pemerintah-desa-blahbatuh') {
                                $url = base_url('landing/struktur_pemerintahan');
                            }
                            ?>
                            
                            <a href="<?=$url?>" 
                            class="lembaga-row text-decoration-none text-dark d-flex justify-content-between align-items-center px-4 px-md-5 py-3">
                                <div class="d-flex align-items-start">
                                    <!-- <i class="bi <?= $row['icon']; ?> me-3 fs-4 text-danger"></i> -->
                                    <div>
                                        <h5 class="nama-lembaga mb-1"><?= $row['nama']; ?></h5>
                                        <p class="text-muted small mb-0">
                                            <?= $row['deskripsi']; ?>
                                        </p>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-secondary ms-3"></i>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>

</div>



</section>
