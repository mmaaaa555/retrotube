<?php /*
Template Name: Full Width
*/
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'page' );
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				}
			}
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
