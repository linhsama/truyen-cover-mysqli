// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

var toast = new Toasty({
	progressBar: true,
	sounds: {
		info: "/truyen-cover/assets/vendor/toasty/dist/sounds/info/2.mp3",
		success: "/truyen-cover/assets/vendor/toasty/dist/sounds/success/2.mp3",
		warning: "/truyen-cover/assets/vendor/toasty/dist/sounds/warning/2.mp3",
		error: "/truyen-cover/assets/vendor/toasty/dist/sounds/error/3.mp3",
	},
	enableSounds: true
});


