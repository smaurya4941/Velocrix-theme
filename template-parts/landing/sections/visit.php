<?php
/**
 * Section "visit": Come and see for yourself.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="visit" id="visit" aria-labelledby="visit-h" data-gfx="contour:bl">
    <div class="wrap vtop">
      <div data-reveal>
        <p class="kicker">Enquire or apply</p>
        <h2 id="visit-h" style="margin-top:14px">Start your <em>journey.</em></h2>
        <p class="lede" style="margin-top:18px">Send us a quick enquiry or the full admission details on WhatsApp, and our team will call you back with batch details and next steps. Fill in either form below and it writes the message for you; nothing is sent until you press send. Prefer the official form? <a href="<?php echo esc_url( home_url( '/registration/' ) ); ?>">Register online</a>.</p>
      </div>
      <div class="facts" data-reveal>
        <div class="fact"><span class="ic"><svg aria-hidden="true"><use href="#i-pin"/></svg></span><div><b>Where</b><span>Sarvottam International School, Sector 10, Greater Noida West. <a href="https://www.google.com/maps/search/?api=1&amp;query=Sarvottam+International+School+Sector+10+Greater+Noida+West" target="_blank" rel="noopener">Open in Google Maps</a></span></div></div>
        <div class="fact"><span class="ic"><svg aria-hidden="true"><use href="#i-cal"/></svg></span><div><b>Admissions</b><span><?php echo esc_html( vx( 'vx_status', 'Registrations are open. Early bird discount available.' ) ); ?> We share batch timings when we call you.</span></div></div>
        <div class="fact"><span class="ic"><svg aria-hidden="true"><use href="#i-phone"/></svg></span><div><b>Call or WhatsApp</b><span><span id="phoneTxt"><?php echo esc_html( vx( 'vx_phone', '+91 879 644 7595' ) ); ?></span><button type="button" class="copy" id="copyPhone">Copy</button></span></div></div>
        <div class="fact"><span class="ic"><svg aria-hidden="true"><use href="#i-ig"/></svg></span><div><b>Instagram</b><span><a href="<?php echo esc_url( vx( 'vx_instagram', 'https://www.instagram.com/velocrixofficial/' ) ); ?>" target="_blank" rel="noopener">@velocrixofficial</a></span></div></div>
      </div>
    </div>

    <div class="wrap">
      <div class="ax-tabs" id="axTabs" role="tablist"><button type="button" class="on" data-t="trial" role="tab" aria-selected="true">Quick enquiry</button><button type="button" data-t="full" role="tab" aria-selected="false">Full admission form</button></div>
      <div class="ax">
        <div style="min-width:0">
          <!-- quick enquiry (ids keep the old "trial" names used by admission.js) -->
          <form class="ax-card" id="axTrial" novalidate>
            <div class="ax-step">
              <h3>Send a quick enquiry</h3>
              <div class="ax-row2">
                <div class="ax-f" data-req><label for="tParent">Your name</label><input id="tParent" autocomplete="name"><span class="ax-err">Enter your name.</span></div>
                <div class="ax-f" data-req data-kind="phone"><label for="tPhone">Mobile number</label><input id="tPhone" type="tel" inputmode="numeric" autocomplete="tel" placeholder="10-digit mobile"><span class="ax-err">Enter a 10-digit mobile number.</span></div>
              </div>
              <div class="ax-row2">
                <div class="ax-f" data-req><label for="tChild">Child's name</label><input id="tChild" autocomplete="off"><span class="ax-err">Enter your child's name.</span></div>
                <div class="ax-f" data-req data-kind="age"><label for="tAge">Child's age</label><input id="tAge" type="number" min="4" max="25" inputmode="numeric"><span class="ax-err">Enter an age between 4 and 25.</span></div>
              </div>
              <div class="ax-f"><label for="interest">Interested in</label>
                <select id="interest">
                  <option>Admission and batch details</option>
                  <option>Fees and plans</option>
                  <option>Visiting the academy</option>
                  <option>Corporate tournament, workshops or guest lectures</option>
                </select>
              </div>
              <div class="ax-f"><label for="tNote">Anything we should know? <em>optional</em></label><textarea id="tNote" placeholder="Has your child played before? Any preferred days?"></textarea></div>
            </div>
          </form>

          <!-- full admission -->
          <form class="ax-card" id="axFull" novalidate hidden>
            <div class="ax-steps" id="axSteps">
              <button type="button" data-s="0" class="on"><span>STEP 1</span><b>Player</b></button>
              <button type="button" data-s="1"><span>STEP 2</span><b>Cricket</b></button>
              <button type="button" data-s="2"><span>STEP 3</span><b>Level and plan</b></button>
              <button type="button" data-s="3"><span>STEP 4</span><b>Parent</b></button>
            </div>
            <div class="ax-step" data-step="0">
              <h3>About the player</h3>
              <div class="ax-row2">
                <div class="ax-f" data-req><label for="aName">Player's full name</label><input id="aName" name="name" autocomplete="off" placeholder="e.g. Aarav Sharma"><span class="ax-err">Enter the player's name.</span></div>
                <div class="ax-f" data-req data-kind="dob"><label for="aDob">Date of birth</label><input id="aDob" name="dob" type="date"><span class="ax-err">Enter a date of birth.</span><span class="ax-chip" id="aAgeChip" hidden></span></div>
              </div>
              <div class="ax-f"><span class="lbl">Player is a</span><div class="ax-pills"><label><input type="radio" name="gender" value="Boy" checked><span>Boy</span></label><label><input type="radio" name="gender" value="Girl"><span>Girl</span></label></div></div>
              <div class="ax-row2">
                <div class="ax-f"><label for="aSchool">School and class <em>optional</em></label><input id="aSchool" name="school" placeholder="e.g. Sarvottam International, Class 6"></div>
                <div class="ax-f"><label for="aArea">Area or society <em>optional</em></label><input id="aArea" name="area" placeholder="e.g. Gaur City 2"></div>
              </div>
              <div class="ax-row2">
                <div class="ax-f"><label for="aHeight">Height in cm <em>optional</em></label><input id="aHeight" name="height" type="number" min="90" max="210" placeholder="e.g. 142"><span class="ax-hint" id="aBatHint">We use it to suggest a bat size.</span></div>
              </div>
            </div>
            <div class="ax-step" data-step="1" hidden>
              <h3>Cricket profile</h3>
              <div class="ax-f" data-req data-group="role"><span class="lbl">Main role <em>choose one or more</em></span>
                <div class="ax-opts">
                  <label class="ax-opt"><input type="checkbox" name="role" value="Batter"><span><b>Batter</b><small>Top or middle order</small></span></label>
                  <label class="ax-opt"><input type="checkbox" name="role" value="Pace bowler"><span><b>Pace bowler</b><small>Medium or fast</small></span></label>
                  <label class="ax-opt"><input type="checkbox" name="role" value="Spin bowler"><span><b>Spin bowler</b><small>Off-spin or leg-spin</small></span></label>
                  <label class="ax-opt"><input type="checkbox" name="role" value="All-rounder"><span><b>All-rounder</b><small>Bats and bowls</small></span></label>
                  <label class="ax-opt"><input type="checkbox" name="role" value="Wicket-keeper"><span><b>Wicket-keeper</b><small>Gloves</small></span></label>
                  <label class="ax-opt"><input type="checkbox" name="role" value="Not sure yet"><span><b>Not sure yet</b><small>We'll find out</small></span></label>
                </div><span class="ax-err">Choose at least one role.</span></div>
              <div class="ax-row2">
                <div class="ax-f"><span class="lbl">Bats</span><div class="ax-pills"><label><input type="radio" name="bats" value="Right-handed" checked><span>Right-handed</span></label><label><input type="radio" name="bats" value="Left-handed"><span>Left-handed</span></label></div></div>
                <div class="ax-f"><span class="lbl">Bowls</span><div class="ax-pills"><label><input type="radio" name="bowls" value="Right-arm" checked><span>Right-arm</span></label><label><input type="radio" name="bowls" value="Left-arm"><span>Left-arm</span></label><label><input type="radio" name="bowls" value="Doesn't bowl"><span>Doesn't bowl</span></label></div></div>
              </div>
              <div class="ax-f" data-req data-group="exp"><span class="lbl">Experience</span>
                <div class="ax-opts wide">
                  <label class="ax-opt"><input type="radio" name="exp" value="New to cricket"><span><b>New to cricket</b><small>Never had coaching</small></span></label>
                  <label class="ax-opt"><input type="radio" name="exp" value="Gully or park cricket"><span><b>Gully or park cricket</b><small>Plays for fun with friends</small></span></label>
                  <label class="ax-opt"><input type="radio" name="exp" value="Has had coaching before"><span><b>Coached before</b><small>Another academy or camp</small></span></label>
                  <label class="ax-opt"><input type="radio" name="exp" value="Plays for a school or club team"><span><b>School or club team</b><small>Competitive matches</small></span></label>
                </div><span class="ax-err">Choose the closest option.</span></div>
              <div class="ax-f"><span class="lbl">Played with a hard leather ball?</span><div class="ax-pills"><label><input type="radio" name="leather" value="Not yet" checked><span>Not yet</span></label><label><input type="radio" name="leather" value="A few times"><span>A few times</span></label><label><input type="radio" name="leather" value="Regularly"><span>Regularly</span></label></div></div>
              <div class="ax-f"><label for="aPrev">Previous academy or team <em>optional</em></label><input id="aPrev" name="prev" placeholder="e.g. School team, U-14"></div>
            </div>
            <div class="ax-step" data-step="2" hidden>
              <h3>Level and plan</h3>
              <div class="ax-f" data-req data-group="level"><span class="lbl">Starting level <em id="aRecNote">the coach confirms it</em></span>
                <div class="ax-opts wide" id="aLevels">
                  <label class="ax-opt" data-k="Beginner"><input type="radio" name="level" value="Beginner"><span><b>Beginner</b><small>New to the game: grip, stance, a safe action</small></span></label>
                  <label class="ax-opt" data-k="Development"><input type="radio" name="level" value="Development"><span><b>Development</b><small>Has the basics: footwork, consistency</small></span></label>
                  <label class="ax-opt" data-k="Advanced"><input type="radio" name="level" value="Advanced"><span><b>Advanced</b><small>Match player: pressure batting, trials</small></span></label>
                  <label class="ax-opt" data-k="Not sure"><input type="radio" name="level" value="Not sure, please assess"><span><b>Not sure</b><small>The coach will assess</small></span></label>
                </div><span class="ax-err">Choose a level, or "Not sure".</span></div>
              <div class="ax-f"><span class="lbl">Plan you're considering</span><div class="ax-pills" id="aPlans"><?php foreach ( vx_plans() as $vx_p ) : $vx_l = $vx_p['name'] . ' (₹' . $vx_p['price'] . ')'; ?><label><input type="radio" name="plan" value="<?php echo esc_attr( $vx_l ); ?>"><span><?php echo esc_html( $vx_p['name'] . ' · ₹' . $vx_p['price'] ); ?></span></label><?php endforeach; ?><label><input type="radio" name="plan" value="Not decided yet" checked><span>Not decided yet</span></label></div></div>
              <div class="ax-row2">
                <div class="ax-f"><span class="lbl">Goals <em>optional</em></span><div class="ax-pills"><label><input type="checkbox" name="goals" value="Fun and fitness"><span>Fun and fitness</span></label><label><input type="checkbox" name="goals" value="School team"><span>School team</span></label><label><input type="checkbox" name="goals" value="District or state trials"><span>District or state trials</span></label></div></div>
                <div class="ax-f"><label for="aStart">Wants to start</label><select id="aStart" name="start"><option>This week</option><option selected>Within a month</option><option>Next month</option><option>Just exploring</option></select></div>
              </div>
            </div>
            <div class="ax-step" data-step="3" hidden>
              <h3>Parent or guardian</h3>
              <div class="ax-row2">
                <div class="ax-f" data-req><label for="pGName">Name</label><input id="pGName" name="pname" autocomplete="name" placeholder="e.g. Neha Sharma"><span class="ax-err">Enter a parent or guardian's name.</span></div>
                <div class="ax-f"><label for="pRel">Relationship</label><select id="pRel" name="rel"><option>Mother</option><option>Father</option><option>Guardian</option><option>Self (adult player)</option></select></div>
              </div>
              <div class="ax-row2">
                <div class="ax-f" data-req data-kind="phone"><label for="pMob">Mobile number</label><input id="pMob" name="phone" type="tel" inputmode="numeric" autocomplete="tel" placeholder="10-digit mobile"><span class="ax-err">Enter a 10-digit mobile number.</span></div>
                <div class="ax-f"><label for="pEmail">Email <em>optional</em></label><input id="pEmail" name="email" type="email" autocomplete="email" placeholder="name@example.com"></div>
              </div>
              <div class="ax-f"><span class="lbl">How did you hear about us?</span><div class="ax-pills"><label><input type="radio" name="heard" value="Instagram" checked><span>Instagram</span></label><label><input type="radio" name="heard" value="Friend or family"><span>Friend or family</span></label><label><input type="radio" name="heard" value="School"><span>School</span></label><label><input type="radio" name="heard" value="Society notice"><span>Society notice</span></label><label><input type="radio" name="heard" value="Other"><span>Other</span></label></div></div>
              <div class="ax-f"><label for="pNote">Anything the coach should know? <em>optional</em></label><textarea id="pNote" name="note" placeholder="Past injuries, school timings, questions…"></textarea></div>
            </div>
            <div class="ax-nav">
              <button type="button" class="btn btn-ghost btn-sm" id="axBack" hidden>Back</button>
              <span id="axStepLbl">Step 1 of 4</span>
              <button type="button" class="btn btn-primary btn-sm" id="axNext">Next</button>
            </div>
          </form>
        </div>
        <aside class="ax-chat" aria-label="WhatsApp message preview">
          <div class="ax-chat-head"><span class="av"><svg aria-hidden="true"><use href="#vx-mark"/></svg></span><div><b>Velocrix Cricket Academy</b><small>Your message, ready to send</small></div></div>
          <div class="ax-chat-body"><div class="ax-bubble" id="msgBubble"></div></div>
          <div class="ax-chat-foot">
            <a class="btn btn-wa" id="waSend" href="#" target="_blank" rel="noopener" style="justify-content:center"><svg aria-hidden="true"><use href="#i-wa"/></svg>Send on WhatsApp</a>
            <div class="ax-two"><button type="button" class="btn btn-ghost btn-sm" id="msgCopy">Copy message</button><button type="button" class="btn btn-ghost btn-sm" id="msgClear">Clear form</button></div>
            <p>Opens WhatsApp with this text to <?php echo esc_html( vx( 'vx_phone', '+91 879 644 7595' ) ); ?>. Your admission draft is saved on this device.</p>
          </div>
        </aside>
      </div>
    </div>
  </section>
