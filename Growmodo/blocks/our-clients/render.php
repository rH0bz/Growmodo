<?php
/**
 * Our Clients — Growmodo SOT: Sections/Our Clients.md, Modules/Client Card.md.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = $attributes['heading'] ?? '';
$body    = $attributes['body'] ?? '';
$items   = ( isset( $attributes['items'] ) && is_array( $attributes['items'] ) ) ? $attributes['items'] : array();

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
			<p class="lead mt-2 max-w-xl"><?php echo esc_html( $body ); ?></p>
			<?php if ( $items ) : ?>
				<div class="grid md:grid-cols-2 gap-6 mt-10">
					<?php foreach ( $items as $item ) : ?>
						<div class="card p-8 shadow-glow-sm">
							<div class="flex items-center justify-between gap-4">
								<div>
									<div class="text-ink text-xs"><?php echo esc_html( $item['since'] ?? '' ); ?></div>
									<h3 class="h3 !text-lg"><?php echo esc_html( $item['name'] ?? '' ); ?></h3>
								</div>
								<span class="btn-secondary text-sm shrink-0"><?php esc_html_e( 'Visit Website', 'growmodo' ); ?></span>
							</div>
							<div class="flex gap-6 mt-4 pt-4 border-t border-surface-line text-sm">
								<div><span class="text-ink"><?php esc_html_e( 'Domain', 'growmodo' ); ?></span><div class="text-heading"><?php echo esc_html( $item['domain'] ?? '' ); ?></div></div>
								<div><span class="text-ink"><?php esc_html_e( 'Category', 'growmodo' ); ?></span><div class="text-heading"><?php echo esc_html( $item['category'] ?? '' ); ?></div></div>
							</div>
							<div class="mt-4 pt-4 border-t border-surface-line">
								<div class="text-heading font-semibold text-sm mb-1"><?php esc_html_e( 'What They Said 🤗', 'growmodo' ); ?></div>
								<p class="lead text-sm"><?php echo esc_html( $item['quote'] ?? '' ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="pager">
					<span class="pager-count"><strong>01</strong> of <?php echo esc_html( count( $items ) ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
