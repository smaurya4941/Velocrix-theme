<?php
/**
 * Shutter intro (home page only). The boot script must run right after #intro.
 * Part of the Velocrix animated pages (see inc/landing.php). Styles: assets/landing/css, scripts: assets/landing/js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="intro" id="intro" hidden aria-hidden="true">
  <div class="blades"><i style="--k:0"></i><i style="--k:1"></i><i style="--k:2"></i><i style="--k:3"></i><i style="--k:4"></i><i style="--k:5"></i><i style="--k:6"></i><i style="--k:7"></i></div>
  <div class="intro-core">
    <svg class="bowler" viewBox="0 0 200 200" aria-hidden="true">
      <g class="fig" fill="none" stroke="#fff" stroke-width="10" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="104" cy="44" r="12" fill="#fff" stroke="none"/>
        <path d="M102 62 L94 112"/>
        <path d="M94 112 L120 140 L136 178"/>
        <path d="M94 112 L76 144 L52 164"/>
        <path d="M101 70 L124 60 L142 44"/>
        <g class="barm"><path d="M100 70 L100 114"/><circle class="hball" cx="100" cy="122" r="7.5" fill="#E0233A" stroke="none"/></g>
      </g>
      <circle class="fball" cx="122" cy="23" r="7.5" fill="#C2142C"/>
    </svg>
    <svg class="iword" aria-hidden="true"><use href="#vx-word-top"/></svg>
    <span class="itag">Where dreams meet discipline</span>
  </div>
  <div class="redwash"></div>
  <button type="button" class="skip" id="skipIntro">Skip intro</button>
</div>
<?php vx_landing_intro_script(); ?>
