<?php
/** Create pages upon theme activation **/
if (isset($_GET['activated']) && is_admin()){
    add_action('init', 'wpst_create_initial');
    add_action('widgets_init', 'unregister_default_wp_widgets', 1);
    add_action('after_switch_theme', 'set_default_theme_widgets', 10, 2);
}
function wpst_create_initial() {
    $pages = array(
// Page Title and URL (a blank space will end up becomeing a dash "-")
        'Actors' => array(
            '' => 'template-actors.php'),
        'Categories' => array(
            '' => 'template-categories.php'),
        'My Profile' => array(
            '' => 'template-my-profile.php'),
        'Submit a video' => array(
            '' => 'template-video-submit.php'),
        'Tags' => array(
            '' => 'template-tags.php')
        );
    foreach($pages as $page_url_title => $page_meta) {
        $id = get_page_by_title($page_url_title);
        foreach ($page_meta as $page_content=>$page_template){
            $page = array(
                'post_type'   => 'page',
                'post_title'  => $page_url_title,
                'post_name'   => $page_url_title,
                'post_status' => 'publish',
                'post_content' => $page_content,
                'post_author' => 1,
                'post_parent' => ''
                );
            if(!isset($id->ID)){
                $new_page_id = wp_insert_post($page);
                if(!empty($page_template)){
                    update_post_meta($new_page_id, '_wp_page_template', $page_template);
                }
            }
        }
    }

    $menuname = 'Main Menu';
    $menu_exists = wp_get_nav_menu_object( $menuname );
    if( !$menu_exists){
        $menu_id = wp_create_nav_menu($menuname);
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'       =>  __('Home', 'wpst'),
            'menu-item-url'         => home_url(),
            'menu-item-classes'     => 'home-icon',
            'menu-item-status'      => 'publish'));
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'       =>  __('Categories', 'wpst'),
            'menu-item-object'      => 'page',
            'menu-item-classes'     => 'cat-icon',
            'menu-item-object-id'   => get_page_by_path('categories')->ID,
            'menu-item-type'        => 'post_type',
            'menu-item-status'      => 'publish'));
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'       =>  __('Tags', 'wpst'),
            'menu-item-object'      => 'page',
            'menu-item-classes'     => 'tag-icon',
            'menu-item-object-id'   => get_page_by_path('tags')->ID,
            'menu-item-type'        => 'post_type',
            'menu-item-status'      => 'publish'));
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'       =>  __('Actors', 'wpst'),
            'menu-item-object'      => 'page',
            'menu-item-classes'     => 'star-icon',
            'menu-item-object-id'   => get_page_by_path('actors')->ID,
            'menu-item-type'        => 'post_type',
            'menu-item-status'      => 'publish'));
        //Get all locations (including the one we just created above)
        $locations = get_theme_mod('nav_menu_locations');
        //set the menu to the new location and save into database
        $locations['wpst-main-menu'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}

// unregister all default WP Widgets
function unregister_default_wp_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}

function set_default_theme_widgets ($old_theme, $WP_theme = null) {

    update_option( 'sidebars_widgets', array() );

    $home_1 = array(
        'title'             => __('Videos being watched', 'wpst'),
        'video_type'        => 'random',
        'video_number'      => '8',
        'video_category'    => '0'
    );

    $home_2 = array(
        'title'             => __('Longest videos', 'wpst'),
        'video_type'        => 'longest',
        'video_number'      => '12',
        'video_category'    => '0'
    );

    $sidebar_1 = array(
        'title'             => __('Latest videos', 'wpst'),
        'video_type'       => 'latest',
        'video_number'     => '6',
        'video_category'   => '0'
    );

    $sidebar_2 = array(
        'title'             => __('Random videos', 'wpst'),
        'video_type'       => 'random',
        'video_number'     => '6',
        'video_category'   => '0'
    );

    /** Footer **/
    $footer_1 = array(
        'title'             => '',
        'video_type'       => 'random',
        'video_number'     => '4',
        'video_category'   => '0'
    );

    $footer_2 = array(
        'title'            => '',
        'video_type'       => 'random',
        'video_number'     => '4',
        'video_category'   => '0'
    );

    wpst_add_widget_theme_activation( 'homepage', 'widget_videos_block', 1, $home_1 );
    wpst_add_widget_theme_activation( 'homepage', 'widget_videos_block', 3, $home_2 );

    wpst_add_widget_theme_activation( 'sidebar', 'widget_videos_block', 4, $sidebar_1 );
    wpst_add_widget_theme_activation( 'sidebar', 'widget_videos_block', 6, $sidebar_2 );

    wpst_add_widget_theme_activation( 'footer', 'widget_videos_block', 7, $footer_1 );
    wpst_add_widget_theme_activation( 'footer', 'widget_videos_block', 10, $footer_2 );

}

function wpst_add_widget_theme_activation( $sidebar_id, $widget_type = 'videos_block', $widget_id, $args = array() ) {
	global $sidebars_widgets;

	/*RAZ*/
	$ops[ $widget_id ] = '';
	$sidebars_widgets  = get_option( 'sidebars_widgets' );
	$widget            = "$widget_type-$widget_id";

	if ( ! isset( $sidebars_widgets[ $sidebar_id ] ) || ! in_array( $widget, $sidebars_widgets[ $sidebar_id ], true ) ) {
		$sidebars_widgets[ $sidebar_id ][] = $widget;
	}

	$ops                 = get_option( 'widget_' . $widget_type );
	$ops[ $widget_id ]   = $args;
	$ops['_multiwidget'] = 1;
	update_option( 'widget_' . $widget_type, $ops );
	update_option( 'sidebars_widgets', $sidebars_widgets );
}

