<?php

if ( ! function_exists( 'wpst_get_type_from_video_url' ) ) {
	function wpst_get_type_from_video_url( $video_url ) {
		// Get allowed mime types.
		$allowed_mime_types = get_allowed_mime_types();
		// And add m3u8 type.
		$allowed_mime_types['m3u8'] = 'application/x-mpegURL';
		// Retrieve video type.
		$parsed_video_url = wp_parse_url( $video_url );
		$video_file_name  = explode( '/', $parsed_video_url['path'] );
		$video_file_name  = end( $video_file_name );
		$video_format     = wp_check_filetype( $video_file_name, $allowed_mime_types );
		$video_type       = $video_format['type'];
		return $video_type;
	}
}

if ( ! function_exists( 'wpst_get_video_duration' ) ) {
	function wpst_get_video_duration( $type_length = '' ) {
		global $post;
		$duration = intval( get_post_meta( $post->ID, 'duration', true ) );

		if ( $duration > 0 ) {
			if ( $duration >= 3600 ) {
				return gmdate( 'H:i:s', $duration );
			} else {
				return gmdate( 'i:s', $duration );
			}
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'wpst_get_duration_sec' ) ) {
	function wpst_get_duration_sec( $duration, $sponsor ) {
		switch ( $sponsor ) {
			case 'pornhub':
			case 'redtube':
			case 'spankwire':
			case 'tube8':
			case 'xhamster':
			case 'youporn':
				$min = explode( ':', $duration );
				$sec = explode( ':', $duration );
				return (int) $min[0] * 60 + (int) $sec[1];
			break;
			case 'xvideos':
				$duration = str_replace( array( '- ', 'h', 'min', 'sec' ), array( '', 'hours', 'minutes', 'seconds' ), $duration );
				return strtotime( $duration ) - strtotime( 'NOW' );
			break;
			default:
				return false;
		}
	}
}

if ( ! function_exists( 'wpst_get_post_views' ) ) {
	function wpst_get_post_views( $postID ) {
		$count_key = 'post_views_count';
		$count     = get_post_meta( $postID, $count_key, true );
		if ( $count == '' ) {
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, '0' );
			return '0';
		}
		return $count;
	}
}

if ( ! function_exists( ' wpst_get_human_number' ) ) {
	/**
	 * Get a human readable number from a given Number.
	 *
	 * @param int $input The number to transform to human number.
	 *
	 * @return string The human number.
	 **/
	function wpst_get_human_number( $input = 0 ) {
		$input = intval( $input );

		if ( $input >= 0 && $input < 1000 ) {
			// 1 - 999
			$get_floor = floor( $input );
			$suffix    = '';
		} elseif ( $input >= 1000 && $input < 1000000 ) {
			// 1k-999k
			$get_floor = floor( $input / 1000 );
			$suffix    = 'K';
		} elseif ( $input >= 1000000 && $input < 1000000000 ) {
			// 1m-999m
			$get_floor = floor( $input / 1000000 );
			$suffix    = 'M';
		} elseif ( $input >= 1000000000 && $input < 1000000000000 ) {
			// 1b-999b
			$get_floor = floor( $input / 1000000000 );
			$suffix    = 'B';
		} elseif ( $input >= 1000000000000 ) {
			// 1t+
			$get_floor = floor( $input / 1000000000000 );
			$suffix    = 'T';
		}
		return ! empty( $get_floor . $suffix ) ? number_format( $get_floor ) . $suffix : 0;
	}
}

// Duration in ISO 8601
if ( ! function_exists( 'wpst_iso8601_duration' ) ) {
	function wpst_iso8601_duration( $seconds ) {
		$seconds = (int) $seconds;
		$days    = floor( $seconds / 86400 );
		$seconds = $seconds % 86400;
		$hours   = floor( $seconds / 3600 );
		$seconds = $seconds % 3600;
		$minutes = floor( $seconds / 60 );
		$seconds = $seconds % 60;
		return sprintf( 'P%dDT%dH%dM%dS', $days, $hours, $minutes, $seconds );
	}
}

if ( ! function_exists( 'wpst_get_multithumbs' ) ) {
	function wpst_get_multithumbs( $post_id ) {
		global $post;
		$thumbs = null;
		if ( has_post_thumbnail() ) {
			$args       = array(
				'post_type'   => 'attachment',
				'numberposts' => -1,
				'post_status' => 'any',
				'post_parent' => $post->ID,
			);
			$thumb_size = xbox_get_field_value( 'wpst-options', 'main-thumbnail-quality', 'wpst_thumb_medium' );

			$attachments = get_attached_media( 'image' );

			if ( count( $attachments ) > 1 ) {
				foreach ( (array) $attachments as $attachment ) {
					$thumbs_array = wp_get_attachment_image_src( $attachment->ID, $thumb_size );
					$thumbs[]     = $thumbs_array[0];
				}
				sort( $thumbs );
			} else {
				$thumbs = get_post_meta( $post_id, 'thumbs', false );
			}
		} else {
			$thumbs = get_post_meta( $post_id, 'thumbs', false );
		}
		if ( is_ssl() ) {
			$thumbs = str_replace( 'http://', 'https://', $thumbs );
		}
		if ( is_array( $thumbs ) ) {
			return implode( ',', $thumbs );
		}

		return false;
	}
}

if ( ! function_exists( 'wpst_entry_footer' ) ) {
	function wpst_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			$postcats = get_the_category();
			$posttags = get_the_tags();
			if ( $postcats || $posttags ) {
				echo '<div class="tags-list">';
				if ( $postcats !== false && xbox_get_field_value( 'wpst-options', 'show-categories-video-about' ) == 'on' ) {
					foreach ( (array) $postcats as $cat ) {
						echo '<a href="' . get_category_link( $cat->term_id ) . '" class="label" title="' . $cat->name . '"><i class="fa fa-folder-open"></i>' . $cat->name . '</a> ';
					}
				}
				if ( $posttags !== false && xbox_get_field_value( 'wpst-options', 'show-tags-video-about' ) == 'on' ) {
					foreach ( (array) $posttags as $tag ) {
						echo '<a href="' . get_tag_link( $tag->term_id ) . '" class="label" title="' . $tag->name . '"><i class="fa fa-tag"></i>' . $tag->name . '</a> ';
					}
				}
				echo '</div>';
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'wpst' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}
	}
}

if ( ! function_exists( 'wpst_entry_blog_footer' ) ) {
	function wpst_entry_blog_footer() {
		// Hide category and tag text for pages.
		if ( 'blog' === get_post_type() ) {
			$blog_cats = get_the_terms( get_the_ID(), 'blog_category' );
			$blog_tags = get_the_terms( get_the_ID(), 'blog_tag' );

			if ( $blog_cats || $blog_tags ) {
				echo '<div class="tags-list">';
				foreach ( (array) $blog_cats as $blog_cat ) {
					echo '<a href="' . get_category_link( $blog_cat->term_id ) . '" class="label" title="' . $blog_cat->name . '"><i class="fa fa-folder-open"></i>' . $blog_cat->name . '</a> ';
				}
				foreach ( (array) $blog_tags as $blog_tag ) {
					echo '<a href="' . get_tag_link( $blog_tag->term_id ) . '" class="label" title="' . $blog_tag->name . '"><i class="fa fa-tag"></i>' . $blog_tag->name . '</a> ';
				}
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'wpst_get_video_preview' ) ) {
	function wpst_get_video_preview( $post_id ) {
		$post_id        = intval( $post_id );
		$trailer_url    = get_post_meta( $post_id, 'trailer_url', true );
		$trailer_format = wpst_get_type_from_video_url( $trailer_url );
		$trailer_video  = '<video width="100%" height="100%" playsinline autoplay loop muted preload="none"><source src="' . $trailer_url . '" type="' . $trailer_format . '">Your browser does not support the video tag.</video>';
		if ( $trailer_url ) {
			return $trailer_video;
		} else {
			throw new Exception( 'No trailer found for video #' . $post_id );
		}
	}
}

