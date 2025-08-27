<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Dusun</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Dusun</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('dusun/update/'.$dusun->id_dusun) ?>" method="post">
                <div class="form-group">
                    <label for="kode_dusun">Kode Dusun</label>
                    <input type="text" name="kode_dusun" id="kode_dusun" class="form-control" value="<?= $dusun->kode_dusun ?>" required>
                </div>

                <div class="form-group">
                    <label for="nama_dusun">Nama Dusun</label>
                    <input type="text" name="nama_dusun" id="nama_dusun" class="form-control" value="<?= $dusun->nama_dusun ?>" required>
                </div>

                <a href="<?= site_url('dusun') ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>