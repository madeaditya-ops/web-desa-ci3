 </div>
 <!-- End of Main Content -->

 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy; Website Resmi Pemerintah Desa Blahbatuh</span>
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
	const BASE_URL = "<?= base_url(); ?>";
	const USER_ROLE = "<?= $this->session->userdata('role'); ?>";
</script>

<script src="<?= base_url('assets/js/notifikasi_global.js'); ?>"></script>
<script src="<?= base_url('assets/js/notifikasi_surat.js'); ?>"></script>

 <script>
     // Panggil plugin DataTables saat dokumen siap
     $(document).ready(function() {
         $('#dataTable').DataTable(); // #dataTable adalah ID dari tabel Anda
     });
 </script>

<script>
$(document).off('click', '.swal-confirm');

$(document).on('click', '.swal-confirm', function(e) {

    e.preventDefault();

    let url   = $(this).attr('href');
    let title = $(this).data('title') || 'Yakin?';
    let text  = $(this).data('text') || 'Aksi ini akan diproses.';
    let icon  = $(this).data('icon') || 'warning';
    let confirmText = $(this).data('confirm') || 'Ya';

    Swal.fire({
        title: title,
        text: text,
        icon: icon,

        showCancelButton: true,

        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',

        confirmButtonText: confirmText,
        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed){

            window.location.href = url;

        }

    });

});
</script>

<script>
$(document).ready(function(){

    $('.btn-setujui').click(function(){

        let url = $(this).data('url');

        Swal.fire({

            title: 'Setujui Surat?',

            text: 'Data surat akan diproses.',

            icon: 'question',

            showCancelButton: true,

            confirmButtonColor: '#28a745',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Ya, Setujui',

            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                window.location.href = url;

            }

        });

    });

});
</script>

<script>
$(document).ready(function(){

    $('.btn-hapus').click(function(){

        let url = $(this).data('url');

        Swal.fire({

            title: 'Hapus Pengajuan?',

            text: "Data yang dihapus tidak bisa dikembalikan.",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Ya, Hapus!',

            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                window.location.href = url;

            }

        });

    });

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
    $(document).on('click', '.btn-detail', function(e) {
    e.preventDefault();

    const id = $(this).data('id');

    if (!id) {
        alert("ID tidak ditemukan");
        return;
    }

    $('#detailContent').html(`
        <tr>
            <td colspan="2" class="text-center text-muted">Memuat data...</td>
        </tr>
    `);

    $('#btnSetujui').attr('href', '<?= site_url('admin/edit_surat/') ?>' + id);
    $('#btnTolak').attr('href', '<?= site_url('admin/tolak/') ?>' + id);

    $('#modalDetail').modal({
        backdrop: 'static',
        keyboard: false
    });

    $.getJSON('<?= site_url('admin/detail_verifikasi/') ?>' + id)
        .done(function(res) {

            if (Object.keys(res).length === 0) {
                $('#detailContent').html(`
                    <tr>
                        <td colspan="2" class="text-center text-muted">
                            Data tidak ditemukan
                        </td>
                    </tr>
                `);
                return;
            }

            let html = '';
            Object.keys(res).forEach(key => {
                if (key === 'id') return;

                html += `
                    <tr>
                        <th width="30%">${key.replace(/_/g,' ')}</th>
                        <td>${res[key] ? res[key] : '-'}</td>
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
let lastNotifCount = 0;

function refreshNotifications() {
    const role = "<?= $this->session->userdata('role') ?>";
    const badge = document.getElementById("notifBadge");
    const list = document.getElementById("notifList");

    if (!badge || !list) return;

    let targetUrl = "";
    
    // PEMISAHAN JALUR DATA URL
    if (role === 'admin') {
        targetUrl = "<?= site_url('admin/get_notif_admin_realtime') ?>";
    } else if (role === 'kadus') {
        targetUrl = "<?= site_url('kadus/get_notif_kadus_realtime') ?>";
    } else {
        badge.style.display = "none";
        return;
    }

    fetch(targetUrl)
        .then(res => res.json())
        .then(data => {
            // Update Badge
            if (data.jumlah > 0) {
                badge.style.display = "inline-block";
                badge.innerText = data.jumlah;
            } else {
                badge.style.display = "none";
            }

            // Update List Dropdown
            let html = "";
            if (data.list && data.list.length > 0) {
                data.list.forEach(item => {
                    let content = "";
                    let iconBg = "bg-primary";
                    let link = (role === 'admin') ? "<?= site_url('admin/verifikasi_data') ?>" : "<?= site_url('kadus/arsip') ?>";

                    if (role === 'admin') {
                        content = `<strong>${item.nama}</strong><br><small>Banjar: ${item.banjar}</small><br>
                        <small>Kadus: ${item.dibuat_oleh}</small>`;
                    } else if (role === 'kadus') {
                        if (item.status === 'disetujui') {
                            content = `Surat <strong>${item.nama}</strong> <span class="text-success">DISETUJUI</span><br><small>Silakan Ke Kantor Ambil Surat</small>`;
                            iconBg = "bg-success";
                        } else {
                            content = `Surat <strong>${item.nama}</strong> <span class="text-danger">DITOLAK</span><br><small class="text-danger">Alasan: ${item.alasan_tolak || '-'}</small>`;
                            iconBg = "bg-danger";
                        }
                    }

                    html += `
                        <a class="dropdown-item d-flex align-items-center" href="${link}">
                            <div class="mr-3">
                                <div class="icon-circle ${iconBg}">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">${item.created_at}</div>
                                <span>${content}</span>
                            </div>
                        </a>`;
                });
            } else {
                html = '<div class="text-center small py-3 text-gray-500">Tidak ada pemberitahuan baru</div>';
            }
            list.innerHTML = html;
        })
        .catch(err => console.log("Notif Error: ", err));
}


// Hanya jalankan satu interval ini saja
setInterval(refreshNotifications, 1000);
document.addEventListener("DOMContentLoaded", refreshNotifications);
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

 
 <script>
$(document).ready(function () {

    $('#select_warga_admin').select2({
        placeholder: "Cari Nama atau NIK",
        allowClear: true,
        width: '100%'
    });

    $('#select_warga_admin').on('change', function () {

        let selected = $(this).find(':selected');

        function setVal(ids, value) {
            if (!value) return;

            ids.forEach(id => {
                let el = $('#' + id);
                if (el.length) {
                    el.val(value).trigger('change');
                }
            });
        }

        // =========================
        // DATA UTAMA
        // =========================
        setVal(['nama'], selected.data('nama'));
        setVal(['nik', 'nomor_nik', 'no_ktp'], selected.data('nik'));
        setVal(['tempat_lahir'], selected.data('tempat'));
        setVal(['tanggal_lahir', 'tgl_lahir'], selected.data('tgl'));
        setVal(['pekerjaan'], selected.data('pekerjaan'));
        setVal(['agama'], selected.data('agama'));
        setVal(['jenis_kelamin', 'jk', 'gender'], selected.data('jk'));
        setVal(['status_perkawinan', 'status', 'sts_kawin'], selected.data('status'));

        // =========================
        // 🔥 BANJAR (pakai id_dusun)
        // =========================
        let idDusun   = selected.data('id_dusun');
        let namaBanjar = selected.data('banjar');
        let kodeBanjar = selected.data('kode');

        // set dropdown kode banjar (value = kode_dusun)
        if (kodeBanjar) {
            $('#kode_banjar').val(kodeBanjar).trigger('change');
        }

        // set hidden banjar
        if (namaBanjar) {
            $('#banjar').val(namaBanjar);
        }

    });

});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll(".btn-setujui");

    buttons.forEach(btn => {
        btn.addEventListener("click", function(e) {
            e.preventDefault();

            let url = this.getAttribute("href");

            Swal.fire({
                title: "Yakin?",
                text: "Data akan disetujui!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Setujui!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
});
</script>

    <!-- Notifikasi pengaduan -->
  <?php if($this->session->userdata('role') == 'superadmin'): ?>
     <script>
     var BASE_URL = "<?= base_url(); ?>";
     </script>

     <script src="<?= base_url('assets/js/notifikasi_pengaduan.js')?>"></script>
 <?php endif; ?> 
 
 <?php if($this->session->userdata('role') == 'kadus'): ?>
    <script>
    var BASE_URL = "<?= base_url(); ?>";
    </script>

    <script src="<?= base_url('assets/js/notifikasi_pengaduan_kadus.js')?>"></script>
<?php endif; ?> 


 </body>

 </html>