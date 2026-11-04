<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#050505">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main">Skip to content</a>

<?php if ( $status = vx( 'vx_status', 'Registrations are open. Early bird discount available.' ) ) : ?>
<div class="topbar">
	<div class="container">
		<span><?php echo esc_html( $status ); ?></span>
		<a href="<?php echo esc_url( vx_phone_href( vx( 'vx_phone', '+91 879 644 7595' ) ) ); ?>"><?php echo esc_html( vx( 'vx_phone', '+91 879 644 7595' ) ); ?></a>
	</div>
</div>
<?php endif; ?>

<header class="site-header" id="top">
	<div class="container bar">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Velocrix Cricket Academy">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<span class="brand-mark">VELOCRIX</span><span class="brand-sub">Cricket Academy</span>
			<?php endif; ?>
		</a>
		<button class="nav-toggle" aria-expanded="false" aria-controls="nav" aria-label="Menu"><span></span><span></span><span></span></button>
		<nav class="nav" id="nav" aria-label="Primary"><?php vx_primary_menu(); ?></nav>
		<a class="btn btn-sm head-cta" href="<?php echo esc_url( home_url( '/admission/' ) ); ?>">Join Academy</a>
	</div>
</header>

<main id="main">
