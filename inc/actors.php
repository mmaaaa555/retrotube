<?php //hook into the init action and call create_topics_nonhierarchical_taxonomy when it fires
add_action( 'init', 'wpst_create_actors_taxonomy', 0 );
function wpst_create_actors_taxonomy() {
// Labels part for the GUI
    $labels = array(
        'name' => _x( 'Video Actors', 'wpst' ),
        'singular_name' => _x( 'Video Actor', 'wpst' ),
        'search_items' =>  __( 'Search Video Actors', 'wpst' ),
        'popular_items' => __( 'Popular Video Actors', 'wpst' ),
        'all_items' => __( 'All Video Actors', 'wpst' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Video Actor', 'wpst' ),
        'update_item' => __( 'Update Video Actor', 'wpst' ),
        'add_new_item' => __( 'Add New Video Actor', 'wpst' ),
        'new_item_name' => __( 'New Video Actor Name', 'wpst' ),
        'separate_items_with_commas' => __( 'Separate Video Actors with commas', 'wpst' ),
        'add_or_remove_items' => __( 'Add or remove Video Actors', 'wpst' ),
        'choose_from_most_used' => __( 'Choose from the most used Video Actors', 'wpst' ),
        'menu_name' => __( 'Video Actors', 'wpst' )
        );
// Now register the non-hierarchical taxonomy like tag
    register_taxonomy('actors','post', array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'show_in_rest' => true,
        'rewrite' => array( 'slug' => 'actor' )
    ));
}