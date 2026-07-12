<?php
/**
 * Our Process — Growmodo SOT: Sections/Our Process.md, Modules/Process Step.md.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = $attributes['heading'] ?? '';
$body    = $attributes['body'] ?? '';
$steps   = ( isset( $attributes['steps'] ) && is_array( $attributes['steps'] ) ) ? $attributes['steps'] : array();

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
			<p class="lead mt-2 max-w-xl"><?php echo esc_html( $body ); ?></p>
			<?php if ( $steps ) : ?>
				<div class="grid md:grid-cols-3 gap-x-8 gap-y-10 mt-10">
					<?php foreach ( $steps as $step ) : ?>
						<div class="flex gap-4">
							<span class="text-ink text-sm font-semibold shrink-0"><?php echo esc_html( $step['number'] ?? '' ); ?></span>
							<div>
								<h3 class="h3 !text-lg"><?php echo esc_html( $step['title'] ?? '' ); ?></h3>
								<p class="lead text-sm mt-1"><?php echo esc_html( $step['body'] ?? '' ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
