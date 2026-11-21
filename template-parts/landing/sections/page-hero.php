<?php
/**
 * Section "page-hero": opening block of the animated inner pages (Training, Training Lab hub and tool pages).
 * Text comes from vx_landing_page_hero() in inc/landing.php. Styles: assets/landing/css/pages.css.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_h = vx_landing_page_hero( vx_landing_view() );
if ( ! $vx_h ) return;
?>
<section class="phero<?php echo empty( $vx_h['stats'] ) ? ' phero-tool' : ''; ?>" aria-labelledby="ph-h" data-gfx="contour:tr icons">
  <div class="phero-glow" aria-hidden="true"></div>
  <div class="wrap">
    <nav class="crumbs" aria-label="Breadcrumb">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span aria-hidden="true">/</span><?php if ( ! empty( $vx_h['parent'] ) ) : ?><a href="<?php echo esc_url( $vx_h['parent'][1] ); ?>"><?php echo esc_html( $vx_h['parent'][0] ); ?></a><span aria-hidden="true">/</span><?php endif; ?><span aria-current="page"><?php echo esc_html( get_the_title() ); ?></span>
    </nav>
    <p class="kicker"><?php echo esc_html( $vx_h['kicker'] ); ?></p>
    <h1 id="ph-h" class="phero-h">
      <span class="ln"><span><?php echo esc_html( $vx_h['title'][0] ); ?></span></span>
      <span class="ln"><span><em><?php echo esc_html( $vx_h['title'][1] ); ?></em></span></span>
    </h1>
    <p class="lede"><?php echo esc_html( $vx_h['lede'] ); ?></p>
    <?php if ( ! empty( $vx_h['stats'] ) ) : ?>
    <div class="phero-stats">
      <?php foreach ( $vx_h['stats'] as $vx_s ) : ?>
        <div><b data-count="<?php echo esc_attr( $vx_s[0] ); ?>"><?php echo esc_html( $vx_s[0] ); ?></b><span><?php echo esc_html( $vx_s[1] ); ?></span></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ( ! empty( $vx_h['jumps'] ) ) : ?>
    <nav class="jumps" aria-label="On this page">
      <?php $vx_i = 0; foreach ( $vx_h['jumps'] as $vx_id => $vx_label ) : $vx_i++; ?>
        <a href="#<?php echo esc_attr( $vx_id ); ?>" style="--i:<?php echo (int) $vx_i; ?>"><i><?php echo esc_html( sprintf( '%02d', $vx_i ) ); ?></i><?php echo esc_html( $vx_label ); ?><svg aria-hidden="true" width="14" height="14"><use href="#i-right"/></svg></a>
      <?php endforeach; ?>
    </nav>
    <?php endif; ?>
  </div>
  <div class="phero-scroll" aria-hidden="true"><span></span></div>
</section>
