<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <title><?php wp_title(''); ?></title>

    <link rel="icon" href="<?php echo get_stylesheet_directory_uri() ; ?>/favicon.ico" type="image/x-icon">
    
    <?php wp_head(); ?>
    <script type="text/javascript">
        var site_url = '<?php echo bloginfo('url'); ?>';
        var theme_url = '<?php echo get_stylesheet_directory_uri(); ?>';
    </script>
</head>
<body <?php body_class(); ?>>