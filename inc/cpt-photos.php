<?php

// hook into the init action and call create_book_taxonomies when it fires

add_action( 'init', 'create_photos_taxonomies', 0 );
// create two taxonomies, genres and writers for the post type "book"

function create_photos_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'                  => _x( 'Photo Categories', 'taxonomy general name' ),
		'singular_name'         => _x( 'Photo Category', 'taxonomy singular name' ),
		'add_new'               => _x( 'Add New Photo Category', 'Category'),
		'add_new_item'          => __( 'Add New Photo Category' ),
		'edit_item'             => __( 'Edit Photo Category' ),
		'new_item'              => __( 'New Photo Category' ),
		'view_item'             => __( 'View Photo Category' ),
		'search_items'          => __( 'Search Photo Categories' ),
		'not_found'             => __( 'No Photo Category found' ),
		'not_found_in_trash'    => __( 'No Photo Category found in Trash' ),
		);
	$args = array(
		'labels'            => $labels,
		'singular_label'    => __('Photo Category'),
		'public'            => true,
		'show_ui'           => true,
		'show_in_rest' 		=> true,
		'hierarchical'      => true,
		'show_tagcloud'     => false,
		'show_in_nav_menus' => true,
		'rewrite'           => array('slug' => 'photos-category', 'with_front' => false ),
		);
    register_taxonomy( 'photos_category', 'photos', $args );
    
    // Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'                  => _x( 'Photo Tags', 'taxonomy general name' ),
		'singular_name'         => _x( 'Photo Tag', 'taxonomy singular name' ),
		'add_new'               => _x( 'Add New Photo Tag', 'Tag'),
		'add_new_item'          => __( 'Add New Photo Tag' ),
		'edit_item'             => __( 'Edit Photo Tag' ),
		'new_item'              => __( 'New Photo Tag' ),
		'view_item'             => __( 'View Photo Tag' ),
		'search_items'          => __( 'Search Photo Tags' ),
		'not_found'             => __( 'No Photo Tag found' ),
		'not_found_in_trash'    => __( 'No Photo Tag found in Trash' ),
		);
	$args = array(
		'labels'            => $labels,
		'singular_label'    => __('Photo Tag'),
		'public'            => true,
		'show_ui'           => true,
		'show_in_rest' 		=> true,
		'hierarchical'      => false,
		'show_tagcloud'     => true,
		'show_in_nav_menus' => true,
		'rewrite'           => array('slug' => 'photos-tag', 'with_front' => false ),
		);
	register_taxonomy( 'photos_tag', 'photos', $args );
}

function register_photos_posttype() {
	$labels = array(
		'name'              => _x( 'Photos', 'post type general name' ),
		'singular_name'     => _x( 'Photo', 'post type singular name' ),
		'add_new'           => __( 'Add Photo' ),
		'add_new_item'      => __( 'Add Photo' ),
		'edit_item'         => __( 'Edit Photo' ),
		'new_item'          => __( 'New Photo' ),
		'view_item'         => __( 'View Photo' ),
		'search_items'      => __( 'Search Photo' ),
		'not_found'         => __( 'No Photo found' ),
		'not_found_in_trash'=> __( 'No Photo found in Trash' ),
		'parent_item_colon' => __( '' ),
		'menu_name'         => __( 'Photos' )
		);
//$taxonomies = array( 'exhibition_type' );
	$supports = array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields');
	$post_type_args = array(
		'labels'            => $labels,
		'singular_label'    => __('Photos'),
		'public'            => true,
		'show_ui'           => true,
		'publicly_queryable'=> true,
		'query_var'         => true,
		'capability_type'   => 'post',
		'has_archive'       => true,
		'hierarchical'      => true,
		'rewrite'           => array('slug' => 'photos', 'with_front' => false ),
		'supports'          => $supports,
		'show_in_rest' 		=> true,
		'menu_position'     => 4,
		'menu_icon'         => 'dashicons-format-gallery',
//'taxonomies'      => $taxonomies,
		'show_in_nav_menus' => true
		);
	register_post_type('photos', $post_type_args);
}

add_action('init', 'register_photos_posttype');