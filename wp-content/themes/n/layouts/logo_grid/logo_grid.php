<?php
$background = get_sub_field('background');
$logos = get_sub_field('logos');
$css_class = get_sub_field('css_class');
?>

<!-- Logo Grid -->
<section class="section<?php echo ($css_class) ? ' ' . $css_class : ''; echo ($background) ? ' u-bg-' . $background : ''; ?>">
	<div class="container">

	    <div class="logo-grid">

            <?php 
            if($logos): 
            	foreach($logos as $logo): 
        	?>

	    	<div class="item"><img src="<?php echo $logo['url']; ?>"></div>

	    	<?php 
	    		endforeach; 
    		endif;
    		?>

	    </div>

    </div>
</section>