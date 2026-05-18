<div class="container-fluid">

    <h4 class="mb-4">Edit Foto Warga</h4>

    <div class="card shadow">
        <div class="card-body">

            <form method="post"
                action="<?= base_url('kadus/update_foto/' . $warga->id) ?>"
                enctype="multipart/form-data">

                <label>Upload Foto</label>

                <input type="file" name="foto" class="form-control">

                <br>

                <button type="submit" class="btn btn-primary">
                    Simpan Foto
                </button>

            </form>
        </div>
    </div>

</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    let cropper;

    document.getElementById('inputImage').addEventListener('change', function(e) {

        const file = e.target.files[0];
        const url = URL.createObjectURL(file);

        const image = document.getElementById('preview');
        image.src = url;

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(image, {
            aspectRatio: 3 / 4,
            viewMode: 1
        });

    });

    document.querySelector("form").addEventListener("submit", function(e) {

        e.preventDefault();

        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 400
        });

        document.getElementById("foto_crop").value =
            canvas.toDataURL("image/jpeg");

        this.submit();

    });
</script>