<?php
/**
 * Hero — Home template's H1 band (headline + stats + portrait image + 4-item
 * feature strip). Growmodo SOT: Sections/Hero.md.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading       = $attributes['heading'] ?? '';
$body          = $attributes['body'] ?? '';
$primary_cta   = $attributes['primaryCta'] ?? '';
$primary_url   = $attributes['primaryUrl'] ?? '#';
$secondary_cta = $attributes['secondaryCta'] ?? '';
$secondary_url = $attributes['secondaryUrl'] ?? '#';
$image_url     = ! empty( $attributes['imageUrl'] ) ? $attributes['imageUrl'] : get_template_directory_uri() . '/assets/img/hero-property.png';
$image_alt     = $attributes['imageAlt'] ?? '';
$badge_text    = $attributes['badgeText'] ?? '';
$stats         = ( isset( $attributes['stats'] ) && is_array( $attributes['stats'] ) ) ? $attributes['stats'] : array();
$features      = ( isset( $attributes['features'] ) && is_array( $attributes['features'] ) ) ? $attributes['features'] : array();

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page grid md:grid-cols-2 gap-10 lg:gap-16 items-center">
			<div>
				<h1 class="h-display"><?php echo esc_html( $heading ); ?></h1>
				<p class="lead mt-4"><?php echo esc_html( $body ); ?></p>
				<div class="flex flex-wrap gap-4 mt-6">
					<a class="btn-secondary" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( $secondary_cta ); ?></a>
					<a class="btn-primary" href="<?php echo esc_url( $primary_url ); ?>"><?php echo esc_html( $primary_cta ); ?></a>
				</div>
				<?php if ( $stats ) : ?>
					<div class="flex flex-wrap gap-8 mt-10">
						<?php foreach ( $stats as $stat ) : ?>
							<div>
								<div class="stat-number"><?php echo esc_html( $stat['number'] ?? '' ); ?></div>
								<div class="lead text-sm"><?php echo esc_html( $stat['label'] ?? '' ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="relative">
				<div class="hidden lg:block absolute -inset-16 -z-10 opacity-50 pointer-events-none" aria-hidden="true">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/hero-ring.svg' ); ?>" alt="" class="w-full h-full object-contain" />
				</div>
				<div class="relative rounded-lg overflow-hidden w-full h-[320px] md:h-[560px] lg:h-[814px]">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="w-full h-full object-cover"<?php echo growmodo_image_dims_attr( $image_url ); // phpcs:ignore WordPress.Security.EscapeOutput ?> loading="lazy" />
					<div class="absolute inset-0" style="background: linear-gradient(238deg, rgba(42,33,63,0.9) 8%, rgba(25,25,25,0) 55%);" aria-hidden="true"></div>
				</div>
				<?php if ( $badge_text ) : ?>
					<div class="hero-badge hidden lg:flex" aria-hidden="true">
						<span class="hero-badge-ring"><?php echo growmodo_circular_text( $badge_text ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<span class="hero-badge-core">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/badge-arrow.svg' ); ?>" alt="" class="w-4 h-4" />
						</span>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( $features ) : ?>
			<div class="container-page mt-12">
				<div class="grid grid-cols-2 md:grid-cols-4 gap-4 rounded-lg bg-surface border border-surface-line p-5 shadow-glow">
					<?php foreach ( $features as $feature ) : ?>
						<div class="flex items-center gap-3">
							<span class="icon-badge"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/' . ( $feature['icon'] ?? 'feature-dream-home.svg' ) ); ?>" alt="" class="w-5 h-5" /></span>
							<span class="text-heading text-sm font-medium"><?php echo esc_html( $feature['label'] ?? '' ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</section>
</div>
