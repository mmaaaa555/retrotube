<?php
/**
 * Auto-generated CSS style from theme options.
 *
 * @package THEME\CSS
 */

$videos_per_row_option = is_page_template( 'template-categories.php' ) ? xbox_get_field_value( 'wpst-options', 'categories-per-row' ) : xbox_get_field_value( 'wpst-options', 'videos-per-row' );

switch ( $videos_per_row_option ) {
	case '2':
		$videos_per_row = '50';
		break;
	case '3':
		$videos_per_row = '33.33';
		break;
	case '4':
		$videos_per_row = '25';
		break;
	case '5':
		$videos_per_row = '20';
		break;
	case '6':
		$videos_per_row = '16.66';
		break;
	default:
		$videos_per_row = '20';
}

if ( 'boxed' === xbox_get_field_value( 'wpst-options', 'layout' ) ) : ?>
	<style>
		#page {
			max-width: 1300px;
			margin: 10px auto;
			background: rgba(0,0,0,0.85);
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.50);
			-moz-box-shadow: 0 0 10px rgba(0, 0, 0, 0.50);
			-webkit-box-shadow: 0 0 10px rgba(0, 0, 0, 0.50);
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
		}
	</style>
<?php endif; ?>
<?php
$ratio_option = xbox_get_field_value( 'wpst-options', 'thumbnails-ratio', '16/9' );
$ratio_width  = intval( explode( '/', $ratio_option )[0] );
$ratio_height = intval( explode( '/', $ratio_option )[1] );
$ratio_format = floatval( $ratio_height * 100 / $ratio_width );

$thumbnails_fit = xbox_get_field_value( 'wpst-options', 'thumbnails-fit', 'fill' );
?>
<style>
	.post-thumbnail {
		padding-bottom: <?php echo esc_html( str_replace( ',', '.', (string) $ratio_format ) ); ?>%;
	}
	.post-thumbnail .wpst-trailer,
	.post-thumbnail img {
		object-fit: <?php echo esc_html( str_replace( ',', '.', (string) $thumbnails_fit ) ); ?>;
	}

	.video-debounce-bar {
		background: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'main-color' ) ); ?>!important;
	}

	<?php if ( 'off' === xbox_get_field_value( 'wpst-options', 'use-logo-image' ) ) : ?>
		@import url(https://fonts.googleapis.com/css?family=<?php echo esc_html( str_replace( ' ', '+', xbox_get_field_value( 'wpst-options', 'logo-font-family' ) ) ); ?>);
	<?php endif; ?>
	<?php
		$background_image       = xbox_get_field_value( 'wpst-options', 'background-image' );
		$background_niche_image = xbox_get_field_value( 'wpst-options', 'background-niche-image' );
	?>
	<?php if ( ! empty( $background_image ) ) : ?>
		body.custom-background {
			background-image: url(<?php echo esc_html( $background_image ); ?>);
			background-color: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-color' ) ); ?>!important;
			background-repeat: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-repeat' ) ); ?>;
			background-attachment: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-attachment' ) ); ?>;
			background-position: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-position' ) ); ?>;
			background-size: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-size' ) ); ?>;
		}
	<?php elseif ( ! empty( $background_niche_image ) ) : ?>
		body.custom-background {
			background-image: url(<?php echo get_template_directory_uri(); ?><?php echo esc_html( $background_niche_image ); ?>);
			background-color: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-color' ) ); ?>!important;
			background-repeat: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-repeat' ) ); ?>;
			background-attachment: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-attachment' ) ); ?>;
			background-position: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-position' ) ); ?>;
			background-size: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'background-size' ) ); ?>;
		}
	<?php endif; ?>

	<?php if ( 'gradient' === xbox_get_field_value( 'wpst-options', 'rendering' ) ) : ?>
		button,
		.button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.label,
		.label:visited,
		.pagination ul li a,
		.widget_categories ul li a,
		.comment-reply-link,
		a.tag-cloud-link,
		.template-actors li a {
			background: -moz-linear-gradient(top, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 70%); /* FF3.6-15 */
			background: -webkit-linear-gradient(top, rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 70%); /* Chrome10-25,Safari5.1-6 */
			background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 70%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a62b2b2b', endColorstr='#00000000',GradientType=0 ); /* IE6-9 */
			-moz-box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12);
			-webkit-box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12);
			-o-box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12);
			box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12);
		}
		input[type="text"],
		input[type="email"],
		input[type="url"],
		input[type="password"],
		input[type="search"],
		input[type="number"],
		input[type="tel"],
		input[type="range"],
		input[type="date"],
		input[type="month"],
		input[type="week"],
		input[type="time"],
		input[type="datetime"],
		input[type="datetime-local"],
		input[type="color"],
		select,
		textarea,
		.wp-editor-container {
			-moz-box-shadow: 0 0 1px rgba(255, 255, 255, 0.3), 0 0 5px black inset;
			-webkit-box-shadow: 0 0 1px rgba(255, 255, 255, 0.3), 0 0 5px black inset;
			-o-box-shadow: 0 0 1px rgba(255, 255, 255, 0.3), 0 0 5px black inset;
			box-shadow: 0 0 1px rgba(255, 255, 255, 0.3), 0 0 5px black inset;
		}
		#site-navigation {
			background: #222222;
			background: -moz-linear-gradient(top, #222222 0%, #333333 50%, #222222 51%, #151515 100%);
			background: -webkit-linear-gradient(top, #222222 0%,#333333 50%,#222222 51%,#151515 100%);
			background: linear-gradient(to bottom, #222222 0%,#333333 50%,#222222 51%,#151515 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#222222', endColorstr='#151515',GradientType=0 );
			-moz-box-shadow: 0 6px 6px 0 rgba(0, 0, 0, 0.12);
			-webkit-box-shadow: 0 6px 6px 0 rgba(0, 0, 0, 0.12);
			-o-box-shadow: 0 6px 6px 0 rgba(0, 0, 0, 0.12);
			box-shadow: 0 6px 6px 0 rgba(0, 0, 0, 0.12);
		}
		#site-navigation > ul > li:hover > a,
		#site-navigation ul li.current-menu-item a {
			background: -moz-linear-gradient(top, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 70%);
			background: -webkit-linear-gradient(top, rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 70%);
			background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 70%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a62b2b2b', endColorstr='#00000000',GradientType=0 );
			-moz-box-shadow: inset 0px 0px 2px 0px #000000;
			-webkit-box-shadow: inset 0px 0px 2px 0px #000000;
			-o-box-shadow: inset 0px 0px 2px 0px #000000;
			box-shadow: inset 0px 0px 2px 0px #000000;
			filter:progid:DXImageTransform.Microsoft.Shadow(color=#000000, Direction=NaN, Strength=2);
		}
		.rating-bar,
		.categories-list .thumb-block .entry-header,
		.actors-list .thumb-block .entry-header,
		#filters .filters-select,
		#filters .filters-options {
			background: -moz-linear-gradient(top, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 70%); /* FF3.6-15 */
			background: -webkit-linear-gradient(top, rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 70%); /* Chrome10-25,Safari5.1-6 */
			background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 70%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			-moz-box-shadow: inset 0px 0px 2px 0px #000000;
			-webkit-box-shadow: inset 0px 0px 2px 0px #000000;
			-o-box-shadow: inset 0px 0px 2px 0px #000000;
			box-shadow: inset 0px 0px 2px 0px #000000;
			filter:progid:DXImageTransform.Microsoft.Shadow(color=#000000, Direction=NaN, Strength=2);
		}
		.breadcrumbs-area {
			background: -moz-linear-gradient(top, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 70%); /* FF3.6-15 */
			background: -webkit-linear-gradient(top, rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 70%); /* Chrome10-25,Safari5.1-6 */
			background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 70%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
		}
	<?php else : ?>
		#site-navigation {
			background: #222222;
		}
	<?php endif; ?>

	.site-title a {
		font-family: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'logo-font-family' ) ); ?>;
		font-size: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'logo-font-size' ) ); ?>px;
	}
	.site-branding .logo img {
		max-width: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'logo-max-width' ) ); ?>px;
		max-height: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'logo-max-height' ) ); ?>px;
		margin-top: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'logo-margin-top' ) ); ?>px;
		margin-left: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'logo-margin-left' ) ); ?>px;
	}
	a,
	.site-title a i,
	.thumb-block:hover .rating-bar i,
	.categories-list .thumb-block:hover .entry-header .cat-title:before,
	.required,
	.like #more:hover i,
	.dislike #less:hover i,
	.top-bar i:hover,
	.main-navigation .menu-item-has-children > a:after,
	.menu-toggle i,
	.main-navigation.toggled li:hover > a,
	.main-navigation.toggled li.focus > a,
	.main-navigation.toggled li.current_page_item > a,
	.main-navigation.toggled li.current-menu-item > a,
	#filters .filters-select:after,
	.morelink i,
	.top-bar .membership a i,
	.thumb-block:hover .photos-count i {
		color: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'main-color' ) ); ?>;
	}
	button,
	.button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.label,
	.pagination ul li a.current,
	.pagination ul li a:hover,
	body #filters .label.secondary.active,
	.label.secondary:hover,
	.main-navigation li:hover > a,
	.main-navigation li.focus > a,
	.main-navigation li.current_page_item > a,
	.main-navigation li.current-menu-item > a,
	.widget_categories ul li a:hover,
	.comment-reply-link,
	a.tag-cloud-link:hover,
	.template-actors li a:hover {
		border-color: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'main-color' ) ); ?>!important;
		background-color: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'main-color' ) ); ?>!important;
	}
	.rating-bar-meter,
	.vjs-play-progress,
	#filters .filters-options span:hover,
	.bx-wrapper .bx-controls-direction a,
	.top-bar .social-share a:hover,
	.thumb-block:hover span.hd-video,
	.featured-carousel .slide a:hover span.hd-video,
	.appContainer .ctaButton {
		background-color: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'main-color' ) ); ?>!important;
	}
	#video-tabs button.tab-link.active,
	.title-block,
	.widget-title,
	.page-title,
	.page .entry-title,
	.comments-title,
	.comment-reply-title,
	.morelink:hover {
		border-color: <?php echo esc_html( xbox_get_field_value( 'wpst-options', 'main-color' ) ); ?>!important;
	}

	/* Small desktops ----------- */
	@media only screen  and (min-width : 64.001em) and (max-width : 84em) {
		#main .thumb-block {
			width: <?php echo esc_html( $videos_per_row ); ?>%!important;
		}
	}

	/* Desktops and laptops ----------- */
	@media only screen  and (min-width : 84.001em) {
		#main .thumb-block {
			width: <?php echo esc_html( $videos_per_row ); ?>%!important;
		}
	}

</style>
