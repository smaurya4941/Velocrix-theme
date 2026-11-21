<?php
/**
 * Section "lab-more": shown after the tool on every Training Lab tool page.
 * Previous / next tool plus quick links to all the others. Data: vx_lab_tools() (inc/training-lab.php).
 * Styles: assets/landing/css/lab.css.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_cur = vx_landing_view();
$vx_all = vx_lab_tools();
if ( ! isset( $vx_all[ $vx_cur ] ) ) return;
list( $vx_prev, $vx_next ) = vx_lab_neighbours( $vx_cur );
?>
<section class="lxm" aria-labelledby="lxm-h">
  <div class="wrap">
    <div class="lxm-card" data-reveal>
      <div class="lxm-head">
        <p class="kicker">More from the Training Lab</p>
        <h2 id="lxm-h">Try <em>another tool.</em></h2>
      </div>
      <nav class="lxm-pn" aria-label="Previous and next tool">
        <a class="lxm-prev" href="<?php echo esc_url( vx_lab_tool_url( $vx_prev ) ); ?>" rel="prev"><svg aria-hidden="true" width="18" height="18"><use href="#i-left"/></svg><span><small>Previous</small><b><?php echo esc_html( $vx_all[ $vx_prev ]['title'] ); ?></b></span></a>
        <a class="lxm-next" href="<?php echo esc_url( vx_lab_tool_url( $vx_next ) ); ?>" rel="next"><span><small>Next</small><b><?php echo esc_html( $vx_all[ $vx_next ]['title'] ); ?></b></span><svg aria-hidden="true" width="18" height="18"><use href="#i-right"/></svg></a>
      </nav>
      <ul class="lxm-list">
        <?php $vx_n = 0; foreach ( $vx_all as $vx_slug => $vx_t ) : $vx_n++; $vx_on = $vx_slug === $vx_cur; ?>
        <li><a href="<?php echo esc_url( vx_lab_tool_url( $vx_slug ) ); ?>"<?php echo $vx_on ? ' aria-current="page"' : ''; ?>><i><?php echo esc_html( sprintf( '%02d', $vx_n ) ); ?></i><?php echo esc_html( $vx_t['title'] ); ?></a></li>
        <?php endforeach; ?>
        <li><a class="lxm-hub" href="<?php echo esc_url( vx_lab_hub_url() ); ?>">All tools</a></li>
      </ul>
    </div>
  </div>
</section>
