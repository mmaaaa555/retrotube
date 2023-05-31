<article class="blog-article" id="post-<?php the_ID(); ?>">	
	<div class="col-1">
		<?php if ( get_the_post_thumbnail() != '' ) {				
			//the_post_thumbnail('wpst_thumb_medium', array( 'alt' => get_the_title() ));
			if( wp_is_mobile() ){
				echo '<a href="' . get_the_permalink() . '" title="' .  get_the_title() . '"><img src="' . get_the_post_thumbnail_url($post->ID, 'wpst_thumb_medium') . '" alt="' . get_the_title() . '">';
			}else{
				echo '<a href="' . get_the_permalink() . '" title="' .  get_the_title() . '"><img data-src="' . get_the_post_thumbnail_url($post->ID, 'wpst_thumb_medium') . '" alt="' . get_the_title() . '" src="' . get_template_directory_uri() . '/assets/img/px.gif"></a>';
			}
		} ?>
	</div>
	<div class="col-2">
		<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<?php echo apply_filters( 'the_content', wp_trim_words( strip_tags( $post->post_content ), 35 ) ); ?>
		<div class="entry-meta">
			<?php wpst_posted_on();	?> <?php esc_html_e('in', 'wpst'); ?> <?php echo get_the_term_list( $post->ID, 'blog_category', '', ', ' ); ?>
		</div><!-- .entry-meta -->
    </div>
</article><!-- #post-## -->