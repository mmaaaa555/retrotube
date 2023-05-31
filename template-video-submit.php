<?php
/* Template Name: Submit a Video */

if ( ! is_user_logged_in() ) {
	wp_safe_redirect( home_url() );
	exit;
}
get_header();
$wpst_video_submitter = new WPST_Video_Submitter();
?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
	<div id="primary" class="content-area <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?> video-submit-area">
		<main id="main" class="site-main <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>" role="main">
			<header class="entry-header">
				<?php the_title( '<h1 class="widget-title"><i class="fa fa-user"></i>', '</h1>' ); ?>
			</header>
			<?php echo $wpst_video_submitter->render_form(); ?>
		</main>
	</div>
			<?php
endwhile;
endif;
get_sidebar();
get_footer();
