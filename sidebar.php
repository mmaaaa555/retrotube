<?php
if ( wp_is_mobile() && 'off' === xbox_get_field_value( 'wpst-options', 'show-sidebar-mobile' ) ) {
	return;
} ?>

<?php if ( wpst_is_sidebar_shown() ) : ?>
	<aside id="sidebar" class="widget-area <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>" role="complementary">
		<?php if ( wp_is_mobile() && xbox_get_field_value( 'wpst-options', 'sidebar-ad-mobile' ) != '' ) : ?>
			<div class="happy-sidebar">
				<?php echo wpst_display_ad_or_error_message( xbox_get_field_value( 'wpst-options', 'sidebar-ad-mobile' ) ); ?>
			</div>
		<?php elseif ( xbox_get_field_value( 'wpst-options', 'sidebar-ad-desktop' ) != '' ) : ?>
			<div class="happy-sidebar">
				<?php echo wpst_display_ad_or_error_message( xbox_get_field_value( 'wpst-options', 'sidebar-ad-desktop' ) ); ?>
			</div>
		<?php endif; ?>
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</aside><!-- #sidebar -->
<?php endif; ?>
