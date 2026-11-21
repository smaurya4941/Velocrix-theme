<?php
/**
 * Section "hero": Where dreamsmeet discipline.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="hero" aria-labelledby="h1" data-gfx="contour:bl">
    <div class="streaks" aria-hidden="true">
      <i style="width:42%;right:-4%;top:14%"></i><i style="width:30%;right:-2%;top:22%"></i>
      <i style="width:52%;right:-6%;top:31%"></i><i style="width:24%;right:0;top:39%"></i>
    </div>
    <div class="wrap">
      <div class="hero-copy">
        <?php $vx_status = vx( 'vx_status', 'Registrations are open. Early bird discount available.' ); if ( $vx_status ) : ?>
        <p class="vx-live on"><i aria-hidden="true"></i><span><?php echo esc_html( $vx_status ); ?></span></p>
        <?php endif; ?>
        <p class="kicker">Velocrix Cricket Academy, Greater Noida West</p>
        <h1 id="h1"><span class="ln"><span>Where dreams</span></span><span class="ln"><span><em>meet discipline.</em></span></span></h1>
        <p class="lede">A next-generation cricket academy at Sarvottam International School, under the mentorship of International Cricketer <?php echo esc_html( vx( 'vx_mentor_name', 'Ms. Meghna Singh' ) ); ?>. Expert coaching, skill-based training, fitness and real match exposure. <?php echo esc_html( vx_copy( 'tagline' ) ); ?></p>
        <div class="hero-ctas">
          <a class="btn btn-primary mag" href="<?php echo esc_url( home_url( '/registration/' ) ); ?>">Join Now</a>
          <a class="btn btn-ghost mag" href="<?php echo esc_url( vx_lx( 'mentor' ) ); ?>">Watch Meghna's message</a>
        </div>
        <div class="hero-meta">
          <span><svg aria-hidden="true"><use href="#i-pin"/></svg>Sarvottam International School, Sector 10</span>
          <span><svg aria-hidden="true"><use href="#i-phone"/></svg><?php echo esc_html( vx( 'vx_phone', '+91 879 644 7595' ) ); ?></span>
        </div>
      </div>
      <?php /* Layered version (frame + cutout + HTML badge/namecard). The flat media/meghna-hero.jpg ("has-shot" mode) is not used: its badge text "CWG 2022 SILVER / India international" is baked into the image and is not Velocrix brochure data. */ ?>
      <div class="showcase" id="showcase" aria-label="Meghna Singh, International Cricketer and Velocrix mentor, holding a cricket ball">
        <div class="layer" data-depth="10">
          <div class="frame">
            <i class="fstreak" style="width:40%;right:-5%;top:20%"></i><i class="fstreak" style="width:26%;right:0;top:27%"></i><i class="fstreak" style="width:34%;left:-4%;top:58%"></i>
            <p class="bigtype" aria-hidden="true"><span>MEGHNA</span><span>SINGH</span></p>
            <div class="fslats" aria-hidden="true"><i style="--k:0"></i><i style="--k:1"></i><i style="--k:2"></i><i style="--k:3"></i><i style="--k:4"></i><i style="--k:5"></i></div>
          </div>
        </div>
        <div class="layer cut" data-depth="22"><img src="<?php echo esc_url( vx_landing_uri( 'media/meghna-cutout.webp' ) ); ?>" alt="Meghna Singh, International Cricketer and Velocrix mentor, gripping a red cricket ball" width="758" height="1460" fetchpriority="high"></div>
        <div class="badge" aria-hidden="true">
          <svg viewBox="0 0 100 100"><defs><path id="circ" d="M50 50 m-38 0 a38 38 0 1 1 76 0 a38 38 0 1 1 -76 0"/></defs><text font-size="8.6" font-weight="800" fill="#fff" font-family="Public Sans, Arial, sans-serif"><textPath href="#circ" textLength="236" lengthAdjust="spacing">INTERNATIONAL CRICKETER — VELOCRIX MENTOR — </textPath></text></svg>
          <span class="ball"></span>
        </div>
        <div class="namecard"><span class="flag" aria-hidden="true"><i style="background:#FF9933"></i><i style="background:#fff;box-shadow:inset 0 0 0 1px #ddd"></i><i style="background:#138808"></i></span><b>Meghna Singh</b><span>International Cricketer. Mentor, Velocrix.</span></div>
      </div>
    </div>
  </section>
