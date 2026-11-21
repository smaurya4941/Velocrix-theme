<?php
/**
 * Section "nets": Great technique isn't an accident.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="nets" aria-labelledby="nets-h" style="padding-top:0">
    <div class="wrap">
      <div class="sec-head" data-reveal>
        <h2 id="nets-h">Great technique <em>isn't an accident.</em></h2>
      </div>
      <div class="reels" tabindex="0" aria-label="Training videos and photos, scroll sideways">
        <figure class="reel"><video class="auto" src="<?php echo esc_url( vx_landing_uri( 'media/reel-pov.mp4' ) ); ?>" poster="<?php echo esc_url( vx_landing_uri( 'media/poster-pov.jpg' ) ); ?>" muted loop playsinline preload="none" aria-label="The Velocrix bowling machine"></video><figcaption>POV: you're a Velocrix student. Practice mode on.</figcaption></figure>
        <figure class="reel"><img src="<?php echo esc_url( vx_landing_uri( 'media/meghna-coaching.jpg' ) ); ?>" alt="A coach in an India training shirt watching a Velocrix session" loading="lazy"><figcaption>Coaching on the field, not from the sidelines</figcaption></figure>
        <figure class="reel"><img src="<?php echo esc_url( vx_landing_uri( 'media/bowler-load.jpg' ) ); ?>" alt="Velocrix student at the top of his bowling action" loading="lazy"><figcaption>Load-up, high arm, eyes on target</figcaption></figure>
        <figure class="reel"><img src="<?php echo esc_url( vx_landing_uri( 'media/batting-nets.jpg' ) ); ?>" alt="Young batter driving in the Velocrix nets" loading="lazy"><figcaption>Nets sessions, every batting day</figcaption></figure>
        <figure class="reel"><img src="<?php echo esc_url( vx_landing_uri( 'media/catch.jpg' ) ); ?>" alt="Student taking a high catch" loading="lazy"><figcaption>Catches win matches</figcaption></figure>
      </div>
      <div class="ig">
        <p>New videos every week on Instagram.</p>
        <a class="btn btn-ghost mag" href="https://www.instagram.com/velocrixofficial/" target="_blank" rel="noopener"><svg aria-hidden="true"><use href="#i-ig"/></svg>@velocrixofficial</a>
      </div>
    </div>
  </section>
