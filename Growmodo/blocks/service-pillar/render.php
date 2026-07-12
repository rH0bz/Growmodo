<?php
/**
 * Service Pillar — Growmodo SOT: Sections/Service Pillar.md, Modules/Service
 * Feature Card.md. Used 3x on the Services template with different content;
 * `ctaPosition` toggles between the two layouts observed in the export
 * ("grid" — two separate flex rows: 3 features, then a 4th feature + the
 * highlighted CTA card, pillars 1 & 2 — vs "aside" — a standalone CTA card
 * beside the intro with a clean 2x2 feature grid below, pillar 3).
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading      = $attributes['heading'] ?? '';
$body         = $attributes['body'] ?? '';
$features     = ( isset( $attributes['features'] ) && is_array( $attributes['features'] ) ) ? $attributes['features'] : array();
$cta_position = $attributes['ctaPosition'] ?? 'grid';
$cta_heading  = $attributes['ctaHeading'] ?? '';
$cta_body     = $attributes['ctaBody'] ?? '';
$cta_label    = $attributes['ctaLabel'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes();

$feature_card = function ( $f ) {
	?>
	<div class="card p-6">
		<div class="flex items-center gap-3 mb-2">
			<span class="icon-badge"><?php echo growmodo_icon( $f['icon'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
			<h3 class="h3 !text-lg"><?php echo esc_html( $f['title'] ?? '' ); ?></h3>
		</div>
		<p class="lead text-sm"><?php echo esc_html( $f['body'] ?? '' ); ?></p>
	</div>
	<?php
};
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<?php if ( 'aside' === $cta_position ) : ?>
				<div class="grid md:grid-cols-2 gap-10 items-start">
					<div>
						<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
						<p class="lead mt-2"><?php echo esc_html( $body ); ?></p>
					</div>
					<div class="card p-8 bg-accent/10 border-accent/40">
						<h3 class="h3 !text-lg"><?php echo esc_html( $cta_heading ); ?></h3>
						<p class="lead text-sm mt-2"><?php echo esc_html( $cta_body ); ?></p>
						<span class="btn-primary text-sm mt-4 inline-flex"><?php echo esc_html( $cta_label ); ?></span>
					</div>
				</div>
				<?php if ( $features ) : ?>
					<div class="grid md:grid-cols-2 gap-6 mt-8">
						<?php foreach ( $features as $feature ) : $feature_card( $feature ); endforeach; ?>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
				<p class="lead mt-2 max-w-xl"><?php echo esc_html( $body ); ?></p>
				<?php
				// Raw export: two separate flex rows, not one continuous grid — row 1 is the
				// first 3 features, row 2 is the 4th feature + the highlighted CTA card.
				$row1 = array_slice( $features, 0, 3 );
				$row2 = array_slice( $features, 3 );
				?>
				<?php if ( $row1 ) : ?>
					<div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 mt-8">
						<?php foreach ( $row1 as $feature ) : $feature_card( $feature ); endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="grid md:grid-cols-2 gap-6 mt-6">
					<?php foreach ( $row2 as $feature ) : $feature_card( $feature ); endforeach; ?>
					<div class="card p-6 bg-accent/10 border-accent/40 flex flex-col justify-center">
						<h3 class="h3 !text-lg"><?php echo esc_html( $cta_heading ); ?></h3>
						<p class="lead text-sm mt-2"><?php echo esc_html( $cta_body ); ?></p>
						<span class="btn-primary text-sm mt-4 inline-flex w-fit"><?php echo esc_html( $cta_label ); ?></span>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
