<?php

/**
 * Function to manage pages navigation.
 *
 * @param string  $pages
 * @param integer $range
 * @return void
 */
function wpst_page_navi( $pages = '', $range = 4 ) {
	if ( '' === $pages ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}
	$pages = intval( $pages );
	if ( $pages > 1 ) {
		global $paged;
		$local_paged = intval( $paged );
		if ( empty( $local_paged ) ) {
			$local_paged = 1;
		}
		$range     = intval( $range );
		$showitems = ( $range * 2 ) + 1;
		$output    = '<div class="pagination">';
		$output   .= '<ul>';
		if ( $local_paged > 2 && $local_paged > $range + 1 && $showitems < $pages ) {
			$output .= '<li><a href="' . get_pagenum_link( 1 ) . '">' . esc_html__( 'First', 'wpst' ) . '</a></li>';
		}
		if ( $local_paged > 1 && $showitems < $pages ) {
			$output .= '<li><a href="' . get_pagenum_link( $local_paged - 1 ) . '">' . esc_html__( 'Previous', 'wpst' ) . '</a></li>';
		}
		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( 1 !== $pages && ( ! ( $i >= $local_paged + $range + 1 || $i <= $local_paged - $range - 1 ) || $pages <= $showitems ) ) {
				if ( $local_paged === $i ) {
					$output .= '<li><a class="current">' . $i . '</a></li>';
				} else {
					$output .= '<li><a href="' . get_pagenum_link( $i ) . '" class="inactive">' . $i . '</a></li>';
				}
			}
		}
		if ( $local_paged < $pages && $showitems < $pages ) {
			$output .= '<li><a href="' . get_pagenum_link( $local_paged + 1 ) . '">' . esc_html__( 'Next', 'wpst' ) . '</a></li>';
		}
		if ( $local_paged < $pages - 1 && $local_paged + $range - 1 < $pages && $showitems < $pages ) {
			$output .= "<li><a href='" . get_pagenum_link( $pages ) . "'>" . esc_html__( 'Last', 'wpst' ) . '</a></li>';
		}
		$output .= '</ul></div>';

		echo wp_kses( $output, wp_kses_allowed_html( 'post' ) );
	}
}

/**
 * Return page number with a given separator string.
 *
 * @param string $separator The separator character to be displayed.
 * @return void echo page number if success, return false if not
 */
function wpst_page_number( $separator = '' ) {
	global $paged;
	if ( (int) $local_paged > 1 ) {
		echo $separator . 'page ' . intval( $local_paged );
	} else {
		return false;
	}
}
