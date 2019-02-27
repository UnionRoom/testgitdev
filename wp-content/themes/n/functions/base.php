<?php


// Setting up thumbnails
add_theme_support('post-thumbnails');
//add_image_size('crop-name', 1000, 9999, false);
//add_image_size('crop-name', 1000, 1000);

// Turning on sessions support
add_action('init', 'urframework_start_session', 1);
function urframework_start_session() {
    if (!session_id())
        session_start();
}

// Set gmaps key - default is urdev.co.uk key
function urframework_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyATr_lTvLb_tflJIK9hOSK8nMSbkmtzMVE');
}
add_action('acf/init', 'urframework_acf_init');

// Add jQuery
function urframework_enqueue_jquery() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-3.1.0.min.js');
    wp_enqueue_script('jquery');
}

function urframework_enqueue_global() {
    wp_enqueue_script('globaljs', get_template_directory_uri() . '/js/global.js', array('jquery'), '1.0', TRUE);
    if( is_child_theme() )
        wp_enqueue_script('globaljs-child', get_stylesheet_directory_uri() . '/js/global.js', array('jquery'), '1.0', TRUE);
}

// Set style sheet for parent and child theme
function urframework_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/global.css' );
    if( is_child_theme() ) {
        wp_enqueue_style( 'child-style',
            get_stylesheet_directory_uri() . '/css/global.css',
            array( $parent_style ),
            wp_get_theme()->get('Version')
        );
    }
}

if (!is_admin()) {
    add_action('wp_enqueue_scripts', 'urframework_enqueue_jquery');
    add_action('wp_footer', 'urframework_enqueue_global', 19);
    add_action( 'wp_enqueue_scripts', 'urframework_enqueue_styles' );
}

// Stop wordpress and plugin updates
function remove_core_updates () {
	global $wp_version;
	return(object) array(
		'last_checked'=> time(),
		'version_checked'=> $wp_version,
		'updates' => array()
	);
}
remove_action('load-update-core.php', 'wp_update_plugins');
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');

// Turn JSON/Rest off
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');

// Turn off xmlrpc.php
add_filter('xmlrpc_enabled', '__return_false');

// Cleaning up WP Head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

// Disable emojis
function disable_wp_emojicons() {
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    add_filter('emoji_svg_url', '__return_false');
}
add_action('init', 'disable_wp_emojicons');

// Remove WP Embed
function deregister_embed_script() {
    wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'deregister_embed_script');

// urdev robots
function urframework_robots() {
    header('Content-Type: text/plain; charset=utf-8');

    do_action('do_robotstxt');

    $domain = $_SERVER['HTTP_HOST'];
    $output = "User-agent: *\n";
    if (strpos($domain, 'urdev.co.uk') != FALSE) {
        $output .= "Disallow: /\n";
        $public = FALSE;
    } else {
        $site_url = parse_url(site_url());
        $path = (!empty($site_url['path']) ) ? $site_url['path'] : '';
        $output .= "Disallow: $path/wp-admin/\n";
        $output .= "Allow: $path/wp-admin/admin-ajax.php\n";
        $public = TRUE;
    }
    echo apply_filters('robots_txt', $output, $public);
}
remove_action('do_robots', 'do_robots');
add_action('do_robots', 'urframework_robots');

// Get featured image url function
function grab_featured_img_url($grab_featured_img_size) {
    $grab_image_id = get_post_thumbnail_id();
    $grab_image_url = wp_get_attachment_image_src($grab_image_id, $grab_featured_img_size);
    $grab_image_url = $grab_image_url[0];
    return $grab_image_url;
}

// Removing p tags from images and iframes
function filter_ptags_on_images($content) {
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    $content = preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
    return preg_replace('/<p>\s*(<span .*>*.<\/span>)\s*<\/p>/iU', '\1', $content);
}
add_filter('the_content', 'filter_ptags_on_images');
add_filter('acf_the_content', 'filter_ptags_on_images');

// Change end of excerpt
function end_excerpt($text) {
    return str_replace(' [...]', '...', $text);
}
add_filter('the_excerpt', 'end_excerpt');

//add union room option to sidebar
function add_union_room_to_menu(){
	add_submenu_page('options-general.php', 'UR Settings', 'UR Settings', 'manage_options', 'union-room-settings', 'ur_settings', 'dashicons-admin-generic', 1);
}
add_action('admin_menu', 'add_union_room_to_menu');

//ur-dashboard callback
function ur_settings(){
	include(get_template_directory().'/inc/ur-admin-settings.php');
}

//include jquery ui
function enqueue_options_style( $hook ) {
		wp_enqueue_script( 'jquery-ui-accordion' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_options_style', 10, 1 );

// Organisation Schema
add_action('wp_head', function(){
	$social_output = 0;
	$osd = array(
		'active' => (get_option('ur-org-schema-active') ? get_option('ur-org-schema-active') : false),
		'logo' => get_option('ur-org-schema-logo'),
		'address-locality' => get_option('ur-org-schema-address-locality'),
		'address-postcode' => get_option('ur-org-schema-address-postcode'),
		'address-street' => get_option('ur-org-schema-address-street'),
		'fax' => get_option('ur-org-schema-fax'),
		'phone' => get_option('ur-org-schema-phone')
	);
	$osd_social = array(
		'facebook' => get_option('ur-org-schema-facebook'),
		'linkedin' => get_option('ur-org-schema-linkedin'),
		'google-plus' => get_option('ur-org-schema-google-plus'),
		'pinterest' => get_option('ur-org-schema-pinterest'),
		'instagram' => get_option('ur-org-schema-instagram'),
		'twitter' => get_option('ur-org-schema-twitter'),
		'youtube' => get_option('ur-org-schema-youtube')
	);

	//For comma in schema
	foreach ($osd_social as $key => $social_site){
		if($social_site == ''){
			unset($osd_social[$key]);
		}
	}

	$address = '"address": {
        "@type": "PostalAddress",
        "addressLocality": "'.$osd['address-locality'].'",
        "postalCode": "'.$osd['address-postcode'].'",
        "streetAddress": "'.$osd['address-street'].'"
        }';

	if($osd['active']) {
		echo '<script type = "application/ld+json" >
    {
        "@context": "http://schema.org/",
        "@type": "Organization",
        "url": "' . site_url() . '",
        '.($osd['logo'] != '' ? '"logo": "' . site_url() . '/' . $osd['logo'] . '",' : '').'
        "sameAs" : [
        ';
        foreach($osd_social as $key => $social_site){
			echo ($osd_social[$key] != '' ? '"' . $social_site . '"' : '').($social_output != count($osd_social)-1 ? ',' : '');
			$social_output++;
        }
		echo '
        ],
        ' . $address . ',
        "telephone": "' . $osd['phone'] . '"
    }
 </script >';
	}
});


function nav_schema( $items, $args ) {
	$menu_id = $args->menu->term_id;

	$nsd = array(
		'active' => (get_option('ur-nav-schema-'.$menu_id.'-active') ? get_option('ur-nav-schema-'.$menu_id.'-active') : false),
	);
	$dom = new DOMDocument();
	$dom->loadHTML($items);
	$find = $dom->getElementsByTagName('a');
	$site_navigation_element = new UR_SiteNavigationElement();
	if($nsd['active']){
		foreach ($find as $item ) {
				$site_navigation_element->add_item($item->textContent, $item->getAttribute('href'));
		}
		return $site_navigation_element->render().$dom->saveHTML();
	}else{
		return $dom->saveHTML();
	}


}
//add_filter('wp_nav_menu_items', 'nav_schema', 10, 2);

//autoload UR classes
spl_autoload_register(function ($class_name) {
	$file = get_template_directory() . '/inc/classes/' . $class_name . '.php';
	if (file_exists($file)) {
		include $file;
	}
});