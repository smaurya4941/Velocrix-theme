<?php
/**
 * Section "reviews": What our families say.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="rv" id="reviews" aria-labelledby="rv-h" data-gfx="seams">
    <div class="wrap">
      <div class="rv-head" data-reveal>
        <div class="sec-head" style="margin-bottom:0">
          <p class="kicker">Parent reviews</p>
          <h2 id="rv-h">What our <em>families say.</em></h2>
          <p class="lede">Velocrix is a young academy and our first families are sharing their experience now. Pick a question below and tell other parents how it is going. We publish a review only with your permission.</p>
        </div>
        <a class="btn btn-primary mag" href="<?php echo esc_url( vx_lx( 'rvShare' ) ); ?>">Write a review</a>
      </div>

      <div class="rv-grid" data-reveal>
        <figure class="rv-card rv-ask">
          <div class="rv-top"><span class="rv-q" aria-hidden="true">&ldquo;</span><span class="rv-tag">Progress</span></div>
          <blockquote>How has your child's game changed since joining Velocrix?</blockquote>
          <p class="rv-hint">Batting, bowling, fitness or confidence: tell other parents what you have noticed.</p>
          <a class="rv-write" href="<?php echo esc_url( vx_lx( 'rvShare' ) ); ?>" data-start="Since joining Velocrix, my child ">Write about progress <svg aria-hidden="true" width="14" height="14"><use href="#i-right"/></svg></a>
        </figure>
        <figure class="rv-card rv-ask">
          <div class="rv-top"><span class="rv-q" aria-hidden="true">&ldquo;</span><span class="rv-tag">Coaching</span></div>
          <blockquote>What stands out to you about the coaching?</blockquote>
          <p class="rv-hint">The drills, the Saturday match days, the attention each child gets, or training with Meghna's methods.</p>
          <a class="rv-write" href="<?php echo esc_url( vx_lx( 'rvShare' ) ); ?>" data-start="What stands out about the coaching is ">Write about coaching <svg aria-hidden="true" width="14" height="14"><use href="#i-right"/></svg></a>
        </figure>
        <figure class="rv-card rv-ask">
          <div class="rv-top"><span class="rv-q" aria-hidden="true">&ldquo;</span><span class="rv-tag">Weekly updates</span></div>
          <blockquote>Do the weekly WhatsApp reports help you follow your child's cricket?</blockquote>
          <p class="rv-hint">Attendance, the coach's note and the quarterly progress card.</p>
          <a class="rv-write" href="<?php echo esc_url( vx_lx( 'rvShare' ) ); ?>" data-start="The weekly reports ">Write about updates <svg aria-hidden="true" width="14" height="14"><use href="#i-right"/></svg></a>
        </figure>
      </div>

      <form class="rv-share" id="rvShare" novalidate data-reveal>
        <div class="rv-share-copy">
          <p class="kicker">Velocrix parent?</p>
          <h3>Tell other families <em>how it's going.</em></h3>
          <p>Write a few lines and we'll receive them on WhatsApp. Nothing goes on the website unless you tick the permission box.</p>
        </div>
        <div class="rv-fields">
          <div class="ax-row2">
            <div class="ax-f"><label for="rvName">Your name</label><input id="rvName" autocomplete="name" placeholder="e.g. Neha Sharma"></div>
            <div class="ax-f"><label for="rvChild">Child's name and batch</label><input id="rvChild" placeholder="e.g. Aarav, Development"></div>
          </div>
          <div class="ax-f"><span class="lbl">Your rating</span>
            <div class="rv-stars" id="rvStars" role="radiogroup" aria-label="Rating out of 5">
              <button type="button" role="radio" aria-checked="false" data-v="1" aria-label="1 star">★</button><button type="button" role="radio" aria-checked="false" data-v="2" aria-label="2 stars">★</button><button type="button" role="radio" aria-checked="false" data-v="3" aria-label="3 stars">★</button><button type="button" role="radio" aria-checked="false" data-v="4" aria-label="4 stars">★</button><button type="button" role="radio" aria-checked="false" data-v="5" aria-label="5 stars">★</button>
            </div>
          </div>
          <div class="ax-f"><label for="rvText">Your review</label><textarea id="rvText" placeholder="What has changed for your child since joining Velocrix?"></textarea></div>
          <label class="rv-ok" for="rvConsent"><input type="checkbox" id="rvConsent"><span>Velocrix may publish this review on its website and Instagram with my first name.</span></label>
          <p class="err" id="rvErr" hidden></p>
          <div class="rv-acts"><a class="btn btn-wa" id="rvSend" href="#" target="_blank" rel="noopener"><svg aria-hidden="true"><use href="#i-wa"/></svg>Send review on WhatsApp</a><span>Goes to +91 87964 47595</span></div>
        </div>
      </form>
    </div>
  </section>
