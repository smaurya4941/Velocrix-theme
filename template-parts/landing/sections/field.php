<?php
/**
 * Section "field": Know the field.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  <section class="field-sec" id="field" aria-labelledby="field-h" data-gfx="contour:tr">
    <div class="wrap">
      <div class="sec-head" data-reveal>
        <h2 id="field-h">Know the <em>field.</em></h2>
        <p class="lede">Good fielders know where they stand and why. Hover or tap a position to learn it, or drag the red fielder and see where you've placed them. Shown for a right-handed batter.</p>
      </div>
      <div class="field-grid">
        <div class="field-box" data-reveal>
          <svg viewBox="0 0 100 100" id="fieldSvg" aria-label="Cricket field with fielding positions">
            <defs>
              <pattern id="mow" width="8" height="100" patternUnits="userSpaceOnUse"><rect width="4" height="100" fill="var(--turf)"/><rect x="4" width="4" height="100" fill="var(--turf-2)"/></pattern>
            </defs>
            <circle cx="50" cy="50" r="48.5" fill="url(#mow)"/>
            <circle cx="50" cy="50" r="48.5" fill="none" stroke="#fff" stroke-width=".6"/>
            <circle cx="50" cy="50" r="27" fill="none" stroke="#fff" stroke-width=".35" stroke-dasharray="1.2 1.2" opacity=".8"/>
            <rect x="48.3" y="39" width="3.4" height="22" rx=".4" fill="var(--clay)"/>
            <path d="M47.6 41.2h4.8M47.6 58.8h4.8" stroke="#fff" stroke-width=".3"/>
            <text x="9" y="51" font-size="2.6" font-weight="800" fill="#fff" opacity=".75" font-family="Public Sans, sans-serif">OFF SIDE</text>
            <text x="91" y="51" text-anchor="end" font-size="2.6" font-weight="800" fill="#fff" opacity=".75" font-family="Public Sans, sans-serif">LEG SIDE</text>
            <g id="posG"></g>
            <g class="fielder" id="fielder" transform="translate(70 76)" tabindex="0" role="button" aria-label="Draggable fielder, use arrow keys to move">
              <circle class="halo" r="4.2" fill="var(--cherry)" opacity=".25"/>
              <circle r="2.6" fill="var(--cherry)" stroke="#fff" stroke-width=".6"/>
            </g>
          </svg>
        </div>
        <div class="info" aria-live="polite" data-reveal>
          <span class="side" id="pSide">Leg side, in the circle</span>
          <span class="pname" id="pName">Mid-wicket</span>
          <p class="pdesc" id="pDesc">In front of square on the leg side. Stops the flick and the pull.</p>
          <span class="hint"><svg aria-hidden="true"><use href="#i-hand"/></svg>Drag the red fielder anywhere</span>
          <div class="legend" id="legend"></div>
        </div>
      </div>
    </div>
  </section>
