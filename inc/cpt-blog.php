<?php

// hook into the init action and call create_book_taxonomies when it fires

add_action( 'init', 'create_blog_taxonomies', 0 );
// create two taxonomies, genres and writers for the post type "book"

function create_blog_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'                  => _x( 'Categories', 'taxonomy general name' ),
		'singular_name'         => _x( 'Category', 'taxonomy singular name' ),
		'add_new'               => _x( 'Add New Category', 'Category'),
		'add_new_item'          => __( 'Add New Category' ),
		'edit_item'             => __( 'Edit Category' ),
		'new_item'              => __( 'New Category' ),
		'view_item'             => __( 'View Category' ),
		'search_items'          => __( 'Search Categories' ),
		'not_found'             => __( 'No Category found' ),
		'not_found_in_trash'    => __( 'No Category found in Trash' ),
		);
	$args = array(
		'labels'            => $labels,
		'singular_label'    => __('Category'),
		'public'            => true,
		'show_ui'           => true,
		'show_in_rest' 		=> true,
		'hierarchical'      => true,
		'show_tagcloud'     => false,
		'show_in_nav_menus' => true,
		'rewrite'           => array('slug' => 'blog-category', 'with_front' => false ),
		);
    register_taxonomy( 'blog_category', 'blog', $args );
    
    // Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'                  => _x( 'Tags', 'taxonomy general name' ),
		'singular_name'         => _x( 'Tag', 'taxonomy singular name' ),
		'add_new'               => _x( 'Add New Tag', 'Tag'),
		'add_new_item'          => __( 'Add New Tag' ),
		'edit_item'             => __( 'Edit Tag' ),
		'new_item'              => __( 'New Tag' ),
		'view_item'             => __( 'View Tag' ),
		'search_items'          => __( 'Search Tags' ),
		'not_found'             => __( 'No Tag found' ),
		'not_found_in_trash'    => __( 'No Tag found in Trash' ),
		);
	$args = array(
		'labels'            => $labels,
		'singular_label'    => __('Tag'),
		'public'            => true,
		'show_ui'           => true,
		'show_in_rest' 		=> true,
		'hierarchical'      => false,
		'show_tagcloud'     => true,
		'show_in_nav_menus' => true,
		'rewrite'           => array('slug' => 'blog-tag', 'with_front' => false ),
		);
	register_taxonomy( 'blog_tag', 'blog', $args );
}

function register_blog_posttype() {
	$labels = array(
		'name'              => _x( 'Blog', 'post type general name' ),
		'singular_name'     => _x( 'Article', 'post type singular name' ),
		'add_new'           => __( 'Add Article' ),
		'add_new_item'      => __( 'Add Article' ),
		'edit_item'         => __( 'Edit Article' ),
		'new_item'          => __( 'New Article' ),
		'view_item'         => __( 'View Article' ),
		'search_items'      => __( 'Search Article' ),
		'not_found'         => __( 'No Article found' ),
		'not_found_in_trash'=> __( 'No Article found in Trash' ),
		'parent_item_colon' => __( '' ),
		'menu_name'         => __( 'Blog' )
		);
//$taxonomies = array( 'exhibition_type' );
	$supports = array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields');
	$post_type_args = array(
		'labels'            => $labels,
		'singular_label'    => __('Blog'),
		'public'            => true,
		'show_ui'           => true,
		'publicly_queryable'=> true,
		'query_var'         => true,
		'capability_type'   => 'post',
		'has_archive'       => true,
		'hierarchical'      => true,
		'rewrite'           => array('slug' => 'blog', 'with_front' => false ),
		'supports'          => $supports,
		'show_in_rest' 		=> true,
		'menu_position'     => 5,
		'menu_icon'         => 'dashicons-admin-post',
//'taxonomies'      => $taxonomies,
		'show_in_nav_menus' => true
		);
	register_post_type('blog', $post_type_args);
}

add_action('init', 'register_blog_posttype');