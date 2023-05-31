<?php
/**
 * Template Name: Categories
 **/
get_header(); ?>
	<div id="primary" class="content-area <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?> categories-list">
		<main id="main" class="site-main <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>" role="main">

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<header class="entry-header">
					<?php the_title( '<h1 class="widget-title"><i class="fa fa-folder"></i>', '</h1>' ); ?>
				</header>
				<?php the_content(); ?>
			<?php endwhile; ?>
		<?php endif; ?>

		<div class="videos-list">
			<?php
			// get_query_var to get page id from url.
			$page = ( get_query_var( 'paged' ) ) ? (int) get_query_var( 'paged' ) : 1;

			// number of categories to show per-page.
			$per_page = xbox_get_field_value( 'wpst-options', 'categories-per-page' ) ? (int) xbox_get_field_value( 'wpst-options', 'categories-per-page' ) : 20;

			// category thumb quality
			$catThumbQuality = xbox_get_field_value( 'wpst-options', 'categories-thumbnail-quality' );

			// count total number of terms related to passed taxonomy.
			$categories       = get_terms( 'category' );
			$number_of_series = is_array( $categories ) ? count( $categories ) : 0;
			$offset           = ( $page - 1 ) * $per_page;

			$terms = get_terms(
				array(
					'taxonomy'   => 'category',
					'hide_empty' => true,
					'number'     => $per_page,
					'offset'     => $offset,
				)
			);

			$count = is_array( $terms ) ? count( $terms ) : 0;

			if ( $count > 0 ) :

				foreach ( $terms as $term ) {

					$args = array(
						'post_type'      => 'post',
						'posts_per_page' => 1,
						'show_count'     => 1,
						'orderby'        => 'rand',
						'post_status'    => 'publish',
						'tax_query'      => array(
							array(
								'taxonomy' => 'category',
								'field'    => 'slug',
								'terms'    => $term->slug,
							),
						),
					);

					$video_from_category = new WP_Query( $args );

					if ( $video_from_category->have_posts() ) {
						$video_from_category->the_post();
					}
					$term->slug;
					$term->name;
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'thumb-block' ); ?>>
						<a href="<?php echo get_category_link( get_cat_ID( $term->name ) ); ?>" title="<?php echo $term->name; ?>">
							<!-- Thumbnail -->
							<div class="post-thumbnail">
								<?php
								$thumb_url = get_post_meta( $post->ID, 'thumb', true );
								$image_id  = get_term_meta( $term->term_id, 'category-image-id', true );
								$cat_image = wp_get_attachment_image( $image_id, $catThumbQuality );
								if ( $cat_image ) {
									echo $cat_image;
								} elseif ( has_post_thumbnail() && wp_get_attachment_url( get_post_thumbnail_id() ) ) {
									the_post_thumbnail( $catThumbQuality, array( 'alt' => get_the_title() ) );
								} elseif ( $thumb_url != '' ) {
									echo '<img src="' . $thumb_url . '" alt="' . get_the_title() . '">';
								} else {
									echo '<div class="no-thumb"><span><i class="fa fa-image"></i> ' . esc_html__( 'No image', 'wpst' ) . '</span></div>';
								}
								?>
							</div>

							<header class="entry-header">
								<span class="cat-title"><?php echo $term->name; ?></span>
							</header><!-- .entry-header -->
						</a>
					</article><!-- #post-## -->

					<?php
				}

				wpst_page_navi( ceil( (int) $number_of_series / (int) $per_page ), $per_page );

			endif;
			?>
		</div>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
