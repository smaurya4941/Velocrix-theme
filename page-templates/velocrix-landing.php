<?php
/**
 * Template Name: Velocrix Animated Home
 * Description: Full animated one-page design (intro, 3D Training Lab, Nets Challenge game). Uses its own header and footer.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#061D14">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/landing/page' ); ?>
<?php wp_footer(); ?>
</body>
</html>
