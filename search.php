<?php get_header(); ?>
	<section id="primary" class="content-area <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>">
		<main id="main" class="site-main <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>" role="main">
		<?php
		if ( have_posts() ) :
			?>
			<header class="page-header">
				<h1 class="widget-title"><?php printf( __( 'Search results for: %s', 'wpst' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php get_template_part( 'template-parts/content', 'filters' ); ?>
			</header><!-- .page-header -->

			<div>
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/loop', get_post_format() ? : 'video' );
				endwhile;
				?>
			</div>
			<?php wpst_page_navi(); ?>

		<?php else : ?>

			<h1 class="widget-title"><?php esc_html_e( 'Nothing found', 'wpst' ); ?></h1>

			<p><?php esc_html_e( 'It looks like nothing was found for this search. Maybe try one of the links below or a new search?', 'wpst' ); ?></p>

			<?php get_search_form(); ?>

			<div class="notfound-videos">
				<h2 class="widget-title"><?php esc_html_e( 'Random videos' ); ?></h2>
				<div>
				<?php
				$args       = array(
					'numberposts' => xbox_get_field_value( 'wpst-options', 'videos-per-page' ),
					'orderby'     => 'rand',
				);
				$rand_posts = get_posts( $args );
				foreach ( $rand_posts as $post ) {
					get_template_part( 'template-parts/loop', 'video' );
				}
				?>
				</div>
			</div>
			<?php endif; ?>
		</main><!-- #main -->
	</section><!-- #primary -->
<?php
get_sidebar();
get_footer();
