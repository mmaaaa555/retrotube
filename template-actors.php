<?php
/**
 * Template Name: Actors
 **/
get_header(); ?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
	<div id="primary" class="content-area <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?> actors-list">
		<main id="main" class="site-main <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>" role="main">

		<header class="entry-header">
			<?php the_title( '<h1 class="widget-title"><i class="fa fa-star"></i>', '</h1>' ); ?>
		</header>

			<?php the_content(); ?>

		<div class="videos-list">
			<?php
			// get_query_var to get page id from url
			$page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

			// number of tags to show per-page
			$per_page = xbox_get_field_value( 'wpst-options', 'actors-per-page' );

			// count total number of terms related to passed taxonomy
			$number_of_series = count( get_terms( 'actors' ) );
			$offset           = ( $page - 1 ) * $per_page;

			$term_args = array(
				'number' => $per_page,
				'offset' => $offset,
			);
			$terms     = get_terms( 'actors', $term_args );

			if ( $terms ) {
				foreach ( $terms as $term ) {
					$args             = array(
						'post_type'      => 'post',
						'posts_per_page' => 1,
						'show_count'     => 1,
						'orderby'        => 'rand',
						'post_status'    => 'publish',
						'tax_query'      => array(
							array(
								'taxonomy' => 'actors',
								'field'    => 'slug',
								'terms'    => $term->slug,
							),
						),
					);
					$video_from_actor = new WP_Query( $args );
					if ( $video_from_actor->have_posts() ) {
						$video_from_actor->the_post();
					}
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'thumb-block' ); ?>>
						<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" title="<?php echo $term->name; ?>">
							<!-- Thumbnail -->
							<div class="post-thumbnail">
								<?php
								$thumb_url = get_post_meta( $post->ID, 'thumb', true );
								$image_id  = get_term_meta( $term->term_id, 'actors-image-id', true );
								$actor_img = wp_get_attachment_image( $image_id, 'wpst_thumb_medium' );
								if ( $actor_img ) {
									echo $actor_img;
								} elseif ( has_post_thumbnail() && wp_get_attachment_url( get_post_thumbnail_id() ) ) {
									the_post_thumbnail( 'wpst_thumb_medium', array( 'alt' => get_the_title() ) );
								} elseif ( $thumb_url != '' ) {
									echo '<img src="' . get_template_directory_uri() . '/assets/img/px.gif" data-src="' . $thumb_url . '" alt="' . get_the_title() . '">';
								} else {
									echo '<div class="no-thumb"><span><i class="fa fa-image"></i> ' . esc_html__( 'No image', 'wpst' ) . '</span></div>';
								}
								?>
								<?php if ( ! wp_is_mobile() ) : ?>
									<div class="play-icon-hover"><i class="fa fa-star-o"></i></div>
								<?php endif; ?>
							</div>

							<header class="entry-header">
								<span class="actor-title"><?php echo $term->name; ?></span>
							</header><!-- .entry-header -->
						</a>
					</article><!-- #post-## -->
					<?php
				}
				wpst_page_navi( ceil( $number_of_series / $per_page ), $per_page );
			}
			?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
			<?php
endwhile;
endif;
get_sidebar();
get_footer();
