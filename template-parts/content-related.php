<div class="under-video-block">
	<?php if ( is_active_sidebar( 'under_video' ) && is_single() ) :
		dynamic_sidebar( 'under_video' ); ?>
	<?php else : ?>
		<?php
		$related = get_posts(
			array(
				'category__in' => wp_get_post_categories( $post->ID ),
				'numberposts'  => xbox_get_field_value( 'wpst-options', 'related-videos-number' ),
				'post__not_in' => array( $post->ID ),
				'orderby'      => 'rand',
			)
		);
		?>
		<?php if ( $related ) : ?>
			<h2 class="widget-title"><?php esc_html_e( 'Related videos', 'wpst' ); ?></h2>

			<div>
			<?php
			if ( $related ) {
				foreach ( $related as $post ) {
					setup_postdata( $post );
					get_template_part( 'template-parts/loop', 'video' );
				}
			}
			?>
			</div>
			<?php
			wp_reset_postdata();

			$category = get_the_category( $post->ID );
			?>
			<div class="clear"></div>
			<div class="show-more-related">
				<a class="button large" href="<?php echo get_category_link( $category[0]->term_id ); ?>"><?php esc_html_e( 'Show more related videos', 'wpst' ); ?></a>
			</div>
			<?php endif; ?>
		
	<?php endif; ?>
</div>
<div class="clear"></div>
