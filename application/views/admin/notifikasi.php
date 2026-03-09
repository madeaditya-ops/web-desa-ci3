<div class="container-fluid">

    <h4 class="mb-4 font-weight-bold text-primary">
        <i class="fas fa-bell"></i> Daftar Notifikasi
    </h4>

    <div class="card shadow">
        <div class="card-body">

            <?php if (!empty($notifikasi)): ?>
               <?php foreach ($notifikasi as $n): ?>

    <?php
        // Tentukan link baca berdasarkan role
        if ($this->session->userdata('role') == 'kadus') {
            $link_baca = site_url('kadus/baca_notif/'.$n->id);
        } else {
            $link_baca = site_url('admin/baca_notif/'.$n->id);
        }
    ?>

    <a href="<?= $link_baca ?>" style="text-decoration:none;">
        <div class="alert <?= $n->status == 'belum dibaca' ? 'alert-warning' : 'alert-light' ?>">

            <?= htmlspecialchars($n->pesan) ?>

            <small class="float-right text-muted">
                <?= date('d-m-Y H:i', strtotime($n->created_at ?? 'now')) ?>
            </small>

        </div>
    </a>

<?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-muted">
                    Tidak ada notifikasi
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>
