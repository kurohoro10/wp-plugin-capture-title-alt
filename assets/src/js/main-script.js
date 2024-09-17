import '../css/main-style.css';
document.addEventListener('DOMContentLoaded', () => {
	const pluginUrl = wpCaptureAltTitle.pluginUrl;
	const nonce = wpCaptureAltTitle.nonce;
	const ajaxUrl = 'admin-ajax.php';
	let userRoleforCaptureTitleAlt = wpCaptureAltTitle.role;
	let captureImageTitleAlt_title;
	let captureImageTitleAlt_altText;
	let captureImageTitleAlt_imgSrc;

	if (userRoleforCaptureTitleAlt === 'administrator') {
		const captureImgs = document.querySelectorAll('main.content img');

		captureImgs.forEach(el => {
			const btn = document.createElement('button');
			btn.classList.add('capture-image-title-alt', 'captureImageTitleAltBtn');
			btn.textContent = 'Capture Alt Title';

			el.parentElement.append(btn);

			btn.addEventListener('click', () => {
				captureImageTitleAlt_title = el.parentElement.previousElementSibling.textContent;
				captureImageTitleAlt_altText = el.parentElement.nextElementSibling.textContent;
				captureImageTitleAlt_imgSrc = el.src;

				appendModalCaptureTitleAlt(captureImageTitleAlt_imgSrc, captureImageTitleAlt_title, captureImageTitleAlt_altText);
				toggleModalCaptureTitleAlt();

				// fetch(ajaxUrl, )
			});
		});
	}

	// To append the modal to the DOM
	const appendModalCaptureTitleAlt = (imgSrc, title, altText) => {
		const exisitingModal = document.getElementById('captureModalTitleAlt');

		if (exisitingModal) {
			exisitingModal.remove();
		}

		const modalCaptureTitleAlt = `
			<div id="captureModalTitleAlt" class="captureModalTitleAlt">
				<div class="modal-content">
					<div class="close-modal">
						<span id="closeCaptureModalTitleAlt" class="close">&times;</span>
					</div>
					<div id="modalContent">
						<div>
							<img src="${imgSrc}" alt="Default text">
						</div>
						<div>
							<label for="captureTitleAlt-title">Title</label>
							<input type="text" id="captureTitleAlt-title" name="captureTitleAlt-title" value = "${title}">
						</div>
						<div >
							<label for="captureTitleAlt-alt-text">Alt Text</label>
							<textarea id="captureTitleAlt-alt-text" name="captureTitleAlt-alt-text" rows="7" cols="50">
							${altText}
							</textarea>
						</div>
						<div>
							<button class="captureImageTitleAltBtn">Save</button>
						</div>
					</div>
				</div>
			</div>
		`;

		document.body.insertAdjacentHTML('beforeend', modalCaptureTitleAlt);
	};

	// To display the modal on button click
	const toggleModalCaptureTitleAlt = () => {
		const modalCaptureTitleAlt = document.getElementById('captureModalTitleAlt');
		modalCaptureTitleAlt.style.display = 'block';
	};

	// Function to close the modal
	const closeModalCaptureTitleAlt = () => {
		document.getElementById('captureModalTitleAlt').style.display = 'none';
	};

	// To close the modal when clicked the close button or the overlay
	document.addEventListener('click', (e) => {
		if (e.target.id === 'closeCaptureModalTitleAlt') {
			closeModalCaptureTitleAlt();
		}

		if (e.target.id === 'captureModalTitleAlt') {
			closeModalCaptureTitleAlt();
		}
	});

});
