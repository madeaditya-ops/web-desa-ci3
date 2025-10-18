<section class="peta_wilayah" id="peta_wilayah">
  <div class="container-fluid">
    <div class="row bg-dark-subtle px-4 px-md-5 py-3">
      <div class="col m-0 p-0">
        <div class="d-flex align-items-center">
          <h4 class="fw-bold text-start m-0" style="color:var(--primary);"><?=$title;?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Gambar Peta dan Informasi Wilayah -->
  <div class="container-fluid px-4 px-md-5">
    <div class="row g-4">
      <!-- Gambar Peta -->
      <div class="col-lg-6">
        <div class="card rounded-0 border-0 shadow-sm my-3">
          <img src="<?= base_url('assets/image/peta_wilayah.jpg') ?>" alt="Struktur Pemerintahan Desa" class="img-fluid rounded-0">
        </div>
      </div>

      <!-- Informasi Luas Wilayah dan Banjar -->
      <div class="col-lg-6">
        <div class="card rounded-0 border-0 shadow-sm my-3 p-4 bg-light">
          <h5 class="fw-bold text-danger mb-3">Luas Wilayah Desa</h5>
          <h1 class="display-6 fw-semibold text-dark">467 Ha</h1>
          <h6 class="text-muted mb-3">Terdiri dari:</h6>
          <ul class="list-group list-group-flush mb-4">
            <li class="list-group-item">🌾 Persawahan: <strong>287,7 Ha</strong></li>
            <li class="list-group-item">🏡 Pekarangan: <strong>63.95 Ha</strong></li>
            <li class="list-group-item">🌿 Tegalan: <strong>86.81 Ha</strong></li>
            <li class="list-group-item">📍 Lainnya: <strong>31.00 Ha</strong></li>
          </ul>
        </div>

        <div class="card rounded-0 border-0 shadow-sm my-3 p-4 bg-light">
          <h5 class="fw-bold text-danger mb-2">Banjar Dinas</h5>
          <p class="text-muted mb-3">
            Desa Blahbatuh terdiri dari <strong>12 Banjar Dinas</strong>, yaitu:
          </p>
          <div class="row">
            <div class="col-6">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">1. Banjar Laud</li>
                <li class="list-group-item">2. Banjar Pande</li>
                <li class="list-group-item">3. Banjar Tusan</li>
                <li class="list-group-item">4. Banjar Kebon</li>
                <li class="list-group-item">5. Banjar Tengah</li>
                <li class="list-group-item">6. Banjar Tubuh</li>
              </ul>
            </div>
            <div class="col-6">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">7. Banjar Babakan</li>
                <li class="list-group-item">8. Banjar Antugan</li>
                <li class="list-group-item">9. Banjar Darmatiaga</li>
                <li class="list-group-item">10. Banjar Satria</li>
                <li class="list-group-item">11. Banjar Pokas</li>
                <li class="list-group-item">12. Banjar Teruna</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Peta Interaktif -->
  <div class="container-fluid px-4 px-md-5">
    <div class="row">
      <div class="col">
        <div class="card border-0 rounded-0 shadow-sm p-3 mt-3">
          <h5 class="fw-bold text-danger mb-3">Lokasi Kantor Desa</h5>
          <div id="map_lengkap" class="z-0 position-relative" style="height: 412px; border-radius: 0.5rem;"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
  var map = L.map('map_lengkap').setView([-8.566260, 115.300647], 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  <?php foreach ($lokasi_banjar as $lokasi): ?>
    var marker = L.marker([<?= $lokasi['lat'] ?>, <?= $lokasi['lng'] ?>]).addTo(map);
    var popupContent = `<strong><?= $lokasi['nama'] ?></strong>`;
    <?php if (!empty($lokasi['link'])): ?>
      popupContent += `<br><a href="<?= $lokasi['link'] ?>" target="_blank">📍 Lihat di Google Maps</a>`;
    <?php endif; ?>
    marker.bindPopup(popupContent);
  <?php endforeach; ?>
</script>
