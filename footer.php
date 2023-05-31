<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WPST
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer
<?php
if ( xbox_get_field_value( 'wpst-options', 'layout' ) == 'boxed' ) :
	?>
	br-bottom-10<?php endif; ?>" role="contentinfo">
	<div class="row">
		<?php if ( xbox_get_field_value( 'wpst-options', 'footer-ad-mobile' ) != '' ) : ?>
			<div class="happy-footer-mobile">
				<?php echo wpst_display_ad_or_error_message( xbox_get_field_value( 'wpst-options', 'footer-ad-mobile' ) ); ?>
			</div>
		<?php endif; ?>
		<?php if ( xbox_get_field_value( 'wpst-options', 'footer-ad-desktop' ) != '' ) : ?>
			<div class="happy-footer">
				<?php echo wpst_display_ad_or_error_message( xbox_get_field_value( 'wpst-options', 'footer-ad-desktop' ) ); ?>
			</div>
		<?php endif; ?>
		<?php if ( function_exists( 'dynamic_sidebar' ) && is_active_sidebar( 'footer' ) ) : ?>
			<div class="<?php echo xbox_get_field_value( 'wpst-options', 'footer-columns' ); ?>">
				<?php dynamic_sidebar( 'footer' ); ?>
			</div>
		<?php endif; ?>

		<div class="clear"></div>

		<?php if ( xbox_get_field_value( 'wpst-options', 'logo-footer' ) == 'on' ) : ?>
			<div class="logo-footer">
			<?php
				$image_logo_file       = xbox_get_field_value( 'wpst-options', 'image-logo-file' );
				$niche_image_logo_file = xbox_get_field_value( 'wpst-options', 'niche-image-logo-file' );
			?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php echo get_bloginfo( 'name' ); ?>"><img class="grayscale" src="
									<?php
									if ( ! empty( $image_logo_file ) ) {
										echo esc_url( $image_logo_file );
									} elseif ( ! empty( $niche_image_logo_file ) ) {
										echo esc_url( get_template_directory_uri() . $niche_image_logo_file ); }
									?>
				" alt="<?php echo get_bloginfo( 'name' ); ?>"></a>
			</div>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'wpst-footer-menu' ) ) : ?>
			<div class="footer-menu-container">
				<?php wp_nav_menu( array( 'theme_location' => 'wpst-footer-menu' ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( xbox_get_field_value( 'wpst-options', 'copyright-bar' ) == 'on' ) : ?>
			<div class="site-info">
				<?php echo xbox_get_field_value( 'wpst-options', 'copyright-text' ); ?>
			</div><!-- .site-info -->
		<?php endif; ?>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<a class="button" href="#" id="back-to-top" title="Back to top"><i class="fa fa-chevron-up"></i></a>

<?php wp_footer(); ?>

<!-- Other scripts -->
<?php
if ( ! wp_is_mobile() && xbox_get_field_value( 'wpst-options', 'other-scripts' ) != '' ) {
	echo wpst_maybe_display_html( xbox_get_field_value( 'wpst-options', 'other-scripts' ) );
}
?>

<!-- Mobile scripts -->
<?php
if ( wp_is_mobile() && xbox_get_field_value( 'wpst-options', 'mobile-scripts' ) != '' ) {
	echo wpst_maybe_display_html( xbox_get_field_value( 'wpst-options', 'mobile-scripts' ) );
}
?>

</body>
</html>
