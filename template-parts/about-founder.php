<?php
/**
 * About (classic): "Meet the founder" (Kirti Sharma). Ported from the animated section
 * template-parts/landing/sections/founder.php, in the Velocrix brand (Public Sans, lime + black).
 * Data: vx_founder() in functions.php (text confirmed by the owner, 2026-11-21).
 * Styles: assets/css/founder.css (+ shared .hx tokens in assets/css/home-extras.css); script: assets/js/home-extras.js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$f      = vx_founder();
$mentor = vx( 'vx_mentor_name', 'Ms. Meghna Singh' );
$parts  = explode( ' ', $f['name'], 2 );
$first  = $parts[0];
?>
<section class="hx hx-founder" id="founder" aria-labelledby="founder-h" data-hx-gfx="contour">
	<div class="container fd-grid">
		<div class="fd-portrait hx-rv">
			<div class="fd-photo"><img src="<?php echo esc_url( $f['img'] ); ?>" alt="<?php echo esc_attr( $f['name'] ); ?>, founder of Velocrix Cricket Academy" width="1003" height="1254" loading="lazy"></div>
			<div class="fd-badge" aria-hidden="true">
				<svg viewBox="0 0 140 140"><defs><path id="fdCirc" d="M70,70 m-52,0 a52,52 0 1,1 104,0 a52,52 0 1,1 -104,0"/></defs><circle cx="70" cy="70" r="68"/><text><textPath href="#fdCirc" textLength="318" lengthAdjust="spacing">FOUNDER · WHERE DREAMS MEET DISCIPLINE ·</textPath></text></svg>
				<b><?php echo esc_html( $f['initials'] ); ?></b>
			</div>
			<div class="fd-plate"><div><b><?php echo esc_html( $f['name'] ); ?></b><small>Founder, Velocrix Cricket Academy</small></div><span>Greater Noida West</span></div>
		</div>

		<div class="fd-copy hx-rv">
			<p class="hx-kicker">Meet the founder</p>
			<h2 id="founder-h"><?php echo esc_html( $first ); ?><?php if ( ! empty( $parts[1] ) ) : ?> <em><?php echo esc_html( $parts[1] ); ?></em><?php endif; ?></h2>
			<p class="fd-role"><?php echo esc_html( $f['role'] ); ?>, Velocrix Cricket Academy</p>
			<p class="hx-lede"><?php echo esc_html( $first ); ?> founded Velocrix to give young cricketers in Greater Noida West a proper place to learn the game: a fixed weekly plan, coaching that builds technique step by step, and parents who always know how their child is doing.</p>
			<p class="fd-p">She runs the academy on the ground every training day. Batches, levels, fees, match days and the weekly WhatsApp report that every parent receives all go through her. Her close friend <?php echo esc_html( preg_replace( '/^Ms\.\s*/', '', $mentor ) ); ?> mentors the coaching programme, and <?php echo esc_html( $first ); ?> makes sure those India-level methods reach every child, every session.</p>

			<dl class="fd-facts">
				<div><dt>Role</dt><dd><?php echo esc_html( $f['role'] ); ?></dd></div>
				<div><dt>Runs</dt><dd>Day-to-day academy</dd></div>
				<div><dt>Ground</dt><dd>Sarvottam International, Sector 10</dd></div>
				<?php if ( $f['ig'] ) : ?><div><dt>Instagram</dt><dd><a href="<?php echo esc_url( $f['ig_url'] ); ?>" target="_blank" rel="noopener">@<?php echo esc_html( $f['ig'] ); ?></a></dd></div><?php endif; ?>
			</dl>

			<div class="fd-built">
				<h3>What she built Velocrix on</h3>
				<ul>
					<li><b>Parents in the loop</b><span>Attendance, focus and a coach's note on WhatsApp every week, and a progress card every quarter.</span></li>
					<li><b>Girls play here</b><span>The same programme, levels and match days for girls as for every batch.</span></li>
					<li><b>One rate card</b><span>The same fees for every family, with no case-by-case deals.</span></li>
					<li><b>Every day has a job</b><span>Batting, bowling, fielding and a Saturday match, so practice always has a purpose.</span></li>
				</ul>
			</div>

			<div class="fd-ctas">
				<a class="btn hx-mag" href="<?php echo esc_url( vx_trial_url() ); ?>" target="_blank" rel="noopener">Book a Free Trial</a>
				<?php if ( $f['ig_url'] ) : ?><a class="btn btn-ghost hx-mag" href="<?php echo esc_url( $f['ig_url'] ); ?>" target="_blank" rel="noopener"><?php echo vx_icon( 'instagram' ); // phpcs:ignore ?>Follow <?php echo esc_html( $first ); ?></a><?php endif; ?>
			</div>
		</div>
	</div>
</section>
