<?php
/**
 * Contact Info Bar — Growmodo SOT: Sections/Contact Info Bar.md.
 * Note: hardcodes the page's only <h1> (this block sits at the top of the
 * Contact template).
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
			<h1 class="h-display"><?php echo esc_html( $heading ); ?></h1>
			<p class="lead mt-4 max-w-xl"><?php echo esc_html( $body ); ?></p>
			<?php if ( $items ) : ?>
				<div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mt-8">
					<?php foreach ( $items as $item ) : ?>
						<div class="card flex items-center gap-3 p-4">
							<span class="icon-badge"><?php echo growmodo_icon( $item['icon'] ?? '', 'w-4 h-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<span class="text-heading text-sm"><?php echo esc_html( $item['label'] ?? '' ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
