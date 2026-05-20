<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-3">

                <div class="col-sm-6">
                    <h1>Preview Surat</h1>
                </div>

                <div class="col-sm-6 text-right">

                    <a href="<?= base_url('uploads/surat/' . $arsip->file_admin) ?>"
                       class="btn btn-success"
                       target="_blank">

                        <i class="fas fa-download"></i>
                        Download Word
                    </a>

                </div>

            </div>

        </div>
    </section>

    <section class="content">

        <div class="container-fluid">

            <div class="preview-wrapper">

                <div class="preview-paper">

                    <?= $html_content ?>

                </div>

            </div>

        </div>

    </section>

</div>

<style>

.preview-wrapper{
    width:100%;
    overflow:auto;
    background:#f1f3f5;
    padding:30px 15px;
    border-radius:10px;
}

.preview-paper{

    width:210mm;
    min-height:297mm;

    margin:0 auto;

    background:#ffffff;

    padding:20mm 18mm;

    box-shadow:0 0 20px rgba(0,0,0,0.15);

    border-radius:5px;

    overflow:hidden;
}

/* Responsive */
@media(max-width:768px){

    .preview-paper{
        width:100%;
        padding:20px;
    }

}

/* Word content */
.preview-paper img{
    max-width:100% !important;
    height:auto !important;
}

.preview-paper table{
    width:100% !important;
    border-collapse:collapse;
}

.preview-paper p{
    margin-bottom:10px;
    line-height:1.6;
}

.preview-paper span,
.preview-paper div,
.preview-paper td,
.preview-paper th{
    font-family:Arial, sans-serif !important;
}

.preview-paper *{
    max-width:100% !important;
}

.preview-paper section{
    overflow:hidden;
}

</style>