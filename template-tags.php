<?php
/**
 * Template Name: Tags
 **/
get_header(); ?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
	<div id="primary" class="content-area <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?> categories-list">
		<main id="main" class="site-main <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>" role="main">

		<header class="entry-header">
			<?php the_title( '<h1 class="widget-title"><i class="fa fa-tags"></i>', '</h1>' ); ?>
		</header>

			<?php the_content(); ?>

			<?php
			$args = array(
				'smallest'                  => 12,
				'largest'                   => 24,
				'unit'                      => 'px',
				'number'                    => 1000,
				'format'                    => 'flat',
				'separator'                 => '',
				'orderby'                   => 'name',
				'order'                     => 'ASC',
				'exclude'                   => null,
				'include'                   => null,
				'topic_count_text_callback' => 'default_topic_count_text',
				'link'                      => 'view',
				'taxonomy'                  => 'post_tag',
				'echo'                      => true,
				'child_of'                  => null,
			);
			?>
			<?php wp_tag_cloud( $args ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

			<?php
endwhile;
endif;
get_sidebar();
get_footer();
