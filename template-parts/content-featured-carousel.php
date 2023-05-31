<?php
if ( /*!is_active_sidebar( 'sidebar' ) ||*/ wp_is_mobile() && xbox_get_field_value( 'wpst-options', 'show-videos-carousel-mobile' ) == 'off' ) {
	return;
} ?>

<?php if( is_home() && xbox_get_field_value( 'wpst-options', 'show-videos-carousel' ) == 'on' ) : ?>
    <?php $the_query = new WP_Query( array(
		'posts_per_page' 	=> xbox_get_field_value( 'wpst-options', 'videos-carousel-amount' ),
		'meta_key'			=> 'featured_video',
		'meta_value'		=> 'on'
    ));?>

	<?php if ( $the_query->have_posts() ) : ?>
		<div class="featured-carousel" style="visibility: hidden">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<?php $trailer_url = get_post_meta($post->ID, 'trailer_url', true);
			$thumb_url = get_post_meta($post->ID, 'thumb', true); ?>
			<?php get_template_part( 'template-parts/loop', 'video-carousel' ); ?>


		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('.featured-carousel').bxSlider({
					slideWidth: 320,
					maxSlides: 40,
					moveSlides: 1,
					pager: false,
					<?php if(xbox_get_field_value( 'wpst-options', 'videos-carousel-show-title' ) == 'on') : ?>
						captions: true,
					<?php endif; ?>
					<?php if(xbox_get_field_value( 'wpst-options', 'videos-carousel-auto-play' ) == 'on') : ?>
						auto: true,
						pause: 2000,
						autoHover: true,
					<?php endif; ?>
					prevText: '',
					nextText: '',
					onSliderLoad: function(){
						jQuery(".featured-carousel").css("visibility", "visible");
					}
				});
			});
		</script>
	<?php endif; ?>
<?php endif; ?>
