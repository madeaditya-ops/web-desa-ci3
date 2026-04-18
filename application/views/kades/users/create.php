<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Pengguna Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Tambah Pengguna</h6>
        </div>
        <div class="card-body">
            
            <form action="<?= site_url('users/store') ?>" method="post">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= set_value('nama') ?>" required>
                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= set_value('username') ?>" required>
                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <small class="form-text text-muted">Password akan di-hash secara otomatis.</small>
                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="superadmin" <?= set_select('role', 'superadmin'); ?>>Super Admin</option>
                        <option value="admin" <?= set_select('role', 'admin'); ?>>Admin</option>
                        <option value="kadus" <?= set_select('role', 'kadus'); ?>>Kadus</option>
                    </select>
                    <?= form_error('role', '<small class="text-danger">', '</small>'); ?>
                </div>
                                
                <div class="form-group">
                    <label for="dusun_id">Dusun</label>
                    <select name="dusun_id" id="dusun_id" class="form-control">
                        <option value="">-- Pilih Dusun --</option>
                        <?php foreach($dusun as $item): ?>
                            <option value="<?= $item->id_dusun ?>" <?= set_select('dusun_id', $item->id_dusun); ?>><?= $item->nama_dusun ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('dusun_id', '<small class="text-danger">', '</small>'); ?>
                </div>

                <a href="<?= site_url('users') ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

</div>