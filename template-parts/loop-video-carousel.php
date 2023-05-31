<?php
$trailer_url    = get_post_meta( get_the_ID(), 'trailer_url', true );
$trailer_format = wpst_get_type_from_video_url( $trailer_url );
$thumb_url      = '';

$ratio_option = xbox_get_field_value( 'wpst-options', 'thumbnails-ratio', '16/9' );
$ratio_width  = intval( explode( '/', $ratio_option )[0] );
$ratio_height = intval( explode( '/', $ratio_option )[1] );
$ratio_format = floatval( $ratio_height * 100 / $ratio_width );

$thumb_width  = 320;
$thumb_height = $thumb_width * $ratio_format / 100;
$thumb_size   = 'width="' . $thumb_width . '" height="' . $thumb_height . '"';

if ( has_post_thumbnail() && wp_get_attachment_url( get_post_thumbnail_id() ) ) {
	$thumb_url = get_the_post_thumbnail_url( get_the_id(), 'video-thumb' );
} elseif ( '' !== get_post_meta( get_the_ID(), 'thumb', true ) ) {
	$thumb_url = get_post_meta( get_the_ID(), 'thumb', true );
}

$hd_video = '';
if ( 'on' === get_post_meta( get_the_ID(), 'hd_video', true ) ) {
	$hd_video = '<span class="hd-video">' . esc_html( 'HD', 'wpst' ) . '</span>';
}

/**
 * Media.
 */
$media = '<div class="post-thumbnail-container no-thumb"><span><i class="fa fa-image"></i> ' . esc_html__( 'No image', 'wpst' ) . '</span></div>';


/* Thumb. */
if ( $thumb_url ) {
	$media =
		'<div class="post-thumbnail-container">' .
			'<img ' . $thumb_size . ' src="' . $thumb_url . '" alt="' . get_the_title() . '">' .
		'</div>';
}

/* Thumbs_rotations */
if ( 'on' === xbox_get_field_value( 'wpst-options', 'enable-thumbnails-rotation' ) && wpst_get_multithumbs( get_the_ID() ) ) {
	$media =
		'<div class="post-thumbnail-container video-with-thumbs thumbs-rotation" data-thumbs="' . wpst_get_multithumbs( get_the_ID() ) . '">' .
			'<img ' . $thumb_size . ' src="' . $thumb_url . '" alt="' . get_the_title() . '">' .
		'</div>';
}

/* Trailer. */
if ( '' !== $trailer_url ) {
	$media =
		'<div class="post-thumbnail-container video-with-trailer">' .
			'<div class="video-debounce-bar"></div>' .
			'<div class="lds-dual-ring"></div>' .
			'<div class="video-preview"></div>' .
			'<img ' . $thumb_size . ' class="video-img" src="' . esc_url( $thumb_url ) . '" alt="' . get_the_title() . '">' .
		'</div>';
}
?>

<div class="slide loop-video" data-video-uid="<?php echo wp_unique_id(); ?>" data-post-id="<?php the_ID(); ?>">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<div class="post-thumbnail">
			<?php echo $media; ?>
			<?php echo $hd_video; ?>
		</div>
	</a>
</div>
