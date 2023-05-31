<?php
function wpst_post_like() {
	$nonce = $_POST['nonce'];

	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
		die( 'Busted!' );
	}

	if ( isset( $_POST['post_like'] ) ) {
		$ip        = $_SERVER['REMOTE_ADDR'];
		$post_id   = $_POST['post_id'];
		$post_like = $_POST['post_like'];

		$meta_likes_count    = intval( get_post_meta( $post_id, 'likes_count', true ) );
		$meta_dislikes_count = intval( get_post_meta( $post_id, 'dislikes_count', true ) );
		$meta_total_count    = $meta_likes_count + $meta_dislikes_count;

		$voted_IPs = get_post_meta( $post_id, 'voted_IP' );
		if ( ! is_array( $voted_IPs ) ) {
			$voted_IPs = array();
		}

		if ( ! wpst_has_already_voted( $post_id ) ) {
			$voted_IPs[ $ip ] = time();
			update_post_meta( $post_id, 'voted_IP', $voted_IPs );

			if ( $post_like == 'like' ) {
				update_post_meta( $post_id, 'likes_count', ++$meta_likes_count );
			} else {
				update_post_meta( $post_id, 'dislikes_count', ++$meta_dislikes_count );
			}

			update_post_meta( $post_id, 'rate', round( wpst_get_post_like_rate( $post_id ) ) );

			$alreadyrate = false;

			$percentage  = ceil( ( $meta_likes_count / ( $meta_total_count + 1 ) ) * 100 );
			$button      = esc_html__( 'Thank you!', 'wpst' );
			$nbrates     = $meta_total_count + 1;
			$progressbar = ceil( ( $meta_likes_count / ( $meta_total_count + 1 ) ) * 100 );
		} else {
			$alreadyrate = true;
		}
		$json_arr = array(
			'alreadyrate' => $alreadyrate,
			'percentage'  => (int) $percentage,
			'button'      => $button,
			'nbrates'     => (int) $nbrates,
			'likes'       => (int) $meta_likes_count,
			'dislikes'    => (int) $meta_dislikes_count,
			'progressbar' => (int) $progressbar,
		);
		wp_send_json( $json_arr );
		wp_die();
	} else {
		return false;
	}
	wp_die();
}

add_action( 'wp_ajax_nopriv_post-like', 'wpst_post_like' );
add_action( 'wp_ajax_post-like', 'wpst_post_like' );
