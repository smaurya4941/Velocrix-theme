<?php
/**
 * Site header (logo, primary menu, Join Now, mobile toggle).
 * Shared by header.php (classic pages) and the "Velocrix Animated Home" template, so the navbar is identical everywhere.
 * id="top" / id="nav" / id="menuBtn" are also used by the animated page's site.js (scroll hide + mobile toggle).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<header class="site-header" id="top">
	<div class="bar">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<img class="brand-logo" src="<?php echo esc_url( VX_URI . '/assets/img/logo-mark.png' ); ?>" alt="" width="54" height="50"><span class="brand-txt"><span class="brand-mark">VELOCRIX</span><span class="brand-sub">Cricket Academy</span></span>
			<?php endif; ?>
		</a>
		<nav class="nav" id="nav" aria-label="Primary"><?php vx_primary_menu(); ?>
			<a class="btn btn-sm nav-cta" href="<?php echo esc_url( home_url( '/registration/' ) ); ?>">Join Now</a>
		</nav>
		<button class="nav-toggle" id="menuBtn" aria-expanded="false" aria-controls="nav" aria-label="Menu"><span></span><span></span><span></span></button>
	</div>
</header>
