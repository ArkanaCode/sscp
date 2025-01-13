<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <?php wp_head(); ?>
</head>
<?php get_header(); ?>
<body <?php body_class(); ?>>
    <main>
        <p>Hello, World! This is my custom theme. I am index.php</p>
    </main>
    <?php get_footer(); ?>
</body>
</html>