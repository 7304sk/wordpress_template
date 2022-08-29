<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- meta information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- page title -->
    <?php meta_title(); ?>
    <!-- font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&family=Noto+Serif+JP:wght@200;300;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">
    <!-- WP head -->
    <?php wp_head(); ?>
</head>

<body>
    <header>
        <div class="centering">
            <h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            <?php get_search_form(); ?>
        </div>
    </header>
    <nav id="global-nav">
        <?php wp_nav_menu(array(
            'theme_location'    => 'global-menu',
            'container'         => '',
            'container_id'      => '',
            'menu_class'        => 'centering'
        )); ?>
    </nav>