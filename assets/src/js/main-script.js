import '../css/main-style.css';
document.addEventListener('DOMContentLoaded', () => {
	const images = document.querySelectorAll('.catch-img-alt-title');

	images.forEach(img => {
		const parentElement = img.parentElement;

		console.log(parentElement.previousElementSibling);
		console.log(parentElement);
		console.log(parentElement.nextElementSibling);


	});
});
