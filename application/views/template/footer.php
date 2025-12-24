<!-- Kontak -->
<section class="kontak py-5" id="kontak">
  <div class="container-fluid px-4 px-md-5">
    <h2 class="text-center fw-bold mb-4">Kontak</h2>
    <hr class="mx-auto mb-5" style="width: 120px; border-top: 4px solid #dc3545;">
    <div class="row g-4">
      <div class="col-lg-5">
        <div class="card p-4 border-0 rounded-0 shadow-sm">
            <!-- Info Alamat -->
            <div class="info-box mb-3 d-flex align-items-start gap-3">
                <i class="bi bi-geo-alt fs-4 text-danger"></i>
                <div>
                <h6 class="mb-1 fw-semibold">Alamat</h6>
                <p class="mb-0 small text-muted">
                    <a href="https://maps.app.goo.gl/8TbpS7mWbyBNcYqY6" target="_blank" class="text-decoration-none text-muted">
                        Jl. Kebo Iwa No.2, Blahbatuh, Kec. Blahbatuh, Kabupaten Gianyar, Bali 80581
                    </a>
                </p>
                </div>
            </div>

            <!-- Info Telepon -->
            <div class="info-box mb-3 d-flex align-items-start gap-3">
                <i class="bi bi-phone fs-4 text-danger"></i>
                <div>
                <h6 class="mb-1 fw-semibold">Telepon</h6>
                <p class="mb-0 small text-muted">(0361) 479419</p>
                </div>
            </div>
 
            <!-- Info Email -->
            <div class="info-box mb-3 d-flex align-items-start gap-3">
                <i class="bi bi-envelope fs-4 text-danger"></i>
                <div>
                <h6 class="mb-1 fw-semibold">Email</h6>
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=desablahbatuhofc@gmail.com" class="mb-0 small text-muted" target="_blank">
                  desablahbatuhofc@gmail.com
                </a>
                </div>
            </div>
        </div>
        <!-- Tabel Jam Kerja -->
        <div class="table-responsive mt-2">
            <table class="table table-hover table-sm custom-table text-center">
              <thead class="table-light">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Hari</th>
                  <th scope="col">Jam Mulai</th>
                  <th scope="col">Jam Selesai</th>
                </tr>
              </thead>
              <tbody>
                <tr><th scope="row">1</th><td>Senin</td><td>08:00 WITA</td><td>16:00 WITA</td></tr>
                <tr><th scope="row">2</th><td>Selasa</td><td>08:00 WITA</td><td>16:00 WITA</td></tr>
                <tr><th scope="row">3</th><td>Rabu</td><td>08:00 WITA</td><td>16:00 WITA</td></tr>
                <tr><th scope="row">4</th><td>Kamis</td><td>08:00 WITA</td><td>16:00 WITA</td></tr>
                <tr><th scope="row">5</th><td>Jumat</td><td>08:00 WITA</td><td>14:00 WITA</td></tr>
              </tbody>
            </table>
        </div>
      </div>

      <!-- Peta -->
      <div class="col-lg-7">
        <div class="card border-0 rounded-0 shadow-sm p-3">
          <div id="map" style="height: 412px; border-radius: 0.5rem;"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-white text-center py-2" style="background-color: var(--primary);">
    <div class="container">
        <p class="mb-1">&copy; 2025 Pemerintah Desa Blahbatuh</p>
        <p class="mb-1">Design by <strong>Jurusan Teknologi Informasi PNB</strong></p>
        <p class="fw-light">JTI MI 2025</p>
    </div>
</footer>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>



 <!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>

    var map = L.map('map').setView([-8.566260, 115.300647], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([-8.566260, 115.300647]).addTo(map);
    marker.bindPopup(`
      <strong>Kantor Desa Blahbatuh</strong><br>
      <a href="https://maps.app.goo.gl/8TbpS7mWbyBNcYqY6" target="_blank">
        📍 Lihat di Google Maps
      </a>
    `).openPopup(); 
</script>

<!-- javascript -->
 <script src="<?= base_url('assets/js/script.js');?>"></script>


</body>
</html>
