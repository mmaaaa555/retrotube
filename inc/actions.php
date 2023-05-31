<?php

function wpst_pre_get_posts( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;   
    
    if(is_category()){
        $query->set( 'posts_per_page', xbox_get_field_value( 'wpst-options', 'videos-per-category-page' ) );
    }else{
        if(wp_is_mobile()){
            $query->set( 'posts_per_page', xbox_get_field_value( 'wpst-options', 'videos-per-page-mobile' ) );
        }else{
            $query->set( 'posts_per_page', xbox_get_field_value( 'wpst-options', 'videos-per-page' ) );
        }
    }
    
    $filter = '';
    if(is_home()) {
        $filter = xbox_get_field_value( 'wpst-options', 'show-videos-homepage' );
    }
    
    if(isset($_GET['filter'])) {
        $filter = $_GET['filter'];
    }

    switch($filter) {
        case 'latest' :
            $query->set( 'orderby', 'date');
            $query->set( 'order', 'DESC');
            break;
        case 'most-viewed' :
            $query->set( 'meta_key', 'post_views_count');
            $query->set( 'orderby', 'meta_value_num');
            $query->set( 'order', 'DESC');
            break;
        case 'longest' :
            $query->set( 'meta_key', 'duration');
            $query->set( 'orderby', 'meta_value_num');
            $query->set( 'order', 'DESC');
            break;
        case 'popular' :
            $query->set( 'orderby', 'meta_value_num');
            $query->set( 'order', 'DESC');
            $query->set( 'meta_query', array(
                                            'relation'  => 'OR',
                                            array(
                                                'key'     => 'rate',
                                                'compare' => 'NOT EXISTS'
                                            ),
                                            array(
                                                'key'     => 'rate',
                                                'compare' => 'EXISTS'
                                            )
                                        )
                        );            
            break;
        case 'random' :
            $query->set( 'orderby', 'rand');
            $query->set( 'order', 'DESC');
            break;            
        default;
    }

    return;

}
add_action( 'pre_get_posts', 'wpst_pre_get_posts', 1 );

// Gallery images
function wpst_fancybox_gallery_attribute( $content, $id ) {
	// Restore title attribute
	$title = get_the_title( $id );
	return str_replace('<a', '<a data-type="image" data-caption="' . esc_attr( $title ) . '" ', $content);
}
//add_filter( 'wp_get_attachment_link', 'wpst_fancybox_gallery_attribute', 10, 4 );

// Single images
function wpst_fancybox_image_attribute( $content ) {
    global $post;
    $pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
    $replace = '<a$1href=$2$3.$4$5 data-type="image" data-fancybox="image">';
    $content = preg_replace( $pattern, $replace, $content );
    return $content;
}
//add_filter( 'the_content', 'wpst_fancybox_image_attribute' );

function get_first_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();

    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches); 
    $first_img = $matches[1][0];

    return '<div class="photo-bg" style="background: url(' . $first_img . ') no-repeat; background-size: cover;">';
}