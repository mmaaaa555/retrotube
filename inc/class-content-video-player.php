<?php

if ( ! class_exists( 'WPST_Content_Video_Player' ) ) {
	/**
	 * Class to manage and render the video player in video page.
	 */
	class WPST_Content_Video_Player {
		/**
		 * The id of the post to work with.
		 *
		 * @var mixed $post_id
		 */
		private $post_id;

		/**
		 * Class constructor.
		 *
		 * @param mixed $post_id The post id to get the content video player for.
		 */
		public function __construct( $post_id ) {
			$this->post_id = $post_id;
		}

		/**
		 * Construct the video player to put in the content of the video page.
		 *
		 * @return string The HTML video player code for the current instance post id.
		 */
		public function get_content_video_player() {
			$output  = $this->generate_seo_meta_tags();
			$output .= $this->maybe_generate_videos_and_iframes_tags();
			return $output;
		}

		/**
		 * Get all the video meta tags for SEO.
		 *
		 * @return string All the meta tags for SEO.
		 */
		private function generate_seo_meta_tags() {
			$output  = '<meta itemprop="author" content="' . $this->get_author_name() . '" />';
			$output .= '<meta itemprop="name" content="' . $this->get_title() . '" />';
			$output .= '<meta itemprop="description" content="' . $this->get_title() . '" />';
			if ( $this->get_description_without_html() ) {
				$output .= '<meta itemprop="description" content="' . $this->get_description_without_html() . '" />';
			}
			$output .= '<meta itemprop="duration" content="' . wpst_iso8601_duration( $this->get_duration() ) . '" />';
			if ( $this->maybe_get_poster_url() ) {
				$output .= '<meta itemprop="thumbnailUrl" content="' . $this->maybe_get_poster_url() . '" />';
			}
			if ( $this->maybe_get_video_url() ) {
				$output .= '<meta itemprop="contentURL" content="' . $this->maybe_get_video_url() . '" />';
			}
			if ( $this->maybe_get_embed_code() ) {
				$output .= '<meta itemprop="embedURL" content="' . $this->get_embed_url_from_embed_code( $this->maybe_get_embed_code() ) . '" />';
			}
			$output .= '<meta itemprop="uploadDate" content="' . $this->get_date() . '" />';
			return $output;
		}

		/**
		 * Maybe generate one or more <video> or <iframe> tags depending on what data is present in the post.
		 * This fuction returns any video data in order they appear in the admin dashboard.
		 * 1. All <video> and <iframe> tags detected in the description.
		 * 2. Or <video> from `Video Url` option.
		 * 3. Or <video> from `Resolutions` options.
		 * 4. Or <iframe> from `Video embed code` option.
		 * 5. Or <video> or <iframe> from `Video shortcode` option.
		 *
		 * @return string Empty string if not <video> or <iframe> tag can be generated, else one or more <video> or <iframe> tags.
		 */
		private function maybe_generate_videos_and_iframes_tags() {
			// 1. <video> and <iframe> tags detected in the description.
			$videos_and_iframes_tags_from_content = $this->maybe_generate_videos_and_iframes_tags_from_description();
			if ( $videos_and_iframes_tags_from_content ) {
				return implode(
					'<br>',
					array_map(
						function( $video_or_iframe_tag ) {
							return $this->generate_responsive_player_tag( $video_or_iframe_tag );
						},
						$videos_and_iframes_tags_from_content
					)
				);
			}

			// 2. <video> from `Video Url` option.
			if ( $this->maybe_get_video_url() ) {
				return $this->generate_responsive_player_tag( $this->maybe_generate_video_or_iframe_tag_from_video_url() );
			}

			// 3. <video> from `Resolutions` options.
			if ( $this->maybe_get_video_resolutions_urls() ) {
				return $this->generate_responsive_player_tag( $this->maybe_generate_video_tag_from_video_resolutions_urls() );
			}

			// 4. <iframe> from `Video embed code` option.
			if ( $this->maybe_get_embed_code() ) {
				return $this->generate_responsive_player_tag( $this->maybe_get_embed_code() );
			}

			// 5. <video> or <iframe> from `Video shortcode` option.
			if ( $this->maybe_get_shortcode() ) {
				return $this->generate_responsive_player_tag( $this->maybe_generate_video_tag_from_shortcode() );
			}

			return implode(
				'<br>',
				array_map(
					function( $video_or_iframe_tag ) {
						return '<div class="responsive-player">' . $video_or_iframe_tag . $this->maybe_generate_ad_tag() . '</div>';
					},
					$videos_and_iframes_tags_from_content
				)
			);
		}

		/**
		 * Generate the final `<div class="responsive-player"></div>` tag.
		 * Includes the player tag + the ad tag.
		 *
		 * @return string The final `<div class="responsive-player"></div>` tag.
		 */
		private function generate_responsive_player_tag( $video_or_iframe_tag ) {
			return '<div class="responsive-player">' . $video_or_iframe_tag . $this->maybe_generate_ad_tag() . '</div>';
		}

		/**
		 * Maybe generate the ad tag from inside player ad zones options.
		 *
		 * @return string Empty string if no ad option is found, or the ad tag if exists.
		 */
		private function maybe_generate_ad_tag() {
			$has_ctpl_inside_player_ad_zone_desktop = xbox_get_field_value( 'ctpl-options', 'inside-player-ad-zone-1-desktop' ) || xbox_get_field_value( 'ctpl-options', 'inside-player-ad-zone-2-desktop' );
			$has_wpst_inside_player_ad_zone_desktop = xbox_get_field_value( 'wpst-options', 'inside-player-ad-zone-1-desktop' ) || xbox_get_field_value( 'wpst-options', 'inside-player-ad-zone-2-desktop' );
			$is_ctpl_activated                      = is_plugin_active( 'clean-tube-player/clean-tube-player.php' );

			if ( ! wp_is_mobile() && $has_wpst_inside_player_ad_zone_desktop && ( ! $is_ctpl_activated || $is_ctpl_activated && ! $has_ctpl_inside_player_ad_zone_desktop ) ) {
				return '
					<div class="happy-inside-player">
						<div class="zone-1">' . wpst_display_ad_or_error_message( xbox_get_field_value( 'wpst-options', 'inside-player-ad-zone-1-desktop' ) ) . '</div>
						<div class="zone-2">' . wpst_display_ad_or_error_message( xbox_get_field_value( 'wpst-options', 'inside-player-ad-zone-2-desktop' ) ) . '</div>
						<button class="close close-text">' . esc_html__( 'Close Advertising', 'wpst' ) . '</button>
					</div>
				';
			}

			return '';
		}

		/**
		 * Maybe generate a <video> or <iframe> tag from `shortcode` post meta.
		 *
		 * @return string Empty string if `shortcode` post meta doesn't exist, a <video> or <iframe> tag if exists.
		 */
		private function maybe_generate_video_tag_from_shortcode() {
			$shortcode = $this->maybe_get_shortcode();

			if ( '' === $shortcode ) {
				return '';
			}

			return do_shortcode( $shortcode );
		}

		/**
		 * Maybe generate a <video> tag from video_url post meta.
		 * Maybe generate a <iframe> tag if a tube url, a youtube url or a google drive url is detected.
		 *
		 * @return string Empty string if video_url post meta doesn't exist, a <video> or <iframe> tag if exists.
		 */
		private function maybe_generate_video_or_iframe_tag_from_video_url() {
			$mp4_url = $this->maybe_get_video_url();

			if ( '' === $mp4_url ) {
				return '';
			}

			// get domain name from url to prevent false positive (eg. bexvideos.com).
			$mp4_url_domain = wp_parse_url( $mp4_url, PHP_URL_HOST );
			if ( false !== strpos( $mp4_url_domain, 'pornhub.com' ) ) {
				// ie. https://fr.pornhub.com/view_video.php?viewkey=ph62271b9669165
				$source_id = explode( '/', $mp4_url );
				$source_id = str_replace( 'view_video.php?viewkey=', '', $source_id[3] );
				return '<iframe src="https://www.pornhub.com/embed/' . $source_id . '" frameborder="0" width="560" height="340" scrolling="no" allowfullscreen></iframe>';
			}
			if ( false !== strpos( $mp4_url_domain, 'redtube.com' ) ) {
				// ie. https://fr.redtube.com/39034741
				$source_id = explode( '/', $mp4_url );
				$source_id = $source_id[3];
				return '<iframe src="https://embed.redtube.com/?id=' . $source_id . '&bgcolor=000000" frameborder="0" width="560" height="315" scrolling="no" allowfullscreen></iframe>';
			}
			if ( false !== strpos( $mp4_url_domain, 'tube8.com' ) ) {
				// ie. https://www.tube8.com/amateur/la-femme-de-m%C3%A9nage-nettoie-la-maison-sans-culotte/51487711/
				$exploded_url    = explode( '/', $mp4_url );
				$source_category = $exploded_url[3];
				$source_slug     = $exploded_url[4];
				$source_id       = $exploded_url[5];
				return '<iframe src="https://www.tube8.com/embed/' . $source_category . '/' . $source_slug . '/' . $source_id . '" frameborder="0" width="640" height="360" scrolling="no" name="t8_embed_video"></iframe>';
			}
			if ( false !== strpos( $mp4_url_domain, 'xhamster.com' ) ) {
				// ie. https://fr.xhamster.com/videos/some-stunning-lesbians-that-are-going-to-make-you-explode-xhCLA9d
				$source_id = explode( '-', $mp4_url );
				$source_id = end( $source_id );
				return '<iframe src="https://xhamster.com/embed/' . $source_id . '" frameborder="0" width="640" height="360" scrolling="no"></iframe>';
			}
			if ( false !== strpos( $mp4_url_domain, 'xvideos.com' ) ) {
				// ie. https://www.xvideos.com/video64342581/real_life_hentai_-_des_extraterrestres_baisent_tout_au_long_de_kaisa_nord_et_eve_sweet_avec_une_enorme_ejaculation
				$source_id = explode( '/', $mp4_url );
				$source_id = str_replace( 'video', '', $source_id[3] );
				return '<iframe src="https://www.xvideos.com/embedframe/' . $source_id . '" frameborder="0" width="640" height="360" scrolling="no"></iframe>';
			}
			if ( false !== strpos( $mp4_url_domain, 'youporn.com' ) ) {
				// ie. https://www.youporn.com/watch/16251384/ultrafilms-legendary-ultra-hot-belle-claire-in-her-best-ever-butt-fucking-with-lots-of-passion-and-real-orgasms/
				$source_id   = explode( '/', $mp4_url );
				$source_id   = $source_id[4];
				$source_slug = $source_id[5];
				return '<iframe src="https://www.youporn.com/embed/' . $source_id . '/' . $source_slug . '" frameborder="0" width="640" height="360" scrolling="no"></iframe>';
			}
			if ( false !== strpos( $mp4_url_domain, 'drive.google.com' ) ) {
				// ie.
				$video_url_gd = str_replace( 'view', 'preview', $mp4_url );
				return '<iframe src="' . $video_url_gd . '" frameborder="0" width="640" height="360" scrolling="no" allowfullscreen></iframe>';
			}
			if ( false !== strpos( $mp4_url_domain, 'youtube.com' ) ) {
				// ie. https://www.youtube.com/watch?v=IrxHf18E91s
				$source_id = explode( '/', $mp4_url );
				$source_id = str_replace( 'watch?v=', '', $source_id[3] );
				return '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $source_id . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
			}

			return $this->generate_video_tag_from_mp4_and_poster_url( $mp4_url );
		}

		/**
		 * Generate a <video> tag compatible with the theme (videojs) from an mp4 url.
		 *
		 * @param string $mp4_url The mp4 url.
		 * @param string $poster_url The poster url. Tries to get poster url from $this->maybe_get_poster_url() if empty.
		 *
		 * @return string A <video> tag compatible with videojs.
		 */
		private function generate_video_tag_from_mp4_and_poster_url( $mp4_url, $poster_url = '' ) {
			if ( '' === $mp4_url ) {
				return '';
			}

			if ( '' === $poster_url ) {
				$poster_url = $this->maybe_get_poster_url();
			}

			$video_tag  = '<video class="video-js vjs-big-play-centered" controls preload="auto" width="640" height="264" poster="' . $poster_url . '">';
			$video_tag .= '<source src="' . $mp4_url . '" type="' . wpst_get_type_from_video_url( $mp4_url ) . '" />';
			$video_tag .= '</video>';

			return $video_tag;
		}

		/**
		 * Maybe generate a <video> tag from video_url_{resolution} post metas.
		 *
		 * @return string Empty string if video_url post meta doesn't exist, a <video> tag if any of video_url_{resolution} post meta exists.
		 */
		private function maybe_generate_video_tag_from_video_resolutions_urls() {
			$mp4_resolutions_and_urls = $this->maybe_get_video_resolutions_urls();

			if ( 0 === count( $mp4_resolutions_and_urls ) ) {
				return '';
			}

			$video_tag = '<video class="video-js vjs-big-play-centered" controls preload="auto" width="640" height="264" poster="' . $this->maybe_get_poster_url() . '">';

			foreach ( $mp4_resolutions_and_urls as $resolution => $mp4_url ) {
				$video_tag .= '<source src="' . $mp4_url . '" label="' . $resolution . '" title="' . $resolution . '" type="' . wpst_get_type_from_video_url( $mp4_url ) . '" />';
			}

			$video_tag .= '</video>';

			return $video_tag;
		}

		/**
		 * Maybe generate one or more <video> or <iframe> tags from the post description, in order where they appear.
		 *
		 * @return array Empty array if no <video> or <iframe> tag found in the description, else an array of one or more <video> and/or <iframe> tags.
		 */
		private function maybe_generate_videos_and_iframes_tags_from_description() {
			$tags    = array();
			$matches = array();
			preg_match_all( '/<video.+<\/video>|<iframe.+<\/iframe>/', $this->get_description(), $matches );

			if ( 0 === count( $matches ) ) {
				return array();
			}

			foreach ( $matches[0] as $tag ) {
				if ( 0 === strpos( $tag, '<iframe', 0 ) ) {
					// $tag is an <iframe>.
					$tags[] = $tag;
				} else {
					// $tag is an <video>.
					$mp4_url    = '';
					$poster_url = '';
					preg_match( '/poster="(.+)"/U', $tag, $poster_url_match );
					$poster_url = $poster_url_match[1];
					preg_match( '/src="(.+)"/U', $tag, $mp4url_match );
					$mp4_url = $mp4url_match[1];
					$tags[]  = $this->generate_video_tag_from_mp4_and_poster_url( $mp4_url, $poster_url );
				}
			}

			return $tags;
		}

		/**
		 * Get the video post title.
		 *
		 * @return string The post title.
		 */
		private function get_title() {
			return get_the_title( $this->post_id );
		}

		/**
		 * Get the video post date.
		 *
		 * @return string The post date.
		 */
		private function get_date() {
			return get_the_date( 'c', $this->post_id );
		}

		/**
		 * Get the video post raw description that maybe contains html tags.
		 *
		 * @return string The post raw description.
		 */
		private function get_description() {
			return get_the_content( $this->post_id );
		}

		/**
		 * Get the video post description without any html code.
		 *
		 * @return string The post description without any html code.
		 */
		private function get_description_without_html() {
			return wp_strip_all_tags( get_the_content( $this->post_id ) );
		}

		/**
		 * Get the video post author.
		 *
		 * @return string The name of the author of the post.
		 */
		private function get_author_name() {
			$author_id = get_post_field( 'post_author', $this->post_id );
			return get_the_author_meta( 'display_name', $author_id );
		}

		/**
		 * Get the video post duration in seconds.
		 *
		 * @return int The post duration.
		 */
		private function get_duration() {
			return intval( get_post_meta( $this->post_id, 'duration', true ) );
		}

		/**
		 * Maybe get the post shortcode from the 'shortcode' post meta key.
		 *
		 * @return string Empty string if not found or the shortcode if found.
		 */
		private function maybe_get_shortcode() {
			return get_post_meta( $this->post_id, 'shortcode', true );
		}

		/**
		 * Maybe get the post embed code from the 'embed' post meta key.
		 *
		 * @return string Empty string if not found or the thumb url if found.
		 */
		private function maybe_get_embed_code() {
			return get_post_meta( $this->post_id, 'embed', true );
		}

		/**
		 * Get the src url of an iframe.
		 *
		 * @param string $embed_code The embed code.
		 *
		 * @return string The url of the embed.
		 */
		private function get_embed_url_from_embed_code( $embed_code ) {
			preg_match( '/src=["\']([^"]+)["\']/', $embed_code, $match );

			if ( ! isset( $match[1] ) ) {
				return '';
			}

			$embed_url = $match[1];
			return $embed_url;
		}

		/**
		 * Maybe get the post mp4 url from the possible mp4 urls post meta keys.
		 *
		 * @return string Empty string if not found or the thumb url if found.
		 */
		private function maybe_get_video_url() {
			if ( '' !== get_post_meta( $this->post_id, 'video_url', true ) ) {
				return get_post_meta( $this->post_id, 'video_url', true );
			}
			return '';
		}

		/**
		 * Maybe get the post mp4 url from the possible mp4 urls post meta keys.
		 *
		 * @return array Empty array if not found or an array of $key => $value as $resolution => $mp4_url.
		 */
		private function maybe_get_video_resolutions_urls() {
			$possible_meta_keys = array(
				'video_url_4k',
				'video_url_1080',
				'video_url_720',
				'video_url_480',
				'video_url_360',
				'video_url_240',
			);
			$output             = array();
			foreach ( $possible_meta_keys as $meta_key ) {
				$mp4_url = get_post_meta( $this->post_id, $meta_key, true );
				if ( '' === $mp4_url ) {
					continue;
				}
				$meta_key_exploded     = explode( '_', $meta_key );
				$resolution            = end( $meta_key_exploded );
				$output[ $resolution ] = $mp4_url;
			}
			return $output;
		}

		/**
		 * Get the poster url.
		 *
		 * @return string Empty string if no thumb url found or the thumb url if found.
		 */
		private function maybe_get_poster_url() {
			if ( '' !== $this->maybe_get_poster_url_from_feature_image() ) {
				return $this->maybe_get_poster_url_from_feature_image();
			}

			if ( '' !== $this->maybe_get_poster_url_from_meta() ) {
				return $this->maybe_get_poster_url_from_meta();
			}

			return '';
		}

		/**
		 * Maybe get the poster url from the 'thumb' post meta key.
		 *
		 * @return string Empty string if not found or the thumb url if found.
		 */
		private function maybe_get_poster_url_from_meta() {
			return get_post_meta( $this->post_id, 'thumb', true );
		}

		/**
		 * Maybe get the poster url from the post feature image.
		 *
		 * @return string Empty string if not found or the thumb url if found.
		 */
		private function maybe_get_poster_url_from_feature_image() {
			if ( ! has_post_thumbnail( $this->post_id ) ) {
				return '';
			}

			$thumb_id = get_post_thumbnail_id( $this->post_id );
			if ( ! wp_get_attachment_url( $thumb_id ) ) {
				return '';
			}
			$thumb_url = wp_get_attachment_image_src( $thumb_id, 'wpst_thumb_large', true );

			return $thumb_url[0];
		}
	}
}
