let last_notif_id = localStorage.getItem("last_notif_id")
    ? parseInt(localStorage.getItem("last_notif_id"))
    : 0;

function load_notifikasi() {

    $.ajax({
        url: BASE_URL + "dashboard/get_notifikasi",
        method: "GET",
        dataType: "json",

        success: function(data) {

            if (data.jumlah > 0) {
                $('#notif_pengaduan').text(data.jumlah).show();
            } else {
                $('#notif_pengaduan').hide();
            }

            if ($('#alertsDropdown').attr('aria-expanded') === "true") {
                return;
            }

            let html = '';

            if (data.data.length > 0) {

                data.data.forEach(function(item) {

                    html += `
                    <a class="dropdown-item d-flex align-items-center notif-item"
                       data-id="${item.id_pengaduan}"
                       href="javascript:void(0)">
                        <div>
                            <div class="small text-gray-500">${item.created_at}</div>
                            <span class="font-weight-bold">
                                Pengaduan dari ${item.nama_pelapor}
                            </span>
                        </div>
                    </a>
                    `;

                });

            } else {

                html = `
                <span class="dropdown-item text-center small text-gray-500">
                    Tidak ada pengaduan
                </span>
                `;
            }

            html += `
            <a class="dropdown-item text-center small text-gray-500"
               href="${BASE_URL}pengaduan_kades">
               Lihat semua pengaduan
            </a>
            `;

            $('#dropdown_notifikasi').html(html);

            let max_id = parseInt(data.last_id) || 0;

            console.log("localStorage ID:", last_notif_id);
            console.log("Database last ID:", max_id);

            // cek jika ada notif baru
            if (max_id > last_notif_id) {

                console.log("Notif baru!");

                let notif_baru = data.data.find(item => item.id_pengaduan == max_id);

                if (notif_baru) {
                    tampilkan_toast(notif_baru);
                }

                last_notif_id = max_id;

                localStorage.setItem("last_notif_id", max_id);
            }

        }

    });

}


function tampilkan_toast(data) {

    let url_detail = BASE_URL + "pengaduan_kades/detail/" + data.id_pengaduan;

    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: 'Pengaduan baru dari ' + data.nama_pelapor,
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,

        didOpen: (toast) => {

            toast.style.cursor = "pointer";

            toast.addEventListener('click', function() {

                $.ajax({
                    url: BASE_URL + "dashboard/read_single_notifikasi/" + data.id_pengaduan,
                    method: "POST",
                    success: function() {

                        window.location.href = url_detail;

                    }
                });

            });

        }
    });
}


load_notifikasi();

setInterval(load_notifikasi, 5000);


$('#alertsDropdown').on('click', function() {

    $('#notif_pengaduan').hide().text(0);

    $.ajax({
        url: BASE_URL + "dashboard/read_notifikasi",
        method: "POST"
    });

});


$(document).on("click", ".notif-item", function(e) {

    e.preventDefault();

    let id = $(this).data("id");

    $.ajax({
        url: BASE_URL + "dashboard/read_single_notifikasi/" + id,
        method: "POST",
        success: function() {
            window.location.href = BASE_URL + "pengaduan_kades/detail/" + id;
        }
    });

});


$(document).on("click", 'a[href*="logout"]', function(){

    localStorage.removeItem("last_notif_id");

});