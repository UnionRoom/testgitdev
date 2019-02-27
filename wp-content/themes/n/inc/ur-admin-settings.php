<?php
$tab = (isset($_GET['tab']) ? $_GET['tab'] : 'layouts');
$setting_pages = array(
	'layouts' => array(
		'title' => 'Layouts',
		'partial' =>'layouts-options'
	),
	'schema' => array(
		'title' => 'Schema',
		'partial' =>'schema-options'
	)
);
?>

<div class="wrap">
	<h2>Union Room : <?php echo $setting_pages[$tab]['title']; ?></h2>
	<div class="nav-tab-wrapper">
		<?php
		foreach($setting_pages as $slug => $page){
			echo "<a href='".site_url().'/wp-admin/options-general.php?page=union-room-settings&tab='.$slug."' class='nav-tab'>".$page['title']."</a>";
		}
		?>
	</div>
	<?php get_template_part('partials/ur-settings/ur', $setting_pages[$tab]['partial']); ?>
</div>