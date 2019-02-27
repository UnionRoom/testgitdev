<?php
$css_class = get_sub_field('css_class');
$alignment = get_sub_field('alignment');
$content_type = get_sub_field('content_type');

$grid_items = array();

if( $content_type == 'custom' ) {
	$grid = get_sub_field('grid');
	foreach($grid as $grid_item) {
		$grid_items[] = array('text' => $grid_item['text'], 'sub_title' => $grid_item['sub_title'], 'link' => $grid_item['link'], 'image' => $grid_item['image']['sizes']['square640']);
	}
} else {
	$post_type = get_sub_field('content_mosiac_post_type');

	$args = array(
			'post_type' => $post_type,
			'posts_per_page' => 6
		);

	$post_type_items = new WP_Query( $args );

	if( $post_type_items->have_posts() ) {
		while ( $post_type_items->have_posts() ) {
			$post_type_items->the_post();
			$text = '<h3>' . get_the_title() . '</h3>';
            $sub_title = get_field('sub_title');
            $link = get_the_permalink();
			$image = get_the_post_thumbnail_url( NULL, 'square640');
			$grid_items[] = array('text' => $text, 'sub_title' => $sub_title, 'link' => $link, 'image' => $image);
		}
	}
	wp_reset_query();
}
?>

<!-- Content Grid -->
<section class="section section--mosaic u-align-<?php echo $alignment; echo ($css_class) ? ' ' . $css_class : ''; ?>">
    <div class="content-grid">

    	<?php
    	$count = 1;
    	if(count($grid_items) > 0):
	    	foreach($grid_items as $item):
				$item_class = 'square';
	    		if($count == 1)
	    			$item_class = 'rectangle';
	    		elseif($count == 2)
	    			$item_class = 'large';
    	?>
    	<div class="grid-item--<?php echo $item_class; ?> item-<?php echo $count; ?>">
    		<a class="u-link-block" href="<?php echo $item['link']; ?>">
	    		<div class="image u-bg-cover" style="background-image:url('<?php echo $item['image']; ?>')">
		    		<div class="u-table">
		    			<div class="u-table-cell">
                            <?php echo $item['text']; ?>
                            <?php echo ($item['sub_title']) ? '<p>'.$item['sub_title'].'</p>' : ''; ?>
                        </div>
		    		</div>
	    		</div>
    		</a>
    	</div>

    	<?php
	    		$count++;
			endforeach;
		endif;
		?>

    </div>
</section>