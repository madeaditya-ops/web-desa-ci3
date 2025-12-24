<style>
  .text-justify {
    text-align: justify;
    text-justify: inter-word;
}
</style>

<section class="potensi_desa" id="potensi_desa">
  <div class="container-fluid">
    <div class="row bg-dark-subtle px-4 px-md-5 py-3">
      <div class="col m-0 p-0">
        <div class="d-flex align-items-center">
          <h4 class="fw-bold text-start m-0" style="color:var(--primary);"><?=$title;?></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="text-center my-3">
    <button class="btn btn-sm btn-outline-danger filter-btn active" data-filter="all">Semua</button>
    <?php 
    $kategori_unik = array_unique(array_column($potensi, 'kategori'));
    foreach ($kategori_unik as $kategori): ?>
      <button class="btn btn-sm btn-outline-danger filter-btn" data-filter="<?=$kategori?>"><?=$kategori?></button>
    <?php endforeach; ?>
  </div>



  
  <div class="container-fluid px-4 px-md-5">
    <div class="row row-cols-1 row-cols-md-3 g-4 py-4">
      <?php foreach ($potensi as $item): ?>
      <div class="col" data-category="<?=$item['kategori']?>">        
        <div class="card h-100">
          <img src="<?=base_url('uploads/potensi/' .$item['gambar']);?>" class="card-img-top img-potensi" alt="potensi_desa" data-bs-toggle="modal" data-bs-target="#modalPotensi<?=$item['id_potensi']?>">
          <div class="card-body">
            <h5 class="card-title fw-bold"><?=$item['nama']?></h5>
            <span class="badge1"><?=$item['kategori']?></span>
            <?php if(!empty($item['lokasi'])): ?>
              <a href="<?=$item['lokasi']?>" target="_blank" class="badge2">
                <i class="bi bi-geo-alt" style="padding-right: 3px;"></i>Kunjungi
              </a>
            <?php endif; ?>
            <p class="card-text pt-2 text-justify"><?=potong_deskripsi_perkata($item['deskripsi'], 100);?></p>

            <button type="button" class="btn-modal btn btn-custom btn-lg mt-2 px-4" data-bs-toggle="modal" data-bs-target="#modalPotensi<?=$item['id_potensi']?>">
                  Selengkapnya
            </button>
          </div>
        </div>
      </div>  
      <!-- Modal -->
      <div class="modal fade" id="modalPotensi<?=$item['id_potensi']?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <!-- Body -->
            <div class="modal-body">
              <div class="modal-img aspect-ratio-box">
              <img src="<?=base_url('uploads/potensi/' .$item['gambar']);?>" class="img-fluid rounded w-100 h-100 object-fit-cover" alt="...">
              </div>
              <div class="modal-subject mt-2">
                <h3 class="modal-title mb-2 fw-bold lh-sm" id="staticBackdropLabel"><?=$item['nama']?></h3>
                <div class="d-flex flex-wrap gap-2 mb-3">
                  <span class="badge1"><?=$item['kategori']?></span>
                  <?php if(!empty($item['lokasi'])): ?>
                    <a href="<?=$item['lokasi']?>" target="_blank" class="badge2">
                      <i class="bi bi-geo-alt" style="padding-right: 3px;"></i>Kunjungi
                    </a>
                  <?php endif; ?>
                </div>
                <p class="modal-desc text-justify"><?=$item['deskripsi']?></p>
                <div class="icon-sosmed mt-2">
                <a href="https://www.facebook.com/kantor.desablahbatuh" target="_blank"><i class="bi bi-facebook fs-4 me-3 "></i></a>
                <a href="https://www.instagram.com/desablahbatuh.ofc" target="_blank"><i class="bi bi-instagram fs-4 me-3 "></i></a>
                <a href="https://www.youtube.com/@kantordesablahbatuh" target="_blank"><i class="bi bi-youtube fs-4 "></i></a>
              </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-custom" data-bs-dismiss="modal">Keluar</button>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>    
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll(".filter-btn");
    const cards = document.querySelectorAll(".col[data-category]");

    buttons.forEach(btn => {
      btn.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");

        const filter = btn.getAttribute("data-filter");

        cards.forEach(card => {
          const category = card.getAttribute("data-category");
          if (filter === "all" || category === filter) {
            card.style.display = "";
          } else {
            card.style.display = "none";
          }
        });
      });
    });
  });
</script>



