<?php
/**
 * Services Overview — Growmodo SOT: Sections/Services Overview.md. Hardcodes
 * the Services template's only <h1>.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading  = $attributes['heading'] ?? '';
$body     = $attributes['body'] ?? '';
$features = ( isset( $attributes['features'] ) && is_array( $attributes['features'] ) ) ? $attributes['features'] : array();

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<h1 class="h-display"><?php echo esc_html( $heading ); ?></h1>
			<p class="lead mt-4 max-w-xl"><?php echo esc_html( $body ); ?></p>
			<?php if ( $features ) : ?>
				<div class="grid grid-cols-2 md:grid-cols-4 gap-4 rounded-lg bg-surface border border-surface-line p-5 mt-8 shadow-glow">
					<?php foreach ( $features as $feature ) : ?>
						<div class="flex items-center gap-3">
							<span class="icon-badge"><?php echo growmodo_icon( $feature['icon'] ?? '', 'w-5 h-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<span class="text-heading text-sm font-medium"><?php echo esc_html( $feature['label'] ?? '' ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
