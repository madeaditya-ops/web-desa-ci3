let last_notif_id_kadus = localStorage.getItem("last_notif_id_kadus")
	? parseInt(localStorage.getItem("last_notif_id_kadus"))
	: 0;

// gunakan variabel global dari notifikasi_global.js
jumlah_notif_kadus = 0;


function load_notifikasi_kadus() {
	$.ajax({
		url: BASE_URL + "dashboard/get_notifikasi_kadus",
		method: "GET",
		dataType: "json",

		success: function (data) {
			console.log("DATA KADUS:", data);

			jumlah_notif_kadus = parseInt(data.jumlah) || 0;
			update_badge_global();

			// ===============================
			// BADGE SIDEBAR PENGADUAN KADUS
			// ===============================
			if (jumlah_notif_kadus > 0) {
				$(".jumlah_notif_kadus")
					.text(jumlah_notif_kadus)
					.attr("style", "display:inline-block !important; font-size:12px; margin-left:6px;");
			} else {
				$(".jumlah_notif_kadus")
					.text(0)
					.attr("style", "display:none !important;");
			}

			if ($("#alertsDropdownGlobal").attr("aria-expanded") === "true") {
				return;
			}

			let html = "";

			if (data.data.length > 0) {
				data.data.forEach(function (item) {
					html += `
                    <a class="dropdown-item d-flex align-items-center notif-item-kadus"
                       data-id="${item.id_pengaduan}"
                       href="javascript:void(0)">
                        <div class="w-100">
							<div class="d-flex justify-content-between align-items-center mb-1">
								<small class="text-gray-500">
									${item.created_at}
								</small>

								<span class="badge badge-primary px-2 py-1">
									Baru
								</span>
        					</div>

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
                    Tidak ada pengaduan dan surat
                </span>
                `;
			}

		

			$("#notif_pengaduan_area").html(html);

			let max_id = parseInt(data.last_id) || 0;

			console.log("Kadus localStorage ID:", last_notif_id_kadus);
			console.log("Kadus Database last ID:", max_id);

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

$("#alertsDropdownGlobal").on("click", function () {

	// hanya role kadus yang boleh reset notif pengaduan kadus
	if (USER_ROLE !== "kadus") {
		return;
	}

	$.ajax({
		url: BASE_URL + "dashboard/read_notifikasi_kadus",
		method: "POST",
		success: function () {
		jumlah_notif_kadus = 0;
		update_badge_global();

		$(".jumlah_notif_kadus")
			.text(0)
			.attr("style", "display:none !important;");
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


// ===============================
// AUTO LOAD SEMUA NOTIF
// ===============================
$(document).ready(function () {

	console.log("JUMLAH BADGE GLOBAL:", $(".notif_global").length);
	console.log("JUMLAH DROPDOWN GLOBAL:", $("#dropdown_notifikasi_global").length);

	if ($(".notif_global").length > 0 && USER_ROLE === "kadus") {

		load_notifikasi_kadus();

		setInterval(function () {
			load_notifikasi_kadus();
		}, 5000);
	}
});