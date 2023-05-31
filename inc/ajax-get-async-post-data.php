<?php
function wpst_get_async_post_data() {
	check_ajax_referer( 'ajax-nonce', 'nonce' );
	if ( ! isset( $_POST['post_id'] ) ) {
		wp_send_json_error( array( 'message' => 'post_id parameter is missing' ) );
	}
	$post_id = intval( $_POST['post_id'] );

	$response = array();

	if ( 'off' !== xbox_get_field_value( 'wpst-options', 'enable-views-system' ) ) {
		$views = (int) wpst_get_post_views( $post_id ) + 1;
		update_post_meta( $post_id, 'post_views_count', $views );
		$response['views'] = wpst_get_human_number( $views );
	}
	if ( 'off' !== xbox_get_field_value( 'wpst-options', 'enable-rating-system' ) ) {
		$response['likes']    = wpst_get_human_number( intval( get_post_meta( $post_id, 'likes_count', true ) ) );
		$response['dislikes'] = wpst_get_human_number( intval( get_post_meta( $post_id, 'dislikes_count', true ) ) );
		$response['rating']   = wpst_get_post_like_rate( $post_id );
	}
	wp_send_json_success( $response );
	wp_die();
}

add_action( 'wp_ajax_nopriv_get-post-data', 'wpst_get_async_post_data' );
add_action( 'wp_ajax_get-post-data', 'wpst_get_async_post_data' );
