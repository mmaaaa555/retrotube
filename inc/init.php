<?php

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( ! is_plugin_active( 'wp-script-core/wp-script-core.php' ) ) {
	$message = __( 'This Theme needs WP-Script Core to be installed and activated.', 'wpst' );
	wpst_display_error_page( $message );
}

if ( WPSCORE()->get_product_status( 'RTT' ) !== 'connected' ) {
	$message = __( 'Please purchase a RetroTube plan - https://www.wp-script.com/adult-wordpress-themes/retrotube/', 'wpst' );
	wpst_display_error_page( $message );
}

/**
 * Display an error page.
 *
 * @param string $message The message to display on the error page.
 *
 * @return void.
 */
function wpst_display_error_page( $message ) { ?>
	<p><?php echo esc_html( $message ); ?></p>
	<style type="text/css">
		body{
			background-color: #222;
			text-align: center;
			color:#eee;
			padding-top:150px;
			font-family: 'arial';
			font-size:16px;
		}
		p{
			text-align: center;
		}
		a{
			color:#f0476d;
		}
	</style>
	<?php
	die();
}

