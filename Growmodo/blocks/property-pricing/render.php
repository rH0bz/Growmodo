<?php
/**
 * Property Pricing — Growmodo SOT: Sections/Property Pricing.md, Modules/Fee
 * Line Item.md. Parses the current property's "Group | Label | Amount |
 * Note" Fees meta into grouped cards. Note callout is its own full-width
 * card (raw `.container12`), separate from and above the two-column
 * Listing Price / fee-groups row (raw `.container13`) — not merged into one
 * card as an earlier version of this block did.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = $attributes['heading'] ?? '';
$body    = $attributes['body'] ?? '';
$note    = $attributes['note'] ?? '';

$post_id = get_the_ID();
$price   = get_post_meta( $post_id, '_property_price', true );
$groups  = growmodo_parse_property_fees( get_post_meta( $post_id, '_property_fees', true ) );

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
			<p class="lead mt-2 max-w-xl"><?php echo esc_html( $body ); ?></p>

			<?php if ( $note ) : ?>
				<div class="card p-6 mt-8 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6">
					<div class="text-heading font-semibold text-sm shrink-0"><?php esc_html_e( 'Note', 'growmodo' ); ?></div>
					<p class="lead text-sm"><?php echo esc_html( $note ); ?></p>
				</div>
			<?php endif; ?>

			<div class="grid md:grid-cols-3 gap-8 mt-6">
				<div class="md:col-span-1">
					<div class="card p-6">
						<div class="text-ink text-xs"><?php esc_html_e( 'Listing Price', 'growmodo' ); ?></div>
						<div class="stat-number mt-1">$<?php echo esc_html( $price ? number_format_i18n( (float) $price ) : '—' ); ?></div>
					</div>
				</div>

				<?php if ( $groups ) : ?>
					<div class="md:col-span-2 grid sm:grid-cols-2 gap-6">
						<?php foreach ( $groups as $group_name => $items ) : ?>
							<div class="card p-6">
								<div class="flex items-center justify-between mb-3">
									<h3 class="h3 !text-lg"><?php echo esc_html( $group_name ); ?></h3>
								</div>
								<div class="divider-h mb-3"></div>
								<ul class="space-y-3">
									<?php foreach ( $items as $item ) : ?>
										<li class="flex items-start justify-between gap-4 text-sm">
											<span class="text-heading font-medium"><?php echo esc_html( $item['label'] ); ?></span>
											<span class="text-right">
												<span class="text-heading font-semibold block"><?php echo esc_html( $item['amount'] ); ?></span>
												<?php if ( $item['note'] ) : ?><span class="text-ink text-xs"><?php echo esc_html( $item['note'] ); ?></span><?php endif; ?>
											</span>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<div class="md:col-span-2 card p-6 text-ink text-sm">
						<?php esc_html_e( 'No pricing details added yet for this property.', 'growmodo' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
</div>
