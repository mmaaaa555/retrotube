<?php

/********************************/
/***** Import dummy content *****/
/********************************/
add_action( 'wp_ajax_wpst_import_dummy_content', 'wpst_import_dummy_content' );
function wpst_import_dummy_content() {
    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        wp_die( 'Busted!' );

    global $wpdb; 

    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

    // Load Importer API
    require_once ABSPATH . 'wp-admin/includes/import.php';     

    if ( !class_exists( 'WP_Importer' ) ) {
        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        if ( file_exists( $class_wp_importer ) ) {
            require $class_wp_importer;
        }
    }

    if ( !class_exists( 'WP_Import' ) ) {
        $class_wp_importer = WPSCORE_DIR . "xbox/libs/wordpress-importer/wordpress-importer.php";
        if ( file_exists( $class_wp_importer ) )
        require $class_wp_importer;      
    } 

    if ( class_exists( 'WP_Import' ) ) {
        $import_dummy_filepath = get_template_directory() . "/inc/import/dummy.xml" ; // Get the xml file from directory 

        include_once('wpst-import.php');

        $wp_import = new wpst_import();
        $wp_import->fetch_attachments = true;
        $wp_import->import($import_dummy_filepath);

        $wp_import->check();

    }
    wp_die(); // this is required to return a proper result
}

/************************************/
/***** Create Video submit page *****/
/************************************/
add_action( 'wp_ajax_wpst_create_video_submit_page', 'wpst_create_video_submit_page' );
function wpst_create_video_submit_page() {

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        wp_die( 'Busted!' ); 

    $pages = array(
    // Page Title and URL (a blank space will end up becomeing a dash "-")
    'Submit a Video' => array( '' => 'template-video-submit.php' ) );
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
    wp_die(); // this is required to return a proper result
}

/************************************/
/***** Create My Profile page *******/
/************************************/
add_action( 'wp_ajax_wpst_create_my_profile_page', 'wpst_create_my_profile_page' );
function wpst_create_my_profile_page() {

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        wp_die( 'Busted!' ); 

    $pages = array(
    // Page Title and URL (a blank space will end up becomeing a dash "-")
    'My Profile' => array( '' => 'template-my-profile.php' ) );
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
    wp_die(); // this is required to return a proper result
}


/************************************/
/***** Create Blog page *******/
/************************************/
add_action( 'wp_ajax_wpst_create_blog_page', 'wpst_create_blog_page' );
function wpst_create_blog_page() {

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        wp_die( 'Busted!' ); 

    $pages = array(
    // Page Title and URL (a blank space will end up becomeing a dash "-")
    'Blog' => array( '' => 'template-blog.php' ) );
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
    wp_die(); // this is required to return a proper result
}


/**********************************/
/***** Create Categories page *****/
/**********************************/
add_action( 'wp_ajax_wpst_create_categories_page', 'wpst_create_categories_page' );
function wpst_create_categories_page() {

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        wp_die( 'Busted!' );

    $pages = array(
    // Page Title and URL (a blank space will end up becomeing a dash "-")
    'Categories' => array( '' => 'template-categories.php' ) );
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
    wp_die(); // this is required to return a proper result
}

/**********************************/
/***** Create Tags page *****/
/**********************************/
add_action( 'wp_ajax_wpst_create_tags_page', 'wpst_create_tags_page' );
function wpst_create_tags_page() {

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        wp_die( 'Busted!' ); 

    $pages = array(
    // Page Title and URL (a blank space will end up becomeing a dash "-")
    'Tags' => array( '' => 'template-tags.php' ) );
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
    wp_die(); // this is required to return a proper result
}

/**********************************/
/***** Create Actors page *****/
/**********************************/
add_action( 'wp_ajax_wpst_create_actors_page', 'wpst_create_actors_page' );
function wpst_create_actors_page() {

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        wp_die( 'Busted!' ); 

    $pages = array(
    // Page Title and URL (a blank space will end up becomeing a dash "-")
    'Actors' => array( '' => 'template-actors.php' ) );
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
    wp_die(); // this is required to return a proper result
}

/***********************/
/***** Create menu *****/
/***********************/
add_action( 'wp_ajax_wpst_create_menu', 'wpst_create_menu' );
function wpst_create_menu() {

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        wp_die( 'Busted!' ); 
        
    $pages = array(    
        'Submit a Video'    => array( '' => 'template-video-submit.php' ),
        'My Profile'        => array( '' => 'template-my-profile.php' ),
        'Categories'        => array( '' => 'template-categories.php' ),
        'Tags'              => array( '' => 'template-tags.php' ),
        'Actors'            => array( '' => 'template-actors.php' ),
        'Blog'              => array( '' => 'template-blog.php' )
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
    if( !$menu_exists ){
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
    wp_die(); // this is required to return a proper result
}

/**************************/
/***** Create widgets *****/
/**************************/
add_action( 'wp_ajax_wpst_create_widgets', 'wpst_create_widgets' );
function wpst_create_widgets() {  

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        wp_die( 'Busted!' );

    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');

    update_option( 'sidebars_widgets', array() );
    
    /** Homepage **/
    $home_1 = array(
        'title'             => __('Videos being watched', 'wpst'),
        'video_type'        => 'random',
        'video_number'      => '8',
        'video_category'    => '0'
    );
    $home_2 = array(
        'title'             => '',
        'text'              => '<div class="text-center"><a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-4.png"></a></div>'
    );
    $home_3 = array(
        'title'             => __('Longest videos', 'wpst'),
        'video_type'        => 'longest',
        'video_number'      => '12',
        'video_category'    => '0'
    );
    // $home_4 = array(
    //     'title'             => '',
    //     'text'              => '<div class="text-center"><a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/leaderboard.jpg"></a></div>'
    // );
    // $home_5 = array(
    //     'title'             => __('Most viewed videos', 'wpst'),
    //     'video_type'        => 'most-viewed',
    //     'video_number'      => '10',
    //     'video_category'    => '0'
    // );

    /** Sidebar **/
    // $sidebar_1 = array(
    //     'title'             => __('Categories', 'wpst'),
    //     'count'             => false,
    //     'hierarchical'      => false,
    //     'dropdown'          => false
    // );

    $sidebar_2 = array(
        'title'             => __('Latest videos', 'wpst'),
        'video_type'       => 'latest',
        'video_number'     => '6',
        'video_category'   => '0'
    );

    $sidebar_3 = array(
        'title'             => '',
        'text'              => '<div class="text-center"><a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-2.png"></a></div>'
    );

    $sidebar_4 = array(
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
        'title'             => '',
        'text'              => '<div class="text-center"><a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-2.png"></a></div>'
    );

    $footer_3 = array(
        'title'             => '',
        'text'              => '<div class="text-center"><a href="#!"><img src="' . get_template_directory_uri() . '/assets/img/banners/happy-2.png"></a></div>'
    );

    $footer_4 = array(
        'title'            => '',
        'video_type'       => 'random',
        'video_number'     => '4',
        'video_category'   => '0'
    );

    wpst_add_widget( 'homepage', 'widget_videos_block', 1, $home_1 );
    wpst_add_widget( 'homepage', 'text', 2, $home_2 );
    wpst_add_widget( 'homepage', 'widget_videos_block', 3, $home_3 );

    // wpst_add_widget( 'sidebar', 'categories', 6, $sidebar_1 );
    wpst_add_widget( 'sidebar', 'widget_videos_block', 4, $sidebar_2 );
    wpst_add_widget( 'sidebar', 'text', 5, $sidebar_3 );
    wpst_add_widget( 'sidebar', 'widget_videos_block', 6, $sidebar_4 );

    wpst_add_widget( 'footer', 'widget_videos_block', 7, $footer_1 );
    wpst_add_widget( 'footer', 'text', 8, $footer_2 );
    wpst_add_widget( 'footer', 'text', 9, $footer_3 );
    wpst_add_widget( 'footer', 'widget_videos_block', 10, $footer_4 );

    wp_die(); // this is required to return a proper result
}

function wpst_add_widget( $sidebar_id, $widget_type = 'videos_block', $widget_id, $args = array() ){    
    global $sidebars_widgets;       
    /*RAZ*/
    $ops[$widget_id] = '';
    //$sidebars_widgets = '';     
    $sidebars_widgets = get_option('sidebars_widgets');
    
    if( ! in_array( $widget_type . "-".$widget_id, (array)$sidebars_widgets[$sidebar_id] ) )
        $sidebars_widgets[$sidebar_id][] = $widget_type . "-" . $widget_id;
    
    $ops = get_option('widget_' . $widget_type);    
    $ops[$widget_id] = $args;    
    $ops["_multiwidget"] = 1;    
    update_option('widget_' . $widget_type, $ops);
    update_option('sidebars_widgets', $sidebars_widgets);    
}