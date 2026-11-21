<?php
/**
 * Section "cta": closing call to action on the animated inner pages.
 * Free trial: the animated Home's trial form, or WhatsApp when Home uses the classic design (vx_lx( 'visit' )).
 * Register goes to the theme's registration page. The "next" link moves between Training and the Training Lab.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_view = vx_landing_view();
if ( 'training' === $vx_view ) {
	$vx_next = array( vx_lab_hub_url(), 'Next: the Training Lab', 'Bowl, bat and field in 3D' );
} elseif ( 'training-lab' === $vx_view || vx_lab_tool( $vx_view ) ) {
	$vx_next = array( home_url( '/training/' ), 'Next: how we train', 'The week, the levels and the trial' );
} else {
	$vx_next = array( vx_lab_hub_url(), 'Next: the Training Lab', 'Bowl, bat and field in 3D' );
}
?>
<section class="pcta" aria-labelledby="pcta-h">
  <div class="wrap">
    <div class="pcta-card" data-reveal>
      <div class="pcta-ball" aria-hidden="true"><i></i></div>
      <p class="kicker">Free trial, no obligation</p>
      <h2 id="pcta-h">See it on the ground. <em>Bring your child to a session.</em></h2>
      <p class="lede">Your child joins a real session, we assess their level, and within a day we call you with the batch and plan that fits.</p>
      <div class="pcta-acts">
        <a class="btn btn-primary mag" href="<?php echo esc_url( vx_lx( 'visit' ) ); ?>">Book a free trial</a>
        <a class="btn btn-ghost mag" href="<?php echo esc_url( home_url( '/registration/' ) ); ?>">Register now</a>
      </div>
      <a class="pcta-next" href="<?php echo esc_url( $vx_next[0] ); ?>"><span><b><?php echo esc_html( $vx_next[1] ); ?></b><small><?php echo esc_html( $vx_next[2] ); ?></small></span><svg aria-hidden="true" width="18" height="18"><use href="#i-right"/></svg></a>
    </div>
  </div>
</section>
