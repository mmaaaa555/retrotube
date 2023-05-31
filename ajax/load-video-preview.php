<?php
/**
 * Ajax function to load the preview of a video based on the video post_id.
 *
 * @package wpst\ajax
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Load a video preview iframe based on the video post_id.
 *
 * @return void
 */
function wpst_load_video_preview() {
	check_ajax_referer( 'ajax-nonce', 'nonce' );
	if ( ! isset( $_POST['post_id'] ) ) {
		wp_send_json_error( array( 'message' => 'post_id parameter is missing' ) );
	}
	try {
		wp_send_json_success( wpst_get_video_preview( intval( $_POST['post_id'] ) ) );
	} catch ( \Exception $exception ) {
		wp_send_json_error( array( 'message' => $exception->getMessage() ) );
	}
	wp_die();
}
add_action( 'wp_ajax_wpst_load_video_preview', 'wpst_load_video_preview' );
add_action( 'wp_ajax_nopriv_wpst_load_video_preview', 'wpst_load_video_preview' );

