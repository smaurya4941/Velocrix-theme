<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#0b0b0d">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main">Skip to content</a>

<header class="site-header" id="top">
	<div class="bar">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Velocrix Cricket Academy">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<img class="brand-logo" src="<?php echo esc_url( VX_URI . '/assets/img/logo-mark.png' ); ?>" alt="" width="54" height="50"><span class="brand-txt"><span class="brand-mark">VELOCRIX</span><span class="brand-sub">Cricket Academy</span></span>
			<?php endif; ?>
		</a>
		<nav class="nav" id="nav" aria-label="Primary"><?php vx_primary_menu(); ?>
			<a class="btn btn-sm nav-cta" href="<?php echo esc_url( home_url( '/registration/' ) ); ?>">Join Now</a>
		</nav>
		<button class="nav-toggle" aria-expanded="false" aria-controls="nav" aria-label="Menu"><span></span><span></span><span></span></button>
	</div>
</header>

<main id="main">
