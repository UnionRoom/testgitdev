<?php
$menuLocations = get_nav_menu_locations();
$menus = wp_get_nav_menus();
if(!empty($menuLocations)){
	foreach ($menus as $menu){
		$menus[] = $menu;
        $menuID = $menu;
        $nav = wp_get_nav_menu_object($menuID);
        $nav_items = wp_get_nav_menu_items($menuID);
        $site_navigation_element = new UR_SiteNavigationElement();
        foreach ($nav_items as $item ) {
	        $data = array(
		        'active' => get_option('ur-nav-schema-'.$nav->term_id.'-active'),
	        );
            $site_navigation_element->add_item($item->title, $item->url);
        }
        ?>
        <div class="organisation-schema col-wrapper">
            <div class="card col--50">
                <form id="schema-setting" method="post" action="<?php echo admin_url( 'admin.php' ); ?>">
                    <h2><?php echo $nav->name; ?> | Navigation Schema</h2>
                    <input type="hidden" name="action" value="ur_update_navigation_schema" />
                    <input type="hidden" name="menu_id" value="<?php echo $nav->term_id; ?>" />
                    <input id="ur_schema-active" type="checkbox" name="active" value="1"
                        <?php echo ($data['active'] == '1' ? "checked=''" : ''); ?>/>
                    <label for="active">Show navigation schema on website</label>
                    <p>
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="Update <?php echo $nav->name; ?>">
                        <a href="#" class="js-toggle-schema button button-primary" data-id="<?php echo $nav->term_id; ?>">Show scheme preview</a>
                    </p>
                </form>
            </div>
            <div class=" col--50">
                <div class="schema-code-container" id="schema-preview-<?php echo $nav->term_id; ?>">
                    <pre class='schema-code' id="<?php echo $nav->term_id; ?>"><?php echo $site_navigation_element->render_preview(); ?></pre>
                </div>
            </div>
        </div>
        <?php
    }
}else{
	echo '<p>You currently don\'t have a menu assigned to a location. Add a menu to a location <a href="'.site_url().'/wp-admin/nav-menus.php?action=locations">here</a>.</p></div>';
}


