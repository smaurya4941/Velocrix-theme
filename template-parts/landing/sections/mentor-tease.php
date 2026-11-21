<?php
/**
 * Section "mentor-tease" (About): mentor card (Meghna Singh; the founder is Kirti Sharma, vx_founder()). Facts = the Our Mentor page / inc/content.php.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$vx_name = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
$vx_role = vx( 'vx_mentor_role', 'International Cricketer' );
$vx_img  = vx( 'vx_mentor_img' );
?>
<section class="mt-sec" id="founder-mentor" aria-labelledby="mt-h">
  <div class="wrap">
    <figure class="mt-photo" data-reveal data-tilt>
      <?php if ( $vx_img ) : ?><img src="<?php echo esc_url( $vx_img ); ?>" alt="<?php echo esc_attr( $vx_name . ', ' . $vx_role ); ?>" loading="lazy" width="384" height="776"><?php endif; ?>
      <figcaption><b><?php echo esc_html( $vx_name ); ?></b><span>Mentor &amp; <?php echo esc_html( $vx_role ); ?></span></figcaption>
    </figure>
    <div class="mt-copy" data-reveal>
      <p class="kicker">Our mentor</p>
      <h2 id="mt-h">Experience of the <em>highest level.</em></h2>
      <p class="lede"><?php echo esc_html( $vx_name ); ?> has represented India across Test, ODI and T20I formats, and brings that international and domestic experience to every Velocrix player.</p>
      <ul class="mt-creds">
        <li><b>Test · ODI · T20I</b><span>Played for India in all three formats</span></li>
        <li><b>CWG silver, 2022</b><span>India women's team, Birmingham</span></li>
        <li><b>4/37 in the WPL</b><span>Gujarat Giants v Delhi Capitals, 2024</span></li>
      </ul>
      <div class="mt-acts">
        <a class="btn btn-primary mag" href="<?php echo esc_url( home_url( '/meghna-singh/' ) ); ?>">Meet our mentor</a>
        <a class="btn btn-ghost mag" href="<?php echo esc_url( home_url( '/meghna-singh/#message' ) ); ?>"><svg aria-hidden="true"><use href="#i-play"/></svg>Watch her message</a>
      </div>
    </div>
  </div>
</section>
