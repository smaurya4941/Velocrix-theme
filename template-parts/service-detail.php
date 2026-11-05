<?php
/**
 * Shared service detail page layout. Args: slug (see vx_service_data()).
 * Sections: hero, overview + facts, what you get, how it works, who is it for, FAQ, CTA.
 */
$s = vx_service_data( isset( $args['slug'] ) ? $args['slug'] : '' );
if ( ! $s ) return;
$img     = VX_URI . '/assets/img/';
$contact = home_url( '/contact/' );

// 1. HERO (shared part)
get_template_part( 'template-parts/hero-page', null, array(
	'eyebrow' => 'Our Services',
	'title'   => $s['hero'][0],
	'text'    => $s['hero'][1],
	'image'   => $img . $s['hero'][2],
) );
?>

<!-- 2. OVERVIEW -->
<section class="section svc-overview">
	<div class="container split">
		<div class="svc-copy">
			<span class="eyebrow"><?php echo esc_html( $s['name'] ); ?></span>
			<h2><?php echo wp_kses_post( $s['overview'][0] ); ?></h2>
			<?php foreach ( $s['overview'][1] as $para ) echo '<p>' . esc_html( $para ) . '</p>'; ?>
			<div class="btn-row">
				<a class="btn" href="<?php echo esc_url( $contact ); ?>"><?php echo esc_html( $s['cta'][1] ); ?></a>
				<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/services/' ) ); ?>">All Services</a>
			</div>
		</div>
		<div class="svc-photo">
			<img src="<?php echo esc_url( $img . $s['overview'][2] ); ?>" alt="<?php echo esc_attr( $s['name'] ); ?> at Velocrix Cricket Academy" loading="lazy" width="800" height="900">
			<dl class="svc-facts">
				<?php foreach ( $s['facts'] as $k => $v ) echo '<div><dt>' . esc_html( $k ) . '</dt><dd>' . esc_html( $v ) . '</dd></div>'; ?>
			</dl>
		</div>
	</div>
</section>

<!-- 3. WHAT YOU GET -->
<section class="section svc-why">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow"><?php echo esc_html( $s['why'][0] ); ?></span>
			<h2><?php echo esc_html( $s['why'][1] ); ?></h2>
		</div>
		<div class="svc-grid">
			<?php foreach ( $s['why'][2] as $i => $c ) : ?>
			<article class="svc-card">
				<span class="svc-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
				<h3><?php echo esc_html( $c[0] ); ?></h3>
				<p><?php echo esc_html( $c[1] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 4. HOW IT WORKS -->
<section class="section dark svc-steps">
	<div class="container">
		<div class="sec-head center">
			<span class="eyebrow"><?php echo esc_html( $s['steps'][0] ); ?></span>
			<h2><?php echo esc_html( $s['steps'][1] ); ?></h2>
		</div>
		<ol class="svc-flow">
			<?php foreach ( $s['steps'][2] as $i => $st ) : ?>
			<li>
				<span class="sf-n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
				<h3><?php echo esc_html( $st[0] ); ?></h3>
				<p><?php echo esc_html( $st[1] ); ?></p>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<!-- 5. WHO IS IT FOR -->
<section class="section svc-who">
	<div class="container split rev">
		<div class="svc-copy">
			<span class="eyebrow">Audience</span>
			<h2><?php echo esc_html( $s['who'][0] ); ?></h2>
			<p><?php echo esc_html( $s['who'][1] ); ?></p>
			<div class="pills"><?php foreach ( $s['who'][2] as $p ) echo '<span>' . esc_html( $p ) . '</span>'; ?></div>
		</div>
		<div class="svc-photo plain">
			<img src="<?php echo esc_url( $img . $s['who'][3] ); ?>" alt="Players at Velocrix Cricket Academy" loading="lazy" width="800" height="700">
		</div>
	</div>
</section>

<?php
// 6. FAQ (shared part)
get_template_part( 'template-parts/faq', null, array( 'faqs' => $s['faqs'], 'title' => 'Common Questions' ) );

// 7. CTA (shared part, goes to Contact)
get_template_part( 'template-parts/cta', null, array( 'title' => $s['cta'][0], 'button' => $s['cta'][1], 'url' => $contact ) );
