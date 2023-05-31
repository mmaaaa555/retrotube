<?php
/**
 * The template for displaying archive blog pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
					the_archive_title( '<h1 class="widget-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/loop', 'blog' );
			endwhile;

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
