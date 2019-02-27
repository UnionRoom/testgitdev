<?php

// Button
function button_shortcode($atts) {
    extract(shortcode_atts(array(
        'link' => '#',
        'text' => 'Find out more',
        'class' => 'primary'
    ), $atts));

    $return = '<a class="btn btn--'.$class.'" href="'.$link.'">'.$text.'</a>';
    
    return $return;
}
add_shortcode('button', 'button_shortcode');

// Custom UL
function custom_ul($atts, $content) {
    extract(shortcode_atts(array(
      'class' => ''
    ), $atts));
    
    $return = '<ul class="'.$class.'">'.do_shortcode($content).'</ul>';
    $return =  preg_replace("#<br\s*/?>#i", "\n", $return);

    return $return;
}
add_shortcode('custom-ul', 'custom_ul');

// Cutsom LI
function li($atts, $content) {
    extract(shortcode_atts(array(
      'class' => ''
    ), $atts));

    $return = '<li class="'.$class.'">'.do_shortcode($content).'</li>';
    $return =  preg_replace("#<br\s*/?>#i", "\n", $return);

    return $return;
}
add_shortcode('li', 'li');
