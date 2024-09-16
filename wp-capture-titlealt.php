<?php
/**
 * Plugin Name:     WP Capture Title and Alt Plugin
 * Plugin URI:
 * Description:     Plugin that captures titles and alt text for images
 * Author:
 * Author URI:
 * Text Domain:     wp-capture-titlealt
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Wp_Capture_Titlealt
 */

// Your code starts here.
defined('ABSPATH') or die('No script kiddies please!');

add_action( 'admin_enqueue_scripts', 'wp_captureAltTitle_scripts' );

function wp_captureAltTitle_scripts() {
	wp_enqueue_style('wp-capture-admin-style', plugins_url('assets/build/admin-style.css', __FILE__));
	wp_enqueue_script('wp-capture-admin-script', plugins_url('assets/build/admin-scripts.js', __FILE__), array('jquery'), null, true);

	wp_localize_script('wp-captureAltTitle-script', 'wpCaptureAltTitle', array(
		'pluginUrl' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('wpCaptureAltTitle')
	));
}

add_action('init', 'include_wp_captureAltTitle_admin_dashboard');

function include_wp_captureAltTitle_admin_dashboard() {
	if (file_exists( plugin_dir_path(__FILE__) . 'includes/admin-dashboard.php')) {
		require_once plugin_dir_path(__FILE__) . 'includes/admin-dashboard.php';
	}
}
