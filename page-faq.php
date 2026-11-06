<?php
get_header();
$img     = VX_URI . '/assets/img/';
$phone   = vx( 'vx_phone', '+91 879 644 7595' );
$email   = vx( 'vx_email', 'admissions@velocrix.com' );
$regfee  = vx( 'vx_regfee', '1,999' );
$mentor  = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
$role    = vx( 'vx_mentor_role', 'International Cricketer' );
$address = vx( 'vx_address', 'Sarvottam International School, Sector 10 Campus, Greater Noida West' );

// 1. HERO (shared part)
get_template_part( 'template-parts/hero-page', null, array(
	'eyebrow' => 'FAQ',
	'title'   => 'Quick Answers for<br>Curious Players',
	'text'    => 'Led by experience and driven by passion, our team helps players evolve on and off the field.',
	'image'   => $img . 'training-2.jpg',
) );

// 2. GENERAL
get_template_part( 'template-parts/faq-split', null, array(
	'title' => 'General Questions',
	'text'  => 'Find quick answers to common questions about joining, training, and enjoying your experience with us.',
	'faqs'  => array(
		array( 'How do I join the academy?', 'Fill in the registration form on our Join Now page, or call us on ' . $phone . ' or email ' . $email . ' and our team will guide you.' ),
		array( 'Who can join Velocrix?', 'Aspiring cricketers who want to build skill, fitness and discipline. The 1 Month plan is ideal for beginners to explore and build the basics. Contact us to find the right plan.' ),
		array( 'Is Velocrix a cricket academy in Noida?', 'Velocrix Cricket Academy is in Greater Noida West (also called Noida Extension), at ' . $address . '.' ),
		array( 'Who founded Velocrix Cricket Academy?', $mentor . ', an Indian international cricketer, founded Velocrix and mentors the academy.' ),
		array( 'Where is the academy located?', $address . '.' ),
	),
) );

// 3. PRICING (tinted)
get_template_part( 'template-parts/faq-split', null, array(
	'title' => 'Pricing Questions',
	'text'  => 'Find the right plan among our flexible memberships, built for every level of player.',
	'tint'  => true,
	'faqs'  => array(
		array( 'Is the registration fee separate?', 'Yes. Registration is a one-time fee of ₹' . $regfee . ' and training plans are paid separately.' ),
		array( 'Is there an early bird discount?', 'Early bird discounts are available for a limited period. Terms & conditions apply, so please contact us to confirm the current offer.' ),
		array( 'Which plan should I choose?', 'Start with 1 Month to explore the basics, choose 3 Months for structured progress, 6 Months for advanced performance coaching, or 1 Year for complete long-term development.' ),
		array( 'What is included in every plan?', 'Expert coaching from qualified and experienced coaches, fitness and skill development, teamwork and character building, a professional training environment and a pathway to professional cricket.' ),
	),
) );

// 4. ACADEMY
get_template_part( 'template-parts/faq-split', null, array(
	'title' => 'Academy Questions',
	'text'  => 'Discover how we train, connect, and help you make the most of your time at Velocrix.',
	'faqs'  => array(
		array( 'What does the training cover?', 'Our six pillars: Expert Coaching, Skill-Based Training, Fitness & Performance, Match Practice & Exposure, Individual Attention, and a Pathway to Professional Cricket.' ),
		array( 'What are the batch timings and age groups?', 'Batches are arranged by age and level. Please call us on ' . $phone . ' to confirm current timings and the right batch for your child.' ),
		array( 'Is there a pathway to professional cricket?', 'Yes. A pathway to professional cricket is one of our core pillars, supported by expert coaching, match practice and exposure.' ),
		array( 'How can I reach the team?', 'Call or WhatsApp us on ' . $phone . ', email ' . $email . ', or send a message from our Contact page.' ),
	),
) );

get_template_part( 'template-parts/cta' );
get_footer();
