    <div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Pengguna</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Pengguna</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('users/update/'.$user->id_user) ?>" method="post">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $user->nama ?>" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= $user->username ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="superadmin" <?= $user->role == 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                        <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="kadus" <?= $user->role == 'kadus' ? 'selected' : '' ?>>Kadus</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dusun_id">Dusun</label>
                    <select name="dusun_id" id="dusun_id" class="form-control">
                        <option value="">-- Pilih Dusun --</option>
                        <?php foreach($dusun as $d): ?>
                            <option value="<?= $d->id_dusun ?>" 
                                <?= $user->dusun_id == $d->id_dusun ? 'selected' : '' ?>>
                                <?= $d->nama_dusun ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <a href="<?= site_url('users') ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>