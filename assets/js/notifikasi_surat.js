let interval_notif_surat = null;

function load_notifikasi_surat() {

	$.ajax({
		url: BASE_URL + "admin/get_notifikasi_surat",
		method: "GET",
		dataType: "json",

		success: function (data) {

			console.log("DATA SURAT:", data);

			jumlah_notif_surat = parseInt(data.jumlah) || 0;
			update_badge_global();
			let htmlSurat = "";

			if (data.data && data.data.length > 0) {

				data.data.forEach(function (item) {

					let pesan = "";
					let linkTujuan = "#";
					let badgeStatus = "";

					if (USER_ROLE === "admin") {

						pesan =
							`Pengajuan surat dari ${item.nama_kadus ?? 'Kadus'} untuk ${item.nama}`;

						linkTujuan =
							BASE_URL + "admin/verifikasi_data";

						badgeStatus =
							`<span class="badge badge-warning ml-2">Menunggu</span>`;
					}

					else if (USER_ROLE === "kadus") {

						if (item.status === "disetujui") {

							pesan =
								`Surat atas nama ${item.nama} disetujui admin`;

							badgeStatus =
								`<span class="badge badge-success ml-2">Disetujui</span>`;

						} else if (item.status === "ditolak") {

							pesan =
								`Surat atas nama ${item.nama} ditolak admin`;

							badgeStatus =
								`<span class="badge badge-danger ml-2">Ditolak</span>`;

						} else {

							pesan =
								`Update surat atas nama ${item.nama}`;
						}

						linkTujuan =
							BASE_URL + "kadus/arsip";
					}

					htmlSurat += `
						<a class="dropdown-item d-flex align-items-center notif-item-surat"
						   href="${linkTujuan}"
						   data-id="${item.id}">

							<div class="w-100">

								<div class="small text-gray-500 d-flex justify-content-between">
									<span>${item.created_at}</span>
									${badgeStatus}
								</div>

								<span class="font-weight-bold">
									${pesan}
								</span>

							</div>
						</a>
					`;
				});

				if (USER_ROLE === "admin") {
					$("#dropdown_notifikasi_global").html(htmlSurat);
				} else {
					$("#notif_surat_area").html(htmlSurat);
				}

			} else {

				if (USER_ROLE === "admin") {
					$("#dropdown_notifikasi_global").html(`
						<span class="dropdown-item text-center small text-gray-500">
							Tidak ada notifikasi
						</span>
					`);
				} else {
					$("#notif_surat_area").html("");
				}
			}
		},

		error: function (xhr, status, error) {

			console.log("ERROR DATA SURAT:");
			console.log(xhr.responseText);
			console.log(error);

			jumlah_notif_surat = 0;

			if (typeof update_badge_global === "function") {
				update_badge_global();
			}

			if (USER_ROLE === "admin") {
				$("#dropdown_notifikasi_global").html(`
					<span class="dropdown-item text-center small text-gray-500">
						Gagal memuat notifikasi
					</span>
				`);
			} else {
				$("#notif_surat_area").html("");
			}
		}
	});
}


// ===============================
// ADMIN READ NOTIF SURAT
// ===============================
$(document).on("click", ".notif-item-surat", function (e) {

	e.preventDefault();

	let url = $(this).attr("href");

	if (USER_ROLE === "admin") {

		$.ajax({
			url: BASE_URL + "admin/read_notifikasi_surat_admin",
			method: "POST",

			success: function () {

				jumlah_notif_surat = 0;

				if (typeof update_badge_global === "function") {
					update_badge_global();
				}

				window.location.href = url;
			}
		});

	} else {

		window.location.href = url;
	}
});


// ===============================
// AUTO LOAD NOTIF SURAT ADMIN
// ===============================
$(document).ready(function () {

	if (USER_ROLE === "admin" || USER_ROLE === "kadus") {

		console.log("AUTO LOAD NOTIF SURAT:", USER_ROLE);

		load_notifikasi_surat();

		if (interval_notif_surat === null) {
			interval_notif_surat = setInterval(function () {
				load_notifikasi_surat();
			}, 5000);
		}
	}

});