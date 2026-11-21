<?php
/**
 * Section "pillars" (Home + About): the six training pillars from inc/content.php ( vx_copy( 'pillars' ) ).
 * Pick a pillar on the left; the detail card on the right changes. Auto-advances until the visitor interacts (pages.js).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_pillars = vx_copy( 'pillars' );
if ( ! $vx_pillars ) return;
// simple line icons, one per pillar (same order as the data)
$vx_icons = array(
	'<path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4Z"/><path d="M17 6h3a3 3 0 0 1-3 3M7 6H4a3 3 0 0 0 3 3"/>',
	'<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.5"/>',
	'<path d="M3 12h4l2-5 4 10 2-5h6"/>',
	'<circle cx="12" cy="12" r="9"/><path d="M8.5 4.2c1.6 2.3 1.6 13.3 0 15.6M15.5 4.2c-1.6 2.3-1.6 13.3 0 15.6"/>',
	'<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
	'<path d="M4 20h4v-5h4v-5h4V5h4"/><path d="M16 5h4v4"/>',
);
$vx_id = 'pl-' . vx_landing_view();
?>
<section class="pl-sec" id="pillars" aria-labelledby="<?php echo esc_attr( $vx_id ); ?>-h" data-gfx="contour:tr">
  <div class="wrap">
    <div class="pl-head" data-reveal>
      <p class="kicker">How we build players</p>
      <h2 id="<?php echo esc_attr( $vx_id ); ?>-h"><?php echo esc_html( count( $vx_pillars ) ); ?> pillars of <em>every Velocrix session.</em></h2>
    </div>
    <div class="pl-grid" data-pillars>
      <div class="pl-list" role="tablist" aria-label="Training pillars" aria-orientation="vertical">
        <?php foreach ( $vx_pillars as $vx_i => $vx_p ) : ?>
          <button type="button" role="tab" id="<?php echo esc_attr( $vx_id . '-t' . $vx_i ); ?>" aria-controls="<?php echo esc_attr( $vx_id . '-p' . $vx_i ); ?>" aria-selected="<?php echo 0 === $vx_i ? 'true' : 'false'; ?>"<?php echo 0 === $vx_i ? '' : ' tabindex="-1"'; ?>>
            <span class="pl-n"><?php echo esc_html( sprintf( '%02d', $vx_i + 1 ) ); ?></span>
            <span class="pl-t"><?php echo esc_html( $vx_p[0] ); ?></span>
            <span class="pl-bar" aria-hidden="true"><i></i></span>
          </button>
        <?php endforeach; ?>
      </div>
      <div class="pl-stage">
        <?php foreach ( $vx_pillars as $vx_i => $vx_p ) : ?>
          <article class="pl-card" role="tabpanel" id="<?php echo esc_attr( $vx_id . '-p' . $vx_i ); ?>" aria-labelledby="<?php echo esc_attr( $vx_id . '-t' . $vx_i ); ?>"<?php echo 0 === $vx_i ? '' : ' hidden'; ?>>
            <span class="pl-big" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $vx_i + 1 ) ); ?></span>
            <svg class="pl-ico" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?php echo $vx_icons[ $vx_i % count( $vx_icons ) ]; // phpcs:ignore -- static SVG ?></g></svg>
            <h3><?php echo esc_html( $vx_p[0] ); ?></h3>
            <p><?php echo esc_html( $vx_p[1] ); ?></p>
            <span class="pl-of"><?php echo esc_html( sprintf( 'Pillar %d of %d', $vx_i + 1, count( $vx_pillars ) ) ); ?></span>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
