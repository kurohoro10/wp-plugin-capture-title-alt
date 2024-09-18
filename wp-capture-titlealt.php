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

		$current_user = wp_get_current_user();
		$user_role = (array) $current_user->roles;

	wp_localize_script('wp-capture-script', 'wpCaptureAltTitle', array(
		'pluginUrl' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('wpCaptureAltTitle'),
		'role' => !empty($user_role) ? $user_role[0] : 'guest'
	));

}

add_action('init', 'include_wp_captureAltTitle_admin_dashboard');

function include_wp_captureAltTitle_admin_dashboard() {
	if (file_exists( plugin_dir_path(__FILE__) . 'includes/admin-dashboard.php')) {
		require_once plugin_dir_path(__FILE__) . 'includes/admin-dashboard.php';
	}
}

add_action('wp_ajax_get_post_id_by_parent', 'get_post_id_by_parent_callback');

function get_post_id_by_parent_callback() {
	global $wpdb;
	if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'wpCaptureAltTitle')) {
		wp_send_json_error('Invalid nonce');
	}

	$parent_id = isset($_GET['parent_id']) ? intval($_GET['parent_id']) : 0;
	$post_title = isset($_GET['post_title']) ? sanitize_text_field($_GET['post_title']) : '';

	if (!$parent_id) {
		wp_send_json_error('Invalid parent ID');
	}

	if (!$post_title) {
		wp_send_json_error('Invalid post title');
	}

	// $result = $wpdb->get_row($wpdb->prepare(
	// 	"SELECT ID FROM $wpdb->posts WHERE post_id = %d AND post_title = %s LIMIT 1", $parent_id, $post_title
	// ));

	// if ($result) {
	// 	wp_send_json_success(array('post_id' => $result->ID));
	// 	error_log($result);
	// } else {
	// 	error_log('No posts found for parent ID: ' . $parent_id);
	// 	wp_send_json_error('Post ID not found for the given parent ID');
	// }

	$query = new WP_Query(array(
		'p' => $parent_id,
		'post_title' => $post_title,
		'post_type' => 'any',
		'posts_per_page' => 1
	));

	if ($query->have_posts()) {
		$post_id = $query->posts[0]->ID;
		wp_send_json_success(array('post_id' => $post_id));
		return $post_id;
	} else {
		wp_send_json_error('Post ID not found for the given parent ID');
	}
}

add_action( 'wp_ajax_save_image_title_alt', 'wp_captureAltTitle_update_image_attributes' );

function wp_captureAltTitle_update_image_attributes() {
	if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wpCaptureAltTitle')) {
		error_log('Invalid nonce detected.');
		wp_send_json_error('Invalid nonce');
		return;
	}

	$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
	if (!current_user_can('edit_post', $post_id)) {
		wp_send_json_error('You do not have the permission to edit this post.');
		return;
	}

	$image_src = isset($_POST['image_src']) ? esc_url_raw($_POST['image_src']) : '';
	$title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
	$alt_text = isset($_POST['alt_text']) ? sanitize_text_field($_POST['alt_text']) : '';

	$post_content = get_post_field('post_content', $post_id);

	preg_match_all('/<img [^>]+>/', $post_content, $matches);

	if (!empty($matches[0])) {
		foreach($matches[0] as $img_tag) {
			if (strpos($img_tag, $image_src) !== false) {
				if(!preg_match('/title="([^"]*)"/', $img_tag)) {
					$new_img_tag = preg_replace('/<img/', '<img title="' . esc_attr($title) . '"', $img_tag, 1);
				} else {
					$new_img_tag = preg_replace('/title="([^"]*)"/', 'title="' . esc_attr($title) . '"', $img_tag, 1);
				}

				if (!preg_match('/alt="([^"]*)"/', $img_tag)) {
					$new_img_tag = preg_replace('/<img/', '<img alt = "' . esc_attr($alt_text) . '"', $img_tag, 1);
				} else {
					$new_img_tag = preg_replace('/alt=([^"]*)/', 'alt="' . esc_attr($alt_text) . '"', $new_img_tag, 1);
				}

				$post_content = str_replace($img_tag, $new_img_tag, $post_content);
			}
		}

		wp_update_post(array(
			'ID' =>$post_id,
			'post_content' => $post_content
		));

		wp_send_json_success('Image attributes updated successfully.');
	} else {
		wp_send_json_error('No image found in the post.');
	}
}
