<?php
function wpst_remove_media_embedded_inZ_content( $content ) {
	if ( ! is_single() ) {
		return $content;
	}

	if ( empty( $content ) ) {
		return $content;
	}

	$medias_in_content     = get_media_embedded_in_content( $content );
	$content_with_no_media = str_replace( $medias_in_content, '', $content );

	return str_replace( '<figure class="wp-block-video"></figure>', '', $content_with_no_media );
}

add_filter( 'the_content', 'wpst_remove_media_embedded_inZ_content' );
