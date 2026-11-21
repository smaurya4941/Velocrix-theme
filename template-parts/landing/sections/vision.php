<?php
/**
 * Section "vision" (About): Vision / Mission as tabs with a photo that swaps (pages.js). Text = classic About copy.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_img  = VX_URI . '/assets/img/';
$vx_tabs = array(
	'vision'  => array( 'Our Vision', 'To make quality cricket training accessible and help young cricketers turn their potential into performance.', 'prog-2.jpg', 'Coach demonstrating a drill to young players', home_url( '/services/' ), 'See our services' ),
	'mission' => array( 'Our Mission', 'Professional coaching, scientific training, real match exposure and a pathway to a brighter future.', 'prog-1.jpg', 'Young cricketers training together', home_url( '/pricing/' ), 'See the plans' ),
);
?>
<section class="vm-sec" id="vision" aria-labelledby="vm-h">
  <div class="wrap">
    <div class="vm-copy" data-reveal>
      <p class="kicker">Vision &amp; mission</p>
      <h2 id="vm-h">Where players train, grow <em>and compete.</em></h2>
      <div class="vm-tabs" role="tablist" aria-label="Vision and mission">
        <?php $vx_first = true; foreach ( $vx_tabs as $vx_k => $vx_t ) : ?>
          <button type="button" role="tab" id="vmt-<?php echo esc_attr( $vx_k ); ?>" aria-controls="vmp-<?php echo esc_attr( $vx_k ); ?>" aria-selected="<?php echo $vx_first ? 'true' : 'false'; ?>"<?php echo $vx_first ? '' : ' tabindex="-1"'; ?>><?php echo esc_html( $vx_t[0] ); ?></button>
        <?php $vx_first = false; endforeach; ?>
        <span class="vm-ind" aria-hidden="true"></span>
      </div>
      <?php $vx_first = true; foreach ( $vx_tabs as $vx_k => $vx_t ) : ?>
        <div class="vm-panel" role="tabpanel" id="vmp-<?php echo esc_attr( $vx_k ); ?>" aria-labelledby="vmt-<?php echo esc_attr( $vx_k ); ?>"<?php echo $vx_first ? '' : ' hidden'; ?>>
          <p class="vm-text"><?php echo esc_html( $vx_t[1] ); ?></p>
          <a class="btn btn-ghost btn-sm mag" href="<?php echo esc_url( $vx_t[4] ); ?>"><?php echo esc_html( $vx_t[5] ); ?> <svg aria-hidden="true"><use href="#i-right"/></svg></a>
        </div>
      <?php $vx_first = false; endforeach; ?>
    </div>
    <div class="vm-photos" data-reveal>
      <?php $vx_first = true; foreach ( $vx_tabs as $vx_k => $vx_t ) : ?>
        <img class="<?php echo $vx_first ? 'on' : ''; ?>" data-tab="<?php echo esc_attr( $vx_k ); ?>" src="<?php echo esc_url( $vx_img . $vx_t[2] ); ?>" alt="<?php echo esc_attr( $vx_t[3] ); ?>" loading="lazy" width="800" height="800">
      <?php $vx_first = false; endforeach; ?>
      <span class="vx-seal" aria-hidden="true">
        <svg viewBox="0 0 120 120"><defs><path id="vmCirc" d="M60,60 m-44,0 a44,44 0 1,1 88,0 a44,44 0 1,1 -88,0"/></defs><text textLength="272" lengthAdjust="spacing"><textPath href="#vmCirc">WHERE DREAMS MEET DISCIPLINE · VELOCRIX ·</textPath></text></svg>
        <img src="<?php echo esc_url( vx_asset( 'assets/img/logo-mark.png' ) ); ?>" alt="" width="54" height="50">
      </span>
    </div>
  </div>
</section>
