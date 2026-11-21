<?php
get_header();
$img      = VX_URI . '/assets/img/';
$plans    = vx_plans();
$badge    = vx( 'vx_plan_badge', 'Best Value' );
$regfee   = vx( 'vx_regfee', '1,999' );
$join     = home_url( '/registration/' );
$phone    = vx( 'vx_phone', '+91 879 644 7595' );
$mentor   = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );

// Per-month cost and saving, worked out from the plans themselves (base = the 1-month plan).
$base = 0;
foreach ( $plans as $p ) if ( vx_plan_months( $p['name'] ) === 1 ) $base = (int) preg_replace( '/\D/', '', $p['price'] );
foreach ( $plans as $i => $p ) {
	$m     = vx_plan_months( $p['name'] );
	$price = (int) preg_replace( '/\D/', '', $p['price'] );
	$plans[ $i ]['months'] = $m;
	if ( $m > 1 && $price ) {
		$save = $base ? $base * $m - $price : 0;
		$plans[ $i ]['sub'] = '₹' . number_format( round( $price / $m ) ) . ' a month' . ( $save > 0 ? ' · save ₹' . number_format( $save ) : '' );
	} elseif ( 1 === $m ) {
		$plans[ $i ]['sub'] = 'Billed monthly';
	}
}

// 1. HERO (shared part)
get_template_part( 'template-parts/hero-page', null, array(
	'eyebrow' => 'Our Pricing Plans',
	'title'   => 'Your Easy Access to<br>Cricket Excellence',
	'text'    => 'Choose a training plan that powers your progress, built for consistent improvement and growth.',
	'image'   => $img . 'hero-pricing.jpg',
) );
?>

<!-- 2. PRICING (tabs) -->
<section class="section pricing-sec" id="plans">
	<div class="container">
		<h2 class="sr-only">Training plans and registration fee</h2>
			<div class="p-tabs" role="tablist" aria-label="Pricing categories">
			<button class="p-tab is-active" role="tab" aria-selected="true" aria-controls="tab-plans" id="t-plans">Training Plans</button>
			<button class="p-tab" role="tab" aria-selected="false" aria-controls="tab-reg" id="t-reg">Registration</button>
		</div>

		<div class="p-panel" id="tab-plans" role="tabpanel" aria-labelledby="t-plans">
			<div class="p-view" role="radiogroup" aria-label="Show prices as" hidden>
				<button type="button" role="radio" aria-checked="true" data-view="total">Full price</button>
				<button type="button" role="radio" aria-checked="false" data-view="month">Per month</button>
				<i class="p-view-pill" aria-hidden="true"></i>
			</div>
			<div class="pgrid p4">
				<?php foreach ( $plans as $p ) vx_plan_card( $p, add_query_arg( 'plan', rawurlencode( $p['name'] ), $join ) . '#form', 'Choose Plan', '', $badge ); ?>
			</div>
		</div>

		<div class="p-panel" id="tab-reg" role="tabpanel" aria-labelledby="t-reg">
			<div class="pgrid p1">
				<?php vx_plan_card( array(
					'name'     => 'Registration',
					'price'    => $regfee,
					'desc'     => 'One-time fee to join Velocrix Cricket Academy.',
					'features' => array( 'Paid once, separate from training plans', 'Early bird discount available', 'Open to players of all levels', 'Terms & conditions apply' ),
					'feat'     => true,
				), $join . '#form', 'Register Now', '/one-time', 'Early Bird Offer' ); ?>
			</div>
		</div>

		<p class="center muted small p-note">Fees shown are subject to change. Please confirm current fees and early bird terms by calling <a href="<?php echo esc_url( vx_phone_href( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>.</p>
	</div>
</section>

<?php
// 2b. PLAN FINDER: three quick questions -> a suggested plan (built by assets/js/motion.js).
// Answers point at plans by position (1st = shortest ... 4th = longest), matching each plan's own description.
$finder = array();
foreach ( $plans as $p ) {
	$finder[] = array(
		'name'  => $p['name'],
		'price' => $p['price'],
		'desc'  => $p['desc'],
		'sub'   => isset( $p['sub'] ) ? $p['sub'] : '',
		'url'   => add_query_arg( 'plan', rawurlencode( $p['name'] ), $join ) . '#form',
	);
}
$questions = array(
	array( 'How much cricket has the player played?', array( 'New to the game', 'Knows the basics', 'Plays regularly', 'Plays matches and wants more' ) ),
	array( 'What is the main goal right now?', array( 'Try it and build basics', 'Improve skills steadily', 'Lift performance', 'Long-term development' ) ),
	array( 'How long would you like to commit to start with?', array( 'One month', 'Around three months', 'Around six months', 'A full year' ) ),
);
if ( count( $finder ) >= 2 ) : ?>
<section class="section tint pf-sec" id="plan-finder" aria-labelledby="pf-h">
	<div class="container">
		<div class="pf" data-plans="<?php echo esc_attr( wp_json_encode( $finder ) ); ?>">
			<div class="pf-head">
				<span class="eyebrow">Plan Finder</span>
				<h2 id="pf-h">Not sure which plan<br>fits? Ask us in 3 taps.</h2>
				<p>Answer three quick questions and we will suggest a plan. It is only a starting point: our team confirms the right fit with you.</p>
			</div>
			<div class="pf-card">
				<div class="pf-progress" aria-hidden="true"><i></i></div>
				<?php foreach ( $questions as $qi => $q ) : ?>
				<fieldset class="pf-q" data-q="<?php echo (int) $qi; ?>"<?php echo $qi ? ' hidden' : ''; ?>>
					<legend><span><?php echo esc_html( sprintf( 'Question %d of %d', $qi + 1, count( $questions ) ) ); ?></span><?php echo esc_html( $q[0] ); ?></legend>
					<div class="pf-opts">
						<?php foreach ( $q[1] as $oi => $o ) : ?>
						<button type="button" class="pf-opt" data-v="<?php echo (int) $oi; ?>"><span class="pf-k"><?php echo esc_html( chr( 65 + $oi ) ); ?></span><?php echo esc_html( $o ); ?></button>
						<?php endforeach; ?>
					</div>
				</fieldset>
				<?php endforeach; ?>
				<div class="pf-result" hidden aria-live="polite">
					<span class="pf-tag">Suggested for you</span>
					<h3 class="pf-name"></h3>
					<p class="pf-price"></p>
					<p class="pf-desc"></p>
					<div class="btn-row">
						<a class="btn pf-go" href="<?php echo esc_url( $join ); ?>">Choose this plan</a>
						<button type="button" class="btn btn-ghost pf-again">Start again</button>
					</div>
					<p class="pf-note">Just a suggestion. Call <a href="<?php echo esc_url( vx_phone_href( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a> and our team will help you decide.</p>
				</div>
				<noscript><p>Turn on JavaScript to use the plan finder, or call <?php echo esc_html( $phone ); ?>.</p></noscript>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
// 3. MENTOR / TESTIMONIAL SLOT (shared part)
get_template_part( 'template-parts/quote-split', null, array(
	'eyebrow' => 'Our Mentor',
	'text'    => 'Mentorship that inspires. Training that transforms. Every plan is guided by the mentorship of ' . $mentor . ', International Cricketer, with expert coaching, scientific training and all-round development.',
	'image'   => $img . 'training-2.jpg',
) );

// 4. FAQ (shared part)
get_template_part( 'template-parts/faq', null, array( 'faqs' => array(
	array(
		array( 'What is included in every plan?', 'Expert coaching from qualified and experienced coaches, fitness and skill development, teamwork and character building, a professional training environment and a pathway to professional cricket.' ),
		array( 'Is the registration fee separate?', 'Yes. Registration is a one-time fee of ₹' . $regfee . ' and training plans are paid separately.' ),
		array( 'Is there an early bird discount?', 'Early bird discounts are available for a limited period. Please contact us to confirm current offers and terms.' ),
	),
	array(
		array( 'Which plan should I choose?', 'Start with 1 Month to explore the basics, choose 3 Months for structured progress, 6 Months for advanced performance coaching, or 1 Year for complete long-term development.' ),
		array( 'How do I enrol?', 'Choose a plan on this page or fill in the admission form. You can also call us on ' . $phone . ' and our team will guide you.' ),
		array( 'Where do the sessions take place?', 'At Sarvottam International School, Sector 10 Campus, Greater Noida West.' ),
	),
) ) );

get_footer();
