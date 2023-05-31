<?php
/**
 * The template for displaying actors pages
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
					the_archive_title( '<h1 class="widget-title"><i class="fa fa-star"></i>', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div>
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Format-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Format name) and that will be used instead.
					*/
					get_template_part( 'template-parts/loop', get_post_format() ? : 'video' );

				endwhile;
				?>
			</div>

			<?php
			wpst_page_navi();

		} else {

			get_template_part( 'template-parts/content', 'none' );

		}
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
