<?php
/**
 * Testimonials — Growmodo SOT: Sections/Testimonials.md, Modules/Testimonial Card.md.
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
							<div class="flex gap-1 mb-4" aria-hidden="true">
								<?php for ( $i = 0; $i < 5; $i++ ) : ?><?php echo growmodo_icon( 'star.svg', 'w-4 h-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php endfor; ?>
							</div>
							<h3 class="h3"><?php echo esc_html( $item['heading'] ?? '' ); ?></h3>
							<p class="lead text-sm mt-3"><?php echo esc_html( $item['quote'] ?? '' ); ?></p>
							<?php
							$avatar_url = ! empty( $item['avatarUrl'] )
								? $item['avatarUrl']
								: ( ! empty( $item['avatarFile'] ) ? get_template_directory_uri() . '/assets/img/' . $item['avatarFile'] : '' );
							?>
							<div class="flex items-center gap-3 mt-6 pt-6 border-t border-surface-line">
								<?php if ( $avatar_url ) : ?>
									<img src="<?php echo esc_url( $avatar_url ); ?>" alt="" class="w-10 h-10 rounded-full object-cover" loading="lazy" />
								<?php else : ?>
									<div class="w-10 h-10 rounded-full bg-surface-alt"></div>
								<?php endif; ?>
								<div>
									<div class="text-heading font-semibold text-sm"><?php echo esc_html( $item['name'] ?? '' ); ?></div>
									<div class="text-ink text-xs"><?php echo esc_html( $item['location'] ?? '' ); ?></div>
								</div>
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
