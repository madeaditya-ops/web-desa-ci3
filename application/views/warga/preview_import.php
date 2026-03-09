<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Preview Data Import</h1>

    <div class="card shadow">
        <div class="card-body table-responsive">

            <form action="<?= base_url('warga/import_excel') ?>" 
                  method="post" 
                  enctype="multipart/form-data">

                <input type="hidden" 
                       name="file_excel" 
                       value="<?= $_FILES['file_excel']['tmp_name'] ?>">
                <button type="submit" 
                        class="btn btn-primary">
                        Proses Import
                </button>

                <a href="<?= base_url('warga') ?>" 
                   class="btn btn-secondary">
                   Batal
                </a>

            </form>

        </div>
    </div>

</div>
