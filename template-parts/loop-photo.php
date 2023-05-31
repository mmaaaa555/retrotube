<?php

$photos_list  = get_post_gallery_images( $post->ID );
$photos_count = count( $photos_list );

$ratio_option = xbox_get_field_value( 'wpst-options', 'thumbnails-ratio', '16/9' );
$ratio_width  = intval( explode( '/', $ratio_option )[0] );
$ratio_height = intval( explode( '/', $ratio_option )[1] );
$ratio_format = floatval( $ratio_height * 100 / $ratio_width );

$thumb_width  = 320;
$thumb_height = $thumb_width * $ratio_format / 100;
$thumb_size   = 'width="' . $thumb_width . '" height="' . $thumb_height . '"';

$photo_url = '';
if ( '' !== get_the_post_thumbnail() ) {
	$photo_url = get_the_post_thumbnail_url( $post->ID, xbox_get_field_value( 'wpst-options', 'main-thumbnail-quality' ) );
} elseif ( get_post_gallery() && $photos_count > 0 ) {
	$photo_url = $photos_list[1];
}


if ( 0 === $photos_count ) {
	$photos_count = 1;
}?>

<article id="post-<?php the_ID(); ?>"
<?php
if ( xbox_get_field_value( 'wpst-options', 'videos-per-row-mobile' ) == '1' ) {
	post_class( 'thumb-block full-width' );
} else {
	post_class( 'thumb-block' ); }
?>
>
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<!-- Thumbnail -->
		<div class="post-thumbnail">
			<?php if ( '' !== $photo_url ) : ?>
				<div class="post-thumbnail-container">
					<img <?php echo $thumb_size; ?> src="<?php echo esc_url( $photo_url ); ?>" />
				</div>
			<?php else : ?>
				<div class="photos-thumb no-thumb"><span><i class="fa fa-image"></i> <?php esc_html_e( 'No image', 'wpst' ); ?></span></div>
			<?php endif; ?>

			<div class="photos-count">
				<i class="fa fa-camera"></i> <?php echo intval( $photos_count ); ?>
			</div>
		</div>
		<header class="entry-header">
			<span><?php the_title(); ?></span>
		</header><!-- .entry-header -->
	</a>
</article><!-- #post-## -->
