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

add_action( 'wp_enqueue_scripts', 'wp_captureAltTitle_scripts' );

function wp_captureAltTitle_scripts() {
	wp_enqueue_style('wp-capture-style', plugins_url('assets/build/main-style.css', __FILE__));
	wp_enqueue_script('wp-capture-script', plugins_url('assets/build/main-scripts.js', __FILE__), array('jquery'), null, true);

	wp_localize_script('wp-capture-script', 'wpCaptureAltTitle', array(
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

// add_action( 'init', 'fetch_all_published_posts' );

// function fetch_all_published_posts() {
// 	$args = array(
// 		'post_type' => 'post',
// 		'post_status' => 'publish',
// 		'posts_per_page' => -1,
// 		'ignore_sticky_posts' => true
// 	);

// 	$results = new WP_Query($args);

// 	if ($results->have_posts()) {
// 		$results->the_posts();

// 		$post = $results->post;

// 		$id = $post->ID;
// 		$title = $post->post_title;
// 		$content = $post->post_content;

// 		print_r([
// 			$id . '<br>',
// 			$title . '<br>',
// 			$content
// 		]);
// 	}
// }
