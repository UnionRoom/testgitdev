<?php
$background_image = get_sub_field('background_image');
$css_class = get_sub_field('css_class');
$text = get_sub_field('text');
$alignment = get_sub_field('alignment');
?>

<!-- Full Bleed -->
<section class="section section--full-bleed u-align-<?php echo ($alignment) ? $alignment : ''; echo ($css_class) ? ' ' . $css_class : ''; ?>">
	<div class="full-bleed u-bg-cover"<?php echo ($background_image) ? ' style="background-image:url(\'' . $background_image['sizes']['full-bleed'] . '\')"' : ''; ?>>
	    <div class="u-table">
	        <div class="u-table-cell">
	            <div class="container">
	                <div class="text"><?php echo $text; ?></div>
	            </div>
	        </div>
		</div>
	</div>
</section>