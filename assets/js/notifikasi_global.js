var jumlah_notif_kadus = 0;
var jumlah_notif_surat = 0;
var jumlah_notif_pengaduan = 0;

function update_badge_global() {

	let total = 0;

	// ===============================
	// ROLE KADUS
	// ===============================
	if (USER_ROLE === "kadus") {

		total =
			(parseInt(jumlah_notif_kadus) || 0) +
			(parseInt(jumlah_notif_surat) || 0);
	}

	// ===============================
	// ROLE ADMIN
	// ===============================
	else if (USER_ROLE === "admin") {

		total =
			(parseInt(jumlah_notif_surat) || 0);
	}

	// ===============================
	// ROLE SUPERADMIN
	// ===============================
	else if (USER_ROLE === "superadmin") {

		total =
			(parseInt(jumlah_notif_pengaduan) || 0);
	}

	console.log("TOTAL BADGE GLOBAL:", total);

	if (total > 0) {

		$(".notif_global")
			.text(total)
			.show();

	} else {

		$(".notif_global")
			.hide()
			.text(0);
	}
}