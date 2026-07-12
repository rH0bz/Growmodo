<?php
/**
 * Our Story — Growmodo SOT: Sections/Our Story.md.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading   = $attributes['heading'] ?? '';
$body      = $attributes['body'] ?? '';
$image_url = ! empty( $attributes['imageUrl'] ) ? $attributes['imageUrl'] : get_template_directory_uri() . '/assets/img/about-story.png';
$image_alt = $attributes['imageAlt'] ?? '';
$stats     = ( isset( $attributes['stats'] ) && is_array( $attributes['stats'] ) ) ? $attributes['stats'] : array();

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page grid md:grid-cols-2 gap-10 lg:gap-16 items-center">
			<div>
				<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
				<p class="lead mt-4"><?php echo esc_html( $body ); ?></p>
				<?php if ( $stats ) : ?>
					<div class="flex flex-wrap gap-8 mt-8">
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
				<div class="hidden lg:block absolute -inset-12 -z-10 opacity-50 pointer-events-none" aria-hidden="true">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/story-ring.svg' ); ?>" alt="" class="w-full h-full object-contain" />
				</div>
				<?php if ( $image_url ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="rounded-lg w-full h-[280px] md:h-[420px] lg:h-[546px] object-cover"<?php echo growmodo_image_dims_attr( $image_url ); // phpcs:ignore WordPress.Security.EscapeOutput ?> loading="lazy" />
				<?php else : ?>
					<div class="rounded-lg w-full h-[280px] md:h-[420px] lg:h-[546px] bg-surface-alt border border-surface-line"></div>
				<?php endif; ?>
			</div>
		</div>
	</section>
</div>
