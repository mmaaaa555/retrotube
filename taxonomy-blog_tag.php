<?php
/**
 * The template for displaying blog tag pages
 *
 * @package WPST
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>
	<div id="primary" class="content-area <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>">
		<main id="main" class="site-main <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>" role="main">

		<?php if ( have_posts() ) { ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="widget-title"><i class="fa fa-folder-open"></i>', '</h1>' );
				if ( xbox_get_field_value( 'wpst-options', 'cat-desc-position' ) == 'top' ) {
					the_archive_description( '<div class="archive-description">', '</div>' ); }
				?>
			</header><!-- .page-header -->

			<div class="blog-list">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/loop', 'blog' );
				endwhile;
				?>
			</div>

			<?php
			wpst_page_navi();

		} else {

			get_template_part( 'template-parts/content', 'none' );

		}

		if ( xbox_get_field_value( 'wpst-options', 'cat-desc-position' ) == 'bottom' ) {
			the_archive_description( '<div class="archive-description">', '</div>' ); }
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
