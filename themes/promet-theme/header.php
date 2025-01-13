<!-- header.php -->

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php wp_head(); // Always include wp_head() ?>
</head>
<body <?php body_class(); ?>>

<header>
    <div class="site-header">
        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Site Logo">
            </a>
        </div>

        <nav>
            <?php 
                wp_nav_menu( array(
                    'theme_location' => 'main-menu',
                    'container' => 'ul',
                    'menu_class' => 'main-menu',
                ) );
            ?>
        </nav>
    </div>
</header>
