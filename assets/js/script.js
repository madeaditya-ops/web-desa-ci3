//slider otomatis
const myCarousel = document.querySelector("#carouselExampleIndicators");
const carousel = new bootstrap.Carousel(myCarousel, {
	interval: 5000,
	ride: "carousel",
});

// close modal
document.addEventListener("click", function (e) {
	document.querySelectorAll(".modal.show").forEach((modal) => {
		const modalContent = modal.querySelector(".modal-content");
		if (!modalContent.contains(e.target)) {
			const bsModal = bootstrap.Modal.getInstance(modal);
			bsModal.hide();
		}
	});
});
