<?php get_header(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>">
		<main id="main" class="site-main <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>" role="main">

		<?php
		if ( xbox_get_field_value( 'wpst-options', 'homepage-title-desc-position' ) == 'top' ) {
			if ( xbox_get_field_value( 'wpst-options', 'homepage-title' ) != '' ) :
				?>
				<h1 class="widget-title"><?php echo xbox_get_field_value( 'wpst-options', 'homepage-title' ); ?></h1>
				<?php
			endif;
			if ( xbox_get_field_value( 'wpst-options', 'seo-footer-text' ) != '' ) :
				?>
				<p class="archive-description"><?php echo xbox_get_field_value( 'wpst-options', 'seo-footer-text' ); ?></p>
				<?php
			endif;
		}

		if ( have_posts() ) {

			if ( ! wp_is_mobile() && function_exists( 'dynamic_sidebar' ) && is_active_sidebar( 'homepage' ) && ! isset( $_GET['filter'] ) ) {
				dynamic_sidebar( 'Homepage' );
			} elseif ( wp_is_mobile() && xbox_get_field_value( 'wpst-options', 'disable-homepage-widgets-mobile' ) == 'off' && function_exists( 'dynamic_sidebar' ) && is_active_sidebar( 'homepage' ) && ! isset( $_GET['filter'] ) ) {
				dynamic_sidebar( 'Homepage' );
			} else {
				?>

				<header class="page-header">
					<h2 class="widget-title"><?php echo wpst_get_filter_title(); ?></h2>
					<?php get_template_part( 'template-parts/content', 'filters' ); ?>
				</header><!-- .page-header -->

				<div class="videos-list">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/loop', 'video' );
					endwhile;
					?>
				</div>

				<?php
				wpst_page_navi();
			}
		}
		?>

		<div class="clear"></div>

		<?php
		if ( xbox_get_field_value( 'wpst-options', 'homepage-title-desc-position' ) == 'bottom' ) {
			if ( xbox_get_field_value( 'wpst-options', 'homepage-title' ) != '' ) :
				?>
				<h1 class="widget-title"><?php echo xbox_get_field_value( 'wpst-options', 'homepage-title' ); ?></h1>
				<?php
			endif;
			if ( xbox_get_field_value( 'wpst-options', 'seo-footer-text' ) != '' ) :
				?>
				<p class="archive-description"><?php echo xbox_get_field_value( 'wpst-options', 'seo-footer-text' ); ?></p>
				<?php
			endif;
		}
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
