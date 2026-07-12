<?php
/**
 * Site Footer — global template-part block (Growmodo).
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$brand       = $attributes['brand'] ?? 'Estatein';
$placeholder = $attributes['newsletterPlaceholder'] ?? 'Enter Your Email';
$columns     = ( isset( $attributes['columns'] ) && is_array( $attributes['columns'] ) ) ? $attributes['columns'] : array();
$copyright   = $attributes['copyright'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<footer class="bg-surface-alt border-t border-surface-line">
		<div class="container-page py-16 md:py-20">
			<div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-10 pb-12 border-b border-surface-line">
				<div class="max-w-xs">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/logo-mark.svg' ); ?>" alt="" class="h-8 w-8" />
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/logo-wordmark.svg' ); ?>" alt="<?php echo esc_attr( $brand ); ?>" class="h-4 w-auto" />
					</a>
					<form role="search" method="get" action="#" class="mt-6 flex items-center gap-2 rounded border border-surface-line bg-surface px-4 py-3">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/footer-mail.svg' ); ?>" alt="" class="w-5 h-5 shrink-0" />
						<input type="email" name="newsletter_email" placeholder="<?php echo esc_attr( $placeholder ); ?>" class="bg-transparent border-0 outline-none text-heading placeholder:text-ink w-full text-sm" />
						<button type="submit" aria-label="<?php esc_attr_e( 'Subscribe', 'growmodo' ); ?>" class="shrink-0">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/footer-send.svg' ); ?>" alt="" class="w-4 h-4" />
						</button>
					</form>
				</div>
				<nav aria-label="<?php esc_attr_e( 'Footer', 'growmodo' ); ?>" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-8 flex-1">
					<?php foreach ( $columns as $col ) : ?>
						<div>
							<div class="h3 !text-base mb-3"><?php echo esc_html( $col['title'] ?? '' ); ?></div>
							<ul class="space-y-2">
								<?php foreach ( ( $col['links'] ?? array() ) as $link ) : ?>
									<li><span class="text-ink text-sm"><?php echo esc_html( $link ); ?></span></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>
				</nav>
			</div>
			<div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6">
				<div class="flex items-center gap-6 text-ink text-sm">
					<span><?php echo esc_html( $copyright ); ?></span>
					<span class="underline underline-offset-4"><?php esc_html_e( 'Terms & Conditions', 'growmodo' ); ?></span>
				</div>
				<div class="flex items-center gap-3">
					<?php foreach ( array( 'social-1.svg', 'social-2.svg', 'social-3.svg', 'social-4.svg' ) as $social_icon ) : ?>
						<span class="btn-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/' . $social_icon ); ?>" alt="" class="w-4 h-4" /></span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</footer>
</div>
