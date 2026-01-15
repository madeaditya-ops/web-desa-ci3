<section>
    <div class="container-fluid">
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <h1>Selamat Datang Di Dashboard Admin</h1>
    </div>
</section>