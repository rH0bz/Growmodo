<?php
/**
 * Our Achievements — Growmodo SOT: Sections/Our Achievements.md.
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
				<div class="grid md:grid-cols-3 gap-6 mt-10">
					<?php foreach ( $items as $item ) : ?>
						<div class="card p-8">
							<h3 class="h3"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
							<p class="lead text-sm mt-2"><?php echo esc_html( $item['body'] ?? '' ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
