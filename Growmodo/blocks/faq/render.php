<?php
/**
 * FAQ — Growmodo SOT: Sections/FAQ.md (scope: shared, reused on Home + Property
 * Single). Modules/FAQ Item.md.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading  = $attributes['heading'] ?? '';
$body     = $attributes['body'] ?? '';
$view_all = $attributes['viewAllLabel'] ?? '';
$items    = ( isset( $attributes['items'] ) && is_array( $attributes['items'] ) ) ? $attributes['items'] : array();

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<div class="section-header mb-10">
				<div>
					<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
					<p class="lead mt-2 max-w-xl"><?php echo esc_html( $body ); ?></p>
				</div>
				<span class="btn-secondary shrink-0"><?php echo esc_html( $view_all ); ?></span>
			</div>
			<?php if ( $items ) : ?>
				<div class="grid md:grid-cols-3 gap-6">
					<?php foreach ( $items as $item ) : ?>
						<div class="card p-8">
							<h3 class="h3"><?php echo esc_html( $item['question'] ?? '' ); ?></h3>
							<p class="lead text-sm mt-3"><?php echo esc_html( $item['answer'] ?? '' ); ?></p>
							<span class="link-text mt-4"><?php esc_html_e( 'Read More', 'growmodo' ); ?></span>
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
