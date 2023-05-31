<?php
/**
 * Options page.
 *
 * @package WPST\Admin\Options
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'WPSCORE-tabs', 'wpst_add_admin_navigation' );
/**
 * WPSCORE-tabs filter call back.
 *
 * @param array $nav The WP-Script menu without the theme options tab.
 *
 * @return array $nav The WP-Script menu with the theme options tab.
 */
function wpst_add_admin_navigation( $nav ) {
	eval( WPSCORE()->eval_product_data( WPSCORE()->get_installed_theme( 'sku' ), 'add_tab' ) );
	if ( isset( $wpst_nav ) && is_array( $wpst_nav ) ) {
		$nav[1] = $wpst_nav;
	}
	return $nav;
}

add_filter( 'wpst-options', 'wpst_options_page' );
/**
 * This function is a wpst-options filter callback to display WP-Script logo & tabs at the top of the Xbox options page.
 *
 * @param string $options_table - default options HTML string to render the Xbox options in the page.
 * @return $output
 */
function wpst_options_page( $options_table ) {
	$output  = '<div id="wp-script">'; // Open DIV#1.
	$output .= '<div class="content-tabs">'; // Open DIV#2.
	$output .= WPSCORE()->display_logo( false );
	$output .= WPSCORE()->display_tabs( false );
	$output .= '<div class="tab-content tab-options">'; // Open DIV#3.
	$output .= $options_table;
	$output .= get_modal_html();
	$output .= '</div>'; // Close DIV#3.
	$output .= WPSCORE()->display_footer( false );
	$output .= '</div>'; // Close DIV#2.
	$output .= '</div>'; // Close DIV#1.
	$output .= get_script_to_validate_html_code();
	return $output;
}

function get_script_to_validate_html_code() {
	ob_start();
	?>
	<script>
		;(function() {
			function validateHTML(htmlString) {
				var htmlStringWithoutScriptTags = removeStyleTags( removeScriptTags(htmlString) );
				var regex = /^(?:<([\w-]+)(?:(?:\s+[\w-]+(?:\s*=\s*(?:".*?"|'.*?'|[^'">\s]+))?)+\s*|\s*)>[^<>]*(?:(?:<[^<>]*>)[^<>]*)*<\/\1+\s*>|<[\w-]+(?:(?:\s+[\w-]+(?:\s*=\s*(?:".*?"|'.*?'|[^'">\s]+))?)+\s*|\s*)\/>|<!--.*?-->|[^<>]+)*$/;

				return regex.test(htmlStringWithoutScriptTags) ? true : false;
			}

			function removeScriptTags(html) {
				return html.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, "");
			}

			function removeStyleTags(html) {
				return html.replace(/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/gi, "");
			}

			function updateMessageElt(messageId, message, color, htmlCodeIsEmpty) {
				var messageElt = document.getElementById(messageId);
				// Remove existing message element if it exists and html code is empty.
				if ( messageElt && htmlCodeIsEmpty ) {
					messageElt.remove();
				}
				// Return empty string if html code is empty.
				if( htmlCodeIsEmpty ) {
					return ''
				}
				// Update and return existing message element.
				if ( messageElt ) {
						messageElt.innerHTML = message;
						messageElt.style.backgroundColor = color;
						return messageElt;
				}
				// Else, Create new message element.
				var newMessageElt = document.createElement("div");
				newMessageElt.id = messageId;
				newMessageElt.style.color = "white";
				newMessageElt.style.fontWeight = "bold";
				newMessageElt.style.borderRadius = "3px";
				newMessageElt.style.padding = "5px";
				newMessageElt.innerHTML = message;
				newMessageElt.style.backgroundColor = color;
				return newMessageElt;
			}

			function updateDom(textAreaElt) {
				var eltId = textAreaElt.id || Math.floor(Math.random() * 1000000);
				var messageId = "validate-html-message-" + eltId;
				var htmlIsValid = validateHTML(textAreaElt.value);
				var htmlCodeIsEmpty = ! textAreaElt.value;
				var color = htmlIsValid ? 'green' : 'red';
				var messageElt = updateMessageElt(
					messageId,
					htmlIsValid ? '✓ Valid HTML code.' : '✗ Some html tags are not closed properly.',
					color,
					htmlCodeIsEmpty
				);
				textAreaElt.after(messageElt);
				textAreaElt.style.borderColor = htmlCodeIsEmpty ? null : color;
			}

			// Add messages elements on load.
			document.addEventListener("DOMContentLoaded", function(event) {
				document.querySelectorAll('.validate-html-code').forEach(function (textAreaElt) {
					// Add message element on load.
					updateDom(textAreaElt);
					// Update message element on load on keyup.
					textAreaElt.addEventListener('keyup', function(e) {
						updateDom(e.target);
					});
				});
			});
		})();
	</script>
	<?php
	return ob_get_clean();
}

/**
 * Get modal html code for tools.
 *
 * @return string The html code for modals.
 */
function get_modal_html() {
	$output = '<div class="modal fade" id="create_video_submit_page_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">' . esc_html__( 'Create Video Submit page', 'wpst' ) . '</h4>
						</div>
						<div class="modal-body">' . esc_html__( 'This action will create a "Submit a Video" page in your admin.', 'wpst' ) . '</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">' . esc_html__( 'Close', 'wpst' ) . '</button>
						<button type="button" class="btn btn-primary">' . esc_html__( 'Confirm', 'wpst' ) . '</button>
						</div>
					</div>
					</div>
				</div>';

	$output .= '<div class="modal fade" id="create_my_profile_page_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">' . esc_html__( 'Create Profile page', 'wpst' ) . '</h4>
						</div>
						<div class="modal-body">' . esc_html__( 'This action will create a "My profile" page in your admin.', 'wpst' ) . '</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">' . esc_html__( 'Close', 'wpst' ) . '</button>
						<button type="button" class="btn btn-primary">' . esc_html__( 'Confirm', 'wpst' ) . '</button>
						</div>
					</div>
					</div>
				</div>';

	$output .= '<div class="modal fade" id="create_blog_page_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">' . esc_html__( 'Create Blog page', 'wpst' ) . '</h4>
						</div>
						<div class="modal-body">' . esc_html__( 'This action will create a "Blog" page in your admin.', 'wpst' ) . '</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">' . esc_html__( 'Close', 'wpst' ) . '</button>
						<button type="button" class="btn btn-primary">' . esc_html__( 'Confirm', 'wpst' ) . '</button>
						</div>
					</div>
					</div>
				</div>';

	$output .= '<div class="modal fade" id="create_categories_page_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">' . esc_html__( 'Create Categories page', 'wpst' ) . '</h4>
						</div>
						<div class="modal-body">' . esc_html__( 'This action will create an illustrated categories page in your admin.', 'wpst' ) . '</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">' . esc_html__( 'Close', 'wpst' ) . '</button>
						<button type="button" class="btn btn-primary">' . esc_html__( 'Confirm', 'wpst' ) . '</button>
						</div>
					</div>
					</div>
				</div>';

	$output .= '<div class="modal fade" id="create_tags_page_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">' . esc_html__( 'Create Tags page', 'wpst' ) . '</h4>
						</div>
						<div class="modal-body">' . esc_html__( 'This action will create a tags list page in your admin.', 'wpst' ) . '</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">' . esc_html__( 'Close', 'wpst' ) . '</button>
						<button type="button" class="btn btn-primary">' . esc_html__( 'Confirm', 'wpst' ) . '</button>
						</div>
					</div>
					</div>
				</div>';

	$output .= '<div class="modal fade" id="create_actors_page_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">' . esc_html__( 'Create Actors page', 'wpst' ) . '</h4>
						</div>
						<div class="modal-body">' . esc_html__( 'This action will create an actors list page in your admin.', 'wpst' ) . '</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">' . esc_html__( 'Close', 'wpst' ) . '</button>
						<button type="button" class="btn btn-primary">' . esc_html__( 'Confirm', 'wpst' ) . '</button>
						</div>
					</div>
					</div>
				</div>';

	$output .= '<div class="modal fade" id="create_menu_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">' . esc_html__( 'Create Menu', 'wpst' ) . '</h4>
						</div>
						<div class="modal-body">' . esc_html__( 'This action will create a menu in your admin.', 'wpst' ) . '</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">' . esc_html__( 'Close', 'wpst' ) . '</button>
						<button type="button" class="btn btn-primary">' . esc_html__( 'Confirm', 'wpst' ) . '</button>
						</div>
					</div>
					</div>
				</div>';

	$output .= '<div class="modal fade" id="create_widgets_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">' . esc_html__( 'Create Widgets', 'wpst' ) . '</h4>
						</div>
						<div class="modal-body">' . esc_html__( 'This action will integrate video block widgets in your admin.', 'wpst' ) . '</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">' . esc_html__( 'Close', 'wpst' ) . '</button>
						<button type="button" class="btn btn-primary">' . esc_html__( 'Confirm', 'wpst' ) . '</button>
						</div>
					</div>
					</div>
				</div>';
	return $output;
}

add_action( 'xbox_init', 'wpst_options' );
/**
 * Set WPST options.
 * xbox_init action callback to define all the theme Xbox options.
 *
 * @return void
 */
function wpst_options() {
	$icon_slug = wp_get_theme()->get( 'Template' )
		? strtolower( wp_get_theme()->get( 'Template' ) )
		: strtolower( wp_get_theme()->get( 'Name' ) );

	$options = array(
		'id'         => 'wpst-options',
		'title'      => esc_html__( 'Theme Options', 'wpst' ),
		'menu_title' => esc_html__( 'Theme Options', 'wpst' ),
		'skin'       => 'pink',
		'layout'     => 'boxed',
		'header'     => array(
			'name' => '<img src="https://www.wp-script.com/wp-content/uploads/wps-img/products/themes/icons/' . $icon_slug . '-icon.svg" width="20"> ' . wp_get_theme()->get( 'Name' ),
		),
		'capability' => 'edit_published_posts',
	);

	$xbox = xbox_new_admin_page( $options );

	$xbox->add_main_tab(
		array(
			'name'  => esc_html__( 'Main tab', 'wpst' ),
			'id'    => 'main-tab',
			'items' => array(
				'niches'         => '<i class="xbox-icon xbox-icon-star"></i>' . esc_html__( 'Niches', 'wpst' ),
				'general'        => '<i class="xbox-icon xbox-icon-gear"></i>' . esc_html__( 'General', 'wpst' ),
				'visual-options' => '<i class="xbox-icon xbox-icon-desktop"></i>' . esc_html__( 'Visual options', 'wpst' ),
				'logo'           => '<i class="xbox-icon xbox-icon-image"></i>' . esc_html__( 'Logo & Favicon', 'wpst' ),
				'header'         => '<i class="xbox-icon xbox-icon-arrow-up"></i>' . esc_html__( 'Header', 'wpst' ),
				'content'        => '<i class="xbox-icon xbox-icon-th-large"></i>' . esc_html__( 'Content', 'wpst' ),
				'sidebar'        => '<i class="xbox-icon xbox-icon-columns"></i>' . esc_html__( 'Sidebar', 'wpst' ),
				'footer'         => '<i class="xbox-icon xbox-icon-arrow-down"></i>' . esc_html__( 'Footer', 'wpst' ),
				'membership'     => '<i class="xbox-icon xbox-icon-user"></i>' . esc_html__( 'Membership', 'wpst' ),
				'advertising'    => '<i class="xbox-icon xbox-icon-money"></i>' . esc_html__( 'Advertising', 'wpst' ),
				'blog'           => '<i class="xbox-icon xbox-icon-list-alt"></i>' . esc_html__( 'Blog', 'wpst' ),
				'code'           => '<i class="xbox-icon xbox-icon-pencil"></i>' . esc_html__( 'Code', 'wpst' ),
				'tools'          => '<i class="xbox-icon xbox-icon-wrench"></i>' . esc_html__( 'Tools', 'wpst' ),
				'mobile'         => '<i class="xbox-icon xbox-icon-mobile"></i>' . esc_html__( 'Mobile', 'wpst' ),
				'export'         => '<i class="xbox-icon xbox-icon-database"></i>' . esc_html__( 'Export', 'wpst' ),
			),
		)
	);

		/**
		 * NICHES
		 */
		$xbox->open_tab_item( 'niches' );
			$xbox->add_import_field(
				array(
					'name'    => 'Select a Niche',
					'default' => 'https://www.wp-script.com/niches-data/gay.json',
					'desc'    =>
						esc_html__( 'Select a Niche image to import options from a niche. Then click on the Import button.', 'wpst' ) .
						'<br>' .
						esc_html__( 'Theme options will be imported in order to change the appearance of your site.', 'wpst' ) .
						'<br>- ' . esc_html__( 'or', 'wpst' ) . ' -<br>' .
						esc_html__( 'Select "From file" to import options from a json backup file. Then click on the Import button.', 'wpst' ) .
						'<br>' .
						esc_html__( 'You can export a json backup file in the Export section of this theme options.', 'wpst' ),
					'items'   => array(
						'https://www.wp-script.com/niches-data/gay.json'       => get_template_directory_uri() . '/admin/assets/img/theme-options/niches/gay.png',
						'https://www.wp-script.com/niches-data/milf.json'      => get_template_directory_uri() . '/admin/assets/img/theme-options/niches/milf.png',
						'https://www.wp-script.com/niches-data/college.json'   => get_template_directory_uri() . '/admin/assets/img/theme-options/niches/college.png',
						'https://www.wp-script.com/niches-data/hentai.json'    => get_template_directory_uri() . '/admin/assets/img/theme-options/niches/hentai.png',
						'https://www.wp-script.com/niches-data/livexcams.json' => get_template_directory_uri() . '/admin/assets/img/theme-options/niches/livexcams.png',
						'https://www.wp-script.com/niches-data/lesbian.json'   => get_template_directory_uri() . '/admin/assets/img/theme-options/niches/lesbian.png',
						'https://www.wp-script.com/niches-data/trans.json'     => get_template_directory_uri() . '/admin/assets/img/theme-options/niches/trans.png',
						'https://www.wp-script.com/niches-data/filf.json'      => get_template_directory_uri() . '/admin/assets/img/theme-options/niches/filf.png',
					),
					'options' => array(
						'import_from_file' => true, // Hide import from file.
						'import_from_url'  => false, // Hide import from url.
						'width'            => '300px',
					),
				)
			);
		$xbox->close_tab_item( 'niches' );

		/**
		 * GENERAL
		 */
		$xbox->open_tab_item( 'general' );
			$xbox->add_field(
				array(
					'id'      => 'videos-per-page',
					'name'    => esc_html__( 'Number of videos per page', 'wpst' ),
					'type'    => 'number',
					'default' => 28,
					'grid'    => '2-of-8',
					'options' => array(
						'unit' => esc_html__( 'videos', 'wpst' ),
					),
					'desc'    => '<img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/videos-per-page.jpg">',
				)
			);
			$xbox->add_field(
				array(
					'id'         => 'videos-per-row',
					'name'       => esc_html__( 'Number of videos per row', 'wpst' ),
					'type'       => 'number',
					'default'    => 4,
					'grid'       => '2-of-8',
					'options'    => array(
						'unit' => esc_html__( 'videos', 'wpst' ),
					),
					'attributes' => array(
						'min'       => 2,
						'max'       => 6,
						'step'      => 1,
						'precision' => 0,
					),
					'desc'       => '<img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/videos-per-row.jpg">',
				)
			);
			$xbox->add_field(
				array(
					'id'      => 'show-videos-homepage',
					'name'    => esc_html__( 'Show', 'wpst' ),
					'type'    => 'radio',
					'default' => 'latest',
					'items'   => array(
						'latest'      => esc_html__( 'Latest videos', 'wpst' ),
						'most-viewed' => esc_html__( 'Most viewed videos', 'wpst' ),
						'longest'     => esc_html__( 'Longest videos', 'wpst' ),
						'popular'     => esc_html__( 'Popular videos', 'wpst' ),
						'random'      => esc_html__( 'Random videos', 'wpst' ),
					),
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Aspect ratios of thumbnails', 'wpst' ),
					'id'      => 'thumbnails-ratio',
					'type'    => 'radio',
					'desc'    => esc_html__( 'Choose the aspect ratios for all thumbnails.', 'wpst' ),
					'default' => '16/9',
					'items'   => array(
						'16/9'    => '16:9',
						'4/3'     => '4:3',
						'135/170' => 'DVD / Blu-ray',
						'9/16'    => '9:16',
						'1/1'     => esc_html__( 'Square', 'wpst' ),
					),
				)
			);

			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Object fit of thumbnails', 'wpst' ),
					'id'      => 'thumbnails-fit',
					'type'    => 'radio',
					'desc'    => esc_html__( 'Choose how the thumbnails should be resized to fit its container.', 'wpst' ),
					'default' => 'Contain',
					'items'   => array(
						'contain' => 'Contain',
						'cover'   => 'Cover',
						'fill'    => 'Fill',
					),
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Main thumbnail quality', 'wpst' ),
					'id'      => 'main-thumbnail-quality',
					'type'    => 'radio',
					'desc'    => esc_html__( 'Basic = High compression, Normal = Medium compression, Fine = Low compression', 'wpst' ),
					'default' => 'wpst_thumb_medium',
					'items'   => array(
						'wpst_thumb_small'  => 'Basic',
						'wpst_thumb_medium' => 'Normal',
						'wpst_thumb_large'  => 'Fine',
					),
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Enable thumbnails rotation', 'wpst' ),
					'id'      => 'enable-thumbnails-rotation',
					'type'    => 'switcher',
					'desc'    => esc_html__( 'Enable thumbnails rotation to see a preview of the video on mouseover.', 'wpst' ),
					'default' => 'on',
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Enable views system', 'wpst' ),
					'id'      => 'enable-views-system',
					'type'    => 'switcher',
					'desc'    => esc_html__( 'Display number of views on thumbnails, under the video player and add a "Most viewed videos" filter.', 'wpst' ),
					'default' => 'on',
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Enable duration system', 'wpst' ),
					'id'      => 'enable-duration-system',
					'type'    => 'switcher',
					'desc'    => esc_html__( 'Display duration on thumbnails, and add a "Longest videos" filter.', 'wpst' ),
					'default' => 'on',
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Enable rating system', 'wpst' ),
					'id'      => 'enable-rating-system',
					'type'    => 'switcher',
					'desc'    => esc_html__( 'Display a rating bar with percentage under thumbnails, a rating system under the video player, and add a "Popular videos" filter.', 'wpst' ),
					'default' => 'on',
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Enable breadcrumbs', 'wpst' ),
					'id'      => 'enable-breadcrumbs',
					'type'    => 'switcher',
					'desc'    => esc_html__( 'Display a breadcrumb at the top of each pages of your site to allow your visitors to navigate more easily.', 'wpst' ),
					'default' => 'on',
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Enable comments', 'wpst' ),
					'id'      => 'enable-comments',
					'type'    => 'switcher',
					'desc'    => esc_html__( 'Display a comments section in your single video pages.', 'wpst' ),
					'default' => 'on',
				)
			);
		$xbox->close_tab_item( 'general' );

		/**
		 * VISUAL OPTIONS
		 */
		$xbox->open_tab_item( 'visual-options' );
			$xbox->add_field(
				array(
					'name'       => esc_html__( 'Layout', 'wpst' ),
					'id'         => 'layout',
					'type'       => 'image_selector',
					'default'    => 'full-width',
					'items'      => array(
						'boxed'      => get_template_directory_uri() . '/admin/assets/img/theme-options/layout-boxed.jpg',
						'full-width' => get_template_directory_uri() . '/admin/assets/img/theme-options/layout-full-width.jpg',
					),
					'items_desc' => array(
						'boxed'      => esc_html__( 'Boxed', 'wpst' ),
						'full-width' => esc_html__( 'Full Width', 'wpst' ),
					),
					'options'    => array(
						'width'   => '160px',
						'in_line' => true,
					),
				)
			);
			$xbox->add_field(
				array(
					'id'      => 'main-color',
					'name'    => esc_html__( 'Main color', 'wpst' ),
					'type'    => 'colorpicker',
					'default' => '#FF3565',
					'grid'    => '2-of-8',
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Rendering', 'wpst' ),
					'id'      => 'rendering',
					'type'    => 'radio',
					'desc'    => esc_html__( 'Display gradient and shadow on navigation, button, input, etc.', 'wpst' ),
					'default' => 'gradient',
					'items'   => array(
						'flat'     => 'Flat',
						'gradient' => 'Gradient',
					),
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Custom background', 'wpst' ),
					'id'      => 'custom-background',
					'type'    => 'switcher',
					'default' => 'off',
				)
			);
			/* If on */
			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:custom-background:on:background-settings',
					'name' => esc_html__( 'Background settings', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'name'      => esc_html__( 'Image', 'wpst' ),
						'id'        => 'background-niche-image',
						'type'      => 'text',
						'row_class' => 'hidden',
						'grid'      => '6-of-6',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Image', 'wpst' ),
						'id'      => 'background-image',
						'type'    => 'file',
						'grid'    => '6-of-6',
						'options' => array(
							'preview_size' => array(
								'width'  => '37px',
								'height' => 'auto',
							),
						),
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Color', 'wpst' ),
						'id'      => 'background-color',
						'type'    => 'colorpicker',
						'default' => '#181818',
						'grid'    => '2-of-6',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Repeat', 'wpst' ),
						'id'      => 'background-repeat',
						'type'    => 'select',
						'default' => 'repeat',
						'items'   => array(
							'repeat'    => 'Yes',
							'no-repeat' => 'No',
						),
						'grid'    => '2-of-6',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Attachment', 'wpst' ),
						'id'      => 'background-attachment',
						'type'    => 'select',
						'default' => 'fixed',
						'items'   => array(
							'fixed'  => 'Fixed',
							'scroll' => 'Scroll',
						),
						'grid'    => '2-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Position', 'wpst' ),
						'id'      => 'background-position',
						'type'    => 'select',
						'default' => 'center',
						'items'   => array(
							'bottom' => 'Bottom',
							'center' => 'Center',
							'top'    => 'Top',
						),
						'grid'    => '2-of-6',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Size', 'wpst' ),
						'id'      => 'background-size',
						'type'    => 'select',
						'default' => 'auto',
						'items'   => array(
							'auto'    => 'Auto',
							'contain' => 'Contain',
							'cover'   => 'Cover',
						),
						'grid'    => '2-of-6 last',
					)
				);
			$xbox->close_mixed_field();
		$xbox->close_tab_item( 'visual-options' );

		/**
		 * LOGO & FAVICON
		 */
		$xbox->open_tab_item( 'logo' );
			$xbox->add_field(
				array(
					'id'      => 'use-logo-image',
					'name'    => esc_html__( 'Use logo image', 'wpst' ),
					'type'    => 'switcher',
					'default' => 'off',
				)
			);

			// If icon-text-logo.
			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:use-logo-image:off:icon-logo',
					'name' => esc_html__( 'Icon logo settings', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Icon logo', 'wpst' ),
						'id'      => 'icon-logo',
						'type'    => 'select',
						'items'   => XboxItems::icons(),
						'options' => array(
							'search' => true,
						),
						'default' => 'play-circle',
						'grid'    => '3-of-6',
					)
				);
			$xbox->close_mixed_field();

			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:use-logo-image:off:text-logo',
					'name' => esc_html__( 'Text logo settings', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'id'   => 'text-logo',
						'name' => esc_html__( 'Text logo', 'wpst' ),
						'type' => 'text',
						'grid' => '6-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'      => 'logo-font-family',
						'name'    => esc_html__( 'Font family', 'wpst' ),
						'type'    => 'select',
						'default' => 'Open Sans',
						'items'   => array(
							'Google Fonts'   => XboxItems::google_fonts(),
							'Web Safe Fonts' => XboxItems::web_safe_fonts(),
						),
						'options' => array(
							'sort'   => 'asc',
							'search' => true,
						),
						'grid'    => '3-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'      => 'logo-font-size',
						'name'    => esc_html__( 'Font size', 'wpst' ),
						'type'    => 'number',
						'default' => 36,
						'grid'    => '3-of-6 last',
						'options' => array(
							'unit' => 'px',
						),
					)
				);
			$xbox->close_mixed_field();

			/***** Else image-logo */
			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:use-logo-image:on:image-logo-file',
					'name' => esc_html__( 'Image logo file', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'id'        => 'niche-image-logo-file',
						'name'      => esc_html__( 'Image logo', 'wpst' ),
						'type'      => 'text',
						'grid'      => '6-of-6',
						'row_class' => 'hidden',
					)
				);
				$xbox->add_field(
					array(
						'id'      => 'image-logo-file',
						'name'    => esc_html__( 'Image logo', 'wpst' ),
						'type'    => 'file',
						'grid'    => '6-of-6 last',
						'options' => array(
							'preview_size' => array(
								'width'  => '100px',
								'height' => 'auto',
							),
						),
					)
				);
			$xbox->close_mixed_field();

			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:use-logo-image:on:logo-max-width',
					'name' => esc_html__( 'Image logo settings', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'name'       => esc_html__( 'Max width', 'wpst' ),
						'id'         => 'logo-max-width',
						'type'       => 'number',
						'default'    => 300,
						'grid'       => '3-of-6',
						'attributes' => array(
							'min'       => 0,
							'max'       => 350,
							'step'      => 1,
							'precision' => 0,
						),
					)
				);
				$xbox->add_field(
					array(
						'name'       => esc_html__( 'Max height', 'wpst' ),
						'id'         => 'logo-max-height',
						'type'       => 'number',
						'default'    => 120,
						'grid'       => '3-of-6 last',
						'attributes' => array(
							'min'       => 0,
							'max'       => 120,
							'step'      => 1,
							'precision' => 0,
						),
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Margin top', 'wpst' ),
						'id'      => 'logo-margin-top',
						'type'    => 'number',
						'default' => 0,
						'grid'    => '3-of-6',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Margin left', 'wpst' ),
						'id'      => 'logo-margin-left',
						'type'    => 'number',
						'default' => 0,
						'grid'    => '3-of-6 last',
					)
				);
			$xbox->close_mixed_field();

			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Show text slogan', 'wpst' ),
					'id'      => 'show-text-slogan',
					'type'    => 'switcher',
					'default' => 'on',
				)
			);

			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:show-text-slogan:on:text-slogan',
					'name' => esc_html__( 'Text slogan', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'id'   => 'text-slogan',
						'name' => esc_html__( 'Text slogan', 'wpst' ),
						'type' => 'text',
						'grid' => '6-of-6 last',
					)
				);
			$xbox->close_mixed_field();

			$xbox->add_field(
				array(
					'id'        => 'niche-favicon',
					'name'      => esc_html__( 'Favicon', 'wpst' ),
					'type'      => 'text',
					'grid'      => '6-of-6',
					'row_class' => 'hidden',
				)
			);

			$xbox->add_field(
				array(
					'id'      => 'favicon',
					'name'    => esc_html__( 'Favicon', 'wpst' ),
					'type'    => 'file',
					'grid'    => '6-of-6',
					'options' => array(
						'preview_size' => array(
							'width'  => '32px',
							'height' => 'auto',
						),
					),
				)
			);
		$xbox->close_tab_item( 'logo' );

		/**
		 * HEADER
		 */
		$xbox->open_tab_item( 'header' );
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Show social profiles', 'wpst' ),
					'id'      => 'show-social-profiles',
					'type'    => 'switcher',
					'default' => 'off',
				)
			);

			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:show-social-profiles:on:social-profiles-text',
					'name' => esc_html__( 'Text before icons', 'wpst' ),
				)
			);

				$xbox->add_field(
					array(
						'id'      => 'social-profiles-text',
						'name'    => esc_html__( 'Text before social profiles icons', 'wpst' ),
						'type'    => 'text',
						'default' => 'Follow us:',
						'grid'    => '4-of-6 last',
					)
				);

			$xbox->close_mixed_field();

			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:show-social-profiles:on:social-profiles',
					'name' => esc_html__( 'Your social profiles', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'id'   => 'facebook-profile',
						'name' => esc_html__( 'Facebook', 'wpst' ),
						'type' => 'text',
						'grid' => '3-of-6',
					)
				);
				$xbox->add_field(
					array(
						'id'   => 'google-plus-profile',
						'name' => esc_html__( 'Google Plus', 'wpst' ),
						'type' => 'text',
						'grid' => '3-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'   => 'instagram-profile',
						'name' => esc_html__( 'Instagram', 'wpst' ),
						'type' => 'text',
						'grid' => '3-of-6',
					)
				);
				$xbox->add_field(
					array(
						'id'   => 'reddit-profile',
						'name' => esc_html__( 'Reddit', 'wpst' ),
						'type' => 'text',
						'grid' => '3-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'   => 'tumblr-profile',
						'name' => esc_html__( 'Tumblr', 'wpst' ),
						'type' => 'text',
						'grid' => '3-of-6',
					)
				);
				$xbox->add_field(
					array(
						'id'   => 'twitter-profile',
						'name' => esc_html__( 'Twitter', 'wpst' ),
						'type' => 'text',
						'grid' => '3-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'   => 'youtube-profile',
						'name' => esc_html__( 'Youtube', 'wpst' ),
						'type' => 'text',
						'grid' => '3-of-6',
					)
				);
			$xbox->close_mixed_field();

			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Show search bar', 'wpst' ),
					'id'      => 'show-search-bar',
					'type'    => 'switcher',
					'default' => 'on',
				)
			);
		$xbox->close_tab_item( 'header' );

		/**
		 * CONTENT
		 */
		$xbox->open_tab_item( 'content' );
			$xbox->add_tab(
				array(
					'name'  => esc_html__( 'Content tabs', 'wpst' ),
					'id'    => 'content-tabs',
					'items' => array(
						'content-homepage'        => '<i class="xbox-icon xbox-icon-home"></i>' . esc_html__( 'Homepage', 'wpst' ),
						'content-video-page'      => '<i class="xbox-icon xbox-icon-play"></i>' . esc_html__( 'Video single post', 'wpst' ),
						'content-categories-page' => '<i class="xbox-icon xbox-icon-folder"></i>' . esc_html__( 'Categories', 'wpst' ),
						'content-tags-page'       => '<i class="xbox-icon xbox-icon-tag"></i>' . esc_html__( 'Tags', 'wpst' ),
						'content-actors-page'     => '<i class="xbox-icon xbox-icon-users"></i>' . esc_html__( 'Actors', 'wpst' ),
					),
				)
			);
				$xbox->open_tab_item( 'content-homepage' );
					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Show carousel of videos', 'wpst' ),
							'id'      => 'show-videos-carousel',
							'type'    => 'switcher',
							'default' => 'on',
							'desc'    => esc_html__( 'Will display featured videos.', 'wpst' ),
							'grid'    => '2-of-8',
						)
					);
					$xbox->open_mixed_field(
						array(
							'id'   => 'displayed-when:switch:show-videos-carousel:on:videos-carousel-settings',
							'name' => esc_html__( 'Carousel settings', 'wpst' ),
						)
					);
						$xbox->add_field(
							array(
								'name'       => esc_html__( 'Videos amount', 'wpst' ),
								'id'         => 'videos-carousel-amount',
								'type'       => 'number',
								'options'    => array(
									'unit' => 'videos',
								),
								'attributes' => array(
									'min'       => 10,
									'max'       => 40,
									'step'      => 1,
									'precision' => 0,
								),
								'desc'       => esc_html__( 'The number of videos displayed in the carousel', 'wpst' ) . '(10 - 40)',
								'default'    => '10',
								'grid'       => '4-of-6 last',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Show video title', 'wpst' ),
								'id'      => 'videos-carousel-show-title',
								'type'    => 'switcher',
								'default' => 'on',
								'desc'    => esc_html__( 'Video title will be displayed as caption over the thumbnail.', 'wpst' ),
								'grid'    => '4-of-6 last',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Autoplay', 'wpst' ),
								'id'      => 'videos-carousel-auto-play',
								'type'    => 'switcher',
								'default' => 'off',
								'desc'    => esc_html__( 'Autoplay will pause when mouse hovers over carousel.', 'wpst' ),
								'grid'    => '4-of-6 last',
							)
						);
					$xbox->close_mixed_field();

					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Show carousel on mobile', 'wpst' ),
							'id'      => 'show-videos-carousel-mobile',
							'type'    => 'switcher',
							'default' => 'on',
							'desc'    => esc_html__( 'Will display featured videos on mobile devices.', 'wpst' ),
							'grid'    => '2-of-8',
						)
					);

					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Show sidebar', 'wpst' ),
							'id'      => 'show-sidebar-homepage',
							'type'    => 'switcher',
							'default' => 'on',
							'grid'    => '2-of-8',
							// translators: %s: Admin URL.
							'desc'    => sprintf( __( '<a href="%s">Click here</a> to manage your sidebar with widgets.', 'wpst' ), get_admin_url() . 'widgets.php' ),
						)
					);

					$xbox->add_field(
						array(
							'name' => esc_html__( 'Title', 'wpst' ),
							'id'   => 'homepage-title',
							'type' => 'text',
							'grid' => '4-of-6 last',
							'desc' => 'Enter a title (h1) to improve your SEO.',
						)
					);

					$xbox->add_field(
						array(
							'name' => esc_html__( 'Text for SEO', 'wpst' ),
							'id'   => 'seo-footer-text',
							'type' => 'textarea',
							'grid' => '4-of-6 last',
							'desc' => 'Enter a description of your site to improve your SEO.',
						)
					);

					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Title and description position', 'wpst' ),
							'id'      => 'homepage-title-desc-position',
							'type'    => 'radio',
							'desc'    => esc_html__( 'Choose if you want to display the title and description at the top or the bottom of your homepage.', 'wpst' ),
							'default' => 'bottom',
							'items'   => array(
								'top'    => 'Top',
								'bottom' => 'Bottom',
							),
						)
					);

					$xbox->add_field(
						array(
							'id'   => 'video-block-homepage',
							'name' => esc_html__( 'Video blocks', 'wpst' ),
							'type' => 'title',
							// translators: %s: Admin URL.
							'desc' => sprintf( __( '<a href="%s">Click here</a> to use video blocks instead of a videos listing.', 'wpst' ), get_admin_url() . 'widgets.php' ),
						)
					);
				$xbox->close_tab_item( 'content-homepage' );

				$xbox->open_tab_item( 'content-video-page' );
					/* Sidebar on video page */
					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Show sidebar', 'wpst' ),
							'id'      => 'show-sidebar-video-page',
							'type'    => 'switcher',
							'default' => 'on',
							'grid'    => '2-of-8',
							// translators: %s: Admin URL.
							'desc'    => sprintf( __( '<a href="%s">Click here</a> to manage your sidebar with widgets.', 'wpst' ), get_admin_url() . 'widgets.php' ),
						)
					);

					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Display tracking button', 'wpst' ),
							'id'      => 'display-tracking-button',
							'type'    => 'switcher',
							'default' => 'on',
							'grid'    => '2-of-8',
							'desc'    => esc_html__( 'Display a button with your tracking link under the video player.', 'wpst' ),
						)
					);

					$xbox->open_mixed_field(
						array(
							'id'   => 'displayed-when:switch:display-tracking-button:on:tracking-button-settings',
							'name' => esc_html__( 'Tracking button settings', 'wpst' ),
						)
					);

						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Icon button', 'wpst' ),
								'id'      => 'tracking-button-icon',
								'type'    => 'select',
								'items'   => XboxItems::icons(),
								'options' => array(
									'search' => true,
								),
								'default' => 'download',
								'grid'    => '4-of-6 last',
							)
						);

						$xbox->add_field(
							array(
								'id'   => 'tracking-button-link',
								'name' => esc_html__( 'Tracking button link', 'wpst' ),
								'type' => 'text',
								'grid' => '4-of-6 last',
								'desc' => esc_html__( 'Use the same link for every tracking buttons.', 'wpst' ),
							)
						);

						$xbox->add_field(
							array(
								'id'      => 'tracking-button-text',
								'name'    => esc_html__( 'Tracking button text', 'wpst' ),
								'type'    => 'text',
								'default' => 'Download complete video now!',
								'grid'    => '4-of-6 last',
								'desc'    => esc_html__( 'Change the text of the tracking button.', 'wpst' ),
							)
						);
					$xbox->close_mixed_field();

					$xbox->open_mixed_field(
						array( 'name' => esc_html__( 'Video about', 'wpst' ) )
					);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Show description', 'wpst' ),
								'id'      => 'show-description-video-about',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Show author', 'wpst' ),
								'id'      => 'show-author-video-about',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Show publish date', 'wpst' ),
								'id'      => 'show-publish-date-video-about',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6 last',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Show actors', 'wpst' ),
								'id'      => 'show-actors-video-about',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Show categories', 'wpst' ),
								'id'      => 'show-categories-video-about',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Show tags', 'wpst' ),
								'id'      => 'show-tags-video-about',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6 last',
							)
						);
					$xbox->close_mixed_field();

					$xbox->open_mixed_field(
						array(
							'id'   => 'displayed-when:switch:show-description-video-about:on:show-more-settings',
							'name' => esc_html__( 'Show more settings', 'wpst' ),
						)
					);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Truncate description', 'wpst' ),
								'id'      => 'truncate-description',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '4-of-6 last',
								'desc'    => esc_html__( 'Display a show more link under the description.', 'wpst' ),
							)
						);
					$xbox->close_mixed_field();

					$xbox->open_mixed_field(
						array(
							'id'   => 'displayed-when:switch:show-actors-video-about:on:show-actors-settings',
							'name' => esc_html__( 'Actors label', 'wpst' ),
						)
					);
						$xbox->add_field(
							array(
								'id'      => 'actors-video-label',
								'name'    => esc_html__( 'Actors label', 'wpst' ),
								'type'    => 'text',
								'grid'    => '4-of-6 last',
								'default' => 'Actors',
								'desc'    => esc_html__( 'Change the text of the actor label', 'wpst' ),
							)
						);
					$xbox->close_mixed_field();

					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Video share', 'wpst' ),
							'id'      => 'enable-video-share',
							'type'    => 'switcher',
							'default' => 'on',
							'desc'    => esc_html__( 'Display a "Share" tab with social networks sharing buttons.', 'wpst' ),
						)
					);

					/* If video share is On */
					$xbox->open_mixed_field(
						array(
							'id'   => 'displayed-when:switch:enable-video-share:on:video-share-settings',
							'name' => esc_html__( 'Video share settings', 'wpst' ),
						)
					);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Facebook', 'wpst' ),
								'id'      => 'facebook-video-share',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Twitter', 'wpst' ),
								'id'      => 'twitter-video-share',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Google Plus', 'wpst' ),
								'id'      => 'google-plus-video-share',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6 last',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Linkedin', 'wpst' ),
								'id'      => 'linkedin-video-share',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Tumblr', 'wpst' ),
								'id'      => 'tumblr-video-share',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Reddit', 'wpst' ),
								'id'      => 'reddit-video-share',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6 last',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Odnoklassniki', 'wpst' ),
								'id'      => 'odnoklassniki-video-share',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'VK', 'wpst' ),
								'id'      => 'vk-video-share',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6',
							)
						);
						$xbox->add_field(
							array(
								'name'    => esc_html__( 'Email', 'wpst' ),
								'id'      => 'email-video-share',
								'type'    => 'switcher',
								'default' => 'on',
								'grid'    => '2-of-6 last',
							)
						);
					$xbox->close_mixed_field();
					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Display related videos', 'wpst' ),
							'id'      => 'display-related-videos',
							'type'    => 'switcher',
							'default' => 'on',
							'desc'    => 'Display related videos under the video infos.',
						)
					);
					$xbox->open_mixed_field(
						array(
							'id'   => 'displayed-when:switch:display-related-videos:on:related-videos-settings',
							'name' => esc_html__( 'Related videos settings', 'wpst' ),
						)
					);
						$xbox->add_field(
							array(
								'id'      => 'related-videos-number',
								'name'    => esc_html__( 'Number of related videos', 'wpst' ),
								'type'    => 'number',
								'default' => 8,
								'grid'    => '4-of-6 last',
								'options' => array(
									'unit' => 'videos',
								),
							)
						);
					$xbox->close_mixed_field();
				$xbox->close_tab_item( 'content-video-page' );

				// Categories.
				$xbox->open_tab_item( 'content-categories-page' );
					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Show sidebar', 'wpst' ),
							'id'      => 'show-sidebar-categories-page',
							'type'    => 'switcher',
							'default' => 'on',
							'grid'    => '2-of-8',
							// translators: %s: Admin URL.
							'desc'    => sprintf( __( '<a href="%s">Click here</a> to manage your sidebar with widgets.', 'wpst' ), get_admin_url() . 'widgets.php' ),
						)
					);
					$xbox->add_field(
						array(
							'id'         => 'categories-per-page',
							'name'       => esc_html__( 'Number of categories per page', 'wpst' ),
							'type'       => 'number',
							'default'    => 20,
							'options'    => array(
								'unit' => 'Categories',
							),
							'attributes' => array(
								'min'       => 1,
								'step'      => 1,
								'precision' => 0,
							),
						)
					);
					$xbox->add_field(
						array(
							'id'         => 'categories-per-row',
							'name'       => esc_html__( 'Number of categories per row', 'wpst' ),
							'type'       => 'number',
							'default'    => 3,
							'options'    => array(
								'unit' => esc_html__( 'videos', 'wpst' ),
							),
							'attributes' => array(
								'min'       => 2,
								'max'       => 6,
								'step'      => 1,
								'precision' => 0,
							),
							'desc'       => '<img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/videos-per-row.jpg">',
						)
					);
					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Categories thumbnail quality', 'wpst' ),
							'id'      => 'categories-thumbnail-quality',
							'type'    => 'radio',
							'desc'    => esc_html__( 'Basic = High compression, Normal = Medium compression, Fine = Low compression', 'wpst' ),
							'default' => 'wpst_thumb_large',
							'items'   => array(
								'wpst_thumb_small'  => 'Basic',
								'wpst_thumb_medium' => 'Normal',
								'wpst_thumb_large'  => 'Fine',
							),
						)
					);
					$xbox->add_field(
						array(
							'id'         => 'videos-per-category-page',
							'name'       => esc_html__( 'Number of videos per page', 'wpst' ),
							'type'       => 'number',
							'default'    => 20,
							'options'    => array(
								'unit' => 'Videos',
							),
							'attributes' => array(
								'min'       => 1,
								'step'      => 1,
								'precision' => 0,
							),
							'desc'       => '<img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/videos-per-page.jpg">',
						)
					);
					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Category description position', 'wpst' ),
							'id'      => 'cat-desc-position',
							'type'    => 'radio',
							'desc'    => esc_html__( 'Choose if you want to display the category description at the top or the bottom of category page.', 'wpst' ),
							'default' => 'top',
							'items'   => array(
								'top'    => 'Top',
								'bottom' => 'Bottom',
							),
						)
					);
				$xbox->close_tab_item( 'content-categories-page' );

				$xbox->open_tab_item( 'content-tags-page' );
					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Tag description position', 'wpst' ),
							'id'      => 'tag-desc-position',
							'type'    => 'radio',
							'desc'    => esc_html__( 'Choose if you want to display the tag description at the top or the bottom of tag page.', 'wpst' ),
							'default' => 'top',
							'items'   => array(
								'top'    => 'Top',
								'bottom' => 'Bottom',
							),
						)
					);
				$xbox->close_tab_item( 'content-tags-page' );

				$xbox->open_tab_item( 'content-actors-page' );
					$xbox->add_field(
						array(
							'id'         => 'actors-per-page',
							'name'       => esc_html__( 'Number of actors per page', 'wpst' ),
							'type'       => 'number',
							'default'    => 20,
							'grid'       => '4-of-6 last',
							'options'    => array(
								'unit' => 'Actors',
							),
							'attributes' => array(
								'min'       => 1,
								'step'      => 1,
								'precision' => 0,
							),
						)
					);
				$xbox->close_tab_item( 'content-actors-page' );
			$xbox->close_tab( 'content-tabs' );
		$xbox->close_tab_item( 'content' );

		/**
		 * SIDEBAR
		 */
		$xbox->open_tab_item( 'sidebar' );
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Show sidebar', 'wpst' ),
					'id'      => 'show-sidebar',
					'type'    => 'switcher',
					'default' => 'on',
					'grid'    => '2-of-8',
					// translators: %s: Admin URL.
					'desc'    => sprintf( __( '<a href="%s">Click here</a> to manage your sidebar with widgets.', 'wpst' ), get_admin_url() . 'widgets.php' ),
				)
			);

			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:show-sidebar:on:sidebar-settings',
					'name' => esc_html__( 'Sidebar settings', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'name'       => esc_html__( 'Sidebar position', 'wpst' ),
						'id'         => 'sidebar-position',
						'type'       => 'image_selector',
						'default'    => 'sidebar-right',
						'items'      => array(
							'sidebar-left'  => get_template_directory_uri() . '/admin/assets/img/theme-options/sidebar-left.jpg',
							'sidebar-right' => get_template_directory_uri() . '/admin/assets/img/theme-options/sidebar-right.jpg',
						),
						'items_desc' => array(
							'sidebar-left'  => esc_html__( 'Left', 'wpst' ),
							'sidebar-right' => esc_html__( 'Right', 'wpst' ),
						),
						'options'    => array(
							'width'   => '160px',
							'in_line' => true,
						),
					)
				);
			$xbox->close_mixed_field();
		$xbox->close_tab_item( 'sidebar' );

		/**
		 * FOOTER
		 */
		$xbox->open_tab_item( 'footer' );
			$xbox->add_field(
				array(
					'id'         => 'footer-columns',
					'name'       => esc_html__( 'Footer columns', 'wpst' ),
					'type'       => 'image_selector',
					'default'    => 'four-columns-footer',
					// translators: %s: Admin URL.
					'desc'       => sprintf( __( '<a href="%s">Click here</a> to manage your footer with widgets.', 'wpst' ), get_admin_url() . 'widgets.php' ),
					'items'      => array(
						'one-column-footer'    => get_template_directory_uri() . '/admin/assets/img/theme-options/footer-1-column.jpg',
						'two-columns-footer'   => get_template_directory_uri() . '/admin/assets/img/theme-options/footer-2-columns.jpg',
						'three-columns-footer' => get_template_directory_uri() . '/admin/assets/img/theme-options/footer-3-columns.jpg',
						'four-columns-footer'  => get_template_directory_uri() . '/admin/assets/img/theme-options/footer-4-columns.jpg',
					),
					'items_desc' => array(
						'one-column-footer'    => '1 ' . esc_html__( 'column', 'wpst' ),
						'two-columns-footer'   => '2 ' . esc_html__( 'columns', 'wpst' ),
						'three-columns-footer' => '3 ' . esc_html__( 'columns', 'wpst' ),
						'four-columns-footer'  => '4 ' . esc_html__( 'columns', 'wpst' ),
					),
					'options'    => array(
						'width'   => '160px',
						'in_line' => true,
					),
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Logo', 'wpst' ),
					'id'      => 'logo-footer',
					'type'    => 'switcher',
					'default' => 'off',
					'desc'    => esc_html__( 'Turn on to display your logo in the footer. It will use the logo image you set in the Logo & Favicon section.', 'wpst' ),
				)
			);
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Copyright bar', 'wpst' ),
					'id'      => 'copyright-bar',
					'type'    => 'switcher',
					'default' => 'on',
					'desc'    => esc_html__( 'Turn on to display the copyright bar.', 'wpst' ),
				)
			);
			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:copyright-bar:on:copyright-settings',
					'name' => esc_html__( 'Copyright settings', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Copyright text', 'wpst' ),
						'id'      => 'copyright-text',
						'type'    => 'textarea',
						'grid'    => '6-of-6 last',
						'default' => esc_html__( 'All rights reserved. Powered by', 'wpst' ) . ' WP-Script.com',
						'desc'    => esc_html__( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'wpst' ),
					)
				);
			$xbox->close_mixed_field();
		$xbox->close_tab_item( 'footer' );

		/**
		 * MEMBERSHIP
		 */
		$xbox->open_tab_item( 'membership' );
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Enable membership', 'wpst' ),
					'id'      => 'enable-membership',
					'type'    => 'switcher',
					'desc'    => esc_html__( 'Enable membership system with login/register feature, user profile, video submit, etc.', 'wpst' ),
					'default' => 'on',
				)
			);
			$upload_max_filesize = ini_get( 'upload_max_filesize' );
			$post_max_size       = ini_get( 'post_max_size' );
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Enable video submission', 'wpst' ),
					'id'      => 'enable-video-submission',
					'type'    => 'switcher',
					'grid'    => '2-of-6',
					'default' => 'on',
					// translators: %1$s: Upload max filesize. %2$s: PHP post max size . %3$s: Help url to increase Upload max filesize.
					'desc'    => sprintf( __( 'Upload max filesize: %1$s. PHP post max size: %2$s. You can increase these limits: <a href="%3$s" target="_blank">How to Increase the Maximum File Upload Size in WordPress</a>', 'wpst' ), $upload_max_filesize, $post_max_size, 'https://www.wpbeginner.com/wp-tutorials/how-to-increase-the-maximum-file-upload-size-in-wordpress/' ),
				)
			);
			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:enable-video-submission:on:video-submit-settings',
					'name' => esc_html__( 'Video submit settings', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Title', 'wpst' ),
						'id'      => 'video-submit-title-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'on',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-title-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'on',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Description', 'wpst' ),
						'id'      => 'video-submit-description-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-description-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Video URL', 'wpst' ),
						'id'      => 'video-submit-video-link-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-video-link-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Video Embed', 'wpst' ),
						'id'      => 'video-submit-video-embed-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-video-embed-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Video File Upload', 'wpst' ),
						'id'      => 'video-submit-video-file-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-video-file-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Thumb URL', 'wpst' ),
						'id'      => 'video-submit-thumbnail-link-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-thumbnail-link-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Thumb File Upload', 'wpst' ),
						'id'      => 'video-submit-thumbnail-file-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-thumbnail-file-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Category', 'wpst' ),
						'id'      => 'video-submit-category-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-category-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Tags', 'wpst' ),
						'id'      => 'video-submit-tags-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-tags-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Actors', 'wpst' ),
						'id'      => 'video-submit-actors-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-actors-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'off',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Enable Duration', 'wpst' ),
						'id'      => 'video-submit-duration-enabled',
						'type'    => 'switcher',
						'grid'    => '3-of-6',
						'default' => 'on',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Required', 'wpst' ),
						'id'      => 'video-submit-duration-required',
						'type'    => 'switcher',
						'grid'    => '3-of-6 last',
						'default' => 'on',
					)
				);
			$xbox->close_mixed_field();

			$xbox->open_mixed_field(
				array(
					'id'   => 'membership-top-bar-links',
					'name' => esc_html__( 'Membership links', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Display "Submit a Video" link', 'wpst' ),
						'id'      => 'display-video-submit-link',
						'type'    => 'switcher',
						'grid'    => '2-of-6',
						'default' => 'on',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Display "My Profile" link', 'wpst' ),
						'id'      => 'display-my-profile-link',
						'type'    => 'switcher',
						'grid'    => '2-of-6',
						'default' => 'on',
					)
				);
				$xbox->add_field(
					array(
						'name'    => esc_html__( 'Display "My Channel" link', 'wpst' ),
						'id'      => 'display-my-channel-link',
						'type'    => 'switcher',
						'grid'    => '2-of-6 last',
						'default' => 'on',
					)
				);
			$xbox->close_mixed_field();

			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Enable reCaptcha', 'wpst' ),
					'id'      => 'enable-recaptcha',
					'type'    => 'switcher',
					// translators: %s: Google Recaptcha admin URL.
					'desc'    => sprintf( __( 'Enable a Google reCaptcha security code on registration and submit video page. You can get your reCAPTCHA keys here: <a href="%s" target="_blank">Google reCaptcha Keys</a>', 'wpst' ), 'https://www.google.com/recaptcha/admin' ),
					'default' => 'off',
				)
			);
			$xbox->open_mixed_field(
				array(
					'id'   => 'displayed-when:switch:enable-recaptcha:on:recaptcha-settings',
					'name' => esc_html__( 'reCaptcha settings', 'wpst' ),
				)
			);
				$xbox->add_field(
					array(
						'name' => esc_html__( 'Site key', 'wpst' ),
						'id'   => 'recaptcha-site-key',
						'type' => 'text',
					)
				);
				$xbox->add_field(
					array(
						'name' => esc_html__( 'Secret key', 'wpst' ),
						'id'   => 'recaptcha-secret-key',
						'type' => 'text',
					)
				);
			$xbox->close_mixed_field();
			$xbox->add_field(
				array(
					'name'    => esc_html__( 'Display admin bar for logged in users', 'wpst' ),
					'id'      => 'display-admin-bar',
					'type'    => 'switcher',
					'desc'    => esc_html__( 'Display the WP admin bar when a user is logged on your site and let him go to the admin.', 'wpst' ),
					'default' => 'off',
				)
			);
		$xbox->close_tab_item( 'membership' );

		/**
		 * ADVERTISING
		 */
		$xbox->open_tab_item( 'advertising' );
			$xbox->add_field(
				array(
					'id'   => 'ads-zones',
					'name' => esc_html__( 'Ads zones', 'wpst' ),
					'type' => 'title',
					'desc' => esc_html__( 'The following options allows you to set up your ads on desktop.', 'wpst' ) . '<br><br>' . esc_html__( 'You can also:', 'wpst' ) . '<br>- <a href="' . admin_url( 'widgets.php' ) . '" target="_blank">' . esc_html__( 'Edit ads in widget blocks', 'wpst' ) . '</a><br>- <a href="' . admin_url( 'admin.php?page=wpst-options#tab_item-advertising-mobile' ) . '" target="_blank">' . esc_html__( 'Edit ads zones for mobile', 'wpst' ) . '</a>',
				)
			);
			$xbox->add_field(
				array(
					'id'         => 'header-ad-desktop',
					'name'       => esc_html__( 'Header ad zone', 'wpst' ) . '<br><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/header-happy-desktop.jpg" style="margin-top:10px">',
					'type'       => 'textarea',
					'grid'       => '5-of-6',
					'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-1.png"></a>',
					'desc'       => '',
					'attributes' => array(
						'rows'       => 6,
						'class'      => 'validate-html-code',
						'spellcheck' => 'false',
					),
				)
			);
			$xbox->add_field(
				array(
					'id'         => 'sidebar-ad-desktop',
					'name'       => esc_html__( 'Sidebar ad zone', 'wpst' ) . '<br><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/sidebar-happy-desktop.jpg" style="margin-top:10px">',
					'type'       => 'textarea',
					'grid'       => '5-of-6',
					'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-2.png"></a>',
					'desc'       => '',
					'attributes' => array(
						'rows'       => 6,
						'class'      => 'validate-html-code',
						'spellcheck' => 'false',
					),
				)
			);
			$xbox->add_field(
				array(
					'id'         => 'inside-player-ad-zone-1-desktop',
					'name'       => esc_html__( 'Before play ad zone 1', 'wpst' ) . '<br><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/inside-player-happy-zone-1-desktop.jpg" style="margin-top:10px">',
					'type'       => 'textarea',
					'grid'       => '5-of-6',
					'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-2.png"></a>',
					'desc'       => '',
					'attributes' => array(
						'rows'       => 6,
						'class'      => 'validate-html-code',
						'spellcheck' => 'false',
					),
				)
			);
			$xbox->add_field(
				array(
					'id'         => 'inside-player-ad-zone-2-desktop',
					'name'       => esc_html__( 'Before play ad zone 2', 'wpst' ) . '<br><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/inside-player-happy-zone-2-desktop.jpg" style="margin-top:10px">',
					'type'       => 'textarea',
					'grid'       => '5-of-6',
					'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-2.png"></a>',
					'desc'       => '',
					'attributes' => array(
						'rows'       => 6,
						'class'      => 'validate-html-code',
						'spellcheck' => 'false',
					),
				)
			);
			$xbox->add_field(
				array(
					'id'         => 'under-player-ad-desktop',
					'name'       => esc_html__( 'Under video player ad zone', 'wpst' ) . '<br><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/under-player-happy-desktop.jpg" style="margin-top:10px">',
					'type'       => 'textarea',
					'grid'       => '5-of-6',
					'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-3.png"></a>',
					'desc'       => '',
					'attributes' => array(
						'rows'       => 6,
						'class'      => 'validate-html-code',
						'spellcheck' => 'false',
					),
				)
			);
			$xbox->add_field(
				array(
					'id'         => 'footer-ad-desktop',
					'name'       => esc_html__( 'Footer ad zone', 'wpst' ) . '<br><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/footer-happy-desktop.jpg" style="margin-top:10px">',
					'type'       => 'textarea',
					'grid'       => '5-of-6',
					'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-3.png"></a>',
					'desc'       => '',
					'attributes' => array(
						'rows'       => 6,
						'class'      => 'validate-html-code',
						'spellcheck' => 'false',
					),
				)
			);
		$xbox->close_tab_item( 'advertising' );

		/**
		 * BLOG
		 */
		$xbox->open_tab_item( 'blog' );
			$xbox->add_field(
				array(
					'id'      => 'blog-posts-per-page',
					'name'    => esc_html__( 'Number of blog posts per page', 'wpst' ),
					'type'    => 'number',
					'default' => 10,
					'grid'    => '2-of-8',
					'options' => array(
						'unit' => esc_html__( 'posts', 'wpst' ),
					),
				)
			);
		$xbox->close_tab_item( 'blog' );

		/**
		 * CODE
		 */
		$xbox->open_tab_item( 'code' );
			$xbox->add_tab(
				array(
					'name'  => esc_html__( 'Code tabs', 'wpst' ),
					'id'    => 'code-tabs',
					'items' => array(
						'javascript-code' => 'Javascript',
						'meta-code'       => 'Meta Verification',
					),
				)
			);
				// Javascript.
				$xbox->open_tab_item( 'javascript-code' );
					$xbox->add_field(
						array(
							'id'         => 'google-analytics',
							'name'       => esc_html__( 'Google Analytics', 'wpst' ),
							'type'       => 'textarea',
							'desc'       => esc_html__( 'Paste here your Google Analytics following code.', 'wpst' ),
							'attributes' => array(
								'rows'       => 6,
								'class'      => 'validate-html-code',
								'spellcheck' => 'false',
							),
						)
					);
					$xbox->add_field(
						array(
							'id'         => 'other-scripts',
							'name'       => esc_html__( 'Other scripts', 'wpst' ),
							'type'       => 'textarea',
							'desc'       => esc_html__( 'Paste here your other script codes (eg popup script).', 'wpst' ),
							'attributes' => array(
								'rows'       => 6,
								'class'      => 'validate-html-code',
								'spellcheck' => 'false',
							),
						)
					);
				$xbox->close_tab_item( 'javascript-code' );

				// Meta verification.
				$xbox->open_tab_item( 'meta-code' );
					$xbox->add_field(
						array(
							'id'         => 'meta-verification',
							'name'       => esc_html__( 'Meta verification', 'wpst' ),
							'type'       => 'textarea',
							'desc'       => esc_html__( 'Paste here your meta codes (for example to verify your domain from a third party like Google Suite, etc.)', 'wpst' ),
							'attributes' => array(
								'rows'       => 6,
								'class'      => 'validate-html-code',
								'spellcheck' => 'false',
							),
						)
					);
				$xbox->close_tab_item( 'meta-code' );
			$xbox->close_tab( 'code-tabs' );
		$xbox->close_tab_item( 'code' );

		/**
		 * TOOLS
		 */
		$xbox->open_tab_item( 'tools' );
			$xbox->add_field(
				array(
					'id'      => 'create-menu',
					'name'    => esc_html__( 'Menu', 'wpst' ),
					'type'    => 'html',
					'content' => '<input type="button" class="wpst_create_menu xbox-btn xbox-btn-pink" value="' . esc_html__( 'Create Menu', 'wpst' ) . '"><div id="create_menu_message"></div>',
					// translators: %1$s: Current site admin menus URL.
					// translators: %2$s: WP-Script RetroTube Demo URL.
					// translators: %3$s: Current Theme name.
					'desc'    => sprintf( __( 'Create a <a href="%1$s" target="_blank">menu</a> like on <a href="%2$s" target="_blank">%3$s</a> demo.', 'wpst' ), get_admin_url() . 'nav-menus.php', 'https://demo.wp-script.com/rtt-adult/', wp_get_theme()->get( 'Name' ) ),
					'grid'    => '2-of-6',
				)
			);
			$xbox->add_field(
				array(
					'id'      => 'create-widgets',
					'name'    => esc_html__( 'Widgets', 'wpst' ),
					'type'    => 'html',
					'content' => '<input type="button" class="wpst_create_widgets xbox-btn xbox-btn-pink" value="Create Widgets"><div id="create_widgets_message"></div>',
					// translators: %1$s: Current site admin widgets URL.
					// translators: %2$s: WP-Script RetroTube Demo URL.
					// translators: %3$s: Current Theme name.
					'desc'    => sprintf( __( 'Create <a href="%1$s" target="_blank">widgets</a> like on <a href="%2$s" target="_blank">%3$s</a> demo.', 'wpst' ), get_admin_url() . 'widgets.php', 'https://demo.wp-script.com/rtt-adult/', wp_get_theme()->get( 'Name' ) ),
					'grid'    => '2-of-6',
				)
			);
			$xbox->open_mixed_field(
				array( 'name' => esc_html__( 'Pages', 'wpst' ) )
			);
				$xbox->add_field(
					array(
						'id'      => 'create-categories-page',
						'type'    => 'html',
						'content' => '<input type="button" class="wpst_create_categories_page xbox-btn xbox-btn-pink" value="' . esc_html__( 'Create Categories page', 'wpst' ) . '"><div id="create_categories_page_message"></div>',
						// translators: %1$s: WP-Script RetroTube Demo Categories URL.
						// translators: %2$s: Current Theme name.
						'desc'    => sprintf( __( 'Display illustrated categories like on <a href="%1$s" target="_blank">%2$s</a> demo.', 'wpst' ), 'https://demo.wp-script.com/rtt-adult/categories/', wp_get_theme()->get( 'Name' ) ),
						'grid'    => '4-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'      => 'create-tags-page',
						'type'    => 'html',
						'content' => '<input type="button" class="wpst_create_tags_page xbox-btn xbox-btn-pink" value="' . esc_html__( 'Create Tags page', 'wpst' ) . '"><div id="create_tags_page_message"></div>',
						// translators: %1$s: WP-Script RetroTube Demo Tags Categories URL.
						// translators: %2$s: Current Theme name.
						'desc'    => sprintf( __( 'Display a tags list like on <a href="%1$s" target="_blank">%2$s</a> demo.', 'wpst' ), 'https://demo.wp-script.com/rtt-adult/tags/', wp_get_theme()->get( 'Name' ) ),
						'grid'    => '4-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'      => 'create-actors-page',
						'type'    => 'html',
						'content' => '<input type="button" class="wpst_create_actors_page xbox-btn xbox-btn-pink" value="' . esc_html__( 'Create Actors page', 'wpst' ) . '"><div id="create_actors_page_message"></div>',
						// translators: %1$s: WP-Script RetroTube Demo Actors Categories URL.
						// translators: %2$s: Current Theme name.
						'desc'    => sprintf( __( 'Display an actors list like on <a href="%1$s" target="_blank">%2$s</a> demo.', 'wpst' ), 'https://demo.wp-script.com/rtt-adult/actors/', wp_get_theme()->get( 'Name' ) ),
						'grid'    => '4-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'      => 'create-video-submit-page',
						'type'    => 'html',
						'content' => '<input type="button" class="wpst_create_video_submit_page xbox-btn xbox-btn-pink" value="' . esc_html__( 'Create Video Submit page', 'wpst' ) . '"><div id="create_video_submit_page_message"></div>',
						// translators: %1$s: WP-Script RetroTube Demo Submit page URL.
						// translators: %2$s: Current Theme name.
						'desc'    => sprintf( __( 'Allow users to submit videos like on <a href="%1$s" target="_blank">%2$s</a> demo.', 'wpst' ), 'https://demo.wp-script.com/rtt-adult/submit-a-video/', wp_get_theme()->get( 'Name' ) ),
						'grid'    => '4-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'      => 'create-my-profile-page',
						'type'    => 'html',
						'content' => '<input type="button" class="wpst_create_my_profile_page xbox-btn xbox-btn-pink" value="' . esc_html__( 'Create My Profile page', 'wpst' ) . '"><div id="create_my_profile_page_message"></div>',
						// translators: %1$s: WP-Script RetroTube Demo My profile page URL.
						// translators: %2$s: Current Theme name.
						'desc'    => sprintf( __( 'Allow users to modify their profile like on <a href="%1$s" target="_blank">%2$s</a> demo.', 'wpst' ), 'https://demo.wp-script.com/rtt-adult/my-profile/', wp_get_theme()->get( 'Name' ) ),
						'grid'    => '4-of-6 last',
					)
				);
				$xbox->add_field(
					array(
						'id'      => 'create-blog-page',
						'type'    => 'html',
						'content' => '<input type="button" class="wpst_create_blog_page xbox-btn xbox-btn-pink" value="' . esc_html__( 'Create Blog page', 'wpst' ) . '"><div id="create_blog_page_message"></div>',
						// translators: %1$s: WP-Script RetroTube Demo Blog page URL.
						// translators: %2$s: Current Theme name.
						'desc'    => sprintf( __( 'Create separate blog page like on <a href="%1$s" target="_blank">%2$s</a> demo.', 'wpst' ), 'https://demo.wp-script.com/rtt-adult/blog/', wp_get_theme()->get( 'Name' ) ),
						'grid'    => '4-of-6 last',
					)
				);
			$xbox->close_mixed_field();

		$xbox->close_tab_item( 'tools' );

		/**
		 * MOBILE
		 */
		$xbox->open_tab_item( 'mobile' );
			$xbox->add_tab(
				array(
					'name'  => esc_html__( 'Mobile tabs', 'wpst' ),
					'id'    => 'mobile-tabs',
					'items' => array(
						'general-mobile'     => '<i class="xbox-icon xbox-icon-gear"></i>' . esc_html__( 'General', 'wpst' ),
						'advertising-mobile' => '<i class="xbox-icon xbox-icon-money"></i>' . esc_html__( 'Advertising', 'wpst' ),
						'code-mobile'        => '<i class="xbox-icon xbox-icon-pencil"></i>' . esc_html__( 'Code', 'wpst' ),
					),
				)
			);
				$xbox->open_tab_item( 'general-mobile' );
					$xbox->add_field(
						array(
							'id'      => 'videos-per-page-mobile',
							'name'    => esc_html__( 'Number of videos per page', 'wpst' ),
							'type'    => 'number',
							'default' => 20,
							'grid'    => '3-of-6',
							'options' => array(
								'unit' => esc_html__( 'videos', 'wpst' ),
							),
							'desc'    => '<img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/videos-per-page-mobile.jpg">',
						)
					);
					$xbox->add_field(
						array(
							'id'         => 'videos-per-row-mobile',
							'name'       => esc_html__( 'Number of videos per row', 'wpst' ),
							'type'       => 'number',
							'default'    => 2,
							'grid'       => '3-of-6',
							'options'    => array(
								'unit' => esc_html__( 'videos', 'wpst' ),
							),
							'attributes' => array(
								'min'       => 1,
								'max'       => 2,
								'step'      => 1,
								'precision' => 0,
							),
							'desc'       => '<img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/videos-per-row-mobile.jpg">',
						)
					);
					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Show sidebar', 'wpst' ),
							'id'      => 'show-sidebar-mobile',
							'type'    => 'switcher',
							'default' => 'on',
							'grid'    => '2-of-8',
							'desc'    => esc_html__( 'Show the sidebar on mobile devices too.', 'wpst' ),
						)
					);
					$xbox->add_field(
						array(
							'name'    => esc_html__( 'Disable homepage widgets', 'wpst' ),
							'id'      => 'disable-homepage-widgets-mobile',
							'type'    => 'switcher',
							'default' => 'off',
							'grid'    => '2-of-8 last',
							'desc'    => esc_html__( 'Do not display the homepage widgets on mobile devices.', 'wpst' ),
						)
					);
				$xbox->close_tab_item( 'general-mobile' );

				/* Mobile Advertising */
				$xbox->open_tab_item( 'advertising-mobile' );
					$xbox->add_field(
						array(
							'id'         => 'header-ad-mobile',
							'name'       => esc_html__( 'Header ad zone', 'wpst' ) . '<br /><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/header-happy-mobile.jpg" style="margin-top:10px" />',
							'type'       => 'textarea',
							'grid'       => '5-of-6 last',
							'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/header-mobile.jpg"></a>',
							'desc'       => '',
							'attributes' => array(
								'rows'       => 6,
								'class'      => 'validate-html-code',
								'spellcheck' => 'false',
							),
						)
					);
					$xbox->add_field(
						array(
							'id'         => 'sidebar-ad-mobile',
							'name'       => esc_html__( 'Sidebar ad zone', 'wpst' ) . '<br /><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/sidebar-happy-mobile.jpg" style="margin-top:10px" />',
							'type'       => 'textarea',
							'grid'       => '5-of-6 last',
							'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-2.png"></a>',
							'desc'       => '',
							'attributes' => array(
								'rows'       => 6,
								'class'      => 'validate-html-code',
								'spellcheck' => 'false',
							),
						)
					);
					$xbox->add_field(
						array(
							'id'         => 'under-player-ad-mobile',
							'name'       => esc_html__( 'Under video player ad zone', 'wpst' ) . '<br><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/under-player-happy-mobile.jpg" style="margin-top:10px" />',
							'type'       => 'textarea',
							'grid'       => '5-of-6',
							'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-2.png"></a>',
							'desc'       => '',
							'attributes' => array(
								'rows'       => 6,
								'class'      => 'validate-html-code',
								'spellcheck' => 'false',
							),
						)
					);
					$xbox->add_field(
						array(
							'id'         => 'footer-ad-mobile',
							'name'       => esc_html__( 'Footer ad zone', 'wpst' ) . '<br /><img src="' . get_template_directory_uri() . '/admin/assets/img/theme-options/footer-happy-mobile.jpg" style="margin-top:10px" />',
							'type'       => 'textarea',
							'grid'       => '5-of-6',
							'default'    => '<a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-2.png"></a>',
							'desc'       => '',
							'attributes' => array(
								'rows'       => 6,
								'class'      => 'validate-html-code',
								'spellcheck' => 'false',
							),
						)
					);
				$xbox->close_tab_item( 'advertising-mobile' );

				/* Mobile Code */
				$xbox->open_tab_item( 'code-mobile' );
					$xbox->add_field(
						array(
							'id'         => 'mobile-scripts',
							'name'       => esc_html__( 'Mobile scripts', 'wpst' ),
							'type'       => 'textarea',
							'desc'       => esc_html__( 'Paste here your mobile script codes (eg popup script, etc.).', 'wpst' ),
							'attributes' => array(
								'rows'       => 6,
								'class'      => 'validate-html-code',
								'spellcheck' => 'false',
							),
						)
					);
				$xbox->close_tab_item( 'code-mobile' );
			$xbox->close_tab( 'mobile-tabs' );
		$xbox->close_tab_item( 'mobile' );

		/**
		 * EXPORT
		 */
		$xbox->open_tab_item( 'export' );
			$xbox->add_export_field(
				array(
					'name'    => esc_html__( 'Export theme options', 'wpst' ),
					'desc'    =>
						esc_html__( 'Click on the Download button to export a json backup file of your options.', 'wpst' ) .
						'<br>' .
						esc_html( 'You can import this json backup file in the Niches section of this theme options.', 'wpst' ),
					'options' => array(
						'export_button_text' => __( 'Download', 'xbox' ),
						'export_file_name'   => 'retrotube-options-backup-file',
					),
				)
			);
		$xbox->close_tab_item( 'export' );

	$xbox->close_tab( 'main-tab' );
}
