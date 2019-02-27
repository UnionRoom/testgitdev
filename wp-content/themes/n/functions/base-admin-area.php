<?php
// Turn pingbacks off
add_filter('xmlrpc_enabled', '__return_false');

// Load stylesheet into login page
add_action('login_head', 'login_stylesheet');
function login_stylesheet() {
    wp_enqueue_style('login_stylesheet', get_template_directory_uri() . '/css/login.css');
}

// Load stylesheet into admin area
add_action('admin_head', 'admin_stylesheet');
function admin_stylesheet() {
    wp_enqueue_style('admin_stylesheet', get_template_directory_uri() . '/css/admin.css');
	wp_register_script( 'admin_js', get_template_directory_uri() . '/js/admin.js', array(), '1.0', true );
	wp_enqueue_script( 'admin_js' );
}

// Custom bar in admin area based on local or urdev
add_action('in_admin_header', 'what_site_header');
function what_site_header() {
    if ($_SERVER['SERVER_ADDR'] == '192.168.33.10'){
        echo '<div class="what-site notice notice-error">Your currently editing the local site.</div>';
    } elseif ($_SERVER['SERVER_ADDR'] == '46.37.186.164'){
        echo '<div class="what-site notice notice-warning">Your currently editing the urdev site.</div>';
    }
}

// Invalid login
function no_wordpress_errors(){
    return 'Invalid log in details!';
}
add_filter( 'login_errors', 'no_wordpress_errors' );

// Change url on login logo
add_filter('login_headerurl', 'login_url');
function login_url() {
    return ('');
}

// Change title on login logo
add_filter('login_headertitle', 'put_my_title');
function put_my_title() {
    return ('');
}

// Remove WP logo from admin bar
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);
function annointed_admin_bar_remove() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}

// Change footer text
add_filter('admin_footer_text', 'remove_footer_admin');
function remove_footer_admin() {
    echo "Site by <a href='http://www.unionroom.com' target='_blank'>Union Room</a>.";
}

// Remove dashboard widgets
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}

// Move SEO Yoast to bottom
function yoasttobottom() {
    return 'low';
}
add_filter('wpseo_metabox_prio', 'yoasttobottom');

// Setting defualt image upload options (left, no link, full size)
add_action('after_setup_theme', 'default_attachment_display_settings');

function default_attachment_display_settings() {
    update_option('image_default_align', 'left');
    update_option('image_default_link_type', 'none');
    update_option('image_default_size', 'full');
}

// Remove tags meta box
function remove_post_tag_box() {
    remove_meta_box('tagsdiv-post_tag' , 'post' , 'normal'); 
}
add_action('admin_menu' , 'remove_post_tag_box');

// Filter Functions with Hooks
function custom_mce_button() {
	// Check if user have permission
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// Check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'custom_tinymce_plugin' );
		add_filter( 'mce_buttons', 'register_mce_button' );
	}
}
add_action('admin_head', 'custom_mce_button');

// Function for buttons
function custom_tinymce_plugin( $plugin_array ) {
	$plugin_array['button_shortcode'] = get_template_directory_uri() .'/js/admin.js';
	return $plugin_array;
}

// Register for buttons in the editor
function register_mce_button( $buttons ) {
	array_push( $buttons, 'button_shortcode' );
	return $buttons;
}