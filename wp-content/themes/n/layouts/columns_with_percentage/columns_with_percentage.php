<?php
$background = get_sub_field('background');
$css_class = get_sub_field('css_class');
$alignment = get_sub_field('alignment');
$columns = get_sub_field('columns');
?>

<!-- Columns with Percentage -->
<section class="section u-align-<?php echo $alignment; echo ($css_class) ? ' ' . $css_class : ''; echo ($background) ? ' u-bg-' . $background : ''; ?>">
    <div class="container">
		<div class="col-wrapper clearfix">

            <?php 
            if ($columns): 
                foreach($columns as $col):
                    $percentage = $col['percentage'];
                    $text = $col['text'];
                    $text_hover = $col['text_hover'];
                    $link = $col['link'];
                    $image_array = $col['image'];
                    $image = ((int) $percentage > 50) ? $image_array['sizes']['full-bleed'] : $image_array['sizes']['rectangle640'];
            ?>

                <div class="col--<?php echo $percentage; echo ($text_hover) ? ' col--text-hover' : ''; ?>">
                    <?php echo ($link && strlen($link)) ? '<a href="' . $link . '" class="u-link-inherit u-link-block">': ''; ?>

                    <?php echo ($image) ? '<div style="background-image: url(\'' . $image . '\');" class="image bg--cover">': ''; ?>

                    <?php echo ($text_hover && strlen($text_hover)) ? '<div class="u-table"><div class="u-table-cell">': '';?>

                        <div class="text"><?php echo $text; ?></div>

                        <?php if($text_hover && strlen($text_hover)): ?>
                        <div class="text text--hover"><?php echo $text_hover; ?></div>
                        <?php endif; ?>

                    <?php echo ($text_hover && strlen($text_hover)) ? '</div></div>': '';?>

                    <?php echo ($image) ? '</div>': ''; ?>

                    <?php echo ($link && strlen($link)) ? '</a>': ''; ?>
                </div>

            <?php
                endforeach; 
            endif; 
            ?>

		</div>
    </div>
</section>