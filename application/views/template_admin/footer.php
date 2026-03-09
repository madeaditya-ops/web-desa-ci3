 </div>
 <!-- End of Main Content -->

 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy; Your Website 2021</span>
         </div>
     </div>
 </footer>
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Anda ingin logout?</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Pilih "Logout" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                 <a class="btn btn-primary" href="<?= site_url('logout') ?>">Logout</a>
             </div>
         </div>
     </div>
 </div>

 <!-- Bootstrap core JavaScript-->
 <script src="<?= base_url('assets/admin/vendor/jquery/jquery.min.js') ?>"></script>
 <script src="<?= base_url('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <!-- Core plugin JavaScript-->
 <script src="<?= base_url('assets/admin/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

 <!-- Custom scripts for all pages-->
 <script src="<?= base_url('assets/admin/js/sb-admin-2.min.js') ?>"></script>

 <!-- Page level plugins -->
 <script src="<?= base_url('assets/admin/vendor/chart.js/Chart.min.js') ?>"></script>

 <!-- Page level custom scripts -->
 <script src="<?= base_url('assets/admin/js/demo/chart-area-demo.js') ?>"></script>
 <script src="<?= base_url('assets/admin/js/demo/chart-pie-demo.js') ?>"></script>

 <!-- Page level plugins -->
 <script src="<?= base_url('assets/admin/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
 <script src="<?= base_url('assets/admin/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

 <script>
     // Panggil plugin DataTables saat dokumen siap
     $(document).ready(function() {
         $('#dataTable').DataTable(); // #dataTable adalah ID dari tabel Anda
     });
 </script>



 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 <script>
     $(document).ready(function() {

         /* ===============================
            INIT SELECT2
         =============================== */
         const $pilihWarga = $('#pilihWarga').select2({
             placeholder: '-- Pilih Nama Warga --',
             allowClear: true,
             width: '100%'
         });

         /* ===============================
            EVENT SAAT WARGA DIPILIH
         =============================== */
         $pilihWarga.on('select2:select', function(e) {

             const id = e.params.data.id;
             const option = e.params.data.element;

             /* ===============================
                🔥 HILANGKAN LABEL "TERBARU"
             =============================== */
             if ($(option).data('terbaru') == 1) {
                 $(option).data('terbaru', 0);
             }

             if (!id) return;

             fetch('<?= site_url("admin/get_data_warga/") ?>' + id)
                 .then(res => res.json())
                 .then(res => {
                     if (!res.status || !res.data) {
                         console.warn('Data warga tidak valid');
                         return;
                     }

                     const d = res.data;
                     console.log('DATA WARGA:', d);

                     /* ==========================
                        IDENTITAS UTAMA
                     ========================== */
                     setValueByAliases(
                         ['nama', 'nama_lengkap', 'nama_penduduk'],
                         d.nama
                     );

                     setValueByAliases(
                         ['nik', 'nomor_nik', 'nik_penduduk', 'no_ktp'],
                         d.nik
                     );

                     /* ==========================
                        NOMOR SURAT & PENGANTAR
                     ========================== */
                     setValueByAliases(
                         ['nomor_surat', 'nomor'],
                         d.nomor_surat
                     );

                     setValueByAliases(
                         ['nomor_pengantar', 'no_pengantar', 'nomor_pengantar_kelian'],
                         d.nomor_pengantar
                     );

                     /* ==========================
                        BANJAR (KODE & NAMA)
                     ========================== */
                     setValueByAliases(
                         ['kode_banjar', 'kode_dusun', 'kode'],
                         d.kode_banjar
                     );

                     setValueByAliases(
                         ['banjar'],
                         d.banjar
                     );

                     /* ==========================
                        TEMPAT & TGL LAHIR
                     ========================== */
                     setValueByAliases(
                         ['tempat_lahir', 'lahir_di'],
                         d.tempat_lahir
                     );

                     if (d.tanggal_lahir) {
                         setValueByAliases(
                             ['tanggal_lahir', 'tgl_lahir', 'lahir_tanggal'],
                             d.tanggal_lahir
                         );
                     }

                     /* ==========================
                        DATA PERSONAL
                     ========================== */
                     setValueByAliases(
                         ['jenis_kelamin', 'jk', 'gender', 'kelamin'],
                         d.jenis_kelamin
                     );

                     setValueByAliases(
                         ['agama', 'religion'],
                         d.agama
                     );

                     setValueByAliases(
                         ['status_perkawinan', 'perkawinan', 'status'],
                         d.status_perkawinan
                     );

                     setValueByAliases(
                         ['pekerjaan', 'job', 'occupation'],
                         d.pekerjaan
                     );

                     /* ==========================
                        ALAMAT
                     ========================== */
                     setValueByAliases(
                         ['alamat', 'alamat_lengkap', 'alamat_penduduk'],
                         d.alamat_lengkap
                     );

                     setValueByAliases(
                         ['kecamatan'],
                         d.kecamatan || 'Blahbatuh'
                     );

                     setValueByAliases(
                         ['kabupaten'],
                         d.kabupaten || 'Gianyar'
                     );

                     /* ==========================
                        TUJUAN
                     ========================== */
                     setValueByAliases(
                         ['tujuan', 'maksud', 'keperluan'],
                         d.tujuan
                     );

                     /* ==========================
                        FEEDBACK USER
                     ========================== */
                     if (typeof Swal !== 'undefined') {
                         Swal.fire({
                             icon: 'success',
                             title: 'Data Warga Dimuat',
                             text: 'Nomor surat, pengantar, dan banjar terisi otomatis.',
                             timer: 1600,
                             showConfirmButton: false
                         });
                     }
                 })
                 .catch(err => {
                     console.error(err);
                     if (typeof Swal !== 'undefined') {
                         Swal.fire('Error', 'Gagal mengambil data warga', 'error');
                     }
                 });
         });

     });
 </script>

 <script>
     $(document).ready(function() {

         function formatWarga(option) {
             if (!option.id) return option.text;

             const $el = $(option.element);
             const isBaru = $el.data('terbaru') == 1;

             let text = option.text;

             if (isBaru) {
                 text += ' <span class="select2-terbaru">TERBARU</span>';
             }

             return $('<span>' + text + '</span>');
         }

         $('#pilihWarga').select2({
             placeholder: '-- Pilih Nama Warga --',
             allowClear: true,
             width: '100%',
             templateResult: formatWarga,
             templateSelection: formatWarga,
             escapeMarkup: function(m) {
                 return m;
             }
         });

     });
 </script>

 <script>
     $('#pilihWarga').on('select2:select', function(e) {

         const option = e.params.data.element;
         const id = e.params.data.id;

         if ($(option).data('terbaru') == 1) {

             // 1️⃣ Hilangkan badge di frontend
             $(option).data('terbaru', 0);

             // 2️⃣ Update tampilan Select2
             $('#pilihWarga').trigger('change.select2');

             // 3️⃣ RESET KE DATABASE
             $.ajax({
                 url: '<?= site_url("admin/reset_warga_terbaru/") ?>' + id,
                 type: 'POST',
                 dataType: 'json'
             });
         }
     });
 </script>


 <script>
     $(document).on('click', '.btn-detail', function(e) {
         e.preventDefault();

         const id = $(this).data('id');

         $('#detailContent').html(`
        <tr>
            <td colspan="2" class="text-center text-muted">Memuat data...</td>
        </tr>
    `);

         $('#btnSetujui').attr('href', '<?= site_url('admin/setujui/') ?>' + id);
         $('#btnTolak').attr('href', '<?= site_url('admin/tolak/') ?>' + id);

         $('#modalDetail').modal({
             backdrop: 'static',
             keyboard: false
         });

         $.getJSON('<?= site_url('admin/detail_verifikasi/') ?>' + id)
             .done(function(res) {
                 let html = '';
                 Object.keys(res).forEach(key => {
                     if (key === 'id') return;
                     html += `
                    <tr>
                        <th width="30%">${key.replace(/_/g,' ').toUpperCase()}</th>
                        <td>${res[key] ?? '-'}</td>
                    </tr>
                `;
                 });
                 $('#detailContent').html(html);
             })
             .fail(function() {
                 $('#detailContent').html(`
                <tr>
                    <td colspan="2" class="text-danger text-center">
                        Gagal memuat data
                    </td>
                </tr>
            `);
             });
     });
 </script>

 <script>
     $('#template_select').on('change', function() {

         let id = $(this).val();

         if (!id) {
             $('#nomor_surat').val('');
             return;
         }

         $.ajax({
             url: "<?= site_url('kadus/generate_nomor_surat') ?>",
             type: "POST",
             dataType: "json",
             data: {
                 id_template: id
             },
             success: function(res) {
                 if (res.status) {
                     $('#nomor_surat').val(res.nomor);
                 } else {
                     $('#nomor_surat').val('');
                 }
             },
             error: function() {
                 alert('Gagal mengambil nomor surat');
             }
         });

     });
 </script>

 <script>
     document.getElementById('kode_dusun').addEventListener('change', function() {
         var selected = this.options[this.selectedIndex];
         document.getElementById('banjar').value = selected.getAttribute('data-name');
     });
 </script>

 <script>
     $('#template_select').on('change', function() {

         let nama = $("#template_select option:selected").data('nama');

         if (nama === 'surat keterangan') {
             $('#form_keterangan').slideDown();
         } else {
             $('#form_keterangan').slideUp();
         }

     });
 </script>

 <script>
     $('#btnPreview').click(function() {

         var formData = new FormData($('#formImport')[0]);

         $.ajax({
             url: "<?= base_url('warga/preview_import_ajax') ?>",
             type: "POST",
             data: formData,
             contentType: false,
             processData: false,
             success: function(response) {
                 $('#previewContent').html(response);
                 $('#modalPreview').modal('show');
             }
         });

     });

     function startImport(fileName) {

         $.post("<?= base_url('warga/start_import') ?>", {
             file: fileName
         });

         let interval = setInterval(function() {

             $.get("<?= base_url('warga/check_progress') ?>", function(data) {

                 let percent = data.percent;

                 $('#progressBar')
                     .css('width', percent + '%')
                     .text(percent + '%');

                 if (percent >= 100) {
                     clearInterval(interval);
                     alert("Import Selesai!");
                     location.reload();
                 }

             }, 'json');

         }, 1000);
     }

     $('#btnImport').click(function() {

         var formData = new FormData($('#formImport')[0]);

         $.ajax({
             url: "<?= base_url('warga/import_excel_ajax') ?>",
             type: "POST",
             data: formData,
             contentType: false,
             processData: false,
             dataType: 'json',
             success: function(response) {

                 if (response.status === 'success') {
                     Swal.fire({
                         icon: 'success',
                         title: 'Berhasil',
                         html: response.message
                     }).then(() => {
                         location.reload();
                     });

                 } else {

                     Swal.fire({
                         icon: 'error',
                         title: 'Gagal Import',
                         html: response.message,
                         width: 600
                     });

                 }

             }
         });

     });
 </script>

 <script>
     function hitungUmur(tanggal) {

         if (!tanggal) return "-";

         let lahir = new Date(tanggal);
         let today = new Date();

         let umur = today.getFullYear() - lahir.getFullYear();
         let m = today.getMonth() - lahir.getMonth();

         if (m < 0 || (m === 0 && today.getDate() < lahir.getDate())) {
             umur--;
         }

         return umur + " Tahun";
     }

     function loadMemberDetail(keluargaId, noKK) {

         $("#noKKLabel").text(noKK);

         $("#memberTableBody").html(
             '<tr><td colspan="6" class="text-center">Loading...</td></tr>'
         );

         let url = "<?= base_url('index.php/keluarga/get_members/') ?>" + keluargaId;

         console.log("REQUEST URL:", url);

         $.ajax({

             url: url,
             method: "GET",

             success: function(response) {

                 console.log("RAW RESPONSE:", response);

                 let data;

                 try {
                     data = JSON.parse(response);
                 } catch (e) {

                     console.error("JSON PARSE ERROR:", response);

                     $("#memberTableBody").html(
                         '<tr><td colspan="6" class="text-danger text-center">Response bukan JSON</td></tr>'
                     );

                     return;
                 }

                 let html = "";

                 if (data.length === 0) {

                     html =
                         '<tr><td colspan="6" class="text-center">Tidak ada anggota keluarga</td></tr>';

                 } else {

                     data.forEach(function(m, i) {

                         let jk =
                             m.jenis_kelamin_id == 1 ?
                             "Laki-laki" :
                             "Perempuan";

                         let umur = hitungUmur(m.tanggal_lahir);

                         html += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${m.nik}</td>
                        <td>${m.nama}</td>
                        <td>${m.nama_hubungan ?? '-'}</td>
                        <td>${jk}</td>
                        <td>${umur}</td>
                    </tr>
                    `;
                     });

                 }

                 $("#memberTableBody").html(html);

             },

             error: function(xhr) {

                 console.error("AJAX ERROR:", xhr.responseText);

                 $("#memberTableBody").html(
                     '<tr><td colspan="6" class="text-danger text-center">Gagal mengambil data</td></tr>'
                 );

             }

         });

     }
 </script>
 <script>
     $('#btnPreview').click(function() {

         var formData = new FormData($('#formImport')[0]);

         $.ajax({
             url: "<?= base_url('warga/preview_import_ajax') ?>",
             type: "POST",
             data: formData,
             contentType: false,
             processData: false,
             success: function(response) {

                 $('#previewContainer').html(response).show();
                 $('#btnImport').show();

             }
         });

     });
 </script>

 <?php if (!empty($auto_warga)): ?>
     <script>
         document.addEventListener('DOMContentLoaded', function() {

             const data = <?= json_encode($auto_warga) ?>;

             Object.keys(data).forEach(function(key) {

                 // cari berdasarkan name dulu
                 let el = document.querySelector('[name="' + key + '"]');

                 if (!el) {
                     // fallback ke id
                     el = document.getElementById(key);
                 }

                 if (!el) return;

                 if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                     el.value = data[key];
                 }

                 if (el.tagName === 'SELECT') {
                     for (let i = 0; i < el.options.length; i++) {
                         if (el.options[i].value == data[key]) {
                             el.selectedIndex = i;
                             el.dispatchEvent(new Event('change'));
                             break;
                         }
                     }
                 }

             });

         });
     </script>
 <?php endif; ?>


 <script>
     document.addEventListener('DOMContentLoaded', function() {

         const select = document.getElementById('kode_dusun');
         const hidden = document.getElementById('banjar');

         if (!select) return;

         function sync() {
             const opt = select.options[select.selectedIndex];
             hidden.value = opt ? opt.getAttribute('data-name') : '';
         }

         sync();
         select.addEventListener('change', sync);

     });
 </script>

 <script>
     function loadRealtimeNotif() {
         fetch("<?= site_url('admin/get_notifikasi_realtime') ?>")
             .then(res => res.json())
             .then(data => {

                 let badge = document.getElementById('notifBadge');
                 let list = document.getElementById('notifList');

                 if (!badge || !list) return;

                 if (data.length > 0) {
                     badge.innerText = data.length;
                     badge.style.display = 'inline-block';
                 } else {
                     badge.style.display = 'none';
                 }

                 list.innerHTML = '';

                 data.forEach(n => {
                     list.innerHTML += `
                    <a class="dropdown-item small text-gray-700" href="${n.link}">
                        ${n.pesan}
                    </a>
                `;
                 });

                 if (data.length === 0) {
                     list.innerHTML = `
                    <span class="dropdown-item small text-muted">
                        Tidak ada notifikasi
                    </span>
                `;
                 }

             });
     }

     // 🔥 Polling tiap 5 detik
     setInterval(loadRealtimeNotif, 5000);

     // Jalankan saat pertama load
     document.addEventListener("DOMContentLoaded", loadRealtimeNotif);
 </script>

 <script>
     let lastNotifIds = [];

     function loadRealtimeNotif() {
         fetch("<?= site_url('admin/get_notifikasi_realtime') ?>")
             .then(res => res.json())
             .then(data => {

                 let badge = document.getElementById('notifBadge');
                 let list = document.getElementById('notifList');

                 if (!badge || !list) return;

                 let currentIds = data.map(n => n.id);

                 // 🔥 Cek notif baru
                 data.forEach(n => {
                     if (!lastNotifIds.includes(n.id)) {

                         // 💡 TOAST POPUP
                         Swal.fire({
                             toast: true,
                             position: 'top-end',
                             icon: 'info',
                             title: n.pesan,
                             showConfirmButton: false,
                             timer: 4000,
                             timerProgressBar: true
                         });

                     }
                 });

                 lastNotifIds = currentIds;

                 // Update badge
                 if (data.length > 0) {
                     badge.innerText = data.length;
                     badge.style.display = 'inline-block';
                 } else {
                     badge.style.display = 'none';
                 }

                 // Update dropdown
                 list.innerHTML = '';

                 data.forEach(n => {
                     list.innerHTML += `
                    <a class="dropdown-item small text-gray-700" href="${n.link}">
                        ${n.pesan}
                    </a>
                `;
                 });

                 if (data.length === 0) {
                     list.innerHTML = `
                    <span class="dropdown-item small text-muted">
                        Tidak ada notifikasi
                    </span>
                `;
                 }
             });
     }

     // Run pertama kali
     document.addEventListener("DOMContentLoaded", function() {
         loadRealtimeNotif();
     });

     // Poll tiap 5 detik
     setInterval(loadRealtimeNotif, 5000);
 </script>

 <script>
     let lastNotifId = 0;

     function cekNotifikasiRealtime() {

         fetch("<?= site_url('admin/cek_notifikasi_ajax') ?>")
             .then(res => res.json())
             .then(data => {

                 if (data.length > 0) {

                     // Badge jumlah
                     document.getElementById("notifBadge").style.display = "inline-block";
                     document.getElementById("notifBadge").innerText = data.length;

                     let listHTML = '';

                     data.forEach(n => {

                         listHTML += `
                    <a class="dropdown-item small">
                        ${n.pesan}
                    </a>
                `;

                         // 🔊 Bunyi hanya kalau notif baru
                         if (n.id > lastNotifId) {
                             document.getElementById("notifSound").play();
                             showToast(n.pesan);
                             lastNotifId = n.id;
                         }

                     });

                     document.getElementById("notifList").innerHTML = listHTML;

                 } else {

                     document.getElementById("notifBadge").style.display = "none";
                     document.getElementById("notifList").innerHTML =
                         '<div class="text-center small text-gray-500">Tidak ada notifikasi</div>';
                 }

             });

     }

     // cek setiap 5 detik
     setInterval(cekNotifikasiRealtime, 5000);
     cekNotifikasiRealtime();


     // ========================
     // 💬 TOAST POPUP
     // ========================

     function showToast(message) {

         let toast = document.createElement("div");

         toast.className = "toast-notif";
         toast.innerHTML = `
        <strong>Notifikasi Baru</strong><br>
        ${message}
    `;

         document.body.appendChild(toast);

         setTimeout(() => {
             toast.classList.add("show");
         }, 100);

         setTimeout(() => {
             toast.classList.remove("show");
             setTimeout(() => toast.remove(), 300);
         }, 5000);
     }
 </script>



 <script>
     function loadNotifikasi() {
         fetch("<?= site_url($this->session->userdata('role') . '/ajax_notifikasi') ?>")
             .then(res => res.json())
             .then(data => {

                 let html = '';
                 let unread = 0;

                 if (data.length === 0) {
                     html = '<div class="text-center small text-gray-500">Tidak ada notifikasi</div>';
                 } else {
                     data.forEach(n => {

                         if (n.status === 'belum dibaca') unread++;

                         html += `
                    <a href="#" onclick="bacaNotif(${n.id})" class="dropdown-item ${n.status === 'belum dibaca' ? 'font-weight-bold' : ''}">
                        ${n.pesan}
                        <br>
                        <small class="text-muted">${n.created_at}</small>
                    </a>
                `;
                     });
                 }

                 document.getElementById('notifList').innerHTML = html;

                 const badge = document.getElementById('notifBadge');

                 if (unread > 0) {
                     badge.style.display = '';
                     badge.innerText = unread;
                 } else {
                     badge.style.display = 'none';
                 }
             });
     }

     function bacaNotif(id) {
         fetch("<?= site_url($this->session->userdata('role') . '/ajax_baca_notif') ?>/" + id)
             .then(res => res.json())
             .then(res => {
                 if (res.success) {
                     loadNotifikasi();
                     window.location.href = res.link;
                 }
             });
     }

     // Load pertama
     loadNotifikasi();

     // Realtime tiap 5 detik
     setInterval(loadNotifikasi, 5000);
 </script>


 <script>
     $(document).ready(function() {

         // aktifkan select2
         $('#select_warga').select2({
             placeholder: "Cari Nama atau NIK",
             allowClear: true,
             width: '100%'
         });


         // ketika warga dipilih
         $('#select_warga').on('change', function() {

             var selected = $(this).find(':selected');

             $('#nama').val(selected.data('nama'));
             $('#nik').val(selected.data('nik'));
             $('#tempat_lahir').val(selected.data('tempat'));
             $('#tgl_lahir').val(selected.data('tgl'));
             $('#pekerjaan').val(selected.data('pekerjaan'));

             // isi agama
             $('#agama').val(selected.data('agama'));

             // isi jenis kelamin
             $('#jenis_kelamin').val(selected.data('jk'));

             // isi status kawin
             $('#sts_kawin').val(selected.data('status'));

         });

     });
 </script>

 </body>

 </html>