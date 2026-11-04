<?php
get_header();
$img      = VX_URI . '/assets/img/';
$plans    = vx_plans();
$badge    = vx( 'vx_plan_badge', 'Best Value' );
$regfee   = vx( 'vx_regfee', '1,999' );
$join     = home_url( '/registration/' );
$phone    = vx( 'vx_phone', '+91 879 644 7595' );
$mentor   = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );

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
		<div class="p-tabs" role="tablist" aria-label="Pricing categories">
			<button class="p-tab is-active" role="tab" aria-selected="true" aria-controls="tab-plans" id="t-plans">Training Plans</button>
			<button class="p-tab" role="tab" aria-selected="false" aria-controls="tab-reg" id="t-reg">Registration</button>
		</div>

		<div class="p-panel" id="tab-plans" role="tabpanel" aria-labelledby="t-plans">
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
