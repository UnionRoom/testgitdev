<?php

function compile_json() {
	// Get base JSON from parent theme
	$acf_json = json_decode(file_get_contents(get_template_directory() . '/layouts/acf_group.json'), TRUE);
	$acf_add_json_filepaths = array();
	$acf_add_json = array();

	// Get layout JSON files from parent theme
	foreach ( glob( get_template_directory() . '/layouts/*/acf.json' ) as $file ) {
	  	$acf_add_json_filepaths[] = str_replace( get_template_directory(), '', $file );
	}

	// Get layout JSON files from child theme
	foreach ( glob( get_stylesheet_directory() . '/layouts/*/acf.json' ) as $file ) {
	  	$acf_add_json_filepaths[] = str_replace( get_stylesheet_directory(), '', $file );
	}

	// Order files alphabetically
	$acf_add_json_filepaths = array_unique($acf_add_json_filepaths, SORT_STRING);

	// Get file contents from child if it exists, else parent and add to array
	foreach($acf_add_json_filepaths as $file) {
		$acf_add_json[] = json_decode( file_get_contents( locate_template( $file ) ), TRUE );
	}

	// Add leyouts to array
	$acf_json['fields'][0]['layouts'] = $acf_add_json;

	// Write the JSON file using the ACF group key as the filename
	$fp = fopen( get_template_directory() . '/layouts/acf_json/' . $acf_json['key'] . '.json', 'w' );
	fwrite( $fp, json_encode( $acf_json ) );
	fclose( $fp );
}
add_action( 'after_switch_theme', 'compile_json' );
// add_action( 'init', 'compile_json' ); // Manually compile JSON - PLEASE LEAVE!

// Add custom load point from parent theme
function my_acf_json_load_point( $paths ) {
    $paths[] = get_template_directory() . '/layouts/acf_json';
    return $paths;

}
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

// Add custom save point if we're a child theme
function my_acf_json_save_point( $path ) {
	if( is_child_theme() ) {
		$path = get_stylesheet_directory() . '/acf_json';
	}
    return $path;
}
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

if( ! function_exists('get_layouts') ) {
	$layout_count = 1;
	function get_layouts() {
		global $layout_count;
		if(have_rows('layouts')) {
			echo PHP_EOL . PHP_EOL . '<!-- Layouts -->' . PHP_EOL;
			while (have_rows('layouts')) {
				the_row();
				$layout_name = get_row_layout();
				locate_template("layouts/$layout_name/$layout_name.php", TRUE, FALSE);
				$layout_count++;
			}
		}
	}
}

function acf_load_content_mosaic_post_type_field_choices( $field ) {
    $field['choices'] = array(
    	'post' => 'Post'
	);

    // Get all custom public post types
    $args = array(
	   'public'   => true,
	   '_builtin' => false
	);
	$post_types = get_post_types( $args, 'objects', 'and' );

    // loop through array and add to field 'choices'
    foreach( $post_types as $post_type ) {
        $field['choices'][ $post_type->name ] = $post_type->label;
    }

    return $field;
}
add_filter('acf/load_field/name=content_mosiac_post_type', 'acf_load_content_mosaic_post_type_field_choices');


function acf_load_columns_with_image_post_type_field_choices( $field ) {
    $field['choices'] = array(
    	'post' => 'Post'
	);

    // Get all custom public post types
    $args = array(
	   'public'   => true,
	   '_builtin' => false
	);
	$post_types = get_post_types( $args, 'objects', 'and' );

    // loop through array and add to field 'choices'
    foreach( $post_types as $post_type ) {
        $field['choices'][ $post_type->name ] = $post_type->label;
    }
    return $field;
}
add_filter('acf/load_field/name=columns_with_image_post_type', 'acf_load_columns_with_image_post_type_field_choices');

//layouts compile messages
function ur_layouts_updated() {
    //if successful
	if( get_transient( 'ur_layouts_updated_transient' ) ) {
		echo '<div class="notice notice-success is-dismissible">
		<p>Layouts have been recompiled successfully</p>
	    </div>';
        delete_transient('ur_layouts_updated_transient');
	}

	//if error
	if( get_transient( 'ur_layouts_not_updated_transient' ) ) {
		echo '<div class="notice notice-error is-dismissible">
		<p>There was an error compiling the layouts</p>
	    </div>';
		delete_transient('ur_layouts_not_updated_transient');
	}
}
add_action( 'admin_notices', 'ur_layouts_updated' );

//recompile layout function
function ur_recompile_layouts_admin_action()
{
	$acf_json = json_decode(file_get_contents(get_template_directory() . '/layouts/acf_group.json'), TRUE);
	$acf_add_json_filepaths = $_POST['json_to_compile'];
	$acf_json_existing = json_decode(file_get_contents(get_template_directory() . '/layouts/acf_json/' . $acf_json['key'] . '.json'), TRUE);
	$layouts_to_compile = array();

	// Get file contents from child if it exists, else parent and add to array
	$options = array();
	if(isset($acf_add_json_filepaths) && count($acf_add_json_filepaths) > 0) {
		foreach ( $acf_add_json_filepaths as $file ) {
			$layouts_to_compile[] = json_decode( file_get_contents( locate_template( $file ) ), true );
			$path                 = str_replace( '/layouts/', '', $file );
			$acf                  = str_replace( '/acf.json', '', $path );
			$options[]            = trim( $acf );
		}
	}else{
		$layouts_to_compile[] = '';
	}

	update_option( 'latest_recompile_json', $options);

	// Add leyouts to array
	$acf_json['fields'][0]['layouts'] = $layouts_to_compile;

	// Write the JSON file using the ACF group key as the filename
	$fp = fopen( get_template_directory() . '/layouts/acf_json/' . $acf_json['key'] . '.json', 'w' );
	fwrite( $fp, json_encode( $acf_json ) );
	fclose( $fp );

	if(is_bool($fp)){
	    set_transient( 'ur_layouts_not_updated_transient', true, 5 );
	}else{
		set_transient( 'ur_layouts_updated_transient', true, 5 );
	}
	wp_redirect( $_SERVER['HTTP_REFERER'] );
	exit;
}
add_action( 'admin_action_ur_recompile_layouts', 'ur_recompile_layouts_admin_action' );