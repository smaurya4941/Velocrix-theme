<?php
/**
 * Section "partner" (Home + About): In association with Sarvottam International School. Animated band with a ticker.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_words = array( 'Sarvottam International School', 'CBSE senior secondary', 'Sarvottam School of Sports', 'Live the Sport', 'Sector 10, Greater Noida West' );
?>
<section class="pt-sec" aria-label="In association with Sarvottam International School">
  <div class="wrap pt-row" data-reveal>
    <p class="pt-lbl">In association with</p>
    <img class="pt-logo" src="<?php echo esc_url( vx_asset( 'assets/img/sarvottam-logo.webp' ) ); ?>" alt="Sarvottam International School" width="903" height="222" loading="lazy">
    <p class="pt-txt">Our ground is at the Sarvottam International School campus, Sector 10, Greater Noida West.</p>
  </div>
  <div class="pt-tick" aria-hidden="true"><div>
    <?php for ( $vx_r = 0; $vx_r < 2; $vx_r++ ) : foreach ( $vx_words as $vx_w ) : ?><span><?php echo esc_html( $vx_w ); ?></span><?php endforeach; endfor; ?>
  </div></div>
</section>
