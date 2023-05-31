<?php
/**
 * Theme functions and definitions
 *
 * @package WPST
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require get_template_directory() . '/admin/theme-activation.php';

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( ! is_plugin_active( 'wp-script-core/wp-script-core.php' ) ) {
	require_once get_template_directory() . '/tgmpa/class-tgm-plugin-activation.php';
	require_once get_template_directory() . '/tgmpa/config.php';
}

if ( ! function_exists( 'WPSCORE' ) ) {
	return;
}

add_action( 'after_setup_theme', 'wpst_setup' );
add_action( 'after_setup_theme', 'wpst_content_width', 0 );
add_action( 'widgets_init', 'wpst_widgets_init' );
eval( WPSCORE()->eval_product_data( WPSCORE()->get_installed_theme( 'sku' ), 'add_scripts' ) );
eval( WPSCORE()->eval_product_data( WPSCORE()->get_installed_theme( 'sku' ), 'add_admin_scripts' ) );
add_action( 'xbox_after_save_field_read-css-from-file', 'wpst_create_custom_files', 10, 3 );

require get_template_directory() . '/inc/filters/the-content.php';
require get_template_directory() . '/inc/class-video-submitter.php';
require get_template_directory() . '/inc/class-content-video-player.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/jetpack.php';
require get_template_directory() . '/inc/widget-video.php';
require get_template_directory() . '/inc/video-functions.php';
require get_template_directory() . '/inc/ajax-get-async-post-data.php';
require get_template_directory() . '/inc/ajax-post-like.php';
require get_template_directory() . '/inc/post-like.php';
require get_template_directory() . '/ajax/load-video-preview.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/category-image.php';
require get_template_directory() . '/inc/actor-image.php';
require get_template_directory() . '/inc/pagination.php';
require get_template_directory() . '/inc/actors.php';
require get_template_directory() . '/inc/cpt-blog.php';
require get_template_directory() . '/inc/blog-functions.php';
require get_template_directory() . '/inc/cpt-photos.php';
require get_template_directory() . '/inc/actions.php';
require get_template_directory() . '/admin/admin-columns.php';
require_once get_template_directory() . '/admin/options.php';
require_once get_template_directory() . '/admin/metabox.php';
require_once get_template_directory() . '/admin/import/wpst-importer.php';
require_once get_template_directory() . '/inc/ajax-login-register.php';


if ( ! function_exists( 'wpst_setup' ) ) :

	function wpst_setup() {

		load_theme_textdomain( 'wpst', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 320, 180, true );
		add_image_size( 'wpst_thumb_large', '640', '360', true );
		add_image_size( 'wpst_thumb_medium', '320', '180', true );
		add_image_size( 'wpst_thumb_small', '150', '84', true );

		register_nav_menus(
			array(
				'wpst-main-menu'   => esc_html__( 'Main menu', 'wpst' ),
				'wpst-footer-menu' => esc_html__( 'Footer menu', 'wpst' ),
			)
		);

		// If Main Menu exists, set it to main menu location.
		// Prevent visual issues in main menu after theme switching.
		$main_menu = wp_get_nav_menu_object( 'Main Menu' );
		if ( false !== $main_menu ) {
			$locations                   = get_theme_mod( 'nav_menu_locations' );
			$locations['wpst-main-menu'] = $main_menu->term_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		add_theme_support(
			'custom-background',
			apply_filters(
				'wpst_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'post-formats', array( 'video' ) );

		add_theme_support( 'responsive-embeds' );
	}
endif;

function wpst_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wpst_content_width', 640 );
}

function wpst_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Homepage', 'wpst' ),
			'id'            => 'homepage',
			'description'   => esc_html__( 'Display widgets on your homepage.', 'wpst' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'wpst' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Display widgets in your sidebar.', 'wpst' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Under the video', 'wpst' ),
			'id'            => 'under_video',
			'description'   => esc_html__( 'Display widgets under the video in your single video pages.', 'wpst' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'wpst' ),
			'id'            => 'footer',
			'description'   => esc_html__( 'Display widgets in your footer.', 'wpst' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

/**
 * Enqueue scripts and styles.
 */
function wpst_scripts() {
	/* CSS */
	wp_enqueue_style( 'wpst-font-awesome', get_template_directory_uri() . '/assets/stylesheets/font-awesome/css/font-awesome.min.css', array(), '4.7.0', 'all' );
	/* JS */
	if ( is_single() && ( ! is_plugin_active( 'clean-tube-player/clean-tube-player.php' ) || ! is_plugin_active( 'kenplayer-transformer/transform.php' ) ) ) {
		wp_enqueue_style( 'wpst-videojs-style', '//vjs.zencdn.net/7.8.4/video-js.css', array(), '7.8.4', 'all' );
		wp_enqueue_script( 'wpst-videojs', '//vjs.zencdn.net/7.8.4/video.min.js', array(), '7.8.4', true );
		wp_enqueue_script( 'wpst-videojs-quality-selector', 'https://unpkg.com/@silvermine/videojs-quality-selector@1.2.4/dist/js/silvermine-videojs-quality-selector.min.js', array( 'wpst-videojs' ), '1.2.4', true );
	}
	if ( is_singular( 'photos' ) || is_singular( 'blog' ) || is_page() ) {
		wp_enqueue_style( 'wpst-fancybox-style', get_template_directory_uri() . '/assets/stylesheets/fancybox/jquery.fancybox.min.css', '3.4.1', 'all' );
	}
	$current_theme = wp_get_theme();
	$style_version = $current_theme->get( 'Version' ) . '.' . filemtime( get_template_directory() );
	wp_enqueue_style( 'wpst-style', get_stylesheet_uri(), array(), $style_version, 'all' );

	if ( is_singular( 'photos' ) || is_singular( 'blog' ) || is_page() ) {
		wp_enqueue_script( 'wpst-fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.min.js', array(), '3.4.1', true );
		wp_enqueue_script( 'wpst-waterfall', get_template_directory_uri() . '/assets/js/waterfall.js', array(), '1.1.0', true );
	}
	wp_enqueue_script( 'wpst-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '1.0.0', true );

	wp_enqueue_script( 'wpst-carousel', get_template_directory_uri() . '/assets/js/jquery.bxslider.min.js', array( 'jquery' ), '4.2.15', true );

	wp_enqueue_script( 'wpst-touchswipe', get_template_directory_uri() . '/assets/js/jquery.touchSwipe.min.js', array( 'jquery' ), '1.6.18', true );

	wp_enqueue_script( 'wpst-lazyload', get_template_directory_uri() . '/assets/js/lazyload.js', array(), '1.0.0', true );

	$script_version = $current_theme->get( 'Version' ) . '.' . filemtime( get_template_directory() . '/assets/js/main.js' );

	wp_enqueue_script( 'wpst-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), $script_version, true );
	wp_localize_script(
		'wpst-main',
		'wpst_ajax_var',
		array(
			'url'            => admin_url( 'admin-ajax.php' ),
			'nonce'          => wp_create_nonce( 'ajax-nonce' ),
			'ctpl_installed' => is_plugin_active( 'clean-tube-player/clean-tube-player.php' ),
			'is_mobile'      => wp_is_mobile(),
		)
	);
	wp_localize_script(
		'wpst-main',
		'objectL10nMain',
		array(
			'readmore' => __( 'Read more', 'wpst' ),
			'close'    => __( 'Close', 'wpst' ),
		)
	);
	wp_localize_script(
		'wpst-main',
		'options',
		array(
			'thumbnails_ratio'     => xbox_get_field_value( 'wpst-options', 'thumbnails-ratio' ),
			'enable_views_system'  => xbox_get_field_value( 'wpst-options', 'enable-views-system' ),
			'enable_rating_system' => xbox_get_field_value( 'wpst-options', 'enable-rating-system' ),
		)
	);
	wp_enqueue_script( 'wpst-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '1.0.0', true );
	if ( xbox_get_field_value( 'wpst-options', 'enable-recaptcha' ) == 'on' ) {
		wp_register_script( 'wpst-recaptcha', 'https://www.google.com/recaptcha/api.js' );
		wp_enqueue_script( 'wpst-recaptcha' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Enqueue admin scripts
 */
function wpst_admin_scripts() {
	$current_theme = wp_get_theme();

	if ( isset( $_GET['page'] ) && $_GET['page'] == 'wpst-options' ) {
		wp_enqueue_style( 'wpst-bootstrap-modal-style', get_template_directory_uri() . '/admin/vendor/bootstrap-modal/bootstrap.modal.min.css', array(), '3.3.7', 'all' );
		wp_enqueue_script( 'wpst-bootstrap-modal', get_template_directory_uri() . '/admin/vendor/bootstrap-modal/bootstrap.modal.min.js', array( 'jquery' ), '3.3.7', true );
	}
	wp_enqueue_script( 'wpst-admin', get_template_directory_uri() . '/admin/assets/js/admin.js', array( 'jquery' ), $current_theme->get( 'Version' ), true );
	wp_localize_script(
		'wpst-admin',
		'admin_ajax_var',
		array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'ajax-nonce' ),
		)
	);
	wp_enqueue_script( 'wpst-import', get_template_directory_uri() . '/admin/import/wpst-import.js', array( 'jquery' ), $current_theme->get( 'Version' ) );
	wp_localize_script(
		'wpst-import',
		'wpst_import_ajax_var',
		array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'ajax-nonce' ),
		)
	);
	wp_localize_script(
		'wpst-import',
		'objectL10n',
		array(
			'dataimport'  => __( 'Data is being imported please be patient...', 'wpst' ),
			'videosubmit' => __( 'Video submit page created.', 'wpst' ),
			'havefun'     => __( 'Have fun!', 'wpst' ),
			'profilepage' => __( 'Profile page created.', 'wpst' ),
			'blogpage'    => __( 'Blog page created.', 'wpst' ),
			'catpage'     => __( 'Categories page created.', 'wpst' ),
			'tagpage'     => __( 'Tags page created.', 'wpst' ),
			'actorspage'  => __( 'Actors page created.', 'wpst' ),
			'menu'        => __( 'Menu created.', 'wpst' ),
			'widgets'     => __( 'Widgets created.', 'wpst' ),
		)
	);
}

function wpst_selected_filter( $filter ) {
	$current_filter = '';
	if ( is_home() ) {
		$current_filter = xbox_get_field_value( 'wpst-options', 'show-videos-homepage' );
	}
	if ( isset( $_GET['filter'] ) ) {
		$current_filter = $_GET['filter'];
	}
	if ( $current_filter == $filter ) {
		return 'active';
	}
	return false;
}

function wpst_create_custom_files( $value, $field, $updated ) {
	$file_path = get_template_directory() . '/assets/stylesheets/style.css';
	$xbox      = Xbox::get( 'wpst-options' );
	$value     = $xbox->get_field_value( 'read-css-from-file' ); // If you just want to save when there were changes.
	file_put_contents( $file_path, $value );
}

function wpst_get_filter_title() {
	$title  = '';
	$filter = '';
	if ( isset( $_GET['filter'] ) ) {
		$filter = $_GET['filter'];
	} else {
		$filter = xbox_get_field_value( 'wpst-options', 'show-videos-homepage' );
	}
	switch ( $filter ) {
		case 'latest':
			$title = esc_html__( 'Latest videos', 'wpst' );
			break;
		case 'most-viewed':
			$title = esc_html__( 'Most viewed videos', 'wpst' );
			break;
		case 'longest':
			$title = esc_html__( 'Longest videos', 'wpst' );
			break;
		case 'popular':
			$title = esc_html__( 'Popular videos', 'wpst' );
			break;
		case 'random':
			$title = esc_html__( 'Random videos', 'wpst' );
			break;
		default:
			$title = esc_html__( 'Latest videos', 'wpst' );
			break;
	}
	return $title;
}

function wpst_get_nopaging_url() {
	global $wp;

	$current_url  = home_url( $wp->request );
	$position     = strpos( $current_url, '/page' );
	$nopaging_url = ( $position ) ? substr( $current_url, 0, $position ) : $current_url;

	return trailingslashit( $nopaging_url );
}

function wpst_duration_custom_field( $updated, $field ) {
	$duration_hh = isset( $_POST['duration_hh'] ) ? $_POST['duration_hh'] : 0;
	$duration_mm = isset( $_POST['duration_mm'] ) ? $_POST['duration_mm'] : 0;
	$duration_ss = isset( $_POST['duration_ss'] ) ? $_POST['duration_ss'] : 0;
	$field->save( $duration_hh * 3600 + $duration_mm * 60 + $duration_ss );
}
add_action( 'xbox_after_save_field_duration', 'wpst_duration_custom_field', 10, 2 );

function wpst_render_shortcodes( $content ) {
	$regex = '/\[(.+)\]/m';
	preg_match_all( $regex, $content, $matches, PREG_SET_ORDER, 0 );

	// Print the entire match result
	if ( is_array( $matches ) ) {
		foreach ( $matches as $shortcode ) {
			$shortcode_with_brackets    = $shortcode[0];
			$shortcode_without_brackets = $shortcode[1];
			$should_be_shortcode        = explode( ' ', $shortcode_without_brackets );
			$should_be_shortcode        = current( $should_be_shortcode );
			if ( shortcode_exists( $should_be_shortcode ) ) {
				$shortcode = do_shortcode( $shortcode_with_brackets );
				return $shortcode;
			}
		}
	}
	return $content;
}

/**
 * Check if string is well formed HTML
 *
 * @param string $html_string String to check.
 * @return boolean True if string is well formed HTML, false otherwise.
 */
function wpst_is_html_well_formed( $html_string ) {
	$regex                           = '/^(?:<([\w-]+)(?:(?:\s+[\w-]+(?:\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+\s*|\s*)>[^<>]*(?:(?:<[^<>]*>)[^<>]*)*<\/\1+\s*>|<[\w-]+(?:(?:\s+[\w-]+(?:\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+\s*|\s*)\/>|<!--.*?-->|[^<>]+)*$/i';
	$html_string_without_script_tags = wpst_remove_style_tags( wpst_remove_script_tags( $html_string ) );
	return preg_match( $regex, $html_string_without_script_tags ) ? true : false;
}

/**
 * Remove script tags from HTML
 *
 * @param string $html_string String to remove script tags from.
 * @return string String without script tags.
 */
function wpst_remove_script_tags( $html_string ) {
	return preg_replace( '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $html_string );
}

/**
 * Remove style tags from HTML
 *
 * @param string $html_string String to remove style tags from.
 * @return string String without style tags.
 */
function wpst_remove_style_tags( $html_string ) {
	return preg_replace( '/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/i', '', $html_string );
}

/**
 * Display ad or error message
 *
 * @param string $content Ad code from the admin options.
 * @return string Ad code or error message.
 */
function wpst_display_ad_or_error_message( $content ) {
	$content = wpst_render_shortcodes( $content );
	if ( wpst_is_html_well_formed( $content ) ) {
		return $content;
	}
	return '<div style="display:flex; background: #a62b2b; border: 4px solid white; color: white; justify-content: center; text-align:center; font-weight:bold; padding:10px;">' . __( 'The ad code is not a valid HTML code.', 'wpst' ) . '<br/>' . __( 'Fix the ad code in the Theme options.', 'wpst' ) . '</div>';
}

/**
 * Display script or nothing
 *
 * @param string $content Script code from the admin options.
 * @return string Script code or nothing.
 */
function wpst_maybe_display_html( $content ) {
	$content = wpst_render_shortcodes( $content );
	if ( wpst_is_html_well_formed( $content ) ) {
		return $content;
	}
	return '';
}

function wpst_change_post_object() {
	global $wp_post_types;
	$labels                     = &$wp_post_types['post']->labels;
	$labels->name               = 'Videos';
	$labels->singular_name      = 'Videos';
	$labels->add_new            = 'Add Video';
	$labels->add_new_item       = 'Add Video';
	$labels->edit_item          = 'Edit Video';
	$labels->new_item           = 'Videos';
	$labels->view_item          = 'View Videos';
	$labels->search_items       = 'Search Videos';
	$labels->not_found          = 'No Videos found';
	$labels->not_found_in_trash = 'No Videos found in Trash';
	$labels->all_items          = 'All Videos';
	$labels->menu_name          = 'Videos';
	$labels->name_admin_bar     = 'Videos';
}

add_action( 'init', 'wpst_change_post_object' );

function wpst_change_cat_object() {
	global $wp_taxonomies;
	$labels                     = &$wp_taxonomies['category']->labels;
	$labels->name               = 'Video Category';
	$labels->singular_name      = 'Video Category';
	$labels->add_new            = 'Add Video Category';
	$labels->add_new_item       = 'Add Video Category';
	$labels->edit_item          = 'Edit Video Category';
	$labels->new_item           = 'Video Category';
	$labels->view_item          = 'View Video Category';
	$labels->search_items       = 'Search Video Categories';
	$labels->not_found          = 'No Video Categories found';
	$labels->not_found_in_trash = 'No Video Categories found in Trash';
	$labels->all_items          = 'All Video Categories';
	$labels->menu_name          = 'Video Category';
	$labels->name_admin_bar     = 'Video Category';
}
add_action( 'init', 'wpst_change_cat_object' );

function wpst_change_tag_object() {
	global $wp_taxonomies;
	$labels                     = &$wp_taxonomies['post_tag']->labels;
	$labels->name               = 'Video Tag';
	$labels->singular_name      = 'Video Tag';
	$labels->add_new            = 'Add Video Tag';
	$labels->add_new_item       = 'Add Video Tag';
	$labels->edit_item          = 'Edit Video Tag';
	$labels->new_item           = 'Video Tag';
	$labels->view_item          = 'View Video Tag';
	$labels->search_items       = 'Search Video Tags';
	$labels->not_found          = 'No Video Tags found';
	$labels->not_found_in_trash = 'No Video Tags found in Trash';
	$labels->all_items          = 'All Video Tags';
	$labels->menu_name          = 'Video Tag';
	$labels->name_admin_bar     = 'Video Tag';
}
add_action( 'init', 'wpst_change_tag_object' );

/**
 * Auto enable WordPress registration option when Theme membership option is "on"
 *
 * @return void.
 */
function wpst_auto_enable_registration() {
	$enable_membership = xbox_get_field_value( 'wpst-options', 'enable-membership' );
	if ( 'on' === $enable_membership && ! get_option( 'users_can_register' ) ) {
		update_option( 'users_can_register', 1 );
	}
}
add_action( 'get_header', 'wpst_auto_enable_registration' );

function replace_admin_menu_icons_css() {
	?>
	<style>
		#menu-posts .dashicons-admin-post::before, #menu-posts .dashicons-format-standard::before {
			content: "\f236";
		}
	</style>
	<?php
}

add_action( 'admin_head', 'replace_admin_menu_icons_css' );

function wpst_rss_post_thumbnail( $content ) {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ) {
		$content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . $content;
	}
	return $content;
}
add_filter( 'the_excerpt_rss', 'wpst_rss_post_thumbnail' );
add_filter( 'the_content_feed', 'wpst_rss_post_thumbnail' );

/* Remove admin bar for logged in users */
function wpst_remove_admin_bar() {
	if ( ! current_user_can( 'administrator' ) && ! is_admin() && xbox_get_field_value( 'wpst-options', 'display-admin-bar' ) == 'off' ) {
		show_admin_bar( false );
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}
}
add_action( 'get_header', 'wpst_remove_admin_bar' );

/**
 * Modify the "must_log_in" string of the comment form.
 */
add_filter(
	'comment_form_defaults',
	function( $fields ) {
		$fields['must_log_in'] = sprintf(
			__(
				'<p class="must-log-in">
                 You must be <a href="#wpst-login">logged in</a> to post a comment.</p>'
			),
			wp_registration_url(),
			wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		);
		return $fields;
	}
);
