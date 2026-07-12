<?php
/**
 * Our Values — Growmodo SOT: Sections/Our Values.md, Modules/Value Item.md.
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
				<div class="grid md:grid-cols-2 gap-x-10 gap-y-8 mt-10 [&>*:nth-child(odd)]:md:border-r [&>*:nth-child(odd)]:md:pr-10 [&>*:nth-child(odd)]:md:border-surface-line [&>*:nth-child(-n+2)]:pb-8 [&>*:nth-child(-n+2)]:md:border-b [&>*:nth-child(-n+2)]:md:border-surface-line">
					<?php foreach ( $items as $item ) : ?>
						<div class="flex gap-4">
							<span class="icon-badge shrink-0"><?php echo growmodo_icon( $item['icon'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<div>
								<h3 class="h3"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
								<p class="lead text-sm mt-1"><?php echo esc_html( $item['body'] ?? '' ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
