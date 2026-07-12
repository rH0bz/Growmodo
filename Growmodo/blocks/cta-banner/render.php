<?php
/**
 * CTA Banner — Growmodo SOT: Sections/CTA Banner.md (scope: page, owner Home,
 * reused verbatim on About/Contact/Services).
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading  = $attributes['heading'] ?? '';
$body     = $attributes['body'] ?? '';
$cta      = $attributes['ctaLabel'] ?? '';
$cta_url  = $attributes['ctaUrl'] ?? '#';

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface-alt border-y border-surface-line relative overflow-hidden">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/cta-decor-1.svg' ); ?>" alt="" class="hidden md:block absolute -right-24 -bottom-16 w-72 h-auto opacity-40 pointer-events-none" aria-hidden="true" />
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/cta-decor-2.svg' ); ?>" alt="" class="hidden md:block absolute -left-10 bottom-0 w-56 h-auto opacity-40 pointer-events-none" aria-hidden="true" />
		<div class="container-page relative flex flex-col md:flex-row md:items-center gap-8 md:gap-24">
			<div class="flex-1">
				<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
				<p class="lead mt-4"><?php echo esc_html( $body ); ?></p>
			</div>
			<a class="btn-primary shrink-0" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta ); ?></a>
		</div>
	</section>
</div>
