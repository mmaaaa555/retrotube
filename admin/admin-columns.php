<?php

add_filter('manage_edit-post_columns', 'wpst_add_columns');
function wpst_add_columns($defaults) {
    $defaults['featured_video'] = esc_html__( 'Featured', 'wpst' );
    return $defaults;
}
add_action('manage_posts_custom_column',  'wpst_columns_content');
function wpst_columns_content($name) {
    global $post;
    $featured_video = get_post_meta( $post->ID, 'featured_video', true );
    switch ($name) {
        case 'featured_video':
            if( $featured_video == 'on' ){
                echo '<i class="xbox-icon xbox-icon-check"></i>';
            }
        break;
    }
}

add_action('pre_get_posts', 'wpst_query_add_filter' );
function wpst_query_add_filter( $wp_query ) {
    if( is_admin()) {
        add_filter('views_edit-post', 'wpst_add_my_filter');
        global $pagenow;
        if( 'edit.php' == $pagenow && isset( $_GET['meta_key'] ) && isset( $_GET['meta_value'] ) ){
            $wp_query->set( 'meta_key', $_GET['meta_key'] );
            $wp_query->set( 'meta_value', $_GET['meta_value'] );
        }
    }
}

// add filter
function wpst_add_my_filter($views) {
    global $wp_query;

    $query = array(        
        'post_type'   => 'post',
        'meta_key'	  => 'featured_video',
		'meta_value'  => 'on'
    );
    $result = new WP_Query($query);
    $class = ($wp_query->query_vars['meta_key'] == 'featured_video') ? ' class="current"' : '';
    $views['featured'] = sprintf(__('<a href="%s" '. $class .'>Featured <span class="count">(%d)</span></a>', 'wpst'),
        admin_url('edit.php?post_type=post&meta_key=featured_video&meta_value=on'),
        $result->found_posts);

    return $views;
}