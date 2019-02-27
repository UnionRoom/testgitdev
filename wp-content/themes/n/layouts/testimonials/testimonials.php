<?php
global $layout_count;

$background = get_sub_field('background');
$css_class = get_sub_field('css_class');
$alignment = get_sub_field('alignment');
$testimonials = get_sub_field('testimonials');
$js_var = get_sub_field('js_var');
if( ! $js_var )
    $js_var = 'slider_' . $layout_count;

if ($testimonials && count($testimonials) > 1):
    wp_enqueue_script( 'royalslider', get_template_directory_uri() . '/js/royalslider.min.js', array(), '1.0', TRUE );
endif;

?>

<!-- Testimonials -->
<section class="section u-align-<?php echo $alignment; echo ($css_class) ? ' ' . $css_class : ''; echo ($background) ? ' u-bg-' . $background : ''; ?>">
    <div class="container">

        <div class="testimonials<?php echo ($testimonials && count($testimonials) > 1) ? ' testimonials--standard': ''; ?>"
                <?php echo ($testimonials && count($testimonials) > 1) ? ' data-js-var="' . $js_var . '"': ''; ?>>

            <?php
            if($testimonials):
                foreach ($testimonials as $testimonial) :
                    $quote = $testimonial['quote'];
                    $name = $testimonial['name'];
                    $title = $testimonial['title'];
            ?>

            <blockquote>
                <div class="quote">
                    <h4>
                    <span class="speech"><span class="open"></span></span>
                    <?php echo $quote; ?>
                    <span class="speech"><span class="close"></span></span>
                    </h4>
                </div>
                <p class="name"><?php echo $name; ?></p>
                <p class="title"><?php echo $title; ?></p>
            </blockquote>

            <?php
                endforeach;
            endif;
            ?>

        </div>

    </div>
</section>