<?php
/**
 * Section "fees": the four Velocrix plans from vx_plans() (functions.php / Customizer > Velocrix: Fees & Admission).
 * The rate card and the plan picker are built by site.js from the JSON in data-plans.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_plan_data = array();
foreach ( vx_plans() as $vx_p ) {
	$vx_months      = preg_match( '/(\d+)\s*month/i', $vx_p['name'], $vx_m ) ? (int) $vx_m[1] : ( preg_match( '/year/i', $vx_p['name'] ) ? 12 : 1 );
	$vx_plan_data[] = array(
		'name'   => $vx_p['name'],
		'price'  => (int) preg_replace( '/\D/', '', $vx_p['price'] ),
		'months' => $vx_months,
	);
}
if ( ! $vx_plan_data ) return;
$vx_regfee  = vx( 'vx_regfee', '1,999' );
$vx_regnote = vx( 'vx_regnote', 'Early bird discount available. *Terms & conditions apply.' );
$vx_first   = $vx_plan_data[ min( 1, count( $vx_plan_data ) - 1 ) ];
?>
  <section class="fees" id="fees" aria-labelledby="fees-h" style="padding-top:0" data-gfx="seams">
    <div class="wrap">
      <div style="display:grid;gap:24px;min-width:0" data-reveal>
        <div class="sec-head" style="margin-bottom:0">
          <h2 id="fees-h">Fees: <em>flexible plans</em> for every player.</h2>
          <p class="lede">Choose the plan that suits your child. A longer plan brings the monthly cost down. Tap a plan to see the fee.</p>
        </div>
        <div class="ratecard">
          <div style="overflow-x:auto">
          <table>
            <thead><tr><th>Plan</th><th class="n">Price</th><th class="n">Per month</th><th class="n">You save</th></tr></thead>
            <tbody id="rateBody" data-plans="<?php echo esc_attr( wp_json_encode( $vx_plan_data ) ); ?>"></tbody>
          </table>
          </div>
          <div class="foot">
            <?php if ( $vx_regfee ) : ?><span>Registration fee ₹<?php echo esc_html( $vx_regfee ); ?> extra (one time).</span><?php endif; ?>
            <?php if ( $vx_regnote ) : ?><span><?php echo esc_html( $vx_regnote ); ?></span><?php endif; ?>
          </div>
        </div>
      </div>
      <div class="calc" aria-labelledby="calc-h" data-reveal>
        <h3 id="calc-h">Your fee</h3>
        <div class="seg" role="radiogroup" aria-label="Plan" id="planSeg"></div>
        <div class="total" aria-live="polite">
          <small id="totLabel"><?php echo esc_html( $vx_first['name'] ); ?> plan</small>
          <span class="amt" id="totAmt">₹<?php echo esc_html( number_format( $vx_first['price'] ) ); ?></span>
          <small id="totNote"></small>
        </div>
        <a class="btn btn-primary mag" id="feeJoin" href="<?php echo esc_url( home_url( '/registration/' ) ); ?>" data-base="<?php echo esc_url( home_url( '/registration/' ) ); ?>">Join Now</a>
        <a class="btn btn-ghost btn-sm" href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">See what every plan includes</a>
      </div>
    </div>
  </section>
