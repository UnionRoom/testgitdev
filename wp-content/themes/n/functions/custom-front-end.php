<?php

// #Setting up thumbnails

add_theme_support( 'post-thumbnails' );
add_image_size('full-bleed', 1800, 750, true);
add_image_size('square640', 640, 640, true);
add_image_size('rectangle640', 640, 320, true);
add_image_size('logos', 9999, 70, true);

// #Wrap iframe in div

add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);
function my_embed_oembed_html($html, $url, $attr, $post_id) {
	return '<div class="video">' . $html . '</div>';
}

// General Pagination

function pagination($query, $slug, $pages = '', $range = 2, $suffix = '') {
    $morepages = ($range * 2) + 1;
    global $paged;
    if (empty($paged))
        $paged = 1;
    if ($pages == '') {
        $pages = $query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    } if (1 != $pages) {
        echo '<div class="pagination"><ul class="clearfix">';

        //Range of pages
        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $morepages )) {
                echo ($paged == $i) ? '<li><a class="active">' . $i : '<li><a href="' . $slug . $i . '/' . $suffix . '">' . $i . '</a>';
            }
        }

        echo '</ul></div>';
    }
}
