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
			<h1>WP Capture Title and alt text.</h1>
		</div>

	<?php
}
