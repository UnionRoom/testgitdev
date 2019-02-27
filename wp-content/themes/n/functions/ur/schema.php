<?php

//update organisation schema settings
function ur_update_organisation_schema_admin_action() {
	$data = array(
		'active' => (isset($_POST['active']) ? $_POST['active'] : ''),
		'logo' => (isset($_POST['logo']) ? $_POST['logo'] : ''),
		'facebook' => (isset($_POST['facebook']) ? $_POST['facebook'] : ''),
		'linkedin' => (isset($_POST['linkedin']) ? $_POST['linkedin'] : ''),
		'google-plus' => (isset($_POST['google-plus']) ? $_POST['google-plus'] : ''),
		'pinterest' => (isset($_POST['pinterest']) ? $_POST['pinterest'] : ''),
		'instagram' => (isset($_POST['instagram']) ? $_POST['instagram'] : ''),
		'twitter' => (isset($_POST['twitter']) ? $_POST['twitter'] : ''),
		'youtube' => (isset($_POST['youtube']) ? $_POST['youtube'] : ''),
		'address-locality' => (isset($_POST['address-locality']) ? $_POST['address-locality'] : ''),
		'address-postcode' => (isset($_POST['address-postcode']) ? $_POST['address-postcode'] : ''),
		'address-street' => (isset($_POST['address-street']) ? $_POST['address-street'] : ''),
		'phone' => (isset($_POST['phone']) ? $_POST['phone'] : '')
	);

	update_option('ur-org-schema-active', $data['active'], true);
	update_option('ur-org-schema-logo', $data['logo'], true);
	update_option('ur-org-schema-facebook', $data['facebook'], true);
	update_option('ur-org-schema-linkedin', $data['linkedin'], true);
	update_option('ur-org-schema-youtube', $data['youtube'], true);
	update_option('ur-org-schema-google-plus', $data['google-plus'], true);
	update_option('ur-org-schema-pinterest', $data['pinterest'], true);
	update_option('ur-org-schema-instagram', $data['instagram'], true);
	update_option('ur-org-schema-twitter', $data['twitter'], true);
	update_option('ur-org-schema-address-locality', $data['address-locality'], true);
	update_option('ur-org-schema-address-postcode', $data['address-postcode'], true);
	update_option('ur-org-schema-address-street', $data['address-street'], true);
	update_option('ur-org-schema-phone', $data['phone'], true);

	set_transient( 'ur_organisation_schema_updated', true, 5 );
	wp_redirect( $_SERVER['HTTP_REFERER'] );
	exit;
}
add_action( 'admin_action_ur_update_organisation_schema', 'ur_update_organisation_schema_admin_action' );

//layouts compile messages
function ur_organisation_schema_updated() {
	//if successful
	if( get_transient( 'ur_organisation_schema_updated' ) ) {
		echo '<div class="notice notice-success is-dismissible">
		<p>Organisation Schema has been updated</p>
	    </div>';
		delete_transient('ur_organisation_schema_updated');
	}
}
add_action( 'admin_notices', 'ur_organisation_schema_updated' );













//update schema settings
function ur_update_navigation_schema_admin_action() {
	$data = array(
		'active' => (isset($_POST['active']) ? $_POST['active'] : ''),
		'menu_id' => (isset($_POST['menu_id']) ? $_POST['menu_id'] : '')
	);

	update_option('ur-nav-schema-'.$data['menu_id'].'-active', $data['active'], true);

	set_transient( 'ur_navigation_schema_updated', true, 5 );
	wp_redirect( $_SERVER['HTTP_REFERER'] );
	exit;
}
add_action( 'admin_action_ur_update_navigation_schema', 'ur_update_navigation_schema_admin_action' );

//layouts compile messages
function ur_navigation_schema_updated() {
	//if successful
	if( get_transient( 'ur_navigation_schema_updated' ) ) {
		echo '<div class="notice notice-success is-dismissible">
		<p>Navigation Schema has been updated</p>
	    </div>';
		delete_transient('ur_navigation_schema_updated');
	}
}
add_action( 'admin_notices', 'ur_navigation_schema_updated' );