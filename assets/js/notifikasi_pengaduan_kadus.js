let last_notif_id_kadus = localStorage.getItem("last_notif_id_kadus")
	? parseInt(localStorage.getItem("last_notif_id_kadus"))
	: 0;

function load_notifikasi_kadus() {
	$.ajax({
		url: BASE_URL + "dashboard/get_notifikasi_kadus",
		method: "GET",
		dataType: "json",

		success: function (data) {
             console.log("DATA KADUS:", data);

			// Badge jumlah notif
			if (data.jumlah > 0) {
				$(".notif_pengaduan_kadus").text(data.jumlah).show();
			} else {
				$(".notif_pengaduan_kadus").hide();
			}

			// Kalau dropdown lagi dibuka → tidak reload isi
			if ($("#alertsDropdownKadus").attr("aria-expanded") === "true") {
				return;
			}

			let html = "";

			if (data.data.length > 0) {
				data.data.forEach(function (item) {
					html += `
                    <a class="dropdown-item d-flex align-items-center notif-item-kadus"
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
               href="${BASE_URL}PengaduanAdmin">
               Lihat semua pengaduan
            </a>
            `;

			$("#dropdown_notifikasi_kadus").html(html);

			let max_id = parseInt(data.last_id) || 0;

			console.log("Kadus localStorage ID:", last_notif_id_kadus);
			console.log("Kadus Database last ID:", max_id);

			// Deteksi notif baru
			if (max_id > last_notif_id_kadus) {
				console.log("Notif baru untuk Kadus!");

				let notif_baru = data.data.find(
					(item) => item.id_pengaduan == max_id
				);

				if (notif_baru) {
					tampilkan_toast_kadus(notif_baru);
				}

				last_notif_id_kadus = max_id;
				localStorage.setItem("last_notif_id_kadus", max_id);
			}
		},
	});
}


function tampilkan_toast_kadus(data) {
	let url_detail = BASE_URL + "PengaduanAdmin/detail/" + data.id_pengaduan;

	Swal.fire({
		toast: true,
		position: "top-end",
		icon: "info",
		title: "Pengaduan baru dari " + data.nama_pelapor,
		showConfirmButton: false,
		timer: 4000,
		timerProgressBar: true,

		didOpen: (toast) => {
			toast.style.cursor = "pointer";

			toast.addEventListener("click", function () {
				$.ajax({
					url:
						BASE_URL +
						"dashboard/read_single_notifikasi_kadus/" +
						data.id_pengaduan,
					method: "POST",
					success: function () {
						window.location.href = url_detail;
					},
				});
			});
		},
	});
}


if ($(".notif_pengaduan_kadus").length > 0) {
	load_notifikasi_kadus();
	setInterval(load_notifikasi_kadus, 5000);
}



$("#alertsDropdownKadus").on("click", function () {
	$.ajax({
		url: BASE_URL + "dashboard/read_notifikasi_kadus",
		method: "POST",
		success: function () {
			$(".notif_pengaduan_kadus")
				.hide()
				.text(0);
		}
	});
});

$(document).on("click", ".notif-item-kadus", function (e) {
	e.preventDefault();

	let id = $(this).data("id");

	$.ajax({
		url: BASE_URL + "dashboard/read_single_notifikasi_kadus/" + id,
		method: "POST",
		success: function () {
			window.location.href = BASE_URL + "PengaduanAdmin/detail/" + id;
		},
	});
});


$(document).on("click", 'a[href*="logout"]', function () {
	localStorage.removeItem("last_notif_id_kadus");
});