<?php
$background = get_sub_field('background');
$css_class = get_sub_field('css_class');
$alignment = get_sub_field('alignment');
$content_type = get_sub_field('content_type');
$no_of_columns = get_sub_field('no_of_columns');

$col_items = array();

if( $content_type == 'custom' ) {
    $columns = get_sub_field('columns');
    foreach($columns as $col_item) {
        $col_items[] = array('image' => $col_item['image'], 'text' => $col_item['text']);
    }
} else {
    $post_type = get_sub_field('columns_with_image_post_type');


    if ($no_of_columns == '50') {
        $no_of_posts = 2;
    } elseif ($no_of_columns == '33') {
        $no_of_posts = 3;
    } elseif ($no_of_columns == '25') {
        $no_of_posts = 4;
    } elseif ($no_of_columns == '20') {
        $no_of_posts = 5;
    } else {
        $no_of_posts = 1;
    }

    $args = array(
            'post_type' => $post_type,
            'posts_per_page' => $no_of_posts
        );

    $post_type_items = new WP_Query( $args );

    if( $post_type_items->have_posts() ) {
        while ( $post_type_items->have_posts() ) {
            $post_type_items->the_post();
            $image = get_the_post_thumbnail_url( NULL, 'square640');
            $text = '<h3>' . get_the_title() . '</h3>';
            $link = get_the_permalink();
            $col_items[] = array('image' => $image, 'text' => $text);
        }
    }
    wp_reset_query();
}

?>

<!-- Columns with Title/Image -->
<section class="section u-align-<?php echo $alignment; echo ($css_class) ? ' ' . $css_class : ''; echo ($background) ? ' u-bg-' . $background : ''; ?>">
    <div class="container">
		<div class="col-wrapper clearfix">

            <?php 
            if ($col_items): 
                foreach($col_items as $col):
                    $image = $col['image'];
                    $text = $col['text'];
            ?>

			<div class="col--<?php echo $no_of_columns; ?>">
            <?php if ( $content_type == 'custom' ) : ?>
                <img class="image" src="<?php echo $image['sizes']['square640']; ?>"<?php echo ($image['alt'] != '') ? ' alt="' . $image['alt'] . '"' : ''; ?> />
            <?php else : ?>
                <img class="image" src="<?php echo $image; ?>">
            <?php endif; ?>
				<div class="text">
                    <?php echo $text; ?>
                    <?php if ( $content_type == 'post type' ) { echo '<a class="u-link-inherit" href="' .$link. '">Read more</a>'; } ?>
                </div>
			</div>

            <?php
                endforeach; 
            endif; 
            ?>

		</div>
    </div>
</section>