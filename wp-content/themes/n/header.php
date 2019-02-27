<!DOCTYPE html>
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>
<html class="ie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!-->
<html lang="en" class="no-js"><!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <title><?php wp_title(''); ?></title>

    <link rel="icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon">
    
    <?php wp_head(); ?>
    <script type="text/javascript">
        var site_url = '<?php echo bloginfo('url'); ?>';
        var theme_url = '<?php echo bloginfo('template_url'); ?>';
    </script>
</head>
<body <?php body_class(); ?>>

<!-- Site Wrapper -->
<main class="site-wrapper">

<!-- Header -->
<header class="header">
    <div class="header-inner clearfix">

        <a class="logo" href="/">
            <h1>Logo</h1>
        </a>

        <nav class="header-nav">
            <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_class' => 'menu clearfix' ) ); ?>
            <?php wp_nav_menu( array( 'theme_location' => 'sub-menu', 'container_class' => 'menu clearfix' ) ); ?>
        </nav>

        <button class="nav-toggle">
          <span></span>
          <span></span>
          <span></span>
        </button>


    </div>
</header>