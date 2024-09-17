import '../css/main-style.css';
document.addEventListener('DOMContentLoaded', () => {
	const images = document.querySelectorAll('.catch-img-alt-title');

	if (images) {
		images.forEach(img => {
			const parentElement = img.parentElement;
			let title = parentElement.previousElementSibling;
			let par = parentElement.nextElementSibling;
			let img_alt = parentElement.children[0].getAttribute('alt');
			let img_title = parentElement.children[0].getAttribute('title');

			while(title && (!['H1', 'H2', 'H3', 'H4', 'H5', 'H6'].includes(title.tagName) || !title.textContent.trim())){
				title.previousElementSibling;
			}

			while (par && (par.tagName !== 'P' || !par.textContent.trim())) {
				par = par.nextElementSibling;
			}

			console.log(parentElement.children[0].title);

			if (title || par) {
				img_title = img.title ? img_title + `- ${title.textContent}` : title.textContent;
				img_alt = `<p>${par.textContent}</p>::Pexels`;

				parentElement.children[0].setAttribute('title', img_title || 'Default Title');
				parentElement.children[0].setAttribute('alt', img_alt);
			}

		});
	} else {
		console.log('No images with class name of "catch-img-alt-title" has been found within the page.');
	}
});
