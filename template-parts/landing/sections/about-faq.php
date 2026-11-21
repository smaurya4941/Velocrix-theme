<?php
/**
 * Section "about-faq" (About): the classic About page's six questions, in the animated design.
 * Feeds the FAQPage JSON-LD like the classic FAQ parts (vx_seo_collect_faq).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_name = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
$vx_faqs = array(
	array( 'What do players get at Velocrix?', 'Expert coaching, scientific training, fitness and skill development, and teamwork and character building, all in a professional training environment.' ),
	array( 'Who can join the academy?', 'Aspiring cricketers who want to build skill, fitness and discipline. The 1 Month plan is ideal for beginners to explore and build basics. Contact us to find the right plan.' ),
	array( 'Is the registration fee separate?', 'Yes. Registration is a one-time fee of ₹' . vx( 'vx_regfee', '1,999' ) . ' and training plans are paid separately. Early bird discount is available and terms & conditions apply, so please confirm current terms with us.' ),
	array( 'How do I register?', 'Fill in the registration form on our Join Now page, call us on ' . vx( 'vx_phone' ) . ' or email ' . vx( 'vx_email' ) . ' and our team will guide you.' ),
	array( 'Where is the academy located?', vx( 'vx_address' ) . '.' ),
	array( 'Who mentors the academy?', 'Velocrix was founded by ' . $vx_name . ', an Indian international cricketer, who also mentors the academy.' ),
);
if ( function_exists( 'vx_seo_collect_faq' ) ) vx_seo_collect_faq( $vx_faqs );
?>
<section class="faq afaq" id="faq" aria-labelledby="afaq-h" data-gfx="seams">
  <div class="wrap">
    <div class="sec-head" data-reveal><p class="kicker">Questions</p><h2 id="afaq-h">Before you <em>join us.</em></h2></div>
    <?php foreach ( $vx_faqs as $vx_i => $vx_f ) : ?>
      <details<?php echo 0 === $vx_i ? ' open' : ''; ?>><summary><?php echo esc_html( $vx_f[0] ); ?></summary><p><?php echo esc_html( $vx_f[1] ); ?></p></details>
    <?php endforeach; ?>
    <p class="afaq-more">More answers on the <a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">FAQ page</a>.</p>
  </div>
</section>
