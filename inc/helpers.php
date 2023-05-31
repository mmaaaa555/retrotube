<?php
/**
 * Helpers functions
 *
 * @package WPST
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Get the class of the sidebar to display it correctly.
 *
 * @return string {"with-sidebar-right" | "with-sidebar-left" | ""}
 */
function wpst_get_sidebar_position_class() {
	if ( ! wpst_is_sidebar_shown() ) {
		return '';
	}
	if ( 'sidebar-right' === xbox_get_field_value( 'wpst-options', 'sidebar-position' ) ) {
		return 'with-sidebar-right';
	}
	return 'with-sidebar-left';
}

/**
 * Is the sidebar shown or not?
 *
 * @return bool True if yes, false if not.
 */
function wpst_is_sidebar_shown() {
	$show_sidebar = xbox_get_field_value( 'wpst-options', 'show-sidebar' );
	if ( is_home() ) {
		$show_sidebar = xbox_get_field_value( 'wpst-options', 'show-sidebar-homepage' );
	}
	if ( is_single() ) {
		$show_sidebar = xbox_get_field_value( 'wpst-options', 'show-sidebar-video-page' );
	}
	if ( is_page_template( 'template-categories.php' ) ) {
		$show_sidebar = xbox_get_field_value( 'wpst-options', 'show-sidebar-categories-page' );
	}
	return 'on' === $show_sidebar;
}

