<?php
$post_data = wpst_get_post_data( $post->ID );
$url_image = get_post_meta( $post->ID, 'thumb', true );
if ( has_post_thumbnail() && wp_get_attachment_url( get_post_thumbnail_id() ) ) {
	$url_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
}
$current_url   = get_permalink( $post->ID );
$current_title = $post_data->post_title;
$current_desc  = $current_title;
if ( ! empty( $post_data->post_content ) ) {
	$current_desc = $post_data->post_content;
}
?>
<div id="video-share">
	<!-- Facebook -->
	<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'facebook-video-share' ) ) : ?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.12';
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( $current_url ); ?>&amp;src=sdkpreparse"><i id="facebook" class="fa fa-facebook"></i></a>
	<?php endif; ?>

	<!-- Twitter -->
	<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'twitter-video-share' ) ) : ?>
		<a target="_blank" href="https://twitter.com/share?url=<?php echo esc_url( $current_url ); ?>&text=<?php echo esc_html( wp_strip_all_tags( $current_desc ) ); ?>"><i id="twitter" class="fa fa-twitter"></i></a>
	<?php endif; ?>

	<!-- Google Plus -->
	<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'google-plus-video-share' ) ) : ?>
		<a target="_blank" href="https://plus.google.com/share?url=<?php echo esc_url( $current_url ); ?>"><i id="googleplus" class="fa fa-google-plus"></i></a>
	<?php endif; ?>

	<!-- Linkedin -->
	<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'linkedin-video-share' ) ) : ?>
		<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( $current_url ); ?>&amp;title=<?php echo esc_html( $current_title ); ?>&amp;summary=<?php echo esc_html( wp_strip_all_tags( $current_desc ) ); ?>&amp;source=<?php echo esc_url( home_url() ); ?>"><i id="linkedin" class="fa fa-linkedin"></i></a>
	<?php endif; ?>

	<!-- Tumblr -->
	<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'tumblr-video-share' ) ) : ?>
		<a target="_blank" href="http://tumblr.com/widgets/share/tool?canonicalUrl=<?php echo esc_url( $current_url ); ?>"><i id="tumblr" class="fa fa-tumblr-square"></i></a>
	<?php endif; ?>

	<!-- Reddit -->
	<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'reddit-video-share' ) ) : ?>
		<a target="_blank" href="http://www.reddit.com/submit?title=<?php echo esc_html( $current_title ); ?>&url=<?php echo esc_url( $current_url ); ?>"><i id="reddit" class="fa fa-reddit-square"></i></a>
	<?php endif; ?>

	<!-- Odnoklassniki -->
	<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'odnoklassniki-video-share' ) ) : ?>
		<a target="_blank" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=<?php echo esc_url( $current_url ); ?>&title=<?php echo esc_html( $current_title ); ?>"><i id="odnoklassniki" class="fa fa-odnoklassniki"></i></a>
	<?php endif; ?>

	<!-- VK -->
	<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'vk-video-share' ) ) : ?>
		<script type="text/javascript" src="https://vk.com/js/api/share.js?95" charset="windows-1251"></script>
		<a href="http://vk.com/share.php?url=<?php echo esc_url( $current_url ); ?>" target="_blank"><i id="vk" class="fa fa-vk"></i></a>
	<?php endif; ?>

	<!-- Email -->
	<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'email-video-share' ) ) : ?>
		<a target="_blank" href="mailto:?subject=&amp;body=<?php the_permalink(); ?>"><i id="email" class="fa fa-envelope"></i></a>
	<?php endif; ?>
</div>
