<?php
$tab = (isset($_GET['schemaType']) ? $_GET['schemaType'] : 'organisation');
$setting_pages = array(
	'organisation' => array(
		'title' => 'Organisation',
		'partial' =>'schema-organisation'
	),
	'navigation' => array(
		'title' => 'Navigation',
		'partial' =>'schema-navigation'
	)
);
?>

<div class="schema-options wrap">
    <div class="">
		<?php
        $schema_count = 0;
		foreach($setting_pages as $slug => $page){
			echo ($schema_count == 0 ? '' : ' | ')."<a href='".site_url().'/wp-admin/options-general.php?page=union-room-settings&tab=schema&schemaType='.$slug."' >".$page['title']."</a>";
			$schema_count++;
		}
		echo "<a href='https://search.google.com/structured-data/testing-tool/u/0/#url=".site_url()."' target='_blank' style='float:right;'>Test Schema ( Google Structured Data Testing Tool)</a>";
		?>
    </div>
	<?php get_template_part('partials/ur-settings/ur', $setting_pages[$tab]['partial']); ?>
</div>