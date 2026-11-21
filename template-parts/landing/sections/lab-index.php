<?php
/**
 * Section "lab-index": every Training Lab tool as a card linking to its own page.
 * Used on the Training Lab hub and near the end of the Training page. Data: vx_lab_tools() (inc/training-lab.php).
 * Styles: assets/landing/css/lab.css.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_hub   = 'training-lab' === vx_landing_view();
$vx_tools = vx_lab_tools();
?>
<section class="lxi" id="lab-tools" aria-labelledby="lxi-h" data-gfx="<?php echo $vx_hub ? 'field:right' : 'seams'; ?>">
  <div class="wrap">
    <div class="sec-head lxi-head" data-reveal>
      <p class="kicker"><?php echo $vx_hub ? 'Pick a tool' : 'The Velocrix Training Lab'; ?></p>
      <h2 id="lxi-h"><?php echo $vx_hub ? 'One tool, <em>one page.</em>' : 'Try it before <em>the first session.</em>'; // phpcs:ignore ?></h2>
      <p class="lede"><?php echo $vx_hub
        ? 'Every tool opens on its own page, so it loads fast and works the same on a phone. Start anywhere.'
        : esc_html( count( $vx_tools ) ) . ' hands-on tools: bowl a delivery in 3D, set a batting stance, learn the field, check bat size and more.'; // phpcs:ignore ?></p>
    </div>
    <ol class="lxi-grid">
      <?php $vx_n = 0; foreach ( $vx_tools as $vx_slug => $vx_t ) : $vx_n++; ?>
      <li class="lxi-card" data-reveal style="--i:<?php echo (int) $vx_n; ?>">
        <a href="<?php echo esc_url( vx_lab_tool_url( $vx_slug ) ); ?>">
          <span class="lxi-img"><img src="<?php echo esc_url( vx_lab_img( $vx_t ) ); ?>" alt="" loading="lazy" width="640" height="420"></span>
          <span class="lxi-body">
            <span class="lxi-top"><span class="lxi-n"><?php echo esc_html( sprintf( '%02d', $vx_n ) ); ?></span><span class="lxi-tag"><?php echo esc_html( $vx_t['tag'] ); ?></span></span>
            <b><?php echo esc_html( $vx_t['title'] ); ?></b>
            <small><?php echo esc_html( $vx_t['card'] ); ?></small>
            <span class="lxi-go">Open <svg aria-hidden="true" width="14" height="14"><use href="#i-right"/></svg></span>
          </span>
        </a>
      </li>
      <?php endforeach; ?>
    </ol>
    <?php if ( ! $vx_hub ) : ?>
    <p class="lxi-all" data-reveal><a class="btn btn-ghost mag" href="<?php echo esc_url( vx_lab_hub_url() ); ?>">Open the Training Lab</a></p>
    <?php endif; ?>
  </div>
</section>
