<?php
/**
 * Velocrix animated pages: page body.
 * Each section is its own file in template-parts/landing/sections/; which sections a page shows is decided by
 * vx_landing_sections() in inc/landing.php. Styles: assets/landing/css, scripts: assets/landing/js.
 * Loaded by page-templates/velocrix-landing.php (Home) and by the animated inner pages.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$vx_view = vx_landing_view();

get_template_part( 'template-parts/landing/parts/sprite' );
if ( 'home' === $vx_view ) {
	get_template_part( 'template-parts/landing/parts/intro' );
}
get_template_part( 'template-parts/site-header' );
?>

<main id="home">
<?php
foreach ( vx_landing_sections( $vx_view ) as $vx_section ) {
	get_template_part( 'template-parts/landing/sections/' . $vx_section );
}
?>
</main>

<?php
get_template_part( 'template-parts/site-footer' ); // same footer as every other page
get_template_part( 'template-parts/landing/parts/float' );
