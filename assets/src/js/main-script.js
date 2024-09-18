import '../css/main-style.css';

document.addEventListener('DOMContentLoaded', () => {
    const pluginUrl = wpCaptureAltTitle.pluginUrl;
    const nonce = wpCaptureAltTitle.nonce;
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

			el.parentElement.style.position = 'relative';
			el.parentElement.append(btn);

            btn.addEventListener('click', () => {
                captureImageTitleAlt_imgSrc = el.src;

				if (el.title) {
					captureImageTitleAlt_title = el.title;
				} else {
					captureImageTitleAlt_title = el.parentElement.previousElementSibling.textContent;
				}

				if (el.alt) {
					captureImageTitleAlt_altText = el.alt;
				} else {
					captureImageTitleAlt_altText = el.parentElement.nextElementSibling.textContent;
				}

                const article = el.closest('article');
                const postParentmatch = article.className.match(/post-(\d+)/);
                const postParentId = postParentmatch ? postParentmatch[1] : null;

                if (postParentId) {
                    fetch(`${pluginUrl}?action=get_post_id_by_parent&parent_id=${postParentId}&post_title=${captureImageTitleAlt_title}&nonce=${nonce}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const postId = data.data.post_id;
                                appendModalCaptureTitleAlt(
									captureImageTitleAlt_imgSrc,
									captureImageTitleAlt_title,
									captureImageTitleAlt_altText);
                                toggleModalCaptureTitleAlt();

                                const savebutton = document.getElementById('captureImageTitleAltBtn-save');
                                savebutton.addEventListener('click', () => {
                                    let newTitle = document.getElementById('captureTitleAlt-title').value;
                                    let newAltText = document.getElementById('captureTitleAlt-alt-text').value;
									const errMsg = document.getElementById('wpCaptureTitleAlt-capture-error-message');

									if (newAltText !== '') {
										if (newAltText.includes('::Pexels')) {
											newAltText = newAltText.replace('::Pexels', '');
											newAltText = `&lt;p&gt;${newAltText}&lt;/p&gt;::Pexels`;
										} else {
											newAltText = `&lt;p&gt;${newAltText}&lt;/p&gt;::Pexels`;
										}
									}

									savebutton.classList.add('wp-capture-title-alt-loading');
									savebutton.textContent = 'Saving...';

                                    fetch(pluginUrl, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                                        },
                                        body: new URLSearchParams({
                                            action: 'save_image_title_alt',
                                            post_id: postId,
                                            image_src: captureImageTitleAlt_imgSrc,
                                            title: newTitle,
                                            alt_text: newAltText,
                                            nonce: nonce
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
											if (!errMsg.classList.contains('hide-error-message')) errMsg.classList.add('hide-error-message');
                                            console.log('Image title and alt text updated successfully!');
											savebutton.textContent = 'Saved';
											setTimeout(() => {
												closeModalCaptureTitleAlt();
												savebutton.classList.remove('wp-capture-title-alt-loading');
												// document.location.reload();
											}, 1000)

                                        } else {
											if (errMsg.classList.contains('hide-error-message')) errMsg.classList.remove('hide-error-message');
											errMsg.textContent = 'Failed to update image title and alt text.';
                                            console.log('Failed to update image title and alt text.');
											savebutton.classList.remove('wp-capture-title-alt-loading');
                                        }
                                    })
                                    .catch(error => {
										if (errMsg.classList.contains('hide-error-message')) errMsg.classList.remove('hide-error-message');
										errMsg.textContent = 'Error: ' + error.message;
                                        console.log('Error', error.message);
                                    });
                                });
                            } else {
                                console.log('Failed to get post ID');
                            }
                        })
                        .catch(error => {
                            console.log('Error', error.message);
                        });
                } else {
                    console.log('Post ID not found');
                }
            });
        });
    }

    const appendModalCaptureTitleAlt = (imgSrc, title, altText) => {
        const existingModal = document.getElementById('captureModalTitleAlt');

        if (existingModal) {
            existingModal.remove();
        }

        const modalCaptureTitleAlt = `
            <div id="captureModalTitleAlt" class="captureModalTitleAlt" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDescription">
                <div class="modal-content">
                    <div class="close-modal">
                        <button id="closeCaptureModalTitleAlt" class="close" aria-label="Close modal">&times;</button>
                    </div>
					<div id="wpCaptureTitleAlt-capture-error-message" class="hide-error-message">
                        <p>Error.</p>
                    </div>
                    <div id="modalContent">
                        <div>
                            <img src="${imgSrc}" alt="Image preview">
                        </div>
                        <div>
                            <label for="captureTitleAlt-title">Title</label>
                            <input type="text" id="captureTitleAlt-title" name="captureTitleAlt-title" value="${title}">
                        </div>
                        <div>
                            <label for="captureTitleAlt-alt-text">Alt Text</label>
                            <textarea id="captureTitleAlt-alt-text" name="captureTitleAlt-alt-text" rows="7" cols="50">${altText}</textarea>
                        </div>
                        <div>
                            <button id="captureImageTitleAltBtn-save" class="captureImageTitleAltBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalCaptureTitleAlt);
        document.getElementById('captureTitleAlt-title').focus(); // Move focus to the first input
    };

    const toggleModalCaptureTitleAlt = () => {
        const modalCaptureTitleAlt = document.getElementById('captureModalTitleAlt');
        modalCaptureTitleAlt.style.display = 'block';
        document.addEventListener('keydown', handleModalKeyboardNavigation);
    };

    const closeModalCaptureTitleAlt = () => {
        document.getElementById('captureModalTitleAlt').style.display = 'none';
        document.removeEventListener('keydown', handleModalKeyboardNavigation);
    };

    const handleModalKeyboardNavigation = (e) => {
        if (e.key === 'Escape') {
            closeModalCaptureTitleAlt();
        }
    };

    document.addEventListener('click', (e) => {
        if (e.target.id === 'closeCaptureModalTitleAlt') {
            closeModalCaptureTitleAlt();
        }

        if (e.target.id === 'captureModalTitleAlt') {
            closeModalCaptureTitleAlt();
        }
    });
});
