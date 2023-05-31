<?php if ( ! function_exists( 'wpst_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function wpst_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'wpst' ),
			$time_string
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

function wpst_set_posts_per_page_for_towns_cpt( $query ) {
	if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'blog' ) ) {
	  $query->set( 'posts_per_page', xbox_get_field_value( 'wpst-options', 'blog-posts-per-page' ) );
	}
}
add_action( 'pre_get_posts', 'wpst_set_posts_per_page_for_towns_cpt' );
