<?php
/**
 * Property Hero — Growmodo SOT: Sections/Property Hero.md, Modules/Image
 * Gallery.md. Reads the current `property` post (single template loop
 * context) — no block attributes; content is entirely the post + its meta.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id     = get_the_ID();
$price       = get_post_meta( $post_id, '_property_price', true );
$address     = get_post_meta( $post_id, '_property_address', true );
$gallery_ids = growmodo_parse_property_gallery( get_post_meta( $post_id, '_property_gallery_ids', true ) );

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
				<div>
					<h1 class="h-display"><?php the_title(); ?></h1>
					<?php if ( $address ) : ?>
						<div class="flex items-center gap-2 mt-2 text-ink">
							<?php echo growmodo_icon( 'property-location.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							<span><?php echo esc_html( $address ); ?></span>
						</div>
					<?php endif; ?>
				</div>
				<div class="shrink-0">
					<div class="text-ink text-sm"><?php esc_html_e( 'Price', 'growmodo' ); ?></div>
					<div class="stat-number"><?php echo $price ? '$' . esc_html( number_format_i18n( (float) $price ) ) : esc_html__( 'Contact for price', 'growmodo' ); ?></div>
				</div>
			</div>

			<div class="mt-8 rounded-lg border border-surface-line bg-surface p-3">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-[420px] md:h-[583px] object-cover rounded', 'alt' => get_the_title() ) ); ?>
				<?php else : ?>
					<div class="w-full h-[420px] md:h-[583px] bg-surface-alt rounded"></div>
				<?php endif; ?>
				<?php if ( $gallery_ids ) : ?>
					<div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mt-2">
						<?php foreach ( array_slice( $gallery_ids, 0, 12 ) as $id ) : ?>
							<?php echo wp_get_attachment_image( $id, 'thumbnail', false, array( 'class' => 'w-full h-[94px] object-cover rounded', 'loading' => 'lazy' ) ); ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
</div>
