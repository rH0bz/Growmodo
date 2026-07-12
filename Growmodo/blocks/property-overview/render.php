<?php
/**
 * Property Overview — Growmodo SOT: Sections/Property Overview.md. Reads the
 * current `property` post — no block attributes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id   = get_the_ID();
$bedrooms  = get_post_meta( $post_id, '_property_bedrooms', true );
$bathrooms = get_post_meta( $post_id, '_property_bathrooms', true );
$area      = get_post_meta( $post_id, '_property_area_sqft', true );
$features  = growmodo_parse_property_features( get_post_meta( $post_id, '_property_key_features', true ) );

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page grid md:grid-cols-3 gap-10">
			<div class="md:col-span-2">
				<h2 class="h2"><?php esc_html_e( 'Description', 'growmodo' ); ?></h2>
				<div class="prose-body mt-4"><?php the_content(); ?></div>

				<?php if ( $bedrooms || $bathrooms || $area ) : ?>
					<div class="flex flex-wrap gap-6 mt-8 pt-8 border-t border-surface-line">
						<?php if ( $bedrooms ) : ?>
							<div class="flex items-center gap-2"><?php echo growmodo_icon( 'property-bed.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><div><div class="text-ink text-xs"><?php esc_html_e( 'Bedrooms', 'growmodo' ); ?></div><div class="text-heading font-semibold"><?php echo esc_html( $bedrooms ); ?></div></div></div>
						<?php endif; ?>
						<?php if ( $bathrooms ) : ?>
							<div class="flex items-center gap-2"><?php echo growmodo_icon( 'property-bath.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><div><div class="text-ink text-xs"><?php esc_html_e( 'Bathrooms', 'growmodo' ); ?></div><div class="text-heading font-semibold"><?php echo esc_html( $bathrooms ); ?></div></div></div>
						<?php endif; ?>
						<?php if ( $area ) : ?>
							<div class="flex items-center gap-2"><?php echo growmodo_icon( 'property-area.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><div><div class="text-ink text-xs"><?php esc_html_e( 'Area', 'growmodo' ); ?></div><div class="text-heading font-semibold"><?php echo esc_html( number_format_i18n( (float) $area ) ); ?> <?php esc_html_e( 'Square Feet', 'growmodo' ); ?></div></div></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $features ) : ?>
				<div>
					<h2 class="h2 !text-2xl"><?php esc_html_e( 'Key Features and Amenities', 'growmodo' ); ?></h2>
					<ul class="mt-4 space-y-3">
						<?php foreach ( $features as $feature ) : ?>
							<li class="flex items-start gap-2 text-heading text-sm">
								<?php echo growmodo_icon( 'property-check.svg', 'w-4 h-4 mt-0.5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								<span><?php echo esc_html( $feature ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
