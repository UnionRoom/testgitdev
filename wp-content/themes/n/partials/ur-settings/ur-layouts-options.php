<?php
$latest_recompile_json = get_option('latest_recompile_json');
?>
<form method="post" action="<?php echo admin_url( 'admin.php' ); ?>">

	<div class="card">
		<h2>Recompile Layouts</h2>
		<input type="hidden" name="action" value="ur_recompile_layouts" />

		<?php
		// Get layout JSON files from parent theme
		foreach ( glob( get_template_directory() . '/layouts/*/acf.json' ) as $file ) {
			$acf_add_json_filepaths[] = $file;
		}

		// Get layout JSON files from child theme
		foreach ( glob( get_stylesheet_directory() . '/layouts/*/acf.json' ) as $file ) {
			$acf_add_json_filepaths[] = $file;
		}

		// Order files alphabetically
		$acf_add_json_filepaths = array_unique($acf_add_json_filepaths, SORT_STRING);

        $checked_count = 0;
		$acf_add_json_filepaths_new = array();
		foreach ( $acf_add_json_filepaths as $file ){
			$path = str_replace( get_template_directory().'/layouts/', '', $file );
			$acf = str_replace( '/acf.json', '', $path );

			$acf_add_json_filepaths_new[$file] = array(
			        'path' => $path,
			        'acf' => $acf,
			        'compiled' => ($latest_recompile_json && in_array(trim($acf), $latest_recompile_json)? true : false),
            );
			$checked_count++;
        }

		//print list of json files
		?><input type="checkbox" id="all" <?php echo ($checked_count == count($latest_recompile_json) ? "checked=''" : '')?>/><label>All</label>
		<hr/><?php
		foreach ( $acf_add_json_filepaths_new as $key =>$value ):
		?>
			<div class='layout-item'>
			<input id="<?php echo $value['acf']; ?>" type="checkbox" name="json_to_compile[]" value="/layouts/<?php echo $value['path']; ?>" class="json_to_compile_all"
				<?php echo ($value['compiled'] == '1' ? "checked=''" : ''); ?>/>
			<label for="<?php echo $value['acf']; ?>"><?php echo $value['acf']; ?></label><span><?php echo $value['path']; ?></span><br />
			</div>
			<?php
		endforeach;
		submit_button('Recompile');
		?>
	</div>

	<!-- ALl checkbox-->
	<script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#all").click(function() {
                if ($(this).is(':checked'))
                    $(".json_to_compile_all").attr('checked', true);
                else
                    $(".json_to_compile_all").attr('checked', false);
            });
        });
	</script>
</form>