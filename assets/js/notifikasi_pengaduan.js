let shown_notifs = JSON.parse(
	localStorage.getItem("shown_notifs")
) || [];


// Load notifikasi
function load_notifikasi() {

	$.ajax({
		url: BASE_URL + "dashboard/get_notifikasi",
		method: "GET",
		dataType: "json",

		success: function (data) {

			// Badge jumlah notifikasi
			if (data.jumlah > 0) {

				$(".notif_pengaduan")
					.text(data.jumlah)
					.show();

			} else {

				$(".notif_pengaduan")
					.hide();
			}

			// Jika dropdown sedang dibuka jangan refresh isi dropdown
			if (
				$("#alertsDropdown")
					.attr("aria-expanded") === "true"
			) {
				return;
			}

			let html = "";

			if (data.data.length > 0) {

				data.data.forEach(function (item) {

					let pesan = "";
					let badge = "";

					// Pengaduan baru
					if (
						item.status &&
						item.status.toLowerCase() == "pending"
					) {

						pesan =
							`Pengaduan baru dari ${item.nama_pelapor}`;

					}

					// Pengaduan selesai
					else if (
						item.status &&
						item.status.toLowerCase() == "selesai"
					) {

						pesan =
							`Pengaduan diselesaikan oleh ${item.nama_kadus}`;

					}

					else {
						return;
					}

					html += `
						<a class="dropdown-item d-flex align-items-center notif-item"
						   data-id="${item.id_pengaduan}"
						   href="javascript:void(0)">

							<div class="w-100">

								<div class="small text-gray-500 d-flex justify-content-between">

									<span>${item.created_at}</span>

									${badge}

								</div>

								<span class="font-weight-bold">
									${pesan}
								</span>

							</div>

						</a>
					`;
				});

			} else {

				html = `
					<span class="dropdown-item text-center small text-gray-500">
						Tidak ada notifikasi
					</span>
				`;
			}

			html += `
				<a class="dropdown-item text-center small text-gray-500"
				   href="${BASE_URL}PengaduanAdmin">
					Lihat semua pengaduan
				</a>
			`;

			$("#dropdown_notifikasi").html(html);

			// Ambil notif terbaru per status
			let latest_pending = null;
			let latest_selesai = null;

			data.data.forEach(function (notif) {

				// Notif pending terbaru
				if (
					notif.status &&
					notif.status.toLowerCase() == "pending" &&
					!latest_pending
				) {

					latest_pending = notif;
				}

				// Notif selesai terbaru
				if (
					notif.status &&
					notif.status.toLowerCase() == "selesai" &&
					!latest_selesai
				) {

					latest_selesai = notif;
				}
			});

			// List notif yang akan ditampilkan
			let notif_to_show = [];

			if (latest_pending) {
				notif_to_show.push(latest_pending);
			}

			if (latest_selesai) {
				notif_to_show.push(latest_selesai);
			}

			// Tampilkan toast satu per satu
			notif_to_show.forEach(function (notif, index) {

				let notif_key =
					notif.id_pengaduan +
					"_" +
					notif.status;

				// Jika belum pernah tampil
				if (!shown_notifs.includes(notif_key)) {

					setTimeout(() => {

						tampilkan_toast(notif);

					}, index * 3000);

					shown_notifs.push(notif_key);
				}
			});

			localStorage.setItem(
				"shown_notifs",
				JSON.stringify(shown_notifs)
			);
		},

		error: function (xhr, status, error) {

			console.log("Error load notifikasi:");
			console.log(xhr.responseText);
			console.log(error);
		}
	});
}


// Toast notifikasi
function tampilkan_toast(data) {

	let url_detail =
		BASE_URL +
		"PengaduanAdmin/detail/" +
		data.id_pengaduan;

	let title = "";
	let icon = "info";

	// Pengaduan baru
	if (
		data.status &&
		data.status.toLowerCase() == "pending"
	) {

		title =
			"Pengaduan baru dari " +
			data.nama_pelapor;

		icon = "info";
	}

	// Pengaduan selesai
	else if (
		data.status &&
		data.status.toLowerCase() == "selesai"
	) {

		title =
			"Pengaduan diselesaikan oleh " +
			data.nama_kadus;

		icon = "success";
	}

	Swal.fire({
		toast: true,
		position: "top-end",
		icon: icon,
		title: title,
		showConfirmButton: false,
		timer: 4000,
		timerProgressBar: true,

		didOpen: (toast) => {

			toast.style.cursor = "pointer";

			toast.addEventListener("click", function () {

				$.ajax({
					url:
						BASE_URL +
						"dashboard/read_single_notifikasi/" +
						data.id_pengaduan,

					method: "POST",

					success: function () {

						window.location.href =
							url_detail;
					},
				});
			});
		},
	});
}


load_notifikasi();

setInterval(load_notifikasi, 5000);


$("#alertsDropdown").on("click", function () {

	$(".notif_pengaduan")
		.hide()
		.text(0);

	$.ajax({
		url: BASE_URL + "dashboard/read_notifikasi",
		method: "POST",
	});
});


$(document).on(
	"click",
	".notif-item",

	function (e) {

		e.preventDefault();

		let id = $(this).data("id");

		$.ajax({

			url:
				BASE_URL +
				"dashboard/read_single_notifikasi/" +
				id,

			method: "POST",

			success: function () {

				window.location.href =
					BASE_URL +
					"PengaduanAdmin/detail/" +
					id;
			},
		});
	}
);


// Logout
$(document).on(
	"click",
	'a[href*="logout"]',

	function () {

		localStorage.removeItem(
			"shown_notifs"
		);
	}
);