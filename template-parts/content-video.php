<?php
// Autoplay.
if ( xbox_get_field_value( 'wpst-options', 'autoplay-video-player' ) == 'on' ) {
	$autoplay = 'autoplay';
} else {
	$autoplay = '';
}
// Thumbnail.
$thumb = get_post_meta( $post->ID, 'thumb', true );
if ( has_post_thumbnail() && wp_get_attachment_url( get_post_thumbnail_id() ) ) {
	$thumb_id  = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src( $thumb_id, 'wpst_thumb_large', true );
	$poster    = $thumb_url[0];
} else {
	$poster = $thumb;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
	<header class="entry-header">

		<?php get_template_part( 'template-parts/content', 'video-player' ); ?>

		<?php if ( get_post_meta( $post->ID, 'unique_ad_under_player', true ) != '' ) : ?>
			<div class="happy-under-player">
				<?php echo get_post_meta( $post->ID, 'unique_ad_under_player', true ); ?>
			</div>
		<?php elseif ( xbox_get_field_value( 'wpst-options', 'under-player-ad-desktop' ) != '' ) : ?>
			<div class="happy-under-player">
				<?php echo wpst_display_ad_or_error_message( xbox_get_field_value( 'wpst-options', 'under-player-ad-desktop' ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( xbox_get_field_value( 'wpst-options', 'under-player-ad-mobile' ) != '' ) : ?>
			<div class="happy-under-player-mobile">
				<?php echo wpst_display_ad_or_error_message( xbox_get_field_value( 'wpst-options', 'under-player-ad-mobile' ) ); ?>
			</div>
		<?php endif; ?>

		<?php
		if ( xbox_get_field_value( 'wpst-options', 'tracking-button-link' ) != '' ) {
			$tracking_url = xbox_get_field_value( 'wpst-options', 'tracking-button-link' );
		} else {
			$tracking_url = get_post_meta( $post->ID, 'tracking_url', true );
		}
		if ( $tracking_url != '' && xbox_get_field_value( 'wpst-options', 'display-tracking-button' ) == 'on' ) :
			?>
			<a class="button" id="tracking-url" href="<?php echo $tracking_url; ?>" title="<?php the_title(); ?>" target="_blank"><i class="fa fa-<?php echo xbox_get_field_value( 'wpst-options', 'tracking-button-icon' ); ?>"></i> 
																 <?php
																	if ( xbox_get_field_value( 'wpst-options', 'tracking-button-text' ) == '' ) :
																		?>
																		<?php esc_html_e( 'Download complete video now!', 'wpst' ); ?>
																		<?php
else :
	?>
				<?php echo xbox_get_field_value( 'wpst-options', 'tracking-button-text' ); ?><?php endif; ?></a>
		<?php endif; ?>

		<div class="title-block box-shadow">
			<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
			<?php if ( xbox_get_field_value( 'wpst-options', 'enable-rating-system' ) == 'on' ) : ?>
				<div id="rating">
					<span id="video-rate"><?php echo wpst_get_post_like_link( get_the_ID() ); ?></span>
					<?php $is_rated_yet = wpst_get_post_like_rate( get_the_ID() ) === false ? ' not-rated-yet' : ''; ?>
				</div>
			<?php endif; ?>
			<div id="video-tabs" class="tabs">
				<button class="tab-link active about" data-tab-id="video-about"><i class="fa fa-info-circle"></i> <?php esc_html_e( 'About', 'wpst' ); ?></button>
				<?php if ( xbox_get_field_value( 'wpst-options', 'enable-video-share' ) == 'on' ) : ?>
					<button class="tab-link share" data-tab-id="video-share"><i class="fa fa-share"></i> <?php esc_html_e( 'Share', 'wpst' ); ?></button>
				<?php endif; ?>
			</div>
		</div>

		<div class="clear"></div>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( xbox_get_field_value( 'wpst-options', 'enable-views-system' ) == 'on' || xbox_get_field_value( 'wpst-options', 'enable-rating-system' ) == 'on' ) : ?>
			<div id="rating-col">
				<?php
				if ( xbox_get_field_value( 'wpst-options', 'enable-views-system' ) == 'on' ) :
					?>
					<div id="video-views"><span>0</span> <?php esc_html_e( 'views', 'wpst' ); ?></div><?php endif; ?>
				<?php if ( xbox_get_field_value( 'wpst-options', 'enable-rating-system' ) == 'on' ) : ?>
					<div class="rating-bar">
						<div class="rating-bar-meter"></div>
					</div>
					<div class="rating-result">
							<div class="percentage">0%</div>
						<div class="likes">
							<i class="fa fa-thumbs-up"></i> <span class="likes_count">0</span>
							<i class="fa fa-thumbs-down fa-flip-horizontal"></i> <span class="dislikes_count">0</span>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="tab-content">
			<?php
				$width = xbox_get_field_value( 'wpst-options', 'enable-views-system' ) == 'off' && xbox_get_field_value( 'wpst-options', 'enable-rating-system' ) == 'off' ? '100' : '70';
			?>
			<div id="video-about" class="width<?php echo $width; ?>">
					<div class="video-description">
						<?php if ( xbox_get_field_value( 'wpst-options', 'show-description-video-about' ) == 'on' ) : ?>
							<div class="desc 
							<?php
							if ( xbox_get_field_value( 'wpst-options', 'truncate-description' ) == 'on' ) :
								?>
								more<?php endif; ?>">
								<?php the_content(); ?>
							</div>
						<?php endif; ?>
					</div>
				<?php if ( xbox_get_field_value( 'wpst-options', 'show-author-video-about' ) == 'on' ) : ?>
					<div id="video-author">
						<i class="fa fa-user"></i> <?php esc_html_e( 'From', 'wpst' ); ?>: <?php the_author_posts_link(); ?>
					</div>
				<?php endif; ?>
				<?php if ( xbox_get_field_value( 'wpst-options', 'show-publish-date-video-about' ) == 'on' ) : ?>
					<div id="video-date">
						<i class="fa fa-calendar"></i> <?php esc_html_e( 'Date', 'wpst' ); ?>: <?php the_time( 'F j, Y' ); ?>
					</div>
				<?php endif; ?>
				<?php $actors = wp_get_post_terms( $post->ID, 'actors' ); ?>
				<?php if ( xbox_get_field_value( 'wpst-options', 'show-actors-video-about' ) == 'on' && ! empty( $actors ) ) : ?>
					<div id="video-actors">
						<i class="fa fa-star"></i> <?php echo xbox_get_field_value( 'wpst-options', 'actors-video-label' ); ?>:
						<?php
						foreach ( $actors as $actor ) {
							$actor_list[] = '<a href="' . get_term_link( $actor->term_id ) . '" title="' . $actor->name . '">' . $actor->name . '</a>';
						} echo implode( ' / ', $actor_list );
						?>
					</div>
				<?php endif; ?>
				<?php if ( xbox_get_field_value( 'wpst-options', 'show-categories-video-about' ) == 'on' || xbox_get_field_value( 'wpst-options', 'show-tags-video-about' ) == 'on' ) : ?>
					<div class="tags">
						<?php wpst_entry_footer(); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( xbox_get_field_value( 'wpst-options', 'enable-video-share' ) == 'on' ) : ?>
				<?php get_template_part( 'template-parts/content', 'share-buttons' ); ?>
			<?php endif; ?>
		</div>
	</div><!-- .entry-content -->

	<?php
	if ( xbox_get_field_value( 'wpst-options', 'display-related-videos' ) == 'on' ) :
		get_template_part( 'template-parts/content', 'related' );
	endif;
	?>

	<?php
	// If comments are open or we have at least one comment, load up the comment template.
	if ( xbox_get_field_value( 'wpst-options', 'enable-comments' ) == 'on' ) {
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	}
	?>

</article><!-- #post-## -->
