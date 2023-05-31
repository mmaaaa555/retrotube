<?php
add_action( 'xbox_init', 'wpst_video_information_metabox' );
function wpst_video_information_metabox() {
	$options = array(
		'id'            => 'video-information-metabox',
		'title'         => wp_get_theme()->get( 'Name' ) . ' - ' . esc_html__( 'Video information', 'wpst' ),
		'post_types'    => array( 'post' ),
		'layout'        => 'wide', // boxed
		'skin'          => 'pink',
		'fields_prefix' => '',
		'header'        => array(),
	);

	$xbox = xbox_new_metabox( $options );
	/* Featured video */
	$xbox->add_field(
		array(
			'id'      => 'featured_video',
			'name'    => esc_html__( 'Featured video', 'wpst' ),
			'type'    => 'switcher',
			'default' => 'off',
			'desc'    => esc_html__( 'Will be displayed in the carousel on your homepage.', 'wpst' ),
		)
	);
	/* HD */
	$xbox->add_field(
		array(
			'id'      => 'hd_video',
			'name'    => esc_html__( 'HD video', 'wpst' ),
			'type'    => 'switcher',
			'default' => 'off',
			'desc'    => esc_html__( 'Will display a "HD" label over the thumb.', 'wpst' ),
		)
	);
	/* Video URL */
	$xbox->add_field(
		array(
			'id'   => 'video_url',
			'name' => esc_html__( 'Video URL', 'wpst' ),
			'type' => 'file',
			'desc' => __( 'Paste here the video URL or upload a video file (mp4, webm).', 'wpst' ),
		)
	);

	/* Video URL Resolutions */
	$xbox->open_tab_item( 'video-url-resolutions' );
		$xbox->open_mixed_field( array( 'name' => 'Resolutions' ) );
			$xbox->add_field(
				array(
					'id'   => 'video_url_240',
					'name' => __( '240p', 'wpst' ),
					'type' => 'file',
					'grid' => '4-of-8',
				)
			);
			$xbox->add_field(
				array(
					'id'   => 'video_url_360',
					'name' => __( '360p', 'wpst' ),
					'type' => 'file',
					'grid' => '4-of-8 last',
				)
			);
			$xbox->add_field(
				array(
					'id'   => 'video_url_480',
					'name' => __( '480p', 'wpst' ),
					'type' => 'file',
					'grid' => '4-of-8',
				)
			);
			$xbox->add_field(
				array(
					'id'   => 'video_url_720',
					'name' => __( '720p', 'wpst' ),
					'type' => 'file',
					'grid' => '4-of-8 last',
				)
			);
			$xbox->add_field(
				array(
					'id'   => 'video_url_1080',
					'name' => __( '1080p', 'wpst' ),
					'type' => 'file',
					'grid' => '4-of-8',
				)
			);
			$xbox->add_field(
				array(
					'id'   => 'video_url_4k',
					'name' => __( '4k', 'wpst' ),
					'type' => 'file',
					'grid' => '4-of-8 last',
				)
			);
		$xbox->close_mixed_field();
	$xbox->close_tab_item( 'video-url-resolutions' );

	/* Video embed code */
	$xbox->add_field(
		array(
			'id'   => 'embed',
			'name' => esc_html__( 'Video embed code', 'wpst' ),
			'type' => 'textarea',
			'desc' => esc_html__( 'Paste here the embed code (eg. Youtube iframe). It will automatically display the video player in the front of your site.', 'wpst' ),
		)
	);
	/* Video shortcode */
	$xbox->add_field(
		array(
			'id'   => 'shortcode',
			'name' => esc_html__( 'Video shortcode', 'wpst' ),
			'type' => 'text',
			'desc' => esc_html__( 'Paste here the video shortcode (eg. [TM plugin="https://drive.google.com/..."]). It will automatically display the video player in the front of your site.', 'wpst' ),
		)
	);

	/* Duration */
	$xbox->add_field(
		array(
			'name' => esc_html__( 'Duration', 'wpst' ),
			'id'   => 'duration',
			'type' => 'html',
		)
	);

	/* Views */
	$xbox->add_field(
		array(
			'id'         => 'post_views_count',
			'name'       => esc_html__( 'Views', 'wpst' ),
			'type'       => 'number',
			'options'    => array(
				'unit'            => 'views',
				'show_unit'       => true,
				'show_spinner'    => true,
				'disable_spinner' => false,
			),
			'attributes' => array(
				'min'       => 0,
				'step'      => 1,
				'precision' => 0,
			),
		)
	);

	/* Likes */
	$xbox->add_field(
		array(
			'id'         => 'likes_count',
			'name'       => esc_html__( 'Likes', 'wpst' ),
			'type'       => 'number',
			'options'    => array(
				'unit'            => '<i class="xbox-icon xbox-icon-thumbs-up"></i>',
				'show_unit'       => true,
				'show_spinner'    => true,
				'disable_spinner' => false,
			),
			'attributes' => array(
				'min'       => 0,
				'step'      => 1,
				'precision' => 0,
			),
		)
	);

	/* Dislikes */
	$xbox->add_field(
		array(
			'id'         => 'dislikes_count',
			'name'       => esc_html__( 'Dislikes', 'wpst' ),
			'type'       => 'number',
			'options'    => array(
				'unit'            => '<i class="xbox-icon xbox-icon-thumbs-down"></i>',
				'show_unit'       => true,
				'show_spinner'    => true,
				'disable_spinner' => false,
			),
			'attributes' => array(
				'min'       => 0,
				'step'      => 1,
				'precision' => 0,
			),
		)
	);

	/* Video trailer */
	$xbox->add_field(
		array(
			'id'      => 'trailer_url',
			'name'    => esc_html__( 'Video trailer URL', 'wpst' ),
			'type'    => 'file',
			'desc'    => esc_html__( 'Paste here the video trailer URL or upload a video file (mp4 or webm). It will be used as video preview on mouse hover.', 'wpst' ),
			'options' => array(
				'mime_types' => array( 'mp4', 'webm' ),
			),
		)
	);

	/* Main thumb */
	$xbox->add_field(
		array(
			'id'      => 'thumb',
			'name'    => esc_html__( 'Main thumbnail', 'wpst' ),
			'type'    => 'file',
			'desc'    => esc_html__( 'Paste here the main thumb URL or upload an image file. If there isn\'t a featured image, this image will be used as main thumb.', 'wpst' ),
			'options' => array(
				'mime_types'   => array( 'jpg', 'jpeg', 'png', 'gif' ), // Default: array()
				'protocols'    => array( 'http', 'https' ), // Default: array()
				'preview_size' => array(
					'width'  => '320px',
					'height' => '200px',
				), // Default: array( 'width' => '64px', 'height' => 'auto' )
			),
		)
	);

	/* Thumbnail Rotation */
	$xbox->add_field(
		array(
			'id'   => 'thumbnails',
			'name' => esc_html__( 'Thumbnails', 'wpst' ),
			'type' => 'html',
			'desc' => esc_html__( 'Used for thumbnails rotation.', 'wpst' ),
		)
	);

	/* Tracking URL */
	$xbox->add_field(
		array(
			'id'   => 'tracking_url',
			'name' => esc_html__( 'Tracking URL', 'wpst' ),
			'type' => 'text',
			'desc' => esc_html__( 'Paste here the tracking URL you want to display as link under the video in the front of your site (http://...).', 'wpst' ),
		)
	);

	/* Advertising under the video player */
	$xbox->add_field(
		array(
			'id'   => 'unique_ad_under_player',
			'name' => esc_html__( 'Advertising under the video player', 'wpst' ),
			'type' => 'textarea',
			'desc' => esc_html__( 'Paste here the code of your banner, it will be displayed under the video player.', 'wpst' ),
		)
	);
}

/*
|---------------------------------------------------------------------------------------------------
| Inserting thumbnail in Ajax
|---------------------------------------------------------------------------------------------------
*/
function xbox_ajax_insert_thumb() {
	$nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
		die( 'Busted!' );
	}

	if ( isset( $_POST['current_url'], $_POST['thumb_url'] ) ) {
		$parts = parse_url( $_POST['current_url'] );
		parse_str( $parts['query'], $query );
		$post_id   = $query['post'];
		$thumb_url = $_POST['thumb_url'];
		add_post_meta( $post_id, 'thumbs', $thumb_url, false );
		$result = true;
	} else {
		$result = false;
	}

	wp_send_json( array( 'result' => $result ) );

	wp_die();
}
add_action( 'wp_ajax_xbox_ajax_insert_thumb', 'xbox_ajax_insert_thumb' );


/*
|---------------------------------------------------------------------------------------------------
| Removing thumbnail in Ajax
|---------------------------------------------------------------------------------------------------
*/
function xbox_ajax_remove_thumb() {
	$nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
		die( 'Busted!' );
	}

	if ( isset( $_POST['current_url'], $_POST['thumb_url'] ) ) {
		$parts = parse_url( $_POST['current_url'] );
		parse_str( $parts['query'], $query );
		$post_id   = $query['post'];
		$thumb_url = $_POST['thumb_url'];
		delete_post_meta( $post_id, 'thumbs', $thumb_url );
		$result = true;
	} else {
		$result = false;
	}

	wp_send_json( array( 'result' => $result ) );

	wp_die();
}
add_action( 'wp_ajax_xbox_ajax_remove_thumb', 'xbox_ajax_remove_thumb' );
