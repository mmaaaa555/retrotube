<?php // BREADCRUMB START ////
function wpst_breadcrumbs() {

	$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = '<i class="fa fa-caret-right"></i>'; // delimiter between crumbs
	$home        = 'Home'; // text for the 'Home' link
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$before      = '<span class="current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb

	global $post;
	$homeLink = get_bloginfo( 'url' );

	if ( is_home() || is_front_page() ) {

		if ( $showOnHome == 1 ) {
			echo '<div class="breadcrumbs-area"><div id="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
		}
	} else {

		echo '<div class="breadcrumbs-area"><div class="row"><div id="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a><span class="separator">' . $delimiter . '</span>';

		if ( is_category() ) {
			$thisCat = get_category( get_query_var( 'cat' ), false );
			if ( $thisCat->parent != 0 ) {
				echo get_category_parents( $thisCat->parent, true, '<span class="separator">' . $delimiter . '</span>' );
			}
			echo $before . 'Category: ' . single_cat_title( '', false ) . $after;

		} elseif ( is_search() ) {
			echo $before . 'Search results for "' . get_search_query() . '"' . $after;

		} elseif ( is_day() ) {
			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a><span class="separator">' . $delimiter . '</span>';
			echo '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a><span class="separator">' . $delimiter . '</span>';
			echo $before . get_the_time( 'd' ) . $after;

		} elseif ( is_month() ) {
			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a><span class="separator">' . $delimiter . '</span>';
			echo $before . get_the_time( 'F' ) . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time( 'Y' ) . $after;

		} elseif ( is_single() && ! is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object( get_post_type() );
				$slug      = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
				if ( $showCurrent == 1 ) {
					echo '<span class="separator">' . $delimiter . '</span>' . $before . get_the_title() . $after;
				}
			} else {
				  $cat  = get_the_category();
				$cat    = $cat[0];
				  $cats = get_category_parents( $cat, true, '<span class="separator">' . $delimiter . '</span>' );
				if ( $showCurrent == 0 ) {
					$cats = preg_replace( "#^(.+)\s$delimiter\s$#", '$1', $cats );
				}
				echo $cats;
				if ( $showCurrent == 1 ) {
					echo $before . get_the_title() . $after;
				}
			}
		} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( null !== $post_type ) {
				echo $before . $post_type->labels->singular_name . $after;
			}
		} elseif ( is_attachment() ) {
			$parent = get_post( $post->post_parent );
			$cat    = get_the_category( $parent->ID );
			if ( isset( $cat[0] ) ) {
				$cat = $cat[0];
				echo get_category_parents( $cat, true, '<span class="separator">' . $delimiter . '</span>' );
				echo '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>';
				if ( $showCurrent == 1 ) {
					echo '<span class="separator">' . $delimiter . '</span>' . $before . get_the_title() . $after;
				}
			}
		} elseif ( is_page() && ! $post->post_parent ) {
			if ( $showCurrent == 1 ) {
				echo $before . get_the_title() . $after;
			}
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id   = $post->post_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
				  $page          = get_page( $parent_id );
				  $breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
				  $parent_id     = $page->post_parent;
			}
			$breadcrumbs = array_reverse( $breadcrumbs );
			for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo $breadcrumbs[ $i ];
				if ( $i != count( $breadcrumbs ) - 1 ) {
					echo '<span class="separator">' . $delimiter . '</span>';
				}
			}
			if ( $showCurrent == 1 ) {
				echo '<span class="separator">' . $delimiter . '</span>' . $before . get_the_title() . $after;
			}
		} elseif ( is_tag() ) {
			echo $before . 'Tag: ' . single_tag_title( '', false ) . $after;

		} elseif ( is_tax( 'actors' ) ) {
			echo $before . 'Actor: ' . single_tag_title( '', false ) . $after;

		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );
			echo $before . 'Author: ' . $userdata->display_name . $after;

		} elseif ( is_404() ) {
			echo $before . 'Error 404' . $after;
		}

		if ( get_query_var( 'paged' ) ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
				echo ' (';
			}
			echo __( 'Page' ) . ' ' . get_query_var( 'paged' );
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
				echo ')';
			}
		}

		echo '</div></div></div>';

	}
} // end the_breadcrumb()

// BREADCRUMB END ////
