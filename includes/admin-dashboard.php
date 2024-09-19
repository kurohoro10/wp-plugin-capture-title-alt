<?php

defined('ABSPATH') or die ('No script kiddies please!');

add_action( 'admin_menu', 'add_wp_captureAltTitle_menu' );

function add_wp_captureAltTitle_menu() {
	add_menu_page(
		'WP Capture Image Title and Alt text',
		'WP Capture',
		'manage_options',
		'wp-capture-image-alt-title',
		'wp_captureAltTitle_page',
		'dashicons-admin-generic',
		26
	);
}

function wp_captureAltTitle_page() {
	if (!current_user_can('manage_options')) {
		wp_die(__('You dont have sufficient permission to access this page.'));
	}

	?>
		<div class="wp-capture-alt-title-wrapper">
			<h1>How to Use the WP Capture Title Alt Plugin on Your Website</h1>
			<p>This guide will explain how to use the wpCaptureAltTitle plugin, which helps you capture and edit image "Alt Titles" on your website, even if you are not familiar with programming.</p>
			<h2>What is the wpCaptureAltTitle Plugin?</h2>
			<p>The wpCaptureAltTitle plugin is a tool that allows administrators of a WordPress website to easily capture the title and alt text of images and make quick edits through a button interface. The plugin works by adding a button to each image in your posts or pages that, when clicked, opens a window (called a modal) where you can view and update the image’s information.</p>
			<h3>Key Features:</h3>
			<ul>
				<li>* Capture image title: You can capture an image's title and alt text with a click.</li>
				<li>* Easy editing: The plugin provides an interface for editing image titles and alt text directly on the webpage.</li>
				<li>* No technical skills required: All actions are done through buttons and forms, so no coding knowledge is necessary.</li>
			</ul>
			<h2>How to Use the Plugin</h2>
			<h3>1. Logging In</h3>
			<p>Make sure you are logged into your WordPress website as an administrator. The plugin only works for users with administrator privileges.</p>
			<h3>2. Locate Images on Your Site</h3>
			<ul>
				<li>* Navigate to any post or page on your WordPress site.</li>
				<li>* Scroll down to find images within the content. The plugin automatically adds a "Capture Alt Title" button to each image.</li>
			</ul>
			<h3>3. Capturing Image Title and Alt Text</h3>
			<ul>
				<li>* You will see a "Capture Alt Title" button below each image.</li>
				<li>* Click on this button to open a popup window that displays the image’s title, alt text and alt text extension.</li>
			</ul>
			<h3>4. Editing the Image Information</h3>
			<ul>
				<li>
					<p>Once the popup opens, you will see the following:</p>
					<ul>
						<li>* Image Preview: A small preview of the image.</li>
						<li>* Title Field: A text box that shows the current image title. You can edit this field if you want to change the title.</li>
						<li>* Alt Text Field: A larger box that displays the alt text (the description used by screen readers or shown when the image cannot load). You can also update this.</li>
						<li>* Extension: This field allows you to add extra details to the alt text.</li>
					</ul>
				</li>
			</ul>
			<h3>5. Saving Your Changes</h3>
			<ul>
				<li>* After editing the title or alt text, click the "Save" button at the bottom of the popup.</li>
				<li>* If the update is successful, you’ll see a confirmation message and the modal will close after a few moments.</li>
			</ul>
			<h3>6. Closing the Popup</h3>
			<ul>
				<li>* If you don’t want to save your changes, click the "X" in the upper right corner of the popup or press the Escape key on your keyboard to close the window.</li>
			</ul>
			<h2>Common Issues</h2>
			<ul>
				<li>* Not seeing the "Capture Alt Title" button? Make sure you are logged in as an administrator.</li>
				<li>* Error messages while saving: If there’s an error, an error message will appear in the popup window. You can try again or contact your website admin if the problem persists.</li>
				<li>* Extension not saving when I edited it in the alt text field: Extension in the alt text field is read only so it's not going to save the extension even if you save the alt text. You can use the dedicated field for the extension if you want to save the extension you added.</li>
				<li>* Do I manually need to add the heading and paragraph?: You do not need to manually add headings and paragraph just clear the fields then save and reload the page, once you open the popup again you will see that it's populated with the nearest title and paragraph then just hit save to save the the title and alt text together with the extension.</li>
				<li>* Extension is not saving when I clear the alt text field and hit the save button : Extension will only be saved if there is alt text so it cannot be added when there is none.</li>
			</ul>
			<p>This plugin makes it easy to manage your website’s image details without needing to dig into the backend or code. Just log in, click the button, and edit your image details.</p>
		</div>

	<?php
}
