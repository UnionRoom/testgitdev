<?php
/*
// Example post type

function example_post_type() {
  $labels = array(
	'name' => _x('Examples', 'post type general name', ''),
	'singular_name' => _x('Example', 'post type singular name', ''),
	'add_new' => _x('Add New', 'Example', ''),
	'add_new_item' => __('Add New Example', ''),
	'edit_item' => __('Edit Example', ''),
	'new_item' => __('New Example', ''),
	'all_items' => __('All Examples', ''),
	'view_item' => __('View Example', ''),
	'search_items' => __('Search Examples', ''),
	'not_found' =>  __('No Examples found', ''),
	'not_found_in_trash' => __('No Examples found in Trash', ''),
	'parent_item_colon' => '',
	'menu_name' => __('Examples', '')
  );
  $args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => _x( 'example', 'URL slug', '' ) ),
	'capability_type' => 'page',
	'has_archive' => true,
	'hierarchical' => false,
	'menu_position' => null,
	'menu_icon' => '', // https://developer.wordpress.org/resource/dashicons/
	'supports' => array( 'title' )
  );
  register_post_type('examples', $args);
}
add_action( 'init', 'example_post_type' );
*/

/*
// Example custom columns

function add_examples_columns($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'Name' ),
        'custom' => __( 'Custom' )
    );
    return $columns;
}
add_filter('manage_examples_posts_columns' , 'add_examples_columns');

function custom_examples_column( $column, $post_id ) {
    switch ( $column ) {
        case 'custom':
            // Get content and then echo.
        break;
    }
}
add_action( 'manage_examples_posts_custom_column' , 'custom_examples_column' );
 */